<?php

class Application_Model_ServicesMapper extends Application_Model_BaseModel_BaseMapper
{  
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Services';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function save(Application_Model_Post $obj)
    {
        $data = array(
            'id'               => $obj->getToolId(),
            'services_title'            => $obj->getServicesTitle(),
            'services_image'            => $obj->getServicesImage(),
            'services_type'            => $obj->getServicesType(),
            'services_power'            => $obj->getServicesPower(),
            'services_cost'            => $obj->getServicesCost(),
        );
 
        if (null === ($id = $obj->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function getService($ids)
    {
        try {
            // pr($listIds);
            $select = $this->getDbTable()->select()
                    ->from('fe_services')
                    ->joinLeft('fe_type_services', 'fe_type_services.id = fe_services.services_type', 
                        array('typeservice_title','typeservice_slug'))
                    ->joinLeft('fe_type_machines', 'fe_type_machines.id = fe_services.services_typemachine',
                        array('typemachine_title','typemachine_image'))
                    ->where('fe_services.id IN (?)', $ids) 
                    ->setIntegrityCheck(false);
            
            // echo $select;die;
            $services = $this->getDbTable()->fetchAll($select);
            $services = $services ? $services->toArray() : Null;
            // pr($services);
            
            $res = array();
            foreach ($services as $service) {
                // pr($service);
                $res[] = new Application_Model_Service_DetailService($service);
            }
            
            // pr($res);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }

    }
 
    public function getServicesMaintain()
    {
        try {
            $idServiceMaintain = 1;
            $select = $this->getDbTable()->select()
                    ->from('fe_services')
                    ->joinLeft('fe_type_services', 'fe_type_services.id = fe_services.services_type', 
                        array('typeservice_title','typeservice_slug'))
                    ->joinLeft('fe_type_machines', 'fe_type_machines.id = fe_services.services_typemachine',
                        array('typemachine_title','typemachine_image'))
                    ->where('fe_type_services.id = ?', $idServiceMaintain)
                    ->setIntegrityCheck(false);
            
            // echo $select;die;
            $services = $this->getDbTable()->fetchAll($select);
            $services = $services ? $services->toArray() : Null;
            // pr($services);
            $res = array();
            foreach ($services as $val) {
                //group by services_type
                $idServiceType = $val['services_type'];
                $idServiceTypeMachine = $val['services_typemachine'];
                
                if (!isset($res[$idServiceType])) {
                    $service = new Application_Model_Service_Service(array(
                        'service_title' => $val['typeservice_title'],
                        'service_slug' => $val['typeservice_slug'],
                        'list_machine' => array(),
                    ));
                    $res[$idServiceType] = $service;
                }

                $listMachine = $res[$idServiceType]->getListMachine();

                if (!isset($listMachine[$idServiceTypeMachine])) {
                    $machine = new Application_Model_Service_Machine(array(
                        'machine_title' => $val['typemachine_title'],
                        'machine_image' => $val['typemachine_image'],
                        'list_power' => array(),
                    ));
                    $listMachine[$idServiceTypeMachine] = $machine;
                }
                
                $listPower = $listMachine[$idServiceTypeMachine]->getListPower();
                
                $detailService = new Application_Model_Service_DetailService($val);
                $listPower[] = $detailService;

                $listMachine[$idServiceTypeMachine]->setListPower($listPower);

                $res[$idServiceType]->setListMachine($listMachine);
            }
            
            return $res[$idServiceMaintain];
        } catch (Exception $e) {
            pr($e);
        }
    }

    public function getServicesRemoveSetup()
    {
        try {
            $idServiceMaintain = 2;
            $select = $this->getDbTable()->select()
                    ->from('fe_services')
                    ->joinLeft('fe_type_services', 'fe_type_services.id = fe_services.services_type', 
                        array('typeservice_title','typeservice_slug'))
                    ->joinLeft('fe_type_machines', 'fe_type_machines.id = fe_services.services_typemachine',
                        array('typemachine_title','typemachine_image', 'typemachine_cold', 'typemachine_warm'))
                    ->where('fe_type_services.id = ?', $idServiceMaintain)
                    ->setIntegrityCheck(false);
            
            // echo $select;die;
            $services = $this->getDbTable()->fetchAll($select);
            $services = $services ? $services->toArray() : Null;
            // pr($services);
            $res = array();
            foreach ($services as $val) {
                //group by services_type
                $idServiceType = $val['services_type'];
                $idServiceTypeMachine = $val['services_typemachine'];
                
                if (!isset($res[$idServiceType])) {
                    $service = new Application_Model_Service_Service(array(
                        'service_title' => $val['typeservice_title'],
                        'service_slug' => $val['typeservice_slug'],
                        'list_machine' => array(),
                    ));
                    $res[$idServiceType] = $service;
                }

                //may treo tuong, cassette, ...
                $listMachine = $res[$idServiceType]->getListMachine();

                if (!isset($listMachine[$idServiceTypeMachine])) {
                    $machine = new Application_Model_Service_Machine(array(
                        'machine_title' => $val['typemachine_title'],
                        'machine_slug' => $this->slugify($val['typemachine_title']),
                        'machine_image' => $val['typemachine_image'],
                        'machine_image_cold' => $val['typemachine_cold'],
                        'machine_image_warm' => $val['typemachine_warm'],
                        'list_power' => array(),
                    ));
                    $listMachine[$idServiceTypeMachine] = $machine;
                } 
                

                //dan nong, dan lanh
                $grpMachineTitle = $val['services_grpmachine'];
                $listGrpMachine = $listMachine[$idServiceTypeMachine]->getListGrpMachine();

                if (!isset($listGrpMachine[$grpMachineTitle])) {
                    $grpmachine = new Application_Model_Service_GrpMachine(array(
                        'grpmachine_title' => $grpMachineTitle,
                        'grpmachine_slug' => $this->slugify($grpMachineTitle),
                        'list_sub_service' => array(),
                    ));
                    $listGrpMachine[$grpMachineTitle] = $grpmachine;
                }

                // pr($listGrpMachine);


                //sub service: thao, lap, thao va lap
                $subServiceTitle = $val['services_subservice'];
                $listSubService = $listGrpMachine[$grpMachineTitle]->getListSubService();

                if (!isset($listSubService[$subServiceTitle])) {
                    $subservice = new Application_Model_Service_SubService(array(
                        'sub_service_title' => $subServiceTitle,
                        'sub_service_slug' => $this->slugify($subServiceTitle),
                        'list_power' => array(),
                    ));
                    $listSubService[$subServiceTitle] = $subservice;
                }

                // pr($listSubService);

                $listPower = $listSubService[$subServiceTitle]->getListPower();
                
                $detailService = new Application_Model_Service_DetailService($val);
                $listPower[] = $detailService;

                $listSubService[$subServiceTitle]->setListPower($listPower);

                $listGrpMachine[$grpMachineTitle]->setListSubService($listSubService);

                $listMachine[$idServiceTypeMachine]->setListGrpMachine($listGrpMachine);

                $res[$idServiceType]->setListMachine($listMachine);
            }
            // pr($res);
            return $res[$idServiceMaintain];
        } catch (Exception $e) {
            pr($e);
        }
    }


}