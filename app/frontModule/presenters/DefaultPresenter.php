<?php

namespace BF\FrontModule;

use BF\Components\Comments\ICommentsFactory;
use BF\Components\IFlashMessageFactory;
use Nette\Application\UI\Presenter;

class DefaultPresenter extends Presenter {

	protected $commentsFactory;

	protected $flashMessageFactory;

	public function __construct(ICommentsFactory $commentsFactory, IFlashMessageFactory $flashMessageFactory) {
		$this->commentsFactory = $commentsFactory;
		$this->flashMessageFactory = $flashMessageFactory;
	}

	public function actionDefault() {
		// initialize components
		$this['comments'];
		$this['flashMessage'];
	}

	/** Redirect flashes to a special component
	 *
	 * @param string $message
	 * @param string $type
	 */
	public function flashMessage($message, $type = 'info') {
		$this['flashMessage']->flashMessage($message, $type);
		$this['flashMessage']->redrawControl();
	}

	protected function createComponentComments() {
		return $this->commentsFactory->create()
			->enableAjax();
	}

	protected function createComponentFlashMessage() {
	    return $this->flashMessageFactory->create()
		    ->enableAjax();
	}

}
