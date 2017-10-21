<?php
class Application_Model_Service_Machine extends Application_Model_BaseModel_BaseModel
{
  protected $_machineTitle;
  protected $_machineImage;
  protected $_listPower;

  public function setMachineTitle($text)
  {
      $this->_machineTitle = (string) $text;
      return $this;
  }

  public function getMachineTitle()
  {
      return $this->_machineTitle;
  }

  public function setMachineImage($text)
  {
      $this->_machineImage = (string) $text;
      return $this;
  }

  public function getMachineImage()
  {
      return $this->_machineImage;
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