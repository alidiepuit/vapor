<?php
class Application_Model_Service_Service extends Application_Model_BaseModel_BaseModel
{
  protected $_serviceTitle;
  protected $_serviceSlug;
  protected $_listMachine;

  public function setServiceTitle($text)
  {
      $this->_serviceTitle = (string) $text;
      return $this;
  }

  public function getServiceTitle()
  {
      return $this->_serviceTitle;
  }

  public function setServiceSlug($text)
  {
      $this->_serviceSlug = (string) $text;
      return $this;
  }

  public function getServiceSlug()
  {
      return $this->_serviceSlug;
  }

  public function setListMachine($listMachine)
  {
      $this->_listMachine = $listMachine;
      return $this;
  }

  public function getListMachine()
  {
      return $this->_listMachine;
  }
}