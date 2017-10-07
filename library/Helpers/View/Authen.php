<?php

class Helpers_View_Authen extends Zend_View_Helper_Abstract
{
    public function authen() {
        $auth = Zend_Auth::getInstance();
        $modelUser = $auth->getIdentity();
        // pr($modelUser);
        return $modelUser;
    }
}