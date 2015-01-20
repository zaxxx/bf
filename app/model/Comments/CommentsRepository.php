<?php

namespace BF\Model\Comments;

use BF\Model\TreeRepository;
use Nette\Database;

class CommentsRepository extends TreeRepository implements ICommentsRepository {

	public function findAll() {
		return $this->getTable()
			->select('author, time_posted, content, depth')
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

}
