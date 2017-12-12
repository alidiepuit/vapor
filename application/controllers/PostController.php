<?php

class PostController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('articlelayout');
    }

    public function indexAction()
    {
      $request = $this->getRequest();
      $offset = (int) $request->getParam("page", 1);
      $limit = 10;

      $data = Application_Model_PostMapper::getInstance()->getListArticle($offset, $limit);
      // pr($data);
      $this->view->data = $data;
    }

    public function detailAction()
    {
        // pr($this->getParam('slug', ''));
      $slug = $this->getParam('slug', '');
      $id = $this->getParam('id', '');
      // pr($id);
      $data = Null;
      if (empty($id)) {
        $data = Application_Model_PostMapper::getInstance()->getPostBySlug($slug);
        if (!$data->getId()) {
          throw new Exception_Authen(Exception_Authen::EXCEPTION_POST_WRONG_ID);
        }
      } else {
        $data = Application_Model_PostMapper::getInstance()->getPostById($id);
        if (!$data->getId()) {
          throw new Exception_Authen(Exception_Authen::EXCEPTION_POST_WRONG_ID);
        }
      }
      $this->view->data = $data;
      
      $this->view->headMeta()->setName('og:title', $data->getPostTitle());
      $this->view->headMeta()->setName('og:type', 'article');
      $this->view->headMeta()->setName('og:description', $data->getPostSubContent());

      $this->view->headMeta()->appendName('title', $data->getPostTitle());
      $this->view->headMeta()->appendName('description', $data->getPostSubContent());

      // pr($data);
    }


}

