<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('homepagelayout');
    }

    public function indexAction()
    {
        // $username = 'Admin';
        // $salt = 'DtkD0_##$@!dbmcsfkjf';
        // $akey = md5($username.$salt);
        // pr($akey);
    }


}

