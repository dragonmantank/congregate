<?php

class NotesController extends Zend_Controller_Action
{
	public function addAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$n			= new Notes();
		$title		= $this->_request->getParam('title');
		$text		= $this->_request->getParam('text');
		$section	= $this->_request->getParam('section');

		$n->addNewNote($title, $text, $section, $_SESSION['projectId']);

		echo json_encode(array('status' => 1, 'message' => 'The note has been added'));
	}

	public function indexAction()
	{
		$projectId	= $_SESSION['projectId'];

		$projects	= new Projects();
		$n			= new Notes();
		$notes		= $n->fetchNotes($projectId);
		$project	= $projects->find($projectId)->current();

		$this->view->projectName	= $project->name;
		$this->view->notes			= $notes;
		$this->view->sections		= $projects->fetchSections();
	}

	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}

}