<?php

class BookServicesController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('bookinglayout');
    }

    public function indexAction()
    {
        $services = Application_Model_ServicesMapper::getInstance()->getServices();
        $this->view->services = $services;


        $locations = Application_Model_LocationMapper::getInstance()->getLocations();
        $this->view->locations = $locations;
    }
}
