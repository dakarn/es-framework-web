<?php

define('PSR_4', true);
define('IS_DEV', \is_file(__DIR__ . '/dev.php'));

include_once __DIR__ . '/vendor/autoload.php';

$event = new App\AppEvent();
$event = $event->installEvents(new \System\EventListener\EventManager());

$appKernel = new \App\AppKernel();
$appKernel->installMiddlewares()->installProviders();

$env = 'PROD';

if (IS_DEV) {
	$env = 'DEV';
}

$application = (new \App\WebApp())
	->setEnvironment($env)
	->setAppEvent($event)
	->setAppKernel($appKernel)
	->setApplicationType('Web');

set_exception_handler(function($e) use($application) {
	$application->outputException($e);
});

set_error_handler(function($e) use($application) {
	$application->outputException($e);
});

register_shutdown_function(function() use($application) {
	System\Kernel\ShutdownScript::run();
});

$application->run();
$application->outputResponse();