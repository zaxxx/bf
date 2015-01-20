<?php

namespace BF\Model\Comments;

interface ICommentsRepository {

	public function findAll();

	public function getById($id);

	public function addComment($author, $comment, $parentId = NULL);

}
