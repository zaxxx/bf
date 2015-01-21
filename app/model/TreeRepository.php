<?php

namespace BF\Model;

class TreeRepository extends AbstractRepository {

	/**
	 * @param int $parentId
	 * @param array $data
	 */
	protected function addChild($parentId, array $data) {
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

	/**
	 * @param array $data
	 */
	protected function appendToEnd(array $data) {
		$this->database->beginTransaction();

		$struct = $this->getTable()->select('IFNULL(MAX(rgt), 0) + 1 AS lft, IFNULL(MAX(rgt), 0) + 2 AS rgt')
			->fetch();
		$data['lft'] = $struct['lft'];
		$data['rgt'] = $struct['rgt'];
		$this->getTable()->insert($data);

		$this->database->commit();
	}

	/**
	 * @param int $nodeId
	 */
	protected function removeSubtree($nodeId) {
		$this->database->beginTransaction();

		$node = $this->getById($nodeId);

		$this->getTable()
			->where('lft >= ? AND rgt <= ?', $node['lft'], $node['rgt'])
			->delete();

		$diff = $node['rgt'] - $node['lft'] + 1;

		$this->getTable()
			->where('lft > ?', $node['rgt'])
			->update(['lft' => $this->database->literal('lft - ' . $diff)]);

		$this->getTable()
			->where('rgt > ?', $node['rgt'])
			->update(['rgt' => $this->database->literal('rgt - ' . $diff)]);

		$this->database->commit();
	}

}
