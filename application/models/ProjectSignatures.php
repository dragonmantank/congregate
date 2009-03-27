<?php

class ProjectSignatures extends Zend_Db_Table_Abstract
{
	protected $_name	= 'psig_ProjectSignatures';

	public function fetchRequiredSignatures($pid)
	{
		$select	= $this->select()->from(array('psig' => $this->_name))
								 ->join(array('u' => 'u_Users'), 'u.id = psig.signatureId', array('name', 'email'))
								 ->join(array('ps' => 'ps_ProjectSections'), 'ps.id = psig.sectionId', array('sectionName' => 'name'))
								 ->order('psig.sectionId ASC')
								 ->setIntegrityCheck(false);
echo $select->assemble();
		return $this->fetchAll($select);
	}
}