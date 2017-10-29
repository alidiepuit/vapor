<?php
class Application_Model_Service_Machine extends Application_Model_BaseModel_BaseModel
{
  protected $_machineTitle;
  protected $_machineSlug;
  protected $_machineImage;
  protected $_machineImageCold;
  protected $_machineImageWarm;
  protected $_listPower;
  protected $_listGrpMachine;

  public function setMachineTitle($text)
  {
      $this->_machineTitle = (string) $text;
      return $this;
  }

  public function getMachineTitle()
  {
      return $this->_machineTitle;
  }

  public function setMachineSlug($text)
  {
      $this->_machineSlug = (string) $text;
      return $this;
  }

  public function getMachineSlug()
  {
      return $this->_machineSlug;
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


  public function setMachineImageCold($text)
  {
      $this->_machineImageCold = (string) $text;
      return $this;
  }

  public function getMachineImageCold()
  {
      return $this->_machineImageCold;
  }

  public function setMachineImageWarm($text)
  {
      $this->_machineImageWarm = (string) $text;
      return $this;
  }

  public function getMachineImageWarm()
  {
      return $this->_machineImageWarm;
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

  public function setListGrpMachine($list)
  {
      $this->_listGrpMachine = $list;
      return $this;
  }

  public function getListGrpMachine()
  {
      return $this->_listGrpMachine;
  }
}