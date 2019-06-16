<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.03.2018
 * Time: 23:43
 */

namespace ES\App\MiddlewareApp;

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Middleware\MiddlewareInterface;
use ES\Kernel\Http\Middleware\RequestHandler;
use ES\Kernel\Http\Response\Response;
use ES\Kernel\Models\User\User;
use ES\Kernel\Router\Routing;

class MiddlewareCheckAuth implements MiddlewareInterface
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return Response|mixed
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\MiddlewareException
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