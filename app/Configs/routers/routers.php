<?php

use App\MiddlewareApp\MiddlewareCheckAuth;
use Http\Middleware\MiddlewareGrantAccess;
use Models\User\User;

return [
	[
		'name'       => 'main',
		'path'       => '',
		'controller' => 'Controller:IndexController',
		'action'     => 'index',
		'allow'      => ['GET'],
	],
	[
		'name'       => 'checkAuth',
		'path'       => 'check-auth',
		'controller' => 'Controller:UserController',
		'action'     => 'checkAuth',
		'allow'      => ['GET'],
	],
	[
		'name'       => 'logView',
		'path'       => 'log-view/{level}',
		'controller' => 'Controller:IndexController',
		'action'     => 'logView',
		'allow'      => ['GET'],
		'regex'      => true,
		'param'      => [
			'level'  => '\w+',
		],
	],
	[
		'name'       => 'authUser',
		'path'       => 'auth',
		'controller' => 'Controller:UserController',
		'action'     => 'auth',
		'middleware' => [MiddlewareCheckAuth::class],
		'allow'      => ['GET', 'POST'],
	],
	[
		'name'       => 'profileUser',
		'path'       => 'profile',
		'controller' => 'Controller:UserController',
		'action'     => 'profile',
		'access'    => User::ROLE_USER,
		'allow'      => ['GET'],
	],
	[
		'name'       => 'logout',
		'path'       => 'logout',
		'controller' => 'Controller:UserController',
		'action'     => 'logout',
		'middleware' => [MiddlewareCheckAuth::class],
		'allow'      => ['GET'],
	],
	[
		'name'       => 'registerUser',
		'path'       => 'register',
		'controller' => 'Controller:UserController',
		'middleware' => [MiddlewareGrantAccess::class, MiddlewareCheckAuth::class],
		'action'     => 'register',
		'access'     => User::ROLE_USER,
		'allow'      => ['GET', 'POST'],
	],
	[
		'name'       => 'addIndex',
		'path'       => 'addIndex',
		'controller' => 'Controller:ElasticController',
		'action'     => 'addIndex',
		'middleware' => [MiddlewareCheckAuth::class],
		'allow'      => ['GET', 'POST'],
		'enterData'  => []
	],
	[
		'name'       => 'removeIndex',
		'path'       => 'removeIndex',
		'controller' => 'Controller:ElasticController',
		'action'     => 'removeIndex',
		'allow'      => ['GET'],
	],
	[
		'name'       => 'indexer',
		'path'       => 'indexer/{id}/{red}',
		'controller' => 'Controller:ElasticController',
		'action'     => 'indexer',
		'allow'      => ['GET'],
		'regex'      => true,
		'param'      => [
			'id'  => '\d+',
			'red' => '\d+',
		],
	],
	[
		'name'       => 'enterCommand',
		'path'       => 'enterCommand',
		'controller' => 'Controller:ElasticController',
		'action'     => 'enterCommand',
		'allow'      => ['GET'],
	],
	[
		'name'       => 'randomWord',
		'path'       => 'random-word/{id}',
		'controller' => 'Controller:IndexController',
		'action'     => 'dictionary',
		'allow'      => ['GET', 'POST', 'PUT'],
		'regex'      => true,
		'middleware' => [MiddlewareCheckAuth::class],
		'param'      => [
			'id' => '\d{1,5}',
		],
	],
];