<?php

namespace BF\Router;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Application\IRouter;

class RouterFactory {

	/** @return IRouter */
	public function create() {
		$router = new RouteList('Front');

		$router[] = new Route('<presenter>/<action>', 'Default:default');

		return $router;
	}

}
