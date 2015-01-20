<?php

namespace BF\Model;

class TreeRepository extends AbstractRepository {

	protected function addChild($parentId, $data) {
		$this->database->beginTransaction();

		$parent = $this->getById($parentId);

		// re-build "lft"
		$this->getTable()->where('lft > ?', $parent['rgt'])
			->update(['lft' => $this->database->literal('lft + 2')]);

		// re-build "rgt
		$this->getTable()->where('rgt >= ?', $parent['rgt'])
			->update(['rgt' => $this->database->literal('rgt + 2')]);

		// insert
		$data['lft'] = $parent['rgt'];
		$data['rgt'] = $parent['rgt'] + 1;
		$data['depth'] = $parent['depth'] + 1;
		$this->getTable()->insert($data);

		$this->database->commit();
	}

	protected function appendToEnd($data) {
		$this->database->beginTransaction();

		$struct = $this->getTable()->select('IFNULL(MAX(rgt), 0) + 1 AS lft, IFNULL(MAX(rgt), 0) + 2 AS rgt')
			->fetch();
		$data['lft'] = $struct['lft'];
		$data['rgt'] = $struct['rgt'];
		$this->getTable()->insert($data);

		$this->database->commit();
	}

}
