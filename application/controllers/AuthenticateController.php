<?php

class AuthenticateController extends Zend_Controller_Action
{

    public function init()
    {
        $namespace = new Zend_Session_Namespace('Zend_Auth');
        if (isset($namespace->user)) {
            $this->_redirect('/');
        }

        $this->_helper->layout->setLayout('sublayout');
    }

    public function indexAction()
    {
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Signin();

        $data = $request->getPost();

        $typeLogin = isset($data["type"]) ? $data["type"] : "email";
        $isValid = false;

        $isLoginSocial = Application_Model_Authen::getInstance()->isValidAuthenSocial($typeLogin);
        $isResponseJSON = $isLoginSocial;

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

        if ($isResponseJSON) {
            echo json_encode(array('success' => $isValid, 'error' => $this->view->error));
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            return;
        }

        if ($isValid) {
            $this->_redirect('/');
            return;
        }


        $form->getElements()['csrf']->initCsrfToken();
        $this->view->form = $form;
    }

    public function registerAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Register();

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
                    if ($result) {
                        $this->_redirect('/');
                    }
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

        $form->getElements()['csrf']->initCsrfToken();
        $this->view->form = $form;
    }

    public function testCaseAction() {
        $modelUser = new Application_Model_User(array(
            'user_name' => 'a1@fossil.com',
            'user_id' => '123',
            'user_display_name' => 'adsf',
        ));die;
    }
}

