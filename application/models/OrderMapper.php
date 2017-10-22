<?php

class Application_Model_OrderMapper extends Application_Model_BaseModel_BaseMapper
{  
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Order';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function save(Application_Model_Order_Order $obj)
    {
        $data = array(
            'id'                        => $obj->getId(),
            'order_grouporder'          => $obj->getOrderGroup(),
            'order_typeservice'         => $obj->getOrderTypeService(),
            'order_typemachine'         => $obj->getOrderTypeMachine(),
            'order_amount'              => $obj->getOrderAmount(),
            'order_power'               => $obj->getOrderPower(),
        );
 
        if (null === ($id = $obj->getId())) {
            unset($data['id']);
            // pr($data);
            $id = $this->getDbTable()->insert($data);
            return $id;
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
}