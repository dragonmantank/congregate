<?php

class Admin_AuthenticationController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$u	= new Users();
		$g	= new Groups();

		$this->view->users	= $u->fetchAllUsers();
		$this->view->groups	= $g->fetchAll();
	}

	public function init()
	{
		$this->_helper->layout->setLayout('admin-layout');
	}
}