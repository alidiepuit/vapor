<?php
class Application_Model_Order_Order extends Application_Model_BaseModel_BaseModel
{
  protected $_orderId;
  protected $_orderGroup;
  protected $_orderTypeService;
  protected $_orderTypeMachine;
  protected $_orderAmount;
  protected $_orderPower;

  public function setId($text)
  {
      $this->_orderId = (string) $text;
      return $this;
  }

  public function getId()
  {
      return $this->_orderId;
  }

  public function setOrderGrouporder($text)
  {
      $this->_orderGroup = (string) $text;
      return $this;
  }

  public function getOrderGroup()
  {
      return $this->_orderGroup;
  }

  public function setOrderTypeservice($text)
  {
      $this->_orderTypeService = (string) $text;
      return $this;
  }

  public function getOrderTypeService()
  {
      return $this->_orderTypeService;
  }

  public function setOrderTypemachine($text)
  {
      $this->_orderTypeMachine = (string) $text;
      return $this;
  }

  public function getOrderTypeMachine()
  {
      return $this->_orderTypeMachine;
  }

  public function setOrderAmount($text)
  {
      $this->_orderAmount = (string) $text;
      return $this;
  }

  public function getOrderAmount()
  {
      return $this->_orderAmount;
  }

  public function setOrderPower($text)
  {
      $this->_orderPower = (string) $text;
      return $this;
  }

  public function getOrderPower()
  {
      return $this->_orderPower;
  }
}