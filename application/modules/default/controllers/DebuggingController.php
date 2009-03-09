<?php

class DebuggingController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$projectId	= $_SESSION['projectId'];

		$projects	= new Projects();
		$project	= $projects->find($projectId)->current();
		
		$this->view->projectName	= $project->name;
		$this->view->projectId		= $projectId;
	}
	
	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}
}