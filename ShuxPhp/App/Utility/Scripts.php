<?php
namespace ShuxPhp\App\Utility
{
	use ShuxPhp\App\Configuration as config;

	defined('ShuxPhp') or exit;

	final class Scripts
	{	
		protected static $scripts = [];

		public function __construct()
		{
			if(config::CSRF_enabled)
			{
				self::__add('<script src="/Assets/js/csrfForms.js" type="text/javascript"></script>');
				self::__add('<script type="text/javascript">generateCsrfFields("{{ csrf_token }}");</script>');
			}
		}

		public static function __add($script)
		{
			array_push(self::$scripts,$script);
		}

		public static function __load()
		{
			return implode('',self::$scripts);
		}
	}
}