<?php

class Tws_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $module	= $request->getModuleName();
        $auth 	= Zend_Auth::getInstance();

        $openModules	= array('auth', 'upload');

        // Make sure that the user is logged in
        if( !in_array($module, $openModules)) {
            if( !$auth->hasIdentity()) {
                $request->setModuleName('auth')
                        ->setControllerName('index')
                        ->setActionName('login')
                        ->setDispatched(true);
            }
        }
    }
}