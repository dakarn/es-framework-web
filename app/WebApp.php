<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 14:53
 */

namespace ES\App;

use ES\Kernel\Configs\Config;
use ES\Kernel\Http\Request\ServerRequest;
use ES\Kernel\Http\Middleware\StorageMiddleware;
use ES\Kernel\Http\Response\Text;
use ES\Kernel\Providers\StorageProviders;
use ES\Kernel\Http\Response\Response;
use ES\Kernel\EventListener\EventTypes;
use ES\Kernel\Logger\Logger;
use ES\Kernel\Logger\LoggerAware;
use ES\Kernel\Logger\LogLevel;
use ES\Kernel\Kernel\TypesApp\AbstractApplication;
use ES\Kernel\Helper\Render;
use ES\Kernel\EventListener\EventManager;

final class WebApp extends AbstractApplication implements WebAppInterface
{
	/**
	 * @var Response
	 */
	private $response;

    /**
     * @var ServerRequest
     */
	private $request;

	/**
	 * @var AppKernel
	 */
	private $appKernel;

	/**
	 * @return WebApp
	 * @throws \ES\Kernel\Exception\MiddlewareException
	 */
	public function handle(): WebApp
	{
		$this->request = ServerRequest::fromGlobal()->handle();

		return $this;
	}

	/**
	 * @throws \Throwable
	 */
	public function run()
	{
	    $this->runInternal();

		try {
			$this->handle();
		} catch(\Throwable $e) {
			$this->log(LogLevel::ERROR, $e->getTraceAsString());
			$this->outputException($e);
		}
	}

	/**
	 * @return void
	 */
	public function outputResponse(): void
	{
		$this->response = $this->request->resultHandle();

		$this->response->sendHeaders();
		$this->response->output();

		$this->eventManager->runEvent(EventTypes::AFTER_OUTPUT_RESPONSE);
	}

	/**
	 * @return void
	 */
	public function setupClass()
	{
		$appEvent = new AppEvent();
		$this->eventManager = $appEvent->installEvents(new EventManager());

		$this->appKernel = new AppKernel();
		$this->appKernel
			->installMiddlewares()
			->installProviders();

		StorageProviders::add($this->appKernel->getProviders());
		StorageMiddleware::add($this->appKernel->getMiddlewares());
	}

	/**
	 *
	 */
	public function terminate()
	{
		LoggerAware::setLogger(Logger::class)->getLoggerStorage()->releaseLogs();
	}

	/**
	 * @param \Throwable $e
	 * @throws \Throwable
	 */
	public function customOutputError(\Throwable $e)
	{
		if ($this->env == self::ENV_DEV) {
			throw $e;
		} else {
			$errorPage = Config::get('common','errors')['500'];

			(new Response())
				->withBody(new Text((new Render($errorPage))->render()))
				->output();

			exit;
		}
	}
}