<?php
class Application_Model_Service_TypeService extends Application_Model_BaseModel_BaseModel
{
  protected $_id;
  protected $_typeserviceTitle;
  protected $_typeserviceSlug;

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
      $this->_typeserviceTitle = (string) $text;
      return $this;
  }

  public function getTypeServiceTitle()
  {
      return $this->_typeserviceTitle;
  }

  public function setTypeserviceSlug($text)
  {
      $this->_typeserviceSlug = (string) $text;
      return $this;
  }

  public function getTypeServiceSlug()
  {
      return $this->_typeserviceSlug;
  }
}