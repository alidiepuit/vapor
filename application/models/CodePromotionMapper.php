<?php

class Application_Model_CodePromotionMapper extends Application_Model_BaseModel_BaseMapper
{
  const CODE = array(
    'WELCOME',
  );
  private static $_sharedInstance = Null;
  
  protected $_tableName = 'Application_Model_DbTable_CodePromotion';

  static public function getInstance() {
    if (self::$_sharedInstance) {
      return self::$_sharedInstance;
    }
    self::$_sharedInstance = new self();
    return self::$_sharedInstance;
  }

  public function isValidCode($code)
  {
    return in_array(strtoupper($code), self::CODE);
  }

  public function getPercentDiscount($code)
  {
    $func = 'code' . ucfirst(strtolower($code));
    $percentDiscount = 0;
    if (method_exists('Application_Model_CodePromotionMapper', $func)) {
      return self::$func();
    }
    return $percentDiscount;
  }

  private function getPromotion($code) {
      try {
          $select = $this->getDbTable()->select()
                  ->from('fe_code_promotions')
                  ->where('deleted_at IS NULL')
                  ->where('promotion_code LIKE ?', (string)$code);

          // echo $select;die;

          $discount = $this->getDbTable()->fetchRow($select);
          $discount = $discount ? $discount->toArray() : array();
          // pr($discount);
          $promotion = new Application_Model_CodePromotion($discount);
          // pr($promotion);
          return $promotion;
      } catch (Exception $e) {
          pr($e);
      }
  }

  //code WELCOME
  //First time using VAPOR
  private function codeWelcome()
  {
    $user = Application_Model_Authen::getInstance()->getCurrentUser();
    $userId = $user->getId();
    $services = Application_Model_GroupOrderMapper::getInstance()->getHistoryBooking($userId);
    // pr($services);
    if (!empty($services['comming']) || !empty($services['pass'])) {
      return 0;
    }
    $promotion = self::getPromotion('welcome');
    if ($promotion) {
      return $promotion->getPromotionPercent();
    }
    return 0;
  }
}