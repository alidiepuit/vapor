<?php
class Application_Model_Tool extends Application_Model_BaseModel_BaseModel
{
    protected $_id;
    protected $_toolTitle;
 
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
}