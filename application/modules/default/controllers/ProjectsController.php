<?php

class ProjectsController extends Zend_Controller_Action
{
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
	
	public function addsddsignatureAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$projectId	= $this->_request->getParam('projectId');
		$projects	= new Projects();
		$signatures	= new Signatures();
		$data		= array(
			'signature'	=> $this->_request->getParam('name'),
			'projectId'	=> $projectId,
			'type'		=> 'sdd',
		);
		
		$signatures->insert($data);
		$project = $projects->fetchRow($projects->select()->where('id = ?', $projectId));
		if($project->status == 1) {
			$project->status = 2;
			$project->save();
		}
	}
	
	public function generatesddsignaturesAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$signatures	= new Signatures();
		$sigs		= $signatures->fetchAll($signatures->select()->where('projectId = ?', $this->_request->getParam('project'))->where('type = ?', 'sdd'));
		
		foreach($sigs as $row) {
			echo $row->signature . '<br>';
		}
	}
	
	public function sddsaveAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if($_POST) {
			$section	= $this->_request->getParam('section');
			$text		= $this->_request->getParam('text');
			$projectId	= $this->_request->getParam('project');
			$sdds		= new SDDs();
			$sdd		= $sdds->fetchRow($sdds->select()->where('projectId = ?', $projectId));
			
			$sdd->{$section}	= $text;
			$sdd->save();
		}
	}
	
	public function sddAction()
	{
		$projectId	= $this->_request->getParam('project');

		$projects	= new Projects();
		$sdds		= new SDDs();
		$sdd		= $sdds->fetchAll($sdds->select()->where('projectId = ?', $projectId));
		$project	= $projects->find($projectId)->current();
		
		if(count($sdd) == 0) {
			$sdd	= $sdds->createRow();
			$sdd->projectId = $projectId;
			$sdd->save();
		} elseif(count($sdd) == 1) {
			$sdd	= $sdd[0];
		}
	
		$this->view->projectName	= $project->name;
		$this->view->projectId		= $projectId;
		$this->view->assign($sdd->toArray());
	}
}