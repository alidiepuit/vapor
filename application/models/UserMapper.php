<?php

class Application_Model_UserMapper
{  
    private static $_sharedInstance = Null;

    protected $_dbTable;
 
    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_User $user)
    {
        $data = array(
            'id'                => $user->getId(),
            'user_name'         => $user->getUserName(),
            'user_password'     => $user->getUserPassword(),
            'user_type_login'   => $user->getUserTypeLogin(),
            'user_phone'        => $user->getUserPhone(),
            'user_address'      => $user->getUserAddress(),
            'user_display_name' => $user->getUserDisplayName(),
        );
 
        $user->setUpdatedAt(time());
        $data['updated_at'] = $user->getUpdatedAt();

        if (null === ($id = $user->getId())) {
            unset($data['id']);
            $user->setCreatedAt(time());
            $data['created_at'] = $user->getCreatedAt();
            $this->getDbTable()->insert($data);
        } else {
            // pr($id);
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($username)
    {
        $row = $this->getDbTable()->fetchRow(
                  $this->getDbTable()->select()
                      ->where('user_name LIKE ?', $username)
                  );
        if (is_object($row)) {
          $row = $row->toArray();
        }
        if (0 == count($row)) {
            return Null;
        }
        $user = new Application_Model_User($row);
        return $user;
    }
}
