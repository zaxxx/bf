<?php

namespace BF\Components;

use Zax\Application\UI\Control;

class FlashMessageControl extends Control {


	public function viewDefault() {

	}

	public function beforeRender() {

	}

}

interface IFlashMessageFactory {

	/** @return FlashMessageControl */
	public function create();

}
