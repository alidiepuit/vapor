<?php

class Zend_Controller_Action_Helper_Configs extends Zend_Controller_Action_Helper_Abstract
{
    function direct($key) {
        return Zend_Registry::get('configs')->$key;
    }
}