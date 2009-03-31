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

	public function addnoteAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$notes	= new BugNotes();
		$notes->add($this->_request->getParam('id'), $this->_request->getParam('note'));

		echo json_encode(array('status' => 1));
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

	public function updatesectionAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		if($_POST) {
			$section	= $this->_request->getParam('section');
			$text		= $this->_request->getParam('value');
			$bid		= $this->_request->getParam('bid');
			$bugs		= new Bugs();
			$bug		= $bugs->updateStatus($text, $bid);

			echo $text;
		}
	}

	public function viewAction()
	{
		$bugId	= $this->_request->getParam('id');
		$bugs	= new Bugs();
		$bug	= $bugs->fetchBug($bugId);
		$notes	= $bugs->fetchNotes($bugId);

		$this->view->assign($bug->toArray());
		$this->view->notes	= $notes;
	}
}