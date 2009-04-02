<?php

class Signatures extends Zend_Db_Table_Abstract
{
	protected $_name	= 'sig_Signatures';

	public function add($pid, $signature, $section)
	{
		$sections			= new ProjectSections();


		$data['projectId']	= $pid;
		$data['signature']	= $signature;
		$data['section']	= $section;
	}
}