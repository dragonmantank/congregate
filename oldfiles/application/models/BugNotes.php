<?php

class BugNotes extends Zend_Db_Table_Abstract
{
	protected $_name	= 'bn_BugsNotes';

	public function add($bid, $note)
	{
		$data['bugId']	= $bid;
		$data['author']	= Zend_Auth::getInstance()->getIdentity()->id;
		$data['note']	= $note;

		$this->insert($data);
	}

	public function fetchNotes($bid)
	{
		$select	= $this->select()->from(array('bn' => $this->_name))
								 ->join(array('u' => 'u_Users'), 'bn.author = u.id', array('authorName' => 'name', 'authorEmail' => 'email'))
								 ->where('bn.bugId = ?', $bid)
								 ->order('dateCreated ASC')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}
}
