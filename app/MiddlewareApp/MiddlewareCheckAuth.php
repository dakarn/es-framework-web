<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:43
 */

namespace App\MiddlewareApp;

use Http\Request\ServerRequest;
use Http\Middleware\MiddlewareInterface;
use Http\Middleware\RequestHandler;
use Http\Response\Response;
use Models\User\User;
use System\Router\Routing;

class MiddlewareCheckAuth implements MiddlewareInterface
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return Response|mixed
	 * @throws \Exception\FileException
	 */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		$routersName = [
			'authUser',
			'logout',
			'registerUser',
		];

		$isBug  = false;
		$router = Routing::getFoundRouter();

		switch (true) {
			case $router->getName() === $routersName[0] && User::current()->isAuth():
				$isBug = true;
				break;
			case $router->getName() === $routersName[2] && User::current()->isAuth():
				$isBug = true;
				break;
			case $router->getName() === $routersName[1] && !User::current()->isAuth():
				$isBug = true;
				break;
		}

		if ($isBug) {
			(new Response())->redirect(URL);
		}

		return $handler->handle($request, $handler);
	}
}