<?php
class Application_Model_Discount extends Application_Model_BaseModel_BaseModel
{
  protected $_discountId;
  protected $_discountPercent;
  protected $_discountAmount;

  public function setId($text)
  {
      $this->_discountId = (string) $text;
      return $this;
  }

  public function getId()
  {
      return $this->_discountId;
  }

  public function setDiscountPercent($text)
  {
      $this->_discountPercent = (float) $text;
      return $this;
  }

  public function getDiscountPercent()
  {
      return $this->_discountPercent;
  }

  public function setDiscountAmount($text)
  {
      $this->_discountAmount = (float) $text;
      return $this;
  }

  public function getDiscountAmount()
  {
      return $this->_discountAmount;
  }
}
