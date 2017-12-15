<?php

class BookServicesController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('bookinglayout');

        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        if (isset($user) && empty($user->getUserPhone())) {
            $this->redirect('/user');
        }
    }

    public function indexAction()
    {

        $listTypeService = Application_Model_Service_TypeServiceMapper::getInstance()->getTypeService();
        $this->view->typeServices = $listTypeService;

        $servicesMaintain = Application_Model_ServicesMapper::getInstance()->getServicesMaintain();
        $this->view->servicesMaintain = $servicesMaintain;

        $servicesRemoveSetup = Application_Model_ServicesMapper::getInstance()->getServicesRemoveSetup();
        $this->view->servicesRemoveSetup = $servicesRemoveSetup;

        $servicesFix = Application_Model_ServicesMapper::getInstance()->getServicesFix();
        $this->view->servicesFix = $servicesFix;
        // pr($servicesFix);

        $serviceTool = Application_Model_ServiceToolMapper::getInstance()->getTools();
        $this->view->serviceTool = $serviceTool;
        // pr($serviceTool);

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
                $longitude          = (double)$request->getParam('longitude', '');
                $latitude           = (double)$request->getParam('lattitude', '');
                $address            = (string)$form->getValue('full_address', '');
                $typeLocation       = (int)$request->getParam('type_location', '');
                $datetime           = (string)$request->getParam('datetime', '');
                $amountCurrentOrder = (int)$request->getParam('amount', 0);

                // pr($request->getParams());
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

        ///////////////////
        //booking services//
        ///////////////////
        $services = $request->getParam('services', '');
        
        $ids = array();
        $listAmount = array();
        foreach ($services as $service) {
            $id = isset($service['serviceId']) ? (int)$service['serviceId'] : 0;
            if ($id > 0) {
                $ids[] = $id;
                $listAmount[$id] = (int)$service['serviceCount'];
            }
        }

        // pr($ids);
        $listServices = Application_Model_ServicesMapper::getInstance()->getService($ids);

        // pr($listServices);
        $cost = 0;
        foreach ($listServices as $service) {
            $cost += $service->getServicesCost() * $listAmount[$service->getId()];
        }


        ////////////////
        //booking date//
        ////////////////
        $date = date_create_from_format('d/m/Y H:i A', $dataBooking['datetime']);
        $dateBooking = date_format($date, 'Y-m-d H:i:s');
        // pr($dateBooking);

        /////////////////
        //booking tools//
        /////////////////
        $tools = $request->getParam('tools', '');
        $ids = array();
        $listAmountTool = array();
        $dataTools = array();
        // pr($tools);
        if (is_array($tools) && count($tools) > 0) {
            foreach ($tools as $tool) {
                $id = isset($tool['toolId']) ? (int)$tool['toolId'] : 0;
                if ($id > 0) {
                    $ids[] = $id;
                    $listAmountTool[$id] = (int)$tool['toolCount'];
                }
            }

            $listTools = Application_Model_ServiceToolMapper::getInstance()->getToolsInList($ids);
            
            foreach ($listTools as $tool) {
                $cost += $tool->getToolCost() * $listAmountTool[$tool->getId()];
                $dataTools[] = array(
                    'id' => $tool->getId(),
                    'title' => $tool->getToolSlug(),
                    'number' => $listAmountTool[$tool->getId()],
                    'total' => $tool->getToolCost() * $listAmountTool[$tool->getId()],
                );
            }
        }
        // pr($cost);   

        ////////////////////
        //code promotion //
        ///////////////////
        $codePromotion = trim($request->getParam('codePromotion', ''));
        $promotion = '';
        if (!empty($codePromotion)) {
            $modelCodePromotion = Application_Model_CodePromotionMapper::getInstance();
            if (!$modelCodePromotion->isValidCode($codePromotion)) {
                echo json_encode(array( 
                    'error' => 'Invalid code promotion.',
                    'success' => false,
                ));
                return;
            }
            $promotion = $modelCodePromotion->getPercentDiscount($codePromotion);
            if ($promotion == 0) {
                echo json_encode(array( 
                    'error' => 'This code promotion is expired or not valid.',
                    'success' => false,
                ));
                return;
            }
            $dataBooking['discount'] += $promotion;
        }

        ////////////////////
        //add order to DB //
        ///////////////////
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
            'grouporder_tools'          => $dataTools,
            'grouporder_code'           => $promotion,
        ));
        // pr($groupOrder);
        $groupOrderId = Application_Model_GroupOrderMapper::getInstance()->save($groupOrder);
        // pr($groupOrderId);

        $listOrderIds = array();
        $listOrder = array();
        foreach ($listServices as $service) {
            // pr($service->getServicesType());
            $orderData = array(
                'order_grouporder'          => $groupOrderId,
                'order_typeservice'         => $service->getServicesType(),
                'order_typemachine'         => $service->getServicesTypeMachine(),
                'order_amount'              => $listAmount[$service->getId()],
                'order_power'               => $service->getServicesPower(),
            );
            $order = new Application_Model_Order_Order($orderData);
            // pr($order);
            $id = Application_Model_OrderMapper::getInstance()->save($order);
            $listOrderIds[] = $id;
            $listOrder[] = $service->getServicesTitle() . ' - ' 
                . $service->getServicesTypeMachineTitle() . ' - (' 
                . $service->getServicesPower() . ') - #' 
                . $listAmount[$service->getId()] . ' - $' 
                . $service->getServicesCost();
        }

        // pr(implode("\n",$listOrder));
        $groupOrder->setId($groupOrderId);
        $groupOrder->setGrouporderOrder($listOrderIds);
        $groupOrder->setGrouporderDetail(implode("<br/>",$listOrder));
        Application_Model_GroupOrderMapper::getInstance()->save($groupOrder);

        //Update number order of user
        Application_Model_UserMapper::getInstance()->increaseNumberOrderUser($user);

        echo json_encode(array( 
            'error' => '',
            'success' => true,
        ));

        require_once APPLICATION_PATH . '/../library/Notification/init.php';
        $wonderpush = new \WonderPush\WonderPush(Zend_Registry::get('configs')->webpush->token, Zend_Registry::get('configs')->webpush->id);
        $response = $wonderpush->deliveries()->prepareCreate()
            ->setTargetSegmentIds('@ALL')
            ->setNotification(\WonderPush\Obj\Notification::_new()
                ->setAlert(\WonderPush\Obj\NotificationAlert::_new()
                    ->setTitle('Có đặt hàng mới')
                    ->setText('')
                    ->setTargetUrl('http://admin.vapor.vn/admin/frontend_grouporders')
                ))
            ->execute()
            ->checked();
        // pr($response->getNotificationId());
    }
}
