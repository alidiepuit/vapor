<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('homepagelayout');
    }

    public function indexAction()
    {
        // action body
    }


}

