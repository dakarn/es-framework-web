<?php

\define('PSR_4', true);
\define('IS_DEV', \is_file(__DIR__ . '/dev.php'));
\define('PATH_APP', __DIR__ . '/app/');
\define('TEMPLATE', \PATH_APP . 'Templates');
\define('APP_EVENT', \PATH_APP . 'AppEvent.php');
\define('APP_KERNEL', \PATH_APP . 'AppKernel.php');

include_once __DIR__ . '/vendor/autoload.php';

$env = \App\WebApp::ENV_PROD;

if (\IS_DEV) {
	$env = \App\WebApp::ENV_PROD;
	include_once 'dev.php';
}

$application = (new \App\WebApp())
	->setEnvironment($env)
	->setApplicationType(\App\WebApp::APP_TYPE_WEB);

\set_exception_handler(function($e) use($application) {
	$application->outputException($e);
});

\set_error_handler(function($errno, $errstr, $errfile, $errline) use($application) {
	$application->outputError($errno, $errstr, $errfile, $errline);
});

\register_shutdown_function(function() use($application) {
	System\Kernel\ShutdownScript::run();
});

$application->run();
$application->outputResponse();