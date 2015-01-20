<?php

namespace BF\Components\Comments;

use BF\Model\Comments\ICommentsRepository;
use Zax\Application\UI\Control;

class CommentsControl extends Control {

	protected $commentsRepository;

	public function __construct(ICommentsRepository $commentsRepository) {
		$this->commentsRepository = $commentsRepository;
		//$this->commentsRepository->addComment('Test', 'first');
		//$this->commentsRepository->addComment('Test 2', 'reply to 1', 1);
		//$this->commentsRepository->addComment('Test 3', 'reply to 2', 2);
		//$this->commentsRepository->addComment('Test 4', 'reply to 1', 1);
	}

	public function viewDefault() {
		$this->template->comments = $this->commentsRepository->findAll();
	}

	public function beforeRender() {}

}

interface ICommentsFactory {

	/** @return CommentsControl */
	public function create();

}
