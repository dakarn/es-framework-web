<?php

define('PATH_LOADER', __DIR__ . '/vendor/autoload.php');
define('PATH_SYSTEM', __DIR__ . '/vendor/es-framework-kernel/system/');
define('PATH_APP', __DIR__  . '/app/');
define('PSR_4', true);
define('IS_DEV', \is_file('dev.bootstrap.php'));

include_once PATH_SYSTEM . 'Helper/Util.php';

\Helper\Util::selectLoaderClass();

$event = new App\AppEvent();
$event = $event->installEvents(new \System\EventListener\EventManager());

$appKernel = new \App\AppKernel();
$appKernel->installMiddlewares()->installProviders();

$env = 'PROD';

if (IS_DEV) {
	$env = 'DEV';
}

$application = (new \System\Kernel\TypesApp\WebApp())
	->setEnvironment($env)
	->setAppEvent($event)
	->setAppKernel($appKernel)
	->setApplicationType('Web');

set_exception_handler(function($e) use($application) {
	$application->outputException($e);
});

register_shutdown_function(function() use($application) {
	System\Kernel\ShutdownScript::run();
});

$application->run();
$application->outputResponse();