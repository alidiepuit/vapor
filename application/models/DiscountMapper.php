<?php
class Application_Model_DiscountMapper extends Application_Model_BaseModel_BaseMapper
{
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Discount';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function getDiscount($amount) {
        try {
            $select = $this->getDbTable()->select()
                    ->from('fe_discounts')
                    ->order('discount_amount ASC')
                    ->where('deleted_at IS NULL');

            // echo $select;die;

            $listDiscount = $this->getDbTable()->fetchAll($select);
            $listDiscount = $listDiscount ? $listDiscount->toArray() : Null;
            $res = array();
            foreach ($listDiscount as $discount) {
              // pr($bookingService);
                $res[] = new Application_Model_Discount($discount);
            }
            // pr($res);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }
}