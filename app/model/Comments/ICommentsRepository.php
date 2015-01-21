<?php

namespace BF\Model\Comments;
use Nette\Database\Table\IRow;

interface ICommentsRepository {

	/**
	 * @return array|IRow[]
	 */
	public function findAll();

	/**
	 * @param int $id
	 * @return IRow
	 */
	public function getById($id);

	/**
	 * @param string $author
	 * @param string $comment
	 * @param int|NULL $parentId
	 */
	public function addComment($author, $comment, $parentId = NULL);

	/**
	 * @param int $id
	 */
	public function deleteComment($id);

	/**
	 * @param int $id
	 * @param string $comment
	 */
	public function editComment($id, $comment);

}
