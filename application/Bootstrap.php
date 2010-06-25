<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH));
        return $moduleLoader;
    }

    protected function _initDoctrine()
    {
        $this->bootstrap('RegisterNamespaces');
        $doctrineConfig = $this->getOption('doctrine');
        
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, $doctrineConfig['model_autoloading']);
        $manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);

        $connection = Doctrine_Manager::connection($doctrineConfig['dsn'], 'doctrine');
        $connection->setAttribute(Doctrine_Core::ATTR_USE_NATIVE_ENUM, true);

        return $connection;
    }

    protected function _initFCPlugins()
    {
        $this->bootstrap('frontController');
        $this->bootstrap('RegisterNamespaces');

        $fc = $this->getResource('frontController');

        // $fc->registerPlugin( new Manuscript_Controller_Plugin_Auth() );
        $fc->registerPlugin( new Tws_Controller_Plugin_ModuleLayout() );

        return $fc;
    }

    protected function _initRegisterNamespaces()
    {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('Tws_');
        $loader->registerNamespace('Doctrine_');
        $loader->registerNamespace('sfYaml');
    }
}

