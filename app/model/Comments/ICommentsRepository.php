<?php

namespace BF\Model\Comments;

interface ICommentsRepository {

	public function findAll();

	public function getById($id);

	public function addComment($author, $comment, $parentId = NULL);

	public function deleteComment($id);

	public function editComment($id, $comment);

}
