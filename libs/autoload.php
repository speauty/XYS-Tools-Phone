<?php
	class autoload
	{
		public static function load($className)
		{
			$filePath = str_replace('\\', '/', $className).'.php';
			if (is_file($filePath)) {
				require_once $filePath;
			} else {
				return 'the '.$className.' not found';
			} 

		}
	}
	spl_autoload_register(['autoload', 'load']);
?>
