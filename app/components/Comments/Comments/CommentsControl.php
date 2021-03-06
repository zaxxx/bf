<?php

namespace BF\Components\Comments;

use BF\Model\Comments\ICommentsRepository;
use Zax\Application\UI\Control;

class CommentsControl extends Control {

	/** @persistent */
	public $id;

	/** @var ICommentsRepository */
	protected $commentsRepository;

	/** @var IAddCommentFactory */
	protected $addCommentFactory;

	/** @var IEditCommentFactory */
	protected $editCommentFactory;

	/** @var IDeleteCommentFactory */
	protected $deleteCommentFactory;

	public function __construct(ICommentsRepository $commentsRepository,
	                            IAddCommentFactory $addCommentFactory,
	                            IEditCommentFactory $editCommentFactory,
	                            IDeleteCommentFactory $deleteCommentFactory) {
		$this->commentsRepository = $commentsRepository;
		$this->addCommentFactory = $addCommentFactory;
		$this->editCommentFactory = $editCommentFactory;
		$this->deleteCommentFactory = $deleteCommentFactory;
	}

	public function viewDefault() {}

	public function viewReply() {}

	public function viewEdit() {}

	public function viewDelete() {}

	public function beforeRender() {
		$this->template->comments = $this->commentsRepository->findAll();
	}

	protected function goDefault() {
		$this->go('this', ['view' => 'Default', 'id' => NULL]);
	}

	protected function createComponentAddComment() {
	    $control = $this->addCommentFactory->create();

		$control->onCancel[] = function() {$this->goDefault();};

		$control->onSuccess[] = function() {
			$this->presenter->flashMessage('Comment added.', 'success');
			$this->goDefault();
		};

		return $control;
	}

	protected function createComponentReply() {
		$control = $this->addCommentFactory->create()
			->setReplyTo($this->id);

		$control->onCancel[] = function() {$this->goDefault();};

		$control->onSuccess[] = function() {
			$this->presenter->flashMessage('Reply added.', 'success');
			$this->goDefault();
		};

		return $control;
	}

	protected function createComponentEditComment() {
	    $control = $this->editCommentFactory->create()
			->setCommentId($this->id);

		$control->onCancel[] = function() {$this->goDefault();};

		$control->onSuccess[] = function() {
			$this->presenter->flashMessage('Comment edited.', 'success');
			$this->goDefault();
		};

		return $control;
	}

	protected function createComponentDeleteComment() {
	    $control = $this->deleteCommentFactory->create()
		    ->setCommentId($this->id);

		$control->onCancel[] = function() {$this->goDefault();};

		$control->onSuccess[] = function() {
			$this->presenter->flashMessage('Comment deleted.', 'success');
			$this->goDefault();
		};

		return $control;
	}

}

interface ICommentsFactory {

	/** @return CommentsControl */
	public function create();

}
