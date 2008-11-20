<?php

class Tasks
{
	protected $_table;

	public function getTable()
	{
		if(null === $this->_table) {
			$this->_table = new DbTable_Tasks;
		}

		return $this->_table;
	}

	public function save(array $data)
	{
		$table	= $this->getTable();
		$fields	= $table->info(Zend_Db_Table_Abstract::COLS);

		$data['currEst'] = $data['origEst'];

		foreach($data as $field => $value) {
			if(!in_array($field, $fields)) {
				unset($data[$field]);
			}
		}

		return $table->insert($data);
	}

	public function fetchAll($pid)
	{
		$table	= $this->getTable();
		$select	= $table->select()
						->from('Tasks', array('*', 'estRemain' => '(currEst - elapsed)'))
						->where('projectId = ?', $pid);

		return $table->fetchAll($select)->toArray();
	}

	public function fetchTask($id)
	{
		$table 	= $this->getTable();
		$select	= $table->select()->where('id = ?', $id);

		return $table->fetchRow($select)->toArray();
	}
}