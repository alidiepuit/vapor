<?php

class AuthenticateController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function checkValidUser()
    {
        $request = $this->getRequest();
        $params = $request->getParams();
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        $userId = isset($user) ? $user->getId() : '';
        $embed = isset($params['embed']) ? $params['embed'] : false;
        if (!$embed && !$request->isXmlHttpRequest() && $userId) {
            $this->_redirect('/');
        }
    }

    public function indexAction()
    {
        $this->checkValidUser();
        
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        
        if ($user->getId()) {
            echo json_encode(array('success' => true, 
                'error' => NULL,
            ));
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            return;
        }
        throw new Exception("Error Processing Request", 1);
        
    }

    public function loginAction()
    {
        $this->checkValidUser();
        
        $request = $this->getRequest();
        $form    = new Application_Form_Signin();

        $data = $request->getPost();

        $typeLogin = isset($data["type"]) ? $data["type"] : "email";
        $isValid = false;

        $isLoginSocial = Application_Model_Authen::getInstance()->isValidAuthenSocial($typeLogin);
        $isResponseJSON = $isLoginSocial || $request->isXmlHttpRequest();

        try {
            if ($isLoginSocial) {
                $isValid = Application_Model_Authen::getInstance()->authenSocial($data);
            } else {
                if ($this->getRequest()->isPost()) {
                    if ($form->isValid($data)) {
                        $username = $form->getValue('user_name', '');
                        $password = $form->getValue('user_password', '');
                        // pr($username . " " . $password);
                        $isValid = Application_Model_Authen::getInstance()->authenticate($username, $password);
                        $this->view->error = $isValid ? "" : Exception_Authen::EXCEPTION_AUTHEN_WRONG_EMAIL_PASSWORD['message'];
                    } else {
                        $error = $form->getMessages();
                        // pr($error);
                        if (isset($error['user_password'])) {
                            $this->view->error = Exception_Authen::EXCEPTION_AUTHEN_NOT_MATCH_PASSWORD['message'];
                        }
                    }
                }
            }
        }
        catch (Exception $e) {
            // pr($e);
            $this->view->error = $e->getMessage();
            $form->populate($data);
        }

        $form->getElements()['csrf_login']->initCsrfToken();

        if ($isResponseJSON) {
            $user = Application_Model_Authen::getInstance()->getCurrentUser();
            echo json_encode(array('success' => $isValid, 
                'error' => $this->view->error,
                'token' => $form->getElements()['csrf_login']->getValue(),
                'userId' => $user ? $user->getId() : '',
                'phoneNumber' => $user ? $user->getUserPhone() : '',
            ));
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            return;
        }

        if ($isValid) {
            $this->_redirect('/user');
            return;
        }

        $this->view->form = $form;
    }

    public function registerAction()
    {
        $this->checkValidUser();
        
        $request = $this->getRequest();
        $form    = new Application_Form_Register();

        $isResponseJSON = $request->isXmlHttpRequest();
        $isValid = false;

        // pr($request->getParams());
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $modelUser = new Application_Model_User($request->getPost());
                try {
                    $modelUser->setUserTypeLogin(Application_Model_Authen::TYPE_REGISTER_EMAIL);

                    //md5(password.SALT)
                    $password = md5($modelUser->getUserPassword().Zend_Registry::get('configs')->AUTH_USER_SALT);
                    $modelUser->setUserPassword($password);

                    $result = Application_Model_Authen::getInstance()->register($modelUser);
                    // pr($result);
                    if (!$isResponseJSON && $result) {
                        $this->_redirect('/user');
                        return;
                    }

                    $isValid = true;
                } catch (Exception $e) {
                    // pr($e->getCode());
                    $this->view->error = $e->getMessage();
                    $form->populate($request->getPost());
                }

            } else {
                // pr($form->getMessages());
                $error = $form->getMessages();
                if (isset($error['confirm_password'])) {
                    $this->view->error = Exception_Authen::EXCEPTION_AUTHEN_NOT_MATCH_PASSWORD['message'];
                }
                if (isset($error['user_name'])) {
                    $this->view->error = Exception_Authen::EXCEPTION_AUTHEN_USERNAME['message'];
                }
            }
        }

        $form->getElements()['csrf_register']->initCsrfToken();

        if ($isResponseJSON) {
            $user = Application_Model_Authen::getInstance()->getCurrentUser();
            echo json_encode(array('success' => $isValid, 
                'error' => $this->view->error,
                'token' => $form->getElements()['csrf_register']->getValue(),
                'userId' => $user ? $user->getId() : '',
                'phoneNumber' => $user ? $user->getUserPhone() : '',
                'email' => $user ? $user->getUserName() : '',
                'displayName' => $user ? $user->getUserDisplayName() : '',
            ));
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            return;
        }

        $this->view->form = $form;
    }

    public function logoutAction() 
    {
        Application_Model_Authen::getInstance()->logout();
        $this->_redirect('/');
    }

    public function testCaseAction() 
    {
        $modelUser = new Application_Model_User(array(
            'user_name' => 'a1@fossil.com',
            'user_id' => '123',
            'user_display_name' => 'adsf',
        ));die;
    }
}

