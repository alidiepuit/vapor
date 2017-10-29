<?php

class BookServicesController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('bookinglayout');
    }

    public function indexAction()
    {
        $listTypeService = Application_Model_Service_TypeServiceMapper::getInstance()->getTypeService();
        $this->view->typeServices = $listTypeService;

        $servicesMaintain = Application_Model_ServicesMapper::getInstance()->getServicesMaintain();
        $this->view->servicesMaintain = $servicesMaintain;

        $servicesRemoveSetup = Application_Model_ServicesMapper::getInstance()->getServicesRemoveSetup();
        $this->view->servicesRemoveSetup = $servicesRemoveSetup;

        $serviceTool = Application_Model_ServiceToolMapper::getInstance()->getTools();
        $this->view->serviceTool = $serviceTool;

        $locations = Application_Model_LocationMapper::getInstance()->getLocations();
        $this->view->locations = $locations;
    }

    public function checkValidLocationAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $form    = new Application_Form_Location();
        $data = $request->getPost();

        if ($request->isPost()) {
            if ($form->isValid($data)) {
                // pr($request->getParams());
                $longitude          = (double)$request->getParam('longitude', '106.68894369999998');
                $latitude           = (double)$request->getParam('latitude', '10.7602476');
                $address            = (string)$form->getValue('full_address', '');
                $typeLocation       = (int)$request->getParam('type_location', '');
                $datetime           = (string)$request->getParam('datetime', '10/25/2017 11:58 PM');
                $amountCurrentOrder = (int)$request->getParam('amount', 0);

                if (!Application_Model_BookingService::getInstance()->isInHCMCity($latitude, $longitude)) {
                    echo json_encode(array( 
                        'error' => 'Địa chỉ không hợp lệ.',
                        'success' => false,
                    ));
                    return;
                }

                $date = date_create_from_format('m/d/Y H:i A', $datetime);
                $dateBooking = date_format($date, 'Y-m-d');
                // pr($date);
                $listBookingServices = Application_Model_BookingService::getInstance()->getBookingServiceAtSameDay($dateBooking);
                $numberServiceNearBy = Application_Model_BookingService::getInstance()->getNumberOfServiceNearCurrentOrder($latitude, $longitude, $listBookingServices);
                // pr($numberServiceNearBy);

                $total = $amountCurrentOrder + $numberServiceNearBy;

                $listDiscount = Application_Model_DiscountMapper::getInstance()->getDiscount($total);
                $percent = 0;
                foreach ($listDiscount as $discount) {
                    if ($discount->getDiscountAmount() <= $total) {
                        $percent = $discount->getDiscountPercent();
                    } else {
                        break;
                    }
                }

                $data = array(
                    'datetime'      => date_format($date, 'd/m/Y H:i A'),
                    'address'       => $address,
                    'discount'      => $percent,
                    'amount'        => $total,
                    'latitude'      => $latitude,
                    'longitude'     => $longitude,
                    'type_location' => $typeLocation,
                    'success'       => true,
                );

                $namespace = new Zend_Session_Namespace('Zend_Auth');
                $namespace->dataBooking = $data;

                echo json_encode($data);

            } else {
                $error = $form->getMessages();
                // pr($error);
                if (isset($error['full_address'])) {
                    echo json_encode(array( 
                        'error' => 'Địa chỉ không hợp lệ.',
                        'success' => false,
                    ));
                    return;
                }
            }

        } else {
            echo json_encode(array( 
                'error' => 'Invalid request.',
                'success' => false,
            ));
            return;
        }
    }

    public function bookAction() 
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        
        if (!$user || !$user->getId()) {
            echo json_encode(array( 
                'error' => 'Bạn phải đăng nhập trước khi tiến hành đặt dịch vụ.',
                'success' => false,
            ));
            return;
        }

        $namespace = new Zend_Session_Namespace('Zend_Auth');
        $dataBooking = $namespace->dataBooking;

        if (!$dataBooking) {
            echo json_encode(array( 
                'error' => 'Dữ liệu đặt dịch vụ không hợp lệ.',
                'success' => false,
            ));
            return;
        }

        $request = $this->getRequest();
        if (!$request->isPost()) {
            echo json_encode(array( 
                'error' => 'Invalid request.',
                'success' => false,
            ));
            return;
        }

        $services = $request->getParam('services', '');
        
        $ids = array();
        $listAmount = array();
        foreach ($services as $service) {
            $id = (int)$service['serviceId'];
            $ids[] = $id;
            $listAmount[$id] = (int)$service['serviceCount'];
        }

        // pr($ids);
        $listServices = Application_Model_ServicesMapper::getInstance()->getService($ids);

        // pr($listServices);
        $cost = 0;
        foreach ($listServices as $service) {
            $cost += $service->getServicesCost() * $listAmount[$service->getId()];
        }

        $date = date_create_from_format('d/m/Y H:i A', $dataBooking['datetime']);
        $dateBooking = date_format($date, 'Y-m-d H:i:s');
        // pr($dateBooking);

        $groupOrder = new Application_Model_Order_GroupOrder(array(
            'grouporder_location'       => $dataBooking['address'],
            'grouporder_datetime'       => $dateBooking,
            'grouporder_typeloc'        => $dataBooking['type_location'],
            'grouporder_latitude'       => $dataBooking['latitude'],
            'grouporder_longitude'      => $dataBooking['longitude'],
            'grouporder_user'           => $user->getId(),
            'grouporder_order'          => array(),
            'grouporder_amount'         => $dataBooking['amount'],
            'grouporder_cost'           => $cost,
            'grouporder_discount'       => $dataBooking['discount'],
        ));
        // pr($groupOrder);
        $groupOrderId = Application_Model_GroupOrderMapper::getInstance()->save($groupOrder);
        // pr($groupOrderId);

        $listOrderIds = array();
        foreach ($listServices as $service) {
            // pr($service->getServicesType());
            $order = new Application_Model_Order_Order(array(
                'order_grouporder'          => $groupOrderId,
                'order_typeservice'         => $service->getServicesType(),
                'order_typemachine'         => $service->getServicesTypeMachine(),
                'order_amount'              => $listAmount[$service->getId()],
                'order_power'               => $service->getServicesPower(),
            ));
            // pr($order);
            $id = Application_Model_OrderMapper::getInstance()->save($order);
            $listOrderIds[] = $id;
        }

        $groupOrder->setId($groupOrderId);
        $groupOrder->setGrouporderOrder($listOrderIds);
        Application_Model_GroupOrderMapper::getInstance()->save($groupOrder);

        echo json_encode(array( 
            'error' => '',
            'success' => true,
        ));
    }
}
