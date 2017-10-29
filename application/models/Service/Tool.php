<?php
class Application_Model_Service_Tool extends Application_Model_BaseModel_BaseModel
{
    protected $_id;
    protected $_toolTitle;
    protected $_toolSlug;
    protected $_toolUnit;
    protected $_toolPower;
    protected $_toolPowerSlug;
    protected $_toolCost;

    public function setId($text)
    {
        $this->_id = (string) $text;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
 
    public function setToolTitle($text)
    {
        $this->_toolTitle = (string) $text;
        return $this;
    }
 
    public function getToolTitle()
    {
        return $this->_toolTitle;
    }
 
    public function setToolSlug($text)
    {
        $this->_toolSlug = (string) $text;
        return $this;
    }
 
    public function getToolSlug()
    {
        return $this->_toolSlug;
    }
 
    public function setToolUnit($text)
    {
        $this->_toolUnit = (string) $text;
        return $this;
    }
 
    public function getToolUnit()
    {
        return $this->_toolUnit;
    }
 
    public function setToolPower($text)
    {
        $this->_toolPower = (string) $text;
        return $this;
    }
 
    public function getToolPower()
    {
        return $this->_toolPower;
    }
 
    public function setToolPowerSlug($text)
    {
        $this->_toolPowerSlug = (string) $text;
        return $this;
    }
 
    public function getToolPowerSlug()
    {
        return $this->_toolPowerSlug;
    }
 
    public function setToolCost($text)
    {
        $this->_toolCost = (string) $text;
        return $this;
    }
 
    public function getToolCost()
    {
        return $this->_toolCost;
    }
}