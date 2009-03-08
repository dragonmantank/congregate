<?php

class Tasks extends Zend_Db_Table_Abstract
{
	protected $_name	= 't_Tasks';
	
	public function add(array $data)
	{
		$data['estimateCurrent']	= $data['estimateOrig'];
		$data['elapsed']			= 0;
		$data['remaining']			= $data['estimateOrig'];
		
		return parent::insert($data);
	}
}