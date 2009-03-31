<?php

class RestrictedController extends Zend_Controller_Action
{
	public function indexAction()
	{

	}

	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}
}