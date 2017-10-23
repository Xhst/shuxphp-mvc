<?php
namespace ShuxPhp\App\Template
{
	use ShuxPhp\App\Configuration as config;

	defined('ShuxPhp') or exit;
	
	class Template
	{
		private $cacheDir;

		public function __construct()
		{
			$this->cacheDir = ROOT.'App/logs/cache/';
		}

		/**
		 * Initialize Template Engine
		 * @param string $text  - Page's text
		 * @param array $data   - Data + langue array
		 */
		public function Init($text, $data)
		{	
			$text = str_replace($text,$this->replaceTags($text, $data),$text);
			$text = str_replace($text,$this->checkConditions($text, $data),$text);
			return $text;
		}

		/**
		 * replace {{ tag }}
		 * @param  string $text  - Page's text
		 * @param  array $data   - Data + langue array
		 * @return string        - Page's text with elaborated tags
		 */
	    private function replaceTags($text, $data)
	    {
	    	preg_match_all('/{{ (.*?) }}/', $text, $tags, PREG_SET_ORDER);

	    	foreach($tags as $tag)
	    	{
		    	if(preg_match('/\./', $tag[1]))
				{
					$extract = explode('.', $tag[1]);
					$var = $data;
					foreach($extract as $key)
					{
					    $var = $var[$key];
					}
					if($var === null)
					{
					    die('Can\'t find "'.$tag[1].'" in the array.');
					}
					$text = str_replace('{{ '.$tag[1].' }}', $var, $text);
					} else {
						if(!array_key_exists($tag[1], $data))
					    {
					        die('Can\'t find "'.$tag[1].'" in the array.');
					    }
					$text = str_replace('{{ '.$tag[1].' }}', $data[$tag[1]], $text);
				}
	    	}
	    	return $text;
	    }

	    /**
	     * replace {% condition %}
	     * @param  string $text  - Page's text
		 * @param  array $data   - data + langue array
	     * @return string        - Page's text with elaborated condition
	     */
		private function checkConditions($text, $data)
		{
			$text = str_replace('{% endif %}', '<?php endif ?>', $text); 
			$text = str_replace('{% else %}', '<?php else: ?>', $text);
			$text = preg_replace('/{% if (.*?) %}/', '<?php if ( $1 ): ?>', $text);
			preg_match_all('/<\?php if \((.*?)\): \?>/', $text, $conditions, PREG_SET_ORDER);
			
			foreach($conditions as $condition) 
			{
				$clearedCondition = preg_replace('/(\'.*?\')|[=>&!\|]/', null,$condition[1]);
				$params = explode(' ', $clearedCondition);
				$result = $condition[1];
				foreach($params as $param)
				{
					if($param != '')
					{
						if(strtolower($param) != 'or' && strtolower($param) != 'and')
						{
							if(preg_match('/\./', $param))
					        {
					            $extract = explode('.', $param);
					            $var = $data;
					            foreach($extract as $key)
					            {
					                $var = $var[$key];
					            }
					            if($var === null)
					            {
					                die('[ERROR]: Can\'t find "'.$param.'" in the array.');
					            }
					            $result = preg_replace(sprintf('/(\'[^\']+\'(*SKIP)(*F))|%s/', preg_quote(' '.$param.' ', '/')), '\''.$var.'\'', $result);
					        } else {
				            	if(!array_key_exists($param, $data))
				            	{
				            		die('[ERROR]: Can\'t find "'.$param.'" in the array.');
				            	}
					            $result = preg_replace(sprintf('/(\'[^\']+\'(*SKIP)(*F))|%s/', preg_quote(' '.$param.' ', '/')), '\''.$data[$param].'\'', $result);
				            }	
						}
					}
				}
				$text = str_replace($condition[1], $result, $text);
			}
			$cachefile = $this->cacheDir.sha1(time().rand(0, 0xfff)).'.php';
			$file = fopen($cachefile, 'x');
			fwrite($file, $text);
			fclose($file);
			ob_start();
			include $cachefile;
			$text = ob_get_clean();
			if(config::unlink_cache == true)
			{
				unlink($cachefile);
			}
			return $text;
		}
	}
}