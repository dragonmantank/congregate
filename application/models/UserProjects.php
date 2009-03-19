<?php

class UserProjects extends Zend_Db_Table_Abstract
{
	protected $_name	= 'up_UserProjects';

	public function getMembers($projectId)
	{
		$select	= $this->select()->from(array('up' => $this->_name))
								 ->where('up.projectId = ?', $projectId)
								 ->join(array('u' => 'u_Users', array('name', 'email')), 'u.id = up.userId')
								 ->order('u.name ASC')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}
}