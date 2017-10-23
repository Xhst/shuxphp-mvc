<?php 
namespace ShuxPhp
{
	define('ShuxPhp', true);

	use ShuxPhp\App\Routing as App;

	require_once 'Initialize.php';
	$app = new App\Router;
}