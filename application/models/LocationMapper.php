<?php

class Application_Model_LocationMapper extends Application_Model_BaseModel_BaseMapper
{  

    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Location';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function getLocations() {
        try {
            $select = $this->getDbTable()->select()
                    ->from('fe_type_locations');

            $locations = $this->getDbTable()->fetchAll($select);
            $locations = $locations ? $locations->toArray() : Null;
            $res = array();
            foreach ($locations as $location) {
                $res[] = new Application_Model_Service_Location($location);
            }
            // pr($res);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }
}
 