<?php

class IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		unset($_SESSION['projectId']);
		
		$projects	= new Projects();
		$this->view->projects	= $projects->fetchAll();
	}
}