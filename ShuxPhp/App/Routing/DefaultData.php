<?php
namespace ShuxPhp\App\Routing
{
	use ShuxPhp\App\{Configuration as config, Utility as Utility};

	defined('ShuxPhp') or exit;
	
	class DefaultData
	{
		private $data = [];

		public function __construct()
		{
			$this->data['csrf_field'] = Utility\AntiCSRF::HiddenField();
			$this->data['csrf_token'] = Utility\AntiCSRF::generateToken();
			$this->data['url']	      = config::url;
		}
		
	 	public function loadData()
	 	{
	 		return $this->data;
	 	}
	}
}