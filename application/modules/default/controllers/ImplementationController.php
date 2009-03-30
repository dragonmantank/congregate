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
		$select		= $tasks->select()->where('projectId = ?', $projectId)->order(array('priority ASC', 'task ASC'));
		$this->view->tasks	= $tasks->fetchAll($select);
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
			$element			= $this->_request->getParam('id');
			list($section, $id)	= explode('_', $element);
			$text				= $this->_request->getParam('value');

			$tasks		= new Tasks();
			$task		= $tasks->fetchRow($tasks->select()->where('id = ?', $id));

			$task->{$section}	= $text;
			switch($section) {
				case 'completedBy';
					$task->status = ($text == '' ? 0 : 1);
					break;
				case 'estimateCurrent':
				case 'elapsed':
					$task->remaining = $task->estimateCurrent - $task->elapsed;
					break;
			}
			$task->save();

			echo $text;
		}
	}
}