<?php

class Application_Model_ToolMapper extends Application_Model_BaseModel_BaseMapper
{  
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Tool';

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
            'tool_id'               => $obj->getToolId(),
            'tool_title'            => $obj->getToolTitle(),
        );
 
        if (null === ($id = $obj->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function getTools()
    {
        try {
            $select = $this->getDbTable()->select()
                    ->from('frontend_tools')
                    ->where('deleted_at IS NULL');

            $services = $this->getDbTable()->fetchAll($select);
            $services = $services ? $services->toArray() : Null;
            $res = array();
            foreach ($services as $val) {
                $res[] = new Application_Model_Tool($val);
            }
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }
}