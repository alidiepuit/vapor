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
      $allDataQueryStatement = Application_Model_PostMapper::getInstance()->getQueryListAllArticle();
      // pr($totalItem);
      $this->view->data = $data;

      Zend_View_Helper_PaginationControl::setDefaultViewPartial('controls.phtml');

      $adapter = new Zend_Paginator_Adapter_DbSelect($allDataQueryStatement);
      $paginator = new Zend_Paginator($adapter);
      // pr(get_class_methods($paginator));
      $paginator->setItemCountPerPage($limit);
      $paginator->setCurrentPageNumber($offset);
      $paginator->setPagerange(3);
      $this->view->paginator = $paginator;
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

      $this->view->doctype('XHTML1_RDFA');
      $this->view->headMeta()->setProperty('og:title', $data->getPostTitle());
      $this->view->headMeta()->setProperty('og:type', 'article');
      $this->view->headMeta()->setProperty('og:description', $data->getPostSubContent());
      $this->view->headMeta()->setProperty('og:image', $this->view->baseUrl() . $data->getPostImage());
      $this->view->headMeta()->setProperty('og:url', $this->view->baseUrl() . '/bai-viet/' . $data->getId() . '/' . $data->getPostSlug() . '.html');
      $this->view->headMeta()->setProperty('og:site_name', 'vapor');

      $this->view->headMeta()->appendName('title', $data->getPostTitle());
      $this->view->headMeta()->appendName('description', $data->getPostSubContent());

      // pr($data);
    }


}

