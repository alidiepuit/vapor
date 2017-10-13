<?php

class ParticipationController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $experiences = Application_Model_PostMapper::getInstance()->getPostByType(Application_Model_Post::POST_TYPE_SERVICE);
        $this->view->experiences = $experiences;

        $tools = Application_Model_ToolMapper::getInstance()->getTools();
        $this->view->tools = $tools;
        // pr($tools);

        $form = new Application_Form_Participation();

        $data = $request->getPost();
        if ($request->isPost() && $form->isValid($data)) {
          $experiences = isset($data['experience']) ? json_encode($data['experience']): "[]";
          $tools = isset($data['tools']) ? json_encode($data['tools']): "[]";
          $acceptTerm = isset($data['terms']) ? true : false;

          unset($data['experience']);
          unset($data['tools']);

          $data['enroll_experience'] = $experiences;
          $data['enroll_tools'] = $tools;
          $data['enroll_acceptterms'] = $acceptTerm;

          // pr($data);

          $modelParticipation = new Application_Model_Participation($data);
          // pr($modelParticipation);
          Application_Model_ParticipationMapper::getInstance()->save($modelParticipation);

          $this->view->success = true;
          return;
        }
        $this->view->success = false;

        $form->getElements()['csrf']->initCsrfToken();
        $this->view->form = $form;
    }


}

