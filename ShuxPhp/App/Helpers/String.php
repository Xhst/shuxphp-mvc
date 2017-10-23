<?php
namespace ShuxPhp\App\Helpers
{
	defined('ShuxPhp') or exit;

	final class String
	{

		/**
		 * StartsWith
		 * @param  string $haystack
		 * @param  string $needle   
		 * @return bool          
		 */
		public static function startsWith(string $haystack, string $needle): bool
		{
		     return (substr($haystack, 0, strlen($needle)) === $needle);
		}

		/**
		 * EndsWith
		 * @param  string $haystack 
		 * @param  string $needle   
		 * @return bool           
		 */
		public static function endsWith(string $haystack, string $needle): bool
		{
		    $length = strlen($needle);
		    if ($length == 0) 
		        return true;

		    return (substr($haystack, -$length) === $needle);
		}

		/**
		 * stripos array
		 * @param  string  $haystack 
		 * @param  array   $needles  
		 * @param  integer $offset   
		 * @return bool            
		 */
		public static function striposa(string $haystack,$needles = [], int $offset=0): bool
		{
	        $chr = [];
	        foreach($needles as $needle)
	        {
                $res = stripos($haystack, $needle, $offset);
                if ($res !== false) 
                	$chr[$needle] = $res;
	        }
	        if(empty($chr)) 
	        	return false;
	        return min($chr);
	    }
	}
}