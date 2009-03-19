<?php

class UserProjects extends Zend_Db_Table_Abstract
{
	protected $_name	= 'up_UserProjects';

	public function addUser($uid, $pid)
	{
		return $this->insert(array('userId' => $uid, 'projectId' => $pid));
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
}