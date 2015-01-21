<?php

namespace BF\Components\Comments;

use BF\Components\BaseControl;
use BF\Forms\IFormFactory;
use BF\Model\Comments\ICommentsRepository;
use Nette\Forms\Form;
use Nette\Database\Table\IRow;



class EditCommentControl extends BaseControl {

	public $onCancel = [];

	public $onSuccess = [];

	/** @var int */
	protected $commentId;

	/** @var ICommentsRepository */
	protected $commentsRepository;

	/** @var IFormFactory */
	protected $formFactory;

	/** @var IRow|NULL */
	protected $comment;

	public function __construct(ICommentsRepository $commentsRepository, IFormFactory $formFactory) {
		$this->commentsRepository = $commentsRepository;
		$this->formFactory = $formFactory;
	}

	/**
	 * @param int $commentId
	 * @return $this
	 */
	public function setCommentId($commentId) {
		$this->commentId = (int) $commentId;
		return $this;
	}

	/**
	 * @return IRow
	 */
	protected function getComment() {
		if($this->comment === NULL) {
			$this->comment = $this->commentsRepository->getById($this->commentId);
		}
		return $this->comment;
	}

	public function viewDefault() {}

	public function beforeRender() {}

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
