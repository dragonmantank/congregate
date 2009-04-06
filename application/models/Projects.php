<?php

class Projects extends Zend_Db_Table_Abstract
{
	protected $_name	= 'p_Projects';

	public function add(array $data)
	{
		$identity		= Zend_Auth::getInstance()->getIdentity();
		$data['author']	= $identity->id;
		$data['slug']	= $this->_generateSlug($data['name']);

		if( $this->insert($data) ) {
			$projectId	= $this->getAdapter()->lastInsertId();
			$up			= new UserProjects();
			$up->insert(array('userId' => $identity->id, 'projectId' => $projectId));

			$psig	= new ProjectSignatures();
			foreach($this->fetchSections() as $section) {
				$psig->add($projectId, $data['author'], $section->id);
			}
		}
	}

	public function addSignature($pid, $signature, $section)
	{
		$signatures	= new Signatures();

		return $signatures->add($pid, $signature, $section);
	}

	public function fetchAllProjects()
	{
		$select	= $this->select()->from(array('p' => $this->_name))
								 ->join(array('u' => 'u_Users'), 'p.author = u.id', array('authorName' => 'name', 'authorEmail' => 'email'))
								 ->join(array('ps' => 'ps_ProjectSections'), 'p.status = ps.id', array('statusName' => 'name'))
								 ->order('p.name ASC')
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}

	public function fetchAllByUser($uid)
	{
		$up	= new UserProjects();

		return $up->fetchUserProjects($uid);
	}

	public function fetchFiles($pid)
	{
		$f	= new Files();

		return $f->fetchFilesByProject($pid);
	}

	public function fetchOwner($pid)
	{
		$select	= $this->select()->from($this, 'author')
								 ->where('id = ?', $pid);

		$row	= $this->fetchRow($select);
		return $row->author;
	}

	public function fetchSlug($pid) {
		$select	= $this->select()->from($this, 'slug')
								 ->where('id = ?', $pid);

		$row	= $this->fetchRow($select);
		return $row->slug;
	}

	public function fetchSections()
	{
		$ps	= new ProjectSections();

		return $ps->fetchAll();
	}

	public function fetchTeamMembers($pid)
	{
		$up	= new UserProjects();

		return $up->getMembers($pid);
	}

	protected function _generateSlug($name)
	{
		$badData	= array(' ', ',', '.', '!', '?', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=', '{', '}', '[', ']', ':', ';', '\\', '|');
		$goodData	= array('-', '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',  '',   '');

		return strtolower(str_replace($badData, $goodData, $name));
	}

	public function getRequiredSignatures($pid)
	{
		$psig	= new ProjectSignatures();

		return $psig->fetchRequiredSignatures($pid);
	}

	public function isMember($uid, $pid)
	{
		$up	= new UserProjects();

		return $up->isMember($uid, $pid);
	}

	public function moveForward($pid)
	{
		$project	= $this->find($pid)->current();
		$project->status++;
		$project->save();
	}
}
