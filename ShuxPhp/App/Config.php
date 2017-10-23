<?php
namespace ShuxPhp\App
{	
	defined('ShuxPhp') or exit;

	final class Configuration
	{
		#Framework#
		
		/**
		 * ShuxPhp Framework Version
		 */
		const Version = '1.1';
		/**
		 * The name of the site
		 */
		const SiteName = 'Shux Framework';
		/**
		 * Url
		 */
		const url = 'http://127.0.0.1:33';
		/**
		 * The default Language, the languages file are situated on ShuxPhp/App/Languages, these are .json files.
		 * Remember to create your default language file in the Language's direcotry (DefaultLang = 'EN', en.json)
		 */
		const DefaultLang = 'EN';
		/**
		 * The default TimeZone, if it isn't setted it will be Europe/London 
		 */
		const DefaultTimeZone = 'Europe/Rome';

		const CSRF_enabled = true;
		/**
		 * It's a string that will be hashed to generate the CSRF token
		 */
		const CSRF_string = '%&ffs[Shux]basM#Mc8()dacvFkda&£420';
		/**
		 * Enable (true)/Disalbe (false) CSRF by GET requests
		 */
		const CSRF_accept_get = false;
		/**
		 * Rembember to turn off (false) Development_Environment and to
 		 * turn on (true) log_php_errors if you are on an Open Project
		 */
		const Development_Environment = true;
		/**
		 * It will log into a file (ShuxPhp/App/logs/error.log) the php errors if true
		 */
		const log_php_errors = false;
		/**
		 * It will auto-delete template engine's cache files if true
		 */
		const unlink_cache = true;
		
		#Database#
		const useDB = false;
		const DB_host = 'localhost';
		const DB_user = 'root';
		const DB_port = 3306;
		const DB_pass = '';
		const DB_name = '';
		/**
		 * It will log into a file (ShuxPhp/App/logs/query.log) all the queries executed if true
		 */
		const log_query = true;

		#Facebook
		
		const FB_APP_ID = null;
		const FB_PAGE_LINK = 'https://facebook.com/';
		const FB_PAGE_NAME = '';

	}
}
