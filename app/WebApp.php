<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.04.2018
 * Time: 14:53
 */

namespace App;

use Configs\Config;
use Exception\ExceptionListener\ExceptionListener;
use Http\Request\ServerRequest;
use Http\Middleware\StorageMiddleware;
use Http\Response\Text;
use Providers\StorageProviders;
use Http\Response\Response;
use System\Database\DB;
use System\EventListener\EventTypes;
use System\Logger\LoggerStorage;
use System\Logger\LogLevel;
use System\Kernel\TypesApp\AbstractApplication;
use System\Render;

final class WebApp extends AbstractApplication
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
	 * @param AppKernel $appKernel
	 * @return AbstractApplication
	 */
	public function setAppKernel(AppKernel $appKernel): AbstractApplication
	{
		parent::setAppKernel($appKernel);
		StorageProviders::add($appKernel->getProviders());
		StorageMiddleware::add($appKernel->getMiddlewares());

		return $this;
	}

	/**
	 * @return WebApp
	 * @throws \Exception\MiddlewareException
	 */
	public function handle(): WebApp
	{
		$this->request = ServerRequest::fromGlobal()->handle();

		return $this;
	}

	/**
	 * @throws \Exception\FileException
	 * @throws \Throwable
	 */
	public function run()
	{
	    $this->runInternal();

		try {
			$this->handle();
		} catch(\Throwable $e) {
			$this->log(LogLevel::ERROR, $e->getTraceAsString());
			new ExceptionListener($e);
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
	public function terminate()
	{
		DB::disconnect();
		LoggerStorage::create()->releaseLog();
	}

	/**
	 * @param \Throwable $e
	 * @throws \Throwable
	 */
	public function customOutputError(\Throwable $e)
	{
		if ($this->env == self::ENV_TYPE['DEV']) {
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