<?php
class Application_Model_Service_Location extends Application_Model_BaseModel_BaseModel
{
    protected $_id;
    protected $_typeLocationTitle;

    public function setId($text)
    {
        $this->_id = (string) $text;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
 
    public function setTypelocationTitle($text)
    {
        $this->_typeLocationTitle = (string) $text;
        return $this;
    }
 
    public function getLocationTitle()
    {
        return $this->_typeLocationTitle;
    }
}
