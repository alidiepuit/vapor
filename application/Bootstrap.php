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

    protected function _initRoutes()
    {
        $configs = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', APPLICATION_ENV);
        // pr($configs);
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $router->addConfig($configs, 'routes');
    }
}

