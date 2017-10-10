<?php

class PostController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // pr($this->getParam('slug', ''));
      $slug = $this->getParam('slug', '');
      $data = Application_Model_PostMapper::getInstance()->getPostBySlug($slug);
      if (!$data->getId()) {
        throw new Exception_Authen(Exception_Authen::EXCEPTION_POST_WRONG_ID);
      }
      $this->view->data = $data;
    }


}

