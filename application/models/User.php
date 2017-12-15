<?php
class Application_Model_User
{
    protected $_phone;
    protected $_createdAt;
    protected $_updatedAt;
    protected $_username;
    protected $_displayName;
    protected $_address;
    protected $_typeLogin;
    protected $_active;
    protected $_id;
    protected $_password;
    protected $_numberOrder;
 
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $uppercaseFirstLetter = function($val) {
                return ucfirst($val);
            };
            $explodeKey = explode('_', $key);
            $explodeKey = array_map($uppercaseFirstLetter, $explodeKey);

            $newKey = implode($explodeKey, '');

            $method = 'set' . $newKey;

            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
 
    public function setUserPhone($text)
    {
        $this->_phone = (string) $text;
        return $this;
    }
 
    public function getUserPhone()
    {
        return $this->_phone;
    }
 
    public function setUserName($text)
    {
        $this->_username = (string) $text;
        return $this;
    }
 
    public function getUserName()
    {
        return $this->_username;
    }
 
    public function setCreatedAt($ts)
    {
        $this->_createdAt = date("Y-m-d H:i:s", (int)$ts);
        return $this;
    }
 
    public function getCreatedAt()
    {
        return !$this->_createdAt ? date("Y-m-d H:i:s", time()) : $this->_createdAt;
    }
 
    public function setUpdatedAt($ts)
    {
        $this->_updatedAt = date("Y-m-d H:i:s", (int)$ts);
        return $this;
    }
 
    public function getUpdatedAt()
    {
        return !$this->_updatedAt ? date("Y-m-d H:i:s", time()) : $this->_updatedAt;
    }
 
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }

    public function setUserDisplayName($text)
    {
        $this->_displayName = (string) $text;
        return $this;
    }
 
    public function getUserDisplayName()
    {
        return $this->_displayName ? $this->_displayName : $this->_username;
    }
 
    public function setUserAddress($text)
    {
        $this->_address = (string) $text;
        return $this;
    }
 
    public function getUserAddress()
    {
        return $this->_address;
    }
 
    public function setUserTypeLogin($text)
    {
        $this->_typeLogin = (string) $text;
        return $this;
    }
 
    public function getUserTypeLogin()
    {
        return $this->_typeLogin;
    }
 
    public function setUserPassword($text)
    {
        $this->_password = (string) $text;
        return $this;
    }
 
    public function getUserPassword()
    {
        return $this->_password;
    }
 
    public function setUserNumberOrder($text)
    {
        $this->_numberOrder = (int) $text;
        return $this;
    }
 
    public function getUserNumberOrder()
    {
        return (int)$this->_numberOrder;
    }

    public function isFirstOrder()
    {
        return $this->getUserNumberOrder() == 0;
    }
}