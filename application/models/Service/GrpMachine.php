<?php
class Application_Model_Service_GrpMachine extends Application_Model_BaseModel_BaseModel
{
  protected $_grpmachineTitle;
  protected $_grpmachineSlug;
  protected $_listSubService;

  public function setGrpmachineTitle($text)
  {
      $this->_grpmachineTitle = (string) $text;
      return $this;
  }

  public function getGrpMachineTitle()
  {
      return $this->_grpmachineTitle;
  }

  public function setGrpmachineSlug($text)
  {
      $this->_grpmachineSlug = (string) $text;
      return $this;
  }

  public function getGrpMachineSlug()
  {
      return $this->_grpmachineSlug;
  }

  public function setListSubService($list)
  {
      $this->_listSubService = $list;
      return $this;
  }

  public function getListSubService()
  {
      return $this->_listSubService;
  }
}