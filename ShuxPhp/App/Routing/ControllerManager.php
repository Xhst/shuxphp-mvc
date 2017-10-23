<?php
namespace ShuxPhp\App\Routing
{
	use ShuxPhp\App\MVC\Models;
	use ShuxPhp\App\{Configuration as config, Template as Template, Utility as Utility};

	defined('ShuxPhp') or exit;

	class ControllerManager extends Router
	{
		/**
		 * It require the model file and create a new class
		 * with model's name prefixed with namespace
		 * @param  string $model
		 * @return new class with name $model 
		 */
		public static function model(string $model)
		{
			require_once ROOT.'App/Patterns/Models/' . $model . '.php';
			$class = '\\ShuxPhp\App\MVC\Models\\'.$model;
			return new $class;
		}

		/**
		 * @param  string $view  - The view's url
		 * @param  array $data   - template datas
		 * @return void
		 */
		public static function view(string $view, array $data = [])
		{
			$file = file_get_contents(ROOT.'App/Patterns/Views/' . $view . '.php');
			//Load Scripts
			$file = str_replace('</body>',Utility\Scripts::__load().'</body>', $file);

			$defaultData = (new DefaultData)->loadData();

			foreach($defaultData as $key => $value)
				$data[$key] = $value;
			
			$data = array_merge($data,  (new Template\LanguageManager)->getLangArray());
			echo $file = str_replace($file, (new Template\Template)->Init($file, $data), $file);
		}
		
		/**
		 * @return array parent::getParams()
		 */
		public static function getParams(): array
		{
			return parent::getParams();
		}

		/**
		 * @param  string $file
		 * @return return the $file content
		 */
		public static function getViewFile(string $file)
		{
    		ob_start();
    		require_once ROOT.'App/Patterns/Views/' . $file . '.php';
    		return ob_get_clean();
		}
	}
}