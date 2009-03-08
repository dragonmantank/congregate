<?php

class ImplementationController extends Zend_Controller_Action
{
	public function addtaskAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if($_POST) {
			$data	= array(
				'feature'		=> $this->_request->getParam('feature'),
				'priority'		=> $this->_request->getParam('priority'),
				'estimateOrig'	=> $this->_request->getParam('estimateOrig'),
				'task'			=> $this->_request->getParam('task'),
				'projectId'		=> $_SESSION['projectId'],
			);
		
			try {
				$task		= new Tasks();
				$task->add($data);
				$status		= 1;
				$message	= 'Task was added successfully.';
			} catch (Exception $e) {
				$status		= 0;
				$message	= $e->getMessage();
			}
			
			echo json_encode(array('status' => $status, 'message' => $message));
		}
	}
	
	public function indexAction()
	{
		$projectId	= $_SESSION['projectId'];
		$tasks		= new Tasks();
		$this->view->tasks	= $tasks->fetchAll('projectId = ' . $projectId);
	}
	
	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
		if(!array_key_exists('projectId', $_SESSION)) {
			$this->_redirect('/');
		}
	}
	
	public function updatecellAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if($_POST) {
			$section	= $this->_request->getParam('section');
			$id			= $this->_request->getParam('id');
			$text		= $this->_request->getParam('text');

			$tasks		= new Tasks();
			$task		= $tasks->fetchRow($tasks->select()->where('id = ?', $id));
			
			$task->{$section}	= $text;
			if($section == 'completedBy') {
				$task->status	= 1;
			}
			$task->save();
		}
	}
}