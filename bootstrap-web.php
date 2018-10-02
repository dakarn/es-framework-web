<?php

define('PSR_4', true);
define('IS_DEV', \is_file(__DIR__ . '/dev.php'));
define('PATH_APP', __DIR__ . '/app/');
define('TEMPLATE', PATH_APP . 'Templates');
define('APP_EVENT', PATH_APP . 'AppEvent.php');
define('APP_KERNEL', PATH_APP . 'AppKernel.php');

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

set_error_handler(function($errno, $errstr, $errfile, $errline) use($application) {
	$application->outputError($errno, $errstr, $errfile, $errline);
});

register_shutdown_function(function() use($application) {
	System\Kernel\ShutdownScript::run();
});

$application->run();
$application->outputResponse();