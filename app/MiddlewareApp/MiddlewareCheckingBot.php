<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.03.2018
 * Time: 2:13
 */

namespace App\MiddlewareApp;

use Http\Request\ServerRequest;
use Http\Middleware\RequestHandler;
use Http\Middleware\MiddlewareInterface;

class MiddlewareCheckingBot implements MiddlewareInterface
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