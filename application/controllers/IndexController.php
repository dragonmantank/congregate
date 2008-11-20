<?php

class IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$projects				= new Projects;
		$this->view->projects	= $projects->fetchAll();
	}
}