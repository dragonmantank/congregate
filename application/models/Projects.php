<?php

class Projects extends Zend_Db_Table_Abstract
{
	protected $_name	= 'p_Projects';

	public function add(array $data)
	{
		$identity		= Zend_Auth::getInstance()->getIdentity();
		$data['author']	= $identity->id;

		if( $this->insert($data) ) {
			$projectId = $this->getAdapter()->lastInsertId();
			$up			= new UserProjects();
			$up->insert(array('userId' => $identity->id, 'projectId' => $projectId));
		}
	}

	public function fetchAllByUser($uid)
	{
		$up	= new UserProjects();

		return $up->fetchUserProjects($uid);
	}
}
