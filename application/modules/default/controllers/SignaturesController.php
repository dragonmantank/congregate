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
		if($project->status == 1 && $type == 'approval') {
			$project->status = 2;
			$project->save();
		}

		if($project->status == 2 && $type == 'sdd') {
			$project->status = 3;
			$project->save();
		}

		if($project->status == 3 && $type == 'design') {
			$project->status = 4;
			$project->save();
		}

		if($project->status == 4 && $type == 'implementation') {
			$project->status = 5;
			$project->save();
		}

		echo json_encode(array('status' => 1));
	}

	public function addreqAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$psig		= new ProjectSignatures();

		$pid		= $_SESSION['projectId'];
		$uid		= $this->_request->getParam('uid');
		$section	= $this->_request->getParam('section');

		if( !$psig->exists($pid, $uid, $section) ) {
			$psig->add($pid, $uid, $section);
			$status		= 1;
			$message	= 'Signature was added successfully';
		} else {
			$status		= 0;
			$message	= 'Signature is already required for this section';
		}

		echo json_encode(array('status' => $status, 'message' => $message));
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

	public function removereqAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$projectId	= $_SESSION['projectId'];
		$user		= Zend_Auth::getInstance()->getIdentity();
		$p			= new Projects();
		$u			= new Users();
		$psig		= new ProjectSignatures();

		$sid		= $this->_request->getParam('sid');
		$sig		= $psig->find($sid)->current();
		$pOwner		= $p->fetchOwner($projectId);

		if( ($user->id != $pOwner) ) {
			if( !($u->isAdmin($user->primaryGroup)) ) {
				$this->_forward('index', 'restricted');
			}
		}

		if($sig->signatureId == $pOwner) {
			$status		= 0;
			$message	= 'Cannot remove signature of project author.';
		} else {
			$sig->delete();
			$status		= 1;
			$message	= 'Signature was removed';
		}

		echo json_encode(array('status' => $status, 'message' => $message));
	}
}