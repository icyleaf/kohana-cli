<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Generate Model class
 *
 * @category Terminal
 * @author   icyleaf <icyleaf.cn@gmail.com>
 * @link     http://icyleaf.com
 */
class Kohana_Terminal_Model extends Terminal {

	public function  __construct() {
		parent::__construct();

		// Load argc and argv
		$argc = Arr::get($_SERVER, 'argc') - 3;
		$argv = array_slice(Arr::get($_SERVER, 'argv'), 3);

		if ($argc > 0)
		{
			// Get model file
			$filename = Arr::get($argv, 0);

			// Get model extends
			$extends = CLI::options('e');
			$extends = Arr::get($extends, 'e');

			$this->generate($filename, $extends);
		}
		else
		{
			$str = 'Missing model name.';
			echo Terminal::color($str, 'red').PHP_EOL;
		}
	}

	public function generate($filename, $extends = NULL)
	{
		// Progress controller file
		$files = explode('/', $filename);
		$files_count = count($files);

		// Progress controller directory
		$model = array('Model');
		$directory = NULL;
		if ($files_count > 1)
		{
			// progress controller name
			for ($i = 0; $i < $files_count; $i++)
			{
				$model[] = $this->_format_name($files[$i]);

				if ($i != ($files_count -1))
				{
					$directory .= $files[$i].DIRECTORY_SEPARATOR;
				}
			}

			$filename = $files[$files_count -1];
		}
		else
		{
			$model[] = $this->_format_name($filename);
		}

		// Set the name of controller file
		$model = implode('_', $model);

		// Set controller extends
		if ($extends)
		{
			$parent = strtolower($extends);
			switch ($parent)
			{
				case 'orm':
					$parent = strtoupper($parent);
				default :
					$parent = ucfirst($parent);
			}

			$extends = $parent;
		}
		else
		{
			$extends = 'Model';
		}

		// Set the name of the controller path
		$directory = $this->config->apppath.Terminal::MODELPATH.$directory;
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
			file_put_contents($filename, PHP_EOL.'class '.ucfirst($model).' extends '.$extends.' {', FILE_APPEND);

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

