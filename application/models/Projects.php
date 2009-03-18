<?php

class Projects extends Zend_Db_Table_Abstract
{
	protected $_name	= 'p_Projects';

	public function add(array $data)
	{
		$identity		= Zend_Auth::getInstance()->getIdentity();
		$data['author']	= $identity->id;

		$this->insert($data);
	}
}