<?php

class FilesComments extends Zend_Db_Table_Abstract
{
	protected $_name	= 'fc_FilesComments';

	public function fetchCommentsByFile($fid)
	{
		$select	= $this->select()->from(array('fc' => $this->_name))
								 ->join(array('u' => 'u_Users'), 'u.id = fc.author', array('name', 'email'))
								 ->where('fileId = ?', $fid)
								 ->order('dateAdded ASC')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}
}