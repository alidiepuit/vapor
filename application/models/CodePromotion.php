<?php
class Application_Model_CodePromotion extends Application_Model_BaseModel_BaseModel
{
  protected $_codePromotionId;
  protected $_codePromotionCode;
  protected $_codePromotionPercent;

  public function setId($text)
  {
      $this->_codePromotionId = (string) $text;
      return $this;
  }

  public function getId()
  {
      return $this->_codePromotionId;
  }

  public function setPromotionPercent($text)
  {
      $this->_codePromotionPercent = (float) $text;
      return $this;
  }

  public function getPromotionPercent()
  {
      return $this->_codePromotionPercent;
  }

  public function setPromotionCode($text)
  {
      $this->_codePromotionCode = (string) $text;
      return $this;
  }

  public function getPromotionCode()
  {
      return $this->_codePromotionCode;
  }
}
