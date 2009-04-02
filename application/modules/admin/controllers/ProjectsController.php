<?php

class Admin_ProjectsController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$p	= new Projects();

		$this->view->projects	= $p->fetchAllProjects();
	}

	public function init()
	{
		$this->_helper->layout->setLayout('admin-layout');
	}
}