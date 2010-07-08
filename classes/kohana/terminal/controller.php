<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Generate Controller class
 *
 * @category Terminal
 * @author   icyleaf <icyleaf.cn@gmail.com>
 * @link     http://icyleaf.com
 */
class Kohana_Terminal_Controller extends Terminal {

	public function  __construct() {
		parent::__construct();

		// Load argc and argv
		$argc = Arr::get($_SERVER, 'argc') - 3;
		$argv = array_slice(Arr::get($_SERVER, 'argv'), 3);

		if ($argc > 0)
		{
			$extends = CLI::options('e');
			$extends = Arr::get($extends, 'e');

			for ($i = 0; $i < $argc; $i++)
			{
				if (strpos($argv[$i], '--e') !== FALSE)
				{
					unset($argv[$i]);
				}
			}

			$filename = Arr::get($argv, 0);
			$methods = array_slice($argv, 1);

			$this->generate($filename, $methods, $extends);
		}
		else
		{
			$str = 'Missing controller name.';
			echo Terminal::color($str, 'red').PHP_EOL;
		}
	}

	public function generate($filename, $methods, $extends = NULL)
	{
		// Progress controller file
		$files = explode('/', $filename);
		$files_count = count($files);

		// Progress controller directory
		$controller = array('Controller');
		$directory = NULL;
		if ($files_count > 1)
		{
			// progress controller name
			for ($i = 0; $i < $files_count; $i++)
			{
				$controller[] = $this->_format_name($files[$i]);

				if ($i != ($files_count -1))
				{
					$directory .= $files[$i].DIRECTORY_SEPARATOR;
				}
			}

			$filename = $files[$files_count -1];
		}
		else
		{
			$controller[] = $this->_format_name($filename);
		}

		// Set the name of controller file
		$controller = implode('_', $controller);

		// Set controller extends
		if ($extends)
		{
			$parent = strtolower($extends);
			switch ($parent)
			{
				case 'rest':
					$parent = strtoupper($parent);
				default :
					$parent = ucfirst($parent);
			}

			$extends = 'Controller_'.$parent;
		}
		else
		{
			$extends = 'Controller';
		}

		// Set the name of the controller path
		$directory = $this->config->apppath.Terminal::CONTROLLERPATH.$directory;
		if ( ! is_dir($directory))
		{
			// Create the yearly directory
			mkdir($directory, 0777, TRUE);

			// Set permissions (must be manually set to fix umask issues)
			chmod($directory, 0777);
		}

		// Set the name of the log file
		$filename = $directory.$filename.EXT;
		if ( ! file_exists($filename))
		{
			// Create the controller file
			file_put_contents($filename, Kohana::FILE_SECURITY.PHP_EOL);

			// Allow anyone to write to controller files
			chmod($filename, 0666);

			// Continute to write
			file_put_contents($filename, PHP_EOL.'class '.ucfirst($controller).' extends '.$extends.' {', FILE_APPEND);
			if (count($methods) > 0)
			{
				foreach ($methods as $method)
				{
					file_put_contents($filename, PHP_EOL.PHP_EOL."\t".'public function action_'.$method.'(){}', FILE_APPEND);
				}
			}

			file_put_contents($filename, PHP_EOL.PHP_EOL.'}'.PHP_EOL.PHP_EOL, FILE_APPEND);

			$result = Terminal::color('create', 'green');
		}
		else
		{
			$result = Terminal::color('exist', 'blue');
		}

		$result = '    '.$result.'  '.Kohana::debug_path($filename);

		echo $result.PHP_EOL;
	}
}

