<?php

/**
 * Application bootstrap
 */

 // Error handling, deactivate for production

ini_set('error_reporting', E_ALL);
ini_set('display_startup_errors',1);
ini_set('display_errors',1);

// Initialize file path
defined('BASE_PATH') || define('BASE_PATH', realpath(__DIR__)."/");
set_include_path(get_include_path().":".BASE_PATH."../application/core:".BASE_PATH."../application/config:".BASE_PATH."../application/models:".BASE_PATH."../application/views:".BASE_PATH."upload:".BASE_PATH."theme");

// Class autoload
spl_autoload_register(function($class){
	$ext = ".class.php";
	require_once(lcfirst($class).$ext);
});

/**
 * Adding routes to the router
 */
Route::reform('/', 'index');
Route::reform(':controller', ':controller/index');
Route::reform(':controller/:action/:args',':controller/:action/?(.*)');

/**
 * Loading additionnal helpers
 */

 require_once "Functions.php";

 /**
  * Starting application
  */

  $sess = new Session();
  $sess->timeOut();

  new Dispatcher();
