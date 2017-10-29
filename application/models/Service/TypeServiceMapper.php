<?php
class Application_Model_Service_TypeServiceMapper extends Application_Model_BaseModel_BaseMapper
{
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_TypeService';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function getTypeService() {
        try {
            $select = $this->getDbTable()->select()
                    ->from('fe_type_services');

            // echo $select;die;

            $rows = $this->getDbTable()->fetchAll($select);
            $rows = $rows ? $rows->toArray() : Null;
            $res = array();
            foreach ($rows as $row) {
              // pr($bookingService);
                $res[] = new Application_Model_Service_TypeService($row);
            }
            // pr($res);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }
}