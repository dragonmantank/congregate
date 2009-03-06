<?php

class ProjectsController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}
	
	public function addAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if($_POST) {
			$projectName	= $this->_request->getParam('projectName');
			$description	= $this->_request->getParam('projectDescription');
		
			try {
				$projects	= new Projects();
				$projects->insert(array('name' => $projectName, 'description' => $description));
				$status		= 1;
				$message	= 'Project was added successfully.';
			} catch (Exception $e) {
				$status		= 0;
				$message	= $e->getMessage();
			}
			
			echo json_encode(array('status' => $status, 'message' => $message));
		}
	}
	
	public function loadAction()
	{
		$projectId				= $this->_request->getParam('project');
		$_SESSION['projectId']	= $projectId;
		
		$this->_forward('index', 'sdd', 'default');
	}
}