<?php

class Helpers_View_Post extends Zend_View_Helper_Abstract
{
  public function services()
  {
    $mapper = Application_Model_PostMapper::getInstance()->getServices();
    // pr($mapper);
    return $mapper;
  }
}