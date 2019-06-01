<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.03.2018
 * Time: 2:13
 */

namespace ES\App\MiddlewareApp;

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Middleware\RequestHandler;
use ES\Kernel\Http\Middleware\MiddlewareInterface;

class MiddlewareCheckingBot implements MiddlewareInterface
{
	/**
	 * @param ServerRequest $request
	 * @param RequestHandler $handler
	 * @return \ES\Kernel\Http\Response\Response
	 * @throws \ES\Kernel\Exception\MiddlewareException
	 */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		return $handler->handle($request, $handler);
	}
}