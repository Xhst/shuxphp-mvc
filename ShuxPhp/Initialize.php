<?php
use ShuxPhp\App\{Configuration as config, Classes as shuxClass};

session_start([
	'name' => 'ShuxPHPSess',
	//'cookie_secure' => 1, //Enable if HTTPS 
	'hash_bits_per_character' => 6,
	'cookie_httponly' => 1,
	'hash_function' => 1
	]);

defined('ShuxPhp') or exit;
/**
 * Define the ROOT directory
 */
define('ROOT', dirname(__DIR__).'/ShuxPhp/');

require ROOT.'App/Config.php';

if(config::DefaultTimeZone != "")
	date_default_timezone_set(config::DefaultTimeZone);
 else 
	date_default_timezone_set('Europe/London');

if(config::Development_Environment == true)
{
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} 
else 
{
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
}

if(config::log_php_errors == true)
{
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT.'App/logs/error.log');
} 
else 
	ini_set('log_errors', 'Off');

spl_autoload_register(
	function($className)
	{
		$className = explode('\\',$className);
		if(file_exists(ROOT.'App/Routing/'.end($className).'.php'))
			require_once ROOT.'App/Routing/'.end($className).'.php';
		if(file_exists(ROOT.'App/Database/'.end($className).'.php'))
			require_once ROOT.'App/Database/'.end($className).'.php';
		if(file_exists(ROOT.'App/Template/'.end($className).'.php'))
			require_once ROOT.'App/Template/'.end($className).'.php';
		if(file_exists(ROOT.'App/Utility/'.end($className).'.php'))
			require_once ROOT.'App/Utility/'.end($className).'.php';
	});

$scripts = new ShuxPhp\App\Utility\Scripts;
$csrf = new ShuxPhp\App\Utility\AntiCSRF;

//TODO CSRF

if(isset($_REQUEST['csrf']))
{
	if(!$csrf->checkToken(config::CSRF_accept_get))
		die('[Error]: Invalid CSRF token. <a href="javascript:history.back()">Back</a>');
}

