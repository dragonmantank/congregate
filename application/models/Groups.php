<?php

class Groups extends Zend_Db_Table_Abstract
{
	protected $_name	= 'g_Groups';

	public function getLevel($gid)
	{
		$select	= $this->select()->from(array('g' => $this->_name), 'level')
							   	 ->where('g.id = ?', $gid);

		$result	= $this->fetchRow($select);

		return $result->level;
	}
}