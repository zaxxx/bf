<?php

namespace BF\Components\Comments;

use BF\Forms\IFormFactory;
use BF\Model\Comments\ICommentsRepository;
use Nette\Forms\Form;
use Zax\Application\UI\Control;

class AddCommentControl extends Control {

	public $onCancel = [];

	public $onSuccess = [];

	/** @var int|NULL */
	protected $replyTo;

	/** @var ICommentsRepository */
	protected $commentsRepository;

	/** @var IFormFactory */
	protected $formFactory;

	public function __construct(ICommentsRepository $commentsRepository, IFormFactory $formFactory) {
		$this->commentsRepository = $commentsRepository;
		$this->formFactory = $formFactory;
	}

	/**
	 * @param int|NULL $replyTo
	 * @return $this
	 */
	public function setReplyTo($replyTo = NULL) {
		$this->replyTo = $replyTo === NULL ? NULL : (int) $replyTo;
		return $this;
	}

	public function viewDefault() {

	}

	public function beforeRender() {
		$this->template->replyTo = $this->replyTo;
	}

	protected function createComponentForm() {
	    $form = $this->formFactory->create();

		$form->addText('author', 'Name')
			->setRequired();

		$form->addTextArea('content', 'Comment');

		$form->addSubmit('send', 'Add comment');
		if($this->replyTo !== NULL) { // show Cancel button only when replying
			$form->addSubmit('cancel', 'Cancel')
				->setValidationScope(FALSE);
		}

		$form->addProtection();

		$form->onSuccess[] = [$this, 'formSubmitted'];

		return $form;
	}

	public function formSubmitted(Form $form, $values) {
		if($form->submitted === $form['send']) {
			$this->commentsRepository->addComment($values->author, $values->content, $this->replyTo);
			$form->setValues([], TRUE); // reset form
			$this->onSuccess();
		} else if($form->submitted === $form['cancel']) {
			$this->onCancel();
		}
	}

}

interface IAddCommentFactory {

	/** @return AddCommentControl */
	public function create();

}
