<?php

class ProjectSections extends Zend_Db_Table_Abstract
{
	protected $_name	= 'ps_ProjectSections';

	public function getId($section)
	{
		$select	= $this->select()->from(array('ps' => $this->_name), 'id')
								 ->where('ps.name = ?', $section);

		$result	= $this->fetchRow($select);

		return $result->id;
	}
}