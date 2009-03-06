<?php

class SignaturesController extends Zend_Controller_Action
{
	public function addAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$projectId	= $_SESSION['projectId'];
		$type		= $this->_request->getParam('type');
		$projects	= new Projects();
		$signatures	= new Signatures();
		
		$data		= array(
			'signature'	=> $this->_request->getParam('name'),
			'projectId'	=> $projectId,
			'type'		=> $type,
		);
		
		$signatures->insert($data);
		$project = $projects->fetchRow($projects->select()->where('id = ?', $projectId));
		if($project->status == 1 && $type == 'sdd') {
			$project->status = 2;
			$project->save();
		}
		
		if($project->status == 2 && $type == 'design') {
			$project->status = 3;
			$project->save();
		}
	}

	public function generateAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$projectId	= $_SESSION['projectId'];
		$type		= $this->_request->getParam('type');
		
		$signatures	= new Signatures();
		$sigs		= $signatures->fetchAll($signatures->select()->where('projectId = ?', $projectId)->where('type = ?', $type));
		
		foreach($sigs as $row) {
			echo $row->signature . '<br>';
		}
	}
}