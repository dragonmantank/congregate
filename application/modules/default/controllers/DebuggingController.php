<?php

class DebuggingController extends Zend_Controller_Action
{
	public function addbugAction()
	{
		$bugs		= new Bugs();
		$projects	= new Projects();

		if($_POST) {
			$bugs->add($_POST, $_SESSION['projectId'], 3);
			$this->_forward('index', 'debugging');
		} else {
			$this->view->categories		= $bugs->fetchCategories();
			$this->view->severities		= $bugs->fetchSeverities();
			$this->view->priorities		= $bugs->fetchPriorities();
			$this->view->teamMembers	= $projects->fetchTeamMembers($_SESSION['projectId']);
		}
	}

	public function indexAction()
	{
		$projectId	= $_SESSION['projectId'];

		$projects	= new Projects();
		$bugs		= new Bugs();
		$project	= $projects->find($projectId)->current();

		$this->view->projectName	= $project->name;
		$this->view->projectId		= $projectId;
		$this->view->bugs			= $bugs->fetchAllByProject($projectId);
	}

	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}
}