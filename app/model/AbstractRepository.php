<?php

namespace BF\Model;

use Nette\Database;

class AbstractRepository {

	protected $tableName;

	protected $database;

	public function __construct($tableName, Database\Context $context) {
		$this->tableName = $tableName;
		$this->database = $context;
	}

	protected function getTable() {
		return $this->database->table($this->tableName);
	}

	public function getById($id) {
		return $this->getTable()
			->select('*')
			->wherePrimary($id)
			->fetch();
	}

}
