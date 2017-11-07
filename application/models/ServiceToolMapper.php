<?php
class Application_Model_ServiceToolMapper extends Application_Model_BaseModel_BaseMapper
{
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_ServiceTool';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function getTools() {
        try {
            $select = $this->getDbTable()->select()
                    ->from('fe_service_tools');

            // echo $select;die;

            $rows = $this->getDbTable()->fetchAll($select);
            $rows = $rows ? $rows->toArray() : Null;
            $res = array();
            foreach ($rows as $row) {
              // pr($bookingService);
                $item = new Application_Model_Service_Tool($row);
                $item->setToolSlug($this->slugify($item->getToolTitle()));
                $item->setToolPowerSlug($this->slugify($item->getToolPower()));
                if (!isset($res[$item->getToolPower()])) {
                    $res[$item->getToolPower()] = array();
                }
                $res[$item->getToolPower()][] = $item;
            }
            // pr($res);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }

    public function getToolsInList($ids)
    {
        try {
            $select = $this->getDbTable()->select()
                    ->from('fe_service_tools')
                    ->where('id in (?)', $ids)
                    ->where('deleted_at IS NULL');

            // echo $select;die;

            $rows = $this->getDbTable()->fetchAll($select);
            $rows = $rows ? $rows->toArray() : Null;
            $res = array();
            foreach ($rows as $row) {
              // pr($bookingService);
                $item = new Application_Model_Service_Tool($row);
                $item->setToolSlug($this->slugify($item->getToolTitle()));
                $item->setToolPowerSlug($this->slugify($item->getToolPower()));
                $res[] = $item;
            }
            // pr($res);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }
}