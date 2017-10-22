<?php
class Application_Model_Service_DetailService extends Application_Model_BaseModel_BaseModel
{
    protected $_id;
    protected $_servicesTitle;
    protected $_servicesImage;
    protected $_servicesTypeMachine;
    protected $_servicesTypeMachineTitle;
    protected $_servicesType;
    protected $_servicesPower;
    protected $_servicesCost;

 
    public function setId($text)
    {
        $this->_id = (string) $text;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
 
    public function setTypeserviceTitle($text)
    {
        $this->_servicesTitle = (string) $text;
        return $this;
    }
 
    public function getServicesTitle()
    {
        return $this->_servicesTitle;
    }
 
    public function setTypemachineImage($text)
    {
        $this->_servicesImage = (string) $text;
        return $this;
    }
 
    public function getServicesImage()
    {
        return $this->_servicesImage;
    }
 
    public function setServicesType($text)
    {
        $this->_servicesType = (string) $text;
        return $this;
    }
 
    public function getServicesType()
    {
        return $this->_servicesType;
    }
 
    public function setServicesPower($text)
    {
        $this->_servicesPower = (string) $text;
        return $this;
    }
 
    public function getServicesPower()
    {
        return $this->_servicesPower;
    }
 
    public function setServicesCost($text)
    {
        $this->_servicesCost = (string) $text;
        return $this;
    }
 
    public function getServicesCost()
    {
        return $this->_servicesCost;
    }
 
    public function setTypemachineTitle($text)
    {
        $this->_servicesTypeMachineTitle = (string) $text;
        return $this;
    }
 
    public function getServicesTypeMachineTitle()
    {
        return $this->_servicesTypeMachineTitle;
    }

 
    public function setServicesTypemachine($text)
    {
        $this->_servicesTypeMachine = (int) $text;
        return $this;
    }
 
    public function getServicesTypeMachine()
    {
        return $this->_servicesTypeMachine;
    }
}