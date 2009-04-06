<?php

class Notes extends Zend_Db_Table_Abstract
{
	protected $_name	= 'n_Notes';

	public function addNewNote($title, $text, $section, $projectId)
	{
		$data['projectId']	= $projectId;
		$data['userId']		= Zend_Auth::getInstance()->getIdentity()->id;
		$data['sectionId']	= $section;

		$noteId	= $this->insert($data);

		$nt	= new NotesText();

		$detailData['noteId']	= $noteId;
		$detailData['title']	= $title;
		$detailData['text']		= $text;
		$detailData['author']	= $data['userId'];

		$revId	= $nt->insert($detailData);

		$this->update(array('currentRev' => $revId), 'id = ' . $noteId);

		return true;
	}

	public function fetchNotes($pid)
	{
		$select	= $this->select()->from(array('n' => $this->_name))
								 ->join(array('nt' => 'nt_NotesText'), 'nt.noteId = n.id', array('noteTitle' => 'title','noteText' => 'text', 'lastUpdated' => 'dateAdded', 'textAuthor' => 'author'))
								 ->join(array('u' => 'u_Users'), 'nt.author = u.id', array('authorName' => 'name', 'authorEmail' => 'email'))
								 ->where('n.projectId = ?', $pid)
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}
}