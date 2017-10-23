<?php
namespace ShuxPhp\App\Database
{
	use ShuxPhp\App\Configuration as config;

	defined('ShuxPhp') or exit;
	
	class MySQL
	{
		protected $pdo;
		private $file_log;
		
		public function __construct()
		{
			$this->file_log = ROOT.'App/logs/query.log';
		}

		/**
		 * PDO database connection 
		 * Configuration file on ShuxPhp/App/config.php
		 * @return database connection
		 */
		public function connect()
		{
			if(config::useDB)
			{
				$this->pdo = new \PDO('mysql:host='. config::DB_host .';dbname='. config::DB_name .';port='. config::DB_port, config::DB_user, config::DB_pass);
				$this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
				$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

				return $this->pdo;
			}
		}
		
		/**
		 * @return delete database's connection
		 */
		public function disconnect()
		{
			$this->pdo = null;
		}
		
		/**
		 * @param  string $time  - default now
		 * @return d-m-Y date
		 */
		public function getdate(string $time = 'now'): string
		{
			if ($time == 'now')
				return date('d-m-Y H:i:s', mktime(date('H'), date('i'), date('s'), date('n'), date('d'), date('Y')));
			else
				return date('d-m-Y H:i:s', $time);
		}
		/**
		 * You can enable/disable queries' log on ShuxPhp/App/config.php
		 * @param  string $query  - Query to log
		 * @param  string $file   - File where is placed the query
		 * @return void
		 */
		private function log_query(string $query,string $file='')
		{
			if (config::log_query == true)
			{
				$var = fopen($this->file_log, 'a');
				fwrite($var, '['. $this->getdate() . '] Query: ' . $query . ' in ' . $file ."\r\n");
				fclose($var);
			}	
		}
		
		/**
		 * @param  string $string
		 * @return filtered string (XSS)
		 */
		private function xss_filter($string)
		{
			$string = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $string);
	        $string = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $string);
	        $string = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $string);
	        $string = html_entity_decode($string, ENT_COMPAT, 'UTF-8');
	        $string = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $string);
	        $string = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $string);
	        $string = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $string);
	        $string = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $string);
	        $string = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $string);
	        $string = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $string);
	        $string = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $string);
	        $string = preg_replace('#</*\w+:\w[^>]*+>#i', '', $string);

	        return $string;
		}

		/**
		 * @param  string $string
		 * @return filtered string (SQL)
		 */
		private function sql_filter($string)
		{
			$string = str_ireplace('SELECT', '', $string);
			$string = str_ireplace('select', '', $string);
	        $string = str_ireplace('INSERT', '', $string);
	        $string = str_ireplace('insert', '', $string);
	        $string = str_ireplace('CREATE', '', $string);
	        $string = str_ireplace('create', '', $string);
	        $string = str_ireplace('TRUNCATE', '', $string);
	        $string = str_ireplace('truncate', '', $string);
	        $string = str_ireplace('DROP', '', $string);
	        $string = str_ireplace('drop', '', $string);
	        $string = str_ireplace('UNION', '', $string);
	        $string = str_ireplace('union', '', $string);
	        $string = str_ireplace('sleep(', '', $string);
	        $string = str_ireplace('\'', '&apos;', $string);
	        $string = str_ireplace('"', '&quot;', $string);
	        $string = str_ireplace('<SCRIPT', '', $string);
	        $string = str_ireplace('<script', '', $string);
	        $string = str_ireplace('exec', '', $string);
	        $string = str_ireplace('eval', '', $string);
	        $string = str_ireplace('$', '&dollar;', $string);

	        return $string;
		}

		/**
		 * @param  string $string
		 * @return filtered string (XSS+SQL+htmlentities)
		 */
		public function filter($string)
		{
			return $this->xss_filter($this->sql_filter(($string)));
		}

		/**
		 * Query Commands Function
		 * @param  array    $query  - Query + PDO prepared statements
		 * @param  string   $fetch  - Fetch type (all or single)
		 * @param  boolean  $count  - Count num of results
		 * @param  boolean  $log    - Enable or Disable query's log
		 * @return executed query, fetched elements, num of results
		 */
		public function act(array $query, string $fetch = 'fetch', bool $count = false, bool $log = true)
		{  
			$file = $_SERVER['REQUEST_URI'];
			 try 
			 {
				$sql = $this->pdo->prepare($query[0]);
				foreach ($query as $key => &$value)
				{
					if ($key && !is_null($value))
					{
						$value = $this->filter($value);
						$sql->bindParam($key, $value);
					}
				}
				$sql->execute();
				if($log === true)
				{
					$this->log_query(json_encode($query),$file);
				}
				switch($fetch)
				{
					case 'fetchall':
						$query = $sql->fetchAll(\PDO::FETCH_ASSOC);
					break;
					case 'fetch':
						$query = $sql->fetch(\PDO::FETCH_ASSOC);
					break;
					default:
					break;
				}
				if($count === true)
				{
					if(!is_array($query))
					{
						$query = [];
					}
					$count = array('COUNT' => $sql->rowCount());
					$query = array_merge($query, $count);
				}
			}
			catch (PDOException $e)
			{	
				$query = $e->getMessage();
			}
			return $query;
		}
		
	}
}
