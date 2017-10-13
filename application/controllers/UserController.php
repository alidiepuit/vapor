<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        if (!$user) {
            $this->redirect('/');
            return;
        }
    }

    public function indexAction()
    {
        $userId = $this->getParam('userId', '');
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        if ($user->getId() != $userId) {
            $this->redirect('/');
            return;
        }
        // pr($userId);
    }
}