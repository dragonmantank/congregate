<?php

class UserProjects extends Zend_Db_Table_Abstract
{
	protected $_name	= 'up_UserProjects';

	public function addUser($uid, $pid)
	{
		$u	= new Users();
		$user	= $u->find($uid)->current();
		if( $this->insert(array('userId' => $uid, 'projectId' => $pid)) ) {
			$u->sendEmail($user->email, $user->name, 'You have been added as a team member to a new project.', 'BiffPM - New Project');
			return true;
		} else {
			return false;
		}
	}

	public function fetchUserProjects($uid)
	{
		$select	= $this->select()->from(array('up' => $this->_name), array('userId'))
								 ->where('up.userId = ?', $uid)
								 ->join(array('p' => 'p_Projects'), 'p.id = up.projectId')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}

	public function getMembers($projectId)
	{
		$select	= $this->select()->from(array('up' => $this->_name))
								 ->where('up.projectId = ?', $projectId)
								 ->join(array('u' => 'u_Users', array('name', 'email')), 'u.id = up.userId')
								 ->order('u.name ASC')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}

	public function isMember($uid, $pid)
	{
		$select	= $this->select()->from($this, 'id')
								 ->where('userId = ?', $uid)
								 ->where('projectId = ?', $pid);

		$result	= $this->fetchAll($select);

		return (count($result) ? true : false);
	}

	public function removeProject($uid, $pid)
	{
		$where[]	= $this->getAdapter()->quoteInto('userId = ?', $uid);
		$where[]	= $this->getAdapter()->quoteInto('projectId = ?', $pid);

		return $this->delete($where);
	}
}