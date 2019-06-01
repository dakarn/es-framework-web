<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.04.2018
 * Time: 15:10
 */

namespace ES\App\MiddlewareApp;

use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Middleware\MiddlewareInterface;
use ES\Kernel\Http\Middleware\RequestHandler;

class MiddlewareCheckAjax implements MiddlewareInterface
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