<?php

class ConfigurationController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$up	= new UserProjects();
		$p	= new Projects();

		$project	= $p->find($_SESSION['projectId'])->current();

		$this->view->teamMembers	= $up->getMembers($_SESSION['projectId']);
		$this->view->name			= $project->name;
		$this->view->description	= $project->description;
		$this->view->requiredSigs	= $p->getRequiredSignatures($project->id);
	}

	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}

	public function saveAction()
	{
		$p				= new Projects();
		$project		= $p->find($_SESSION['projectId'])->current();
		$title			= $this->_request->getParam('name');
		$description	= $this->_request->getParam('description');

		$project->name			= $title;
		$project->description	= $description;

		$project->save();

		$this->_forward('index', 'configuration');
	}
}