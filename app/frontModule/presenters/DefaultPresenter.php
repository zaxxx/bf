<?php

namespace BF\FrontModule;

use BF\Components\Comments\ICommentsFactory;
use Nette\Application\UI\Presenter;

class DefaultPresenter extends Presenter {

	protected $commentsFactory;

	public function __construct(ICommentsFactory $commentsFactory) {
		$this->commentsFactory = $commentsFactory;
	}

	protected function createComponentComments() {
		return $this->commentsFactory->create();
	}

}
