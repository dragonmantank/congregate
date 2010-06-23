<?php

class Signatures extends Zend_Db_Table_Abstract
{
	protected $_name	= 'sig_Signatures';

	public function add($pid, $signature, $section)
	{
		$sections			= new ProjectSections();
		$projectSigs		= new ProjectSignatures();
		$user				= Zend_Auth::getInstance()->getIdentity();

		$data['projectId']	= $pid;
		$data['signature']	= $user->name;
		$data['section']	= ( is_numeric($section) ? $section : $sections->getId($section) );

		$id = $this->insert($data);

		$projectSigs->capture($data['projectId'], $user->id, $data['section']);

		return $id;
	}
}