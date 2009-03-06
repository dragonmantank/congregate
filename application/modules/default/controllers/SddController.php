<?php

class SddController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$projectId	= $_SESSION['projectId'];

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
	
	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}
	
	public function saveAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if($_POST) {
			$section	= $this->_request->getParam('section');
			$text		= $this->_request->getParam('text');
			$projectId	= $_SESSION['projectId'];
			$sdds		= new SDDs();
			$sdd		= $sdds->fetchRow($sdds->select()->where('projectId = ?', $projectId));
			
			$sdd->{$section}	= $text;
			$sdd->save();
		}
	}
}