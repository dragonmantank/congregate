<?php

class Bugs extends Zend_Db_Table_Abstract
{
	protected $_name	= 'b_Bugs';

	public function add($data, $pid, $section)
	{
		$data['projectId']	= $pid;
		$data['reporter']	= Zend_Auth::getInstance()->getIdentity()->id;
		$data['sectionId']	= $section;

		$this->insert($data);
	}

	public function fetchAllByProject($pid)
	{
		$select	= $this->select()->from(array('b' => $this->_name))
								 ->join(array('bc' => 'bc_BugCategories'), 'b.categoryId = bc.id', array('categoryName' => 'name'))
								 ->join(array('bs' => 'bs_BugSeverity'), 'b.severityId = bs.id', array('severityName' => 'name', 'severityWeight' => 'weight'))
								 ->join(array('bp' => 'bp_BugPriority'), 'b.priorityId = bp.id', array('priorityName' => 'name', 'priorityWeight' => 'weight'))
								 ->join(array('u' => 'u_Users'), 'b.reporter = u.id', array('reporterName' => 'name', 'reporterEmail' => 'email'))
								 ->join(array('u2' => 'u_Users'), 'b.assignedTo = u2.id', array('assignedName' => 'name', 'assignedEmail' => 'email'))
								 ->where('b.projectId = ?', $pid)
								 ->setIntegrityCheck(false);

		return $this->fetchAll($select);
	}

	public function fetchCategories()
	{
		$bc	= new BugCategories();

		return $bc->fetchAll();
	}

	public function fetchPriorities()
	{
		$bc	= new BugPriority();

		return $bc->fetchAll();
	}

	public function fetchSeverities()
	{
		$bc	= new BugSeverity();

		return $bc->fetchAll();
	}
}
