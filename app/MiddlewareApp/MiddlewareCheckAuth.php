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

class MiddlewareCheckAuth implements MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandler $handler
     * @return \Http\Response\Response
     */
	public function process(ServerRequest $request, RequestHandler $handler)
	{
		return $handler->handle($request, $handler);
	}
}