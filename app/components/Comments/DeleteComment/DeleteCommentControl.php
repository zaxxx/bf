<?php

namespace BF\Components\Comments;

use BF\Components\BaseControl;
use BF\Forms\IFormFactory;
use BF\Model\Comments\ICommentsRepository;
use Nette\Forms\Form;

class DeleteCommentControl extends BaseControl {

	public $onCancel = [];

	public $onSuccess = [];

	protected $commentId;

	protected $commentsRepository;

	protected $formFactory;

	public function __construct(ICommentsRepository $commentsRepository, IFormFactory $formFactory) {
		$this->commentsRepository = $commentsRepository;
		$this->formFactory = $formFactory;
	}

	public function setCommentId($commentId) {
		$this->commentId = (int) $commentId;
		return $this;
	}

	public function viewDefault() {}

	public function beforeRender() {}

	protected function createComponentForm() {
	    $form = $this->formFactory->create();

		$form->addSubmit('delete', 'Yes, delete it');
		$form->addSubmit('cancel', 'No');

		$form->addProtection();

		$form->onSuccess[] = [$this, 'formSubmitted'];

		return $form;
	}

	public function formSubmitted(Form $form, $values) {
		if($form->submitted === $form['cancel']) {
			$this->onCancel();
		} else if($form->submitted === $form['delete']) {
			$this->commentsRepository->deleteComment($this->commentId);
			$this->onSuccess();
		}
	}

}

interface IDeleteCommentFactory {

	/** @return DeleteCommentControl */
	public function create();

}
