<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig() 
    {
        $configs = new Zend_Config_Ini(APPLICATION_PATH . '/configs/configs.ini', APPLICATION_ENV);
        Zend_Registry::set('configs', $configs);

        $application = $this->getOptions();
        return $application;
    }

    protected function _initHelpers() 
    {
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/../library/Helpers/Action');
    }

}

