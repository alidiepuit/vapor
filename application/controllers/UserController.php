<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        $this->user = Application_Model_Authen::getInstance()->getCurrentUser();
        if (!$this->user || !$this->user->getId()) {
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

    public function voteAction()
    {
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
                    'vote_user'         => $this->user->getId(),
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
}