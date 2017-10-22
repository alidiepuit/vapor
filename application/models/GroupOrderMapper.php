<?php

class Application_Model_GroupOrderMapper extends Application_Model_BaseModel_BaseMapper
{  
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_GroupOrder';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function save(Application_Model_Order_GroupOrder $obj)
    {
        $data = array(
            'id'                        => $obj->getId(),
            'grouporder_location'       => $obj->getGrouporderLocation(),
            'grouporder_datetime'       => $obj->getGrouporderDatetime(),
            'grouporder_typeloc'        => $obj->getGrouporderTypeLocation(),
            'grouporder_latitude'       => $obj->getGrouporderLatitude(),
            'grouporder_longitude'      => $obj->getGrouporderLongitude(),
            'grouporder_user'           => $obj->getGrouporderUser(),
            'grouporder_order'          => json_encode($obj->getGrouporderOrder()),
            'grouporder_amount'         => $obj->getGrouporderAmount(),
            'grouporder_cost'           => $obj->getGrouporderCost(),
            'grouporder_discount'       => $obj->getGrouporderDiscount(),
        );
 
        if (null === ($id = $obj->getId())) {
            unset($data['id']);
            $id = $this->getDbTable()->insert($data);
            return $id;
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
}