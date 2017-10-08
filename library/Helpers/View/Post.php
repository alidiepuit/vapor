<?php

class Helpers_View_Post extends Zend_View_Helper_Abstract
{
  public function services()
  {
    $mapper = Application_Model_PostMapper::getInstance()->getPostByType(Application_Model_Post::POST_TYPE_SERVICE);
    return $mapper;
  }

  public function customer()
  {
    $mapper = Application_Model_PostMapper::getInstance()->getPostByType(Application_Model_Post::POST_TYPE_CUSTOMER);
    return $mapper;
  }
}