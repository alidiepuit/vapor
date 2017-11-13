<?php
class Application_Model_BaseModel_BaseModel extends Application_Model_BaseModel_BaseClass
{
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
}
 