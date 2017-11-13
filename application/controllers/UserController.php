<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->user = Application_Model_Authen::getInstance()->getCurrentUser();
        if (!$this->user || !$this->user->getId()) {
            $this->redirect('/');
            return;
        }

        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        $userId = $user->getId();
        
        $services = Application_Model_GroupOrderMapper::getInstance()->getHistoryBooking($userId);
        // pr($services);

        $this->view->history = $services;
    }

    public function updateInfoAction()
    {
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        $request = $this->getRequest();
        $form    = new Application_Form_UpdateInfo();
        if (!$user) {
            $form->getElements()['csrf_update_info']->initCsrfToken();
            $this->view->form = $form;
            return;
        }
        $this->view->user = $user;

        $data = $request->getPost();

        $refresh = (bool)$request->getParam('refresh', false);
        if ($refresh) {
            $this->_helper->layout()->disableLayout();
        }
        $this->view->refresh = $refresh;

        $isResponseJSON = !$refresh && $request->isXmlHttpRequest();
        $isValid = false;

        try {
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($data)) {
                    $displayName = $form->getValue('display_name', '');
                    $phoneNumber = $form->getValue('phone_number', '');
                    
                    if ($displayName != $user->getUserDisplayName() || $phoneNumber != $user->getUserPhone()) {
                        $user->setUserDisplayName($displayName);
                        $user->setUserPhone($phoneNumber);

                        // pr($user);
                        Application_Model_UserMapper::getInstance()->save($user);

                        $isValid = true;
                    }
                } else {
                    $error = $form->getMessages();
                    // pr($error);
                    if (isset($error['csrf_update_info'])) {
                        $this->view->error = Exception_Authen::EXCEPTION_FORM_CRSF['message'];
                    } else if (isset($error['display_name'])) {
                        $this->view->error = Exception_Authen::EXCEPTION_UPDATE_INFO_WRONG_DISPLAY_NAME['message'];
                    } else if (isset($error['phone_number'])) {
                        $this->view->error = Exception_Authen::EXCEPTION_UPDATE_INFO_WRONG_PHONE_NUMBER['message'];
                    }
                }
            } else {
                $data = array(
                    'email' => $user->getUserName(),
                    'display_name' => $user->getUserDisplayName(),
                    'phone_number' => $user->getUserPhone(),
                );

                if (empty($user->getUserPhone())) {
                    $this->view->error = "Need update phone number.";
                }
            }
        }
        catch (Exception $e) {
            // pr($e);
            $this->view->error = $e->getMessage();
        }

        $data['email'] = $user->getUserName();
        $form->populate($data);
        $form->getElements()['csrf_update_info']->initCsrfToken();

        if ($isResponseJSON) {
            $user = Application_Model_Authen::getInstance()->getCurrentUser();
            echo json_encode(array('success' => $isValid, 
                'error'         => $this->view->error,
                'token'         => $form->getElements()['csrf_update_info']->getValue(),
                'userId'        => $user ? $user->getId() : '',
                'data'          => $data,
            ));
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            return;
        }

        $this->view->form = $form;
    }

    public function voteAction()
    {
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        if (!$user || !$user->getId()) {
            $this->redirect('/');
            return;
        }

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $request = $this->getRequest();
        $form    = new Application_Form_Vote();
        $data = $request->getPost();

        if ($request->isPost()) {
            // pr($data);
            if ($form->isValid($data)) {
                $data = array(
                    'vote_grouporder'   => $form->getValue('grouporder', ''),
                    'vote_star'         => $form->getValue('vote', ''),
                    'vote_comment'      => $form->getValue('comment', ''),
                    'vote_user'         => $user->getId(),
                );
                // pr($data);
                $vote = new Application_Model_Vote($data);
                // pr($vote);
                Application_Model_VoteMapper::getInstance()->save($vote);
            } else {
                $error = $form->getMessages();
                pr($error);
                if (isset($error['star'])) {
                    $this->view->error = 'Bạn chưa bình chọn mức độ hài lòng.';
                } else if (isset($error['comment'])) {
                    $this->view->error = 'Bạn chưa ghi bình luận.';
                }
            }
        }

        if ($this->view->error) {
            echo json_encode(array(
                'error' => $this->view->error,
                'success' => false,
            ));
            return;
        }

        echo json_encode(array(
            'error' => NULL,
            'success' => true,
        ));
    }

    public function topmenuAction()
    {
        $this->_helper->layout()->disableLayout();
        $user = Application_Model_Authen::getInstance()->getCurrentUser();
        $this->view->user = $user;
    }
}