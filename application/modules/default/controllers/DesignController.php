<?php

class DesignController extends Zend_Controller_Action
{
	public function addfileAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$p	= new Projects();
		$f	= new Files();

		$data	= array(
			'projectId'	=> $_SESSION['projectId'],
			'section'	=> $_POST['section'],
			'filename'	=> $_FILES['file']['name'],
			'author'	=> Zend_Auth::getInstance()->getIdentity()->id,
			'title'		=> $_POST['title'],
			'mimetype'	=> $_FILES['file']['type'],
			'size'		=> $_FILES['file']['size'],
			'tmp_name'	=> $_FILES['file']['tmp_name'],
		);

		try {
			$f->add($data);
			$project	= $p->find($_SESSION['projectId'])->current();
			$message	= "Document '" . $_POST['title'] . "' has been uploaded to project '" . $project->name . "'";
			$title		= "New Document Added to Project '" . $project->name . "'";
			$p->emailMembers($_SESSION['projectId'], $message, $title);
		} catch (Exception $e) {
			$flashMessenger	= $this->_helper->FlashMessenger;
			$flashMessenger->addMessage($e->getMessage());
		}

		$this->_forward('index', 'design', 'default');
	}

	public function indexAction()
	{
		$projectId	= $_SESSION['projectId'];

		$projects	= new Projects();
		$project	= $projects->find($projectId)->current();

		$this->view->projectName	= $project->name;
		$this->view->projectId		= $projectId;
		$this->view->files			= $projects->fetchFiles($projectId);
		$this->view->messages		= $this->_helper->FlashMessenger->getMessages();

		$this->_helper->FlashMessenger->clearMessages();
	}

	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}
}