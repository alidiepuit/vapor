<?php
class Application_Model_Order_GroupOrder extends Application_Model_BaseModel_BaseModel
{
  protected $_groupOrderId;
  protected $_grouporderLocation;
  protected $_grouporderDatetime;
  protected $_grouporderTypeLocation;
  protected $_grouporderLatitude;
  protected $_grouporderLongitude;
  protected $_grouporderUser;
  protected $_grouporderOrder;
  protected $_grouporderAmount;
  protected $_grouporderCost;
  protected $_grouporderDiscount;

  public function setId($text)
  {
      $this->_groupOrderId = (string) $text;
      return $this;
  }

  public function getId()
  {
      return $this->_groupOrderId;
  }

  public function setGrouporderLocation($text)
  {
      $this->_grouporderLocation = (string) $text;
      return $this;
  }

  public function getGrouporderLocation()
  {
      return $this->_grouporderLocation;
  }

  public function setGrouporderDatetime($text)
  {
      $this->_grouporderDatetime = (string) $text;
      return $this;
  }

  public function getGrouporderDatetime()
  {
      return $this->_grouporderDatetime;
  }

  public function setGrouporderTypeloc($text)
  {
      $this->_grouporderTypeLocation = (string) $text;
      return $this;
  }

  public function getGrouporderTypeLocation()
  {
      return $this->_grouporderTypeLocation;
  }

  public function setGrouporderLatitude($text)
  {
      $this->_grouporderLatitude = (string) $text;
      return $this;
  }

  public function getGrouporderLatitude()
  {
      return $this->_grouporderLatitude;
  }

  public function setGrouporderLongitude($text)
  {
      $this->_grouporderLongitude = (string) $text;
      return $this;
  }

  public function getGrouporderLongitude()
  {
      return $this->_grouporderLongitude;
  }

  public function setGrouporderUser($text)
  {
      $this->_grouporderUser = (string) $text;
      return $this;
  }

  public function getGrouporderUser()
  {
      return $this->_grouporderUser;
  }

  public function setGrouporderOrder($text)
  {
      $this->_grouporderOrder = json_encode($text);
      return $this;
  }

  public function getGrouporderOrder()
  {
      return json_decode($this->_grouporderOrder, true);
  }

  public function setGrouporderAmount($text)
  {
      $this->_grouporderAmount = (string) $text;
      return $this;
  }

  public function getGrouporderAmount()
  {
      return $this->_grouporderAmount;
  }

  public function setGrouporderCost($text)
  {
      $this->_grouporderCost = (string) $text;
      return $this;
  }

  public function getGrouporderCost()
  {
      return $this->_grouporderCost;
  }

  public function setGrouporderDiscount($text)
  {
      $this->_grouporderDiscount = (string) $text;
      return $this;
  }

  public function getGrouporderDiscount()
  {
      return $this->_grouporderDiscount;
  }
}