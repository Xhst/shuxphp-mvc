<?php
namespace ShuxPhp\App\MVC\Controllers
{
	use ShuxPhp\App\{Utility as Utility, Configuration as config};
	use ShuxPhp\App\Routing\{IRoutable, ControllerManager};

	class Index extends ControllerManager implements IRoutable
	{
		public static function index()
		{		
			$index = parent::model('Index');

			parent::view('index', 
			   [
			   'showcode' => 1,
			   ]);		
		}
	}
}