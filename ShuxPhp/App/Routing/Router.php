<?php
namespace ShuxPhp\App\Routing
{	
	use ShuxPhp\App\MVC\{Controllers as controllers, Models as models};
	
	defined('ShuxPhp') or exit;

	class Router
	{

		protected $controller = 'index';
		protected $method = 'index';
		static protected $params = [];

		public function __construct()
		{
			$url = $this->splitUrl();
			$this->controllerName = $this->controller;
			$this->methodName = $this->method;

			if(isset($url[0]) && $url[0] != 'Assets')
			{
				if(file_exists(ROOT.'App/Patterns/Controllers/' . $url[0] . '.php'))
				{
					$this->controller = $url[0];
					$this->controllerName = $url[0];

					unset($url[0]);
				}
			}
			require_once ROOT.'App/Patterns/Controllers/' . $this->controllerName . '.php';

			if(isset($url[1]))
			{
				if(method_exists('\\ShuxPhp\App\MVC\Controllers\\'.$this->controller, $url[1]))
				{
					$this->method = $url[1];
					$this->methodName = $url[1];
					unset($url[1]);
				}
			}
			else
				$this->method = 'index';


			self::$params = $url ? array_values($url) : [];
			unset($url);

			call_user_func_array(['\\ShuxPhp\App\MVC\Controllers\\'.$this->controller, $this->method], self::$params);
	
		}

		/**
		 * @return array $url
		 * it divide the url by /
		 */
		public function splitUrl(): array
		{
			return isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : '';
		}

		/**
		 * @return array $params
		 * http://example.com/Controller/Method/Param0/Param1/Param2...
		 * Return an array with all parameters
		 * It's a static function so it can only be calledback
		 * with ::getParams()
		 */
		public static function getParams()
		{
			return self::$params;
		}
	}
}