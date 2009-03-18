<?php

class Tws_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$module	= $request->getModuleName();
		$auth 	= Zend_Auth::getInstance();

		if($module != 'auth' && !$auth->hasIdentity()) {
			$request->setModuleName('auth')
			   		->setControllerName('index')
			   		->setActionName('login')
		   			->setDispatched(true);
		}
	}
}