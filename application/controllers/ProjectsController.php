<?php

class ProjectsController extends Zend_Controller_Action
{
	public function addprojectAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		
		$task = new Projects;
		$task->save($_POST);
	}
	
	public function addtaskAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		$task = new Tasks;
		$task->save($_POST, $this->_request->getParam('project'));
	}

	public function edittaskAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		list($col, $id) = explode('_', $this->_request->getParam('id'));
		$value			= $this->_request->getParam('value');

		$table = new DbTable_Tasks;
		if( $table->update(array($col => $value), 'id = ' . $id) ) {
			switch($col) {
				case 'completedBy':
					if($value == '' || $value == '-') {
						$table->update(array('completed' => 0), 'id = ' . $id);
					} else {
						$table->update(array('completed' => 1), 'id = ' . $id);
					}
					break;
			}
			print $value;
		}
	}

	public function viewAction()
	{
		$tasks		= new Tasks;
		$projectId	= $this->_request->getParam('project');

		$this->view->tasks			= $tasks->fetchAll($projectId);
		$this->view->addTaskForm	= new AddTaskForm;
		$this->view->projectId		= $projectId;
	}
}
