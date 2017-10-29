<?php
class Application_Model_Service_SubService extends Application_Model_BaseModel_BaseModel
{
  protected $_subserviceTitle;
  protected $_subserviceSlug;
  protected $_listPower;

  public function setSubServiceTitle($text)
  {
      $this->_subserviceTitle = (string) $text;
      return $this;
  }

  public function getSubServiceTitle()
  {
      return $this->_subserviceTitle;
  }

  public function setSubServiceSlug($text)
  {
      $this->_subserviceSlug = (string) $text;
      return $this;
  }

  public function getSubServiceSlug()
  {
      return $this->_subserviceSlug;
  }

  public function setListPower($listPower)
  {
      $this->_listPower = $listPower;
      return $this;
  }

  public function getListPower()
  {
      return $this->_listPower;
  }
}