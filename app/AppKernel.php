<?php

namespace ES\App;

use ES\Kernel\Http\Middleware\MiddlewareAllowMethod;
use ES\Kernel\Http\Middleware\MiddlewareAnonymousToken;
use ES\Kernel\Http\Middleware\MiddlewareController;
use ES\Kernel\Http\Middleware\MiddlewareGrantAccess;
use ES\Kernel\Http\Middleware\MiddlewarePreController;
use ES\Kernel\Http\Middleware\MiddlewareRouting;
use ES\Kernel\Helper\ES;

final class AppKernel
{
	/**
	 * @var array
	 */
	private $middlewares = [];

	/**
	 * @var array
	 */
	private $providers = [];

	/**
	 * AppKernel constructor.
	 */
	public function __construct()
	{
		ES::set(ES::APP_KERNEL, $this);
	}

	/**
	 * @return AppKernel
	 */
	public function installMiddlewares(): self
	{
        $this->commonMiddlewares();
        $this->customMiddlewares();
		return $this;
	}

	/**
	 * @return AppKernel
	 */
	public function installProviders(): self
	{
		return $this;
	}

	/**
	 * @return array
	 */
	public function getProviders(): array
	{
		return $this->providers;
	}

	/**
	 * @return array
	 */
	public function getMiddlewares(): array
	{
		return $this->middlewares;
	}

    /**
     * @return AppKernel
     */
    private function commonMiddlewares(): self
    {
        $this->middlewares[] = [
            'autoStart' => true,
            'class'     => MiddlewareRouting::class,
        ];

        $this->middlewares[] = [
            'autoStart' => true,
            'class'     => MiddlewareAllowMethod::class,
        ];

        $this->middlewares[] = [
            'autoStart' => true,
            'class'     => MiddlewarePreController::class,
        ];

        $this->middlewares[] = [
            'autoStart' => true,
            'class'     => MiddlewareAnonymousToken::class,
        ];

        $this->middlewares[] = [
            'autoStart' => true,
            'class'     => MiddlewareController::class,
        ];

        return $this;
    }

    /**
     * @return AppKernel
     */
    private function customMiddlewares(): self
    {
        $this->middlewares[] = [
            'autoStart' => false,
            'class'     => MiddlewareGrantAccess::class,
        ];

        $this->middlewares[] = [
            'autoStart' => false,
            'class'     => MiddlewareApp\MiddlewareCheckAuth::class,
        ];

        $this->middlewares[] = [
            'autoStart' => false,
            'class'     => MiddlewareApp\MiddlewareCheckAjax::class,
        ];

        return $this;
    }
}