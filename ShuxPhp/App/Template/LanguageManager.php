<?php
namespace ShuxPhp\App\Template
{	
	use ShuxPhp\App\Configuration as config;

	defined('ShuxPhp') or exit;

	class LanguageManager
	{

		public function getLanguage(): string
		{
			$language_detect = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			if(isset($language_detect))
			{
				$language = $language_detect;
			}else{
				$language = strtolower(config::DefaultLang);
			}
			return $language;
		}
		
		public function getLangFile(): string
		{
			$language = $this->getLanguage();
			
			if(file_exists(ROOT .'App/Template/Languages/' . $language . '.json'))
			{
				return ROOT .'App/Template/Languages/' . $language . '.json';
			}else{
				if(file_exists(ROOT .'App/Template/Languages/' . strtolower(config::DefaultLang) . '.json'))
				{
					return ROOT .'App/Template/Languages/' . strtolower(config::DefaultLang) . '.json';
				}
			}
		}

		public function getLangArray(): array
		{
			return json_decode(file_get_contents($this->getLangFile()), true);
		}	
		
	}
}
