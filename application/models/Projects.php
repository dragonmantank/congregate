<?php

class Projects
{
	protected $_table;

	public function getTable()
	{
		if(null === $this->_table) {
			$this->_table = new DbTable_Projects;
		}

		return $this->_table;
	}

	public function save(array $data)
	{
		$table	= $this->getTable();
		$fields	= $table->info(Zend_Db_Table_Abstract::COLS);

		foreach($data as $field => $value) {
			if(!in_array($field, $fields)) {
				unset($data[$field]);
			}
		}

		return $table->insert($data);
	}

	public function fetchAll()
	{
		return $this->getTable()->fetchAll()->toArray();
	}

	public function fetchProject($id)
	{
		$table 	= $this->getTable();
		$select	= $table->select->where('id = ?', $id);

		return $table->fetchRow($select)->toArray();
	}
}