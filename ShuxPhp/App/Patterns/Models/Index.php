<?php
namespace ShuxPhp\App\MVC\Models
{		
	use ShuxPhp\App\{Database as Database, Template as Template, Utility as Utility};

	class Index
	{
		function __construct()
		{	
			$this->db = new Database\MySQL;
			$this->db->connect();
			$this->lang = new Template\LanguageManager;	
		}

		function __destruct()
		{
			$this->db->disconnect();
		}
	}
}