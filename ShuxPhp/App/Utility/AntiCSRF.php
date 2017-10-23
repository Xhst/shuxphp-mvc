<?php
namespace ShuxPhp\App\Utility
{
	use ShuxPhp\App\Configuration as config;

	defined('ShuxPhp') or exit;

	final class AntiCSRF
	{	

		protected $timeout = 300;

		/**
		 * Save the CSRF token into Session
		 */
		public static function generateToken()
		{
			$_SESSION['csrf'] = [];
			$_SESSION['csrf']['token'] = self::setToken();
			$_SESSION['csrf']['time'] = time();
			$_SESSION['csrf']['ip'] = $_SERVER['REMOTE_ADDR'];
			$hash = self::calculateHash();
        	return base64_encode($hash);
		}

		/**
		 * Generate a new token using CSRF_string on config's file
		 * @return string  - New CSRF token
		 */
		protected static function setToken()
		{
			return rand(0,9999).config::CSRF_string.rand(0,9999);
		}

		protected static function calculateHash() 
		{
        	return self::hash(implode('', $_SESSION['csrf']));
    	}

		/**
		 * @return bool        
		 */
		public function checkToken($acceptGet = false, $timeout = null)
		{
			if(isset($_SESSION['csrf']))
			{
				if(!$this->checkTimeout($timeout)) 
                	return false;

            	$isCsrfGet = isset($_GET['csrf']);
                $isCsrfPost = isset($_POST['csrf']);

                if (($acceptGet and $isCsrfGet) or $isCsrfPost) 
                {
                    $tokenHash = base64_decode($_REQUEST['csrf']);
                    $generatedHash = self::calculateHash();

                    if ($tokenHash and $generatedHash) 
                        return $tokenHash == $generatedHash;
                }
			}
			return false;
		}

		/**
		 * Checks the token to authenticate the request
		 * @param  int $timeout  - custom timeout (Default 5 min)
		 * @return bool        
		 */
		protected function checkTimeout($timeout = null)
		{
			$timeout = $timeout ?? $this->timeout;
			return ($_SERVER['REQUEST_TIME'] - $_SESSION['csrf']['time']) < $timeout;
		}

		public static function HiddenField() 
		{
        	return '<input type="hidden" name="csrf" value="'. self::generateToken() . '" />';
    	}

		/**
		 * hash
		 * @param  string $string  - string to crypt
		 * @return string          - sha1 crypted string
		 */
		protected static function hash($string)
		{
			return sha1($string);
		}
	}
}