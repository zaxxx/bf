<?php

namespace BF\Model\Comments;

use BF\Model\TreeRepository;
use Nette\Database;

class CommentsRepository extends TreeRepository implements ICommentsRepository {

	public function findAll() {
		return $this->getTable()
			->select('id, author, time_posted, content, depth')
			->order('lft')
			->fetchAll();
	}

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

	public function deleteComment($id) {
		$this->removeSubtree($id);
	}

	public function editComment($id, $comment) {
		$this->getTable()
			->wherePrimary($id)
			->update(['content' => $comment]);
	}

}
