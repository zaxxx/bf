<?php

namespace BF\Components\Comments;

use BF\Components\BaseControl;
use BF\Forms\IFormFactory;
use BF\Model\Comments\ICommentsRepository;
use Nette\Forms\Form;

class EditCommentControl extends BaseControl {

	public $onCancel = [];

	public $onSuccess = [];

	protected $commentId;

	protected $commentsRepository;

	protected $formFactory;

	protected $comment;

	public function __construct(ICommentsRepository $commentsRepository, IFormFactory $formFactory) {
		$this->commentsRepository = $commentsRepository;
		$this->formFactory = $formFactory;
	}

	public function setCommentId($commentId) {
		$this->commentId = (int) $commentId;
		return $this;
	}

	protected function getComment() {
		if($this->comment === NULL) {
			$this->comment = $this->commentsRepository->getById($this->commentId);
		}
		return $this->comment;
	}

	public function viewDefault() {

	}

	public function beforeRender() {

	}

	protected function createComponentForm() {
		$form = $this->formFactory->create();

		$form->addTextArea('content', 'Comment');

		$form->addSubmit('send', 'Edit comment');
		$form->addSubmit('cancel', 'Cancel')
			->setValidationScope(FALSE);

		$form->setDefaults($this->getComment());

		$form->addProtection();

		$form->onSuccess[] = [$this, 'formSubmitted'];

		return $form;
	}

	public function formSubmitted(Form $form, $values) {
		if($form->submitted === $form['cancel']) {
			$this->onCancel();
		} else if($form->submitted === $form['send']) {
			$this->commentsRepository->editComment($this->commentId, $values->content);
			$this->onSuccess();
		}
	}

}

interface IEditCommentFactory {

	/** @return EditCommentControl */
	public function create();

}
