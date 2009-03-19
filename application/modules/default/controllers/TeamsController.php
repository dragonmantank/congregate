<?php

class TeamsController extends Zend_Controller_Action
{
/*
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

		if($project->status == 3 && $type == 'implementation') {
			$project->status = 4;
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
*/

	public function addAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$up		= new UserProjects();
		$name	= $this->_request->getParam('name');
		$email	= $this->_request->getParam('email');
		$id		= $this->_request->getParam('id');
		$pid	= $_SESSION['projectId'];

		if($id != '') {
			if($up->isMember($id, $pid)) {
				$status 	= -1;
				$message	= 'User exists in project';
			} else {
				$up->addUser($id, $pid);
				$status 	= 1;
				$message	= 'Existing User was added to project';
			}
		} else {
			$u		= new Users();
			$uid	= $u->autoCreate($name, $email);
			$up->addUser($uid, $pid);
			$status 	= 1;
			$message	= 'New User was added to project';
		}

		echo json_encode(array('status' => $status, 'message' => $message));
	}

	public function searchAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$u	= new Users();
		$user	= $u->fetchRow($u->select()->from($u, array('name', 'id'))->where('email = ?', $this->_request->getParam('email')));

		if( is_object($user) ) {
			$status	= 1;
			$name	= $user->name;
			$id		= $user->id;
		} else {
			$status	= 0;
			$name	= '';
			$id		= '';
		}

		echo json_encode(array('status' => $status, 'name' => $name, 'id' => $id));
	}
}