<?php

namespace BF\Model\Comments;

use BF\Model\TreeRepository;
use Nette\Database;

class CommentsRepository extends TreeRepository implements ICommentsRepository {

	/**
	 * @return array|Database\Table\IRow[]
	 */
	public function findAll() {
		return $this->getTable()
			->select('id, author, time_posted, content, depth')
			->order('lft')
			->fetchAll();
	}

	/**
	 * @param string $author
	 * @param string $comment
	 * @param int|NULL $parentId
	 */
	public function addComment($author, $comment, $parentId = NULL) {

		$data = [
			'author' => $author,
			'content' => $comment,
			'time_posted' => $this->database->literal('NOW()')
		];

		if($parentId === NULL) {
			$this->appendToEnd($data);
		} else {
			$this->addChild($parentId, $data);
		}
	}

	/**
	 * @param int $id
	 */
	public function deleteComment($id) {
		$this->removeSubtree($id);
	}

	/**
	 * @param int $id
	 * @param string $comment
	 */
	public function editComment($id, $comment) {
		$this->getTable()
			->wherePrimary($id)
			->update(['content' => $comment]);
	}

}
