<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        if (!$user || !$user->getId()) {
            $this->redirect('/');
            return;
        }
    }

    public function indexAction()
    {
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        $userId = $user->getId();
        // pr($userId);

        $services = Application_Model_GroupOrderMapper::getInstance()->getHistoryBooking($userId);
        // pr($services);

        $this->view->history = $services;
    }
}