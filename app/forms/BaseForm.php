<?php

namespace BF\Forms;

use Nette\Application\UI;
use Zax\Application\UI\IAjaxAware;

class Form extends UI\Form implements IAjaxAware {

	/**
	 * @return $this
	 */
	public function enableAjax() {
		$this->getElementPrototype()->addClass('ajax');
		return $this;
	}

}
