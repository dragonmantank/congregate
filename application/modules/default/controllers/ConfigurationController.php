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
}