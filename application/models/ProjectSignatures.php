<?php

class ProjectSignatures extends Zend_Db_Table_Abstract
{
	protected $_name	= 'psig_ProjectSignatures';

	public function add($pid, $uid, $section)
	{
		$data	= array(
			'projectId'		=> $pid,
			'signatureId'	=> $uid,
			'sectionId'		=> $section,
		);

		return $this->insert($data);
	}

	public function exists($pid, $uid, $section)
	{
		$select	= $this->select()->where('projectId = ?', $pid)
								 ->where('sectionId = ?', $section)
								 ->where('signatureId = ?', $uid);

		$result	= $this->fetchAll($select);

		return (count($result) ? true : false);
	}

	public function fetchRequiredSignatures($pid)
	{
		$select	= $this->select()->from(array('psig' => $this->_name))
								 ->join(array('u' => 'u_Users'), 'u.id = psig.signatureId', array('name', 'email'))
								 ->join(array('ps' => 'ps_ProjectSections'), 'ps.id = psig.sectionId', array('sectionName' => 'name'))
								 ->order('psig.sectionId ASC')
								 ->where('psig.projectId = ?', $pid)
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}
}