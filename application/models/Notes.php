<?php

class Notes extends Zend_Db_Table_Abstract
{
	protected $_name	= 'n_Notes';

	public function addNewNote($title, $text, $section, $projectId)
	{
		$data['projectId']	= $projectId;
		$data['userId']		= Zend_Auth::getInstance()->getIdentity()->id;
		$data['section']	= $section;

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
		$select	= $this->select()->join(array('nt' => 'nt_NotesText'), 'nt.noteId = id')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}
}