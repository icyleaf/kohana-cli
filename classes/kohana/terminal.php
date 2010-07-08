<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Terminal Tools for Kohana v3
 *
 * @category Terminal
 * @author   icyleaf <icyleaf.cn@gmail.com>
 * @version  0.1
 * @link     http://icyleaf.com
 */
class Kohana_Terminal {

	const CONTROLLERPATH = 'classes/controller/';
	const MODELPATH = 'classes/model/';
	const VIEWPATH = 'view/';

	protected $config = NULL;

	protected $argc   = NULL;
	protected $argv   = NULL;

	public function __construct()
	{
		// Load the configurations
		$this->config = Kohana::config('terminal');
	}

	public function init()
	{
		// Load argc and argv
		$argc = Arr::get($_SERVER, 'argc');
		$argv = Arr::get($_SERVER, 'argv');

		// Remove some argv
		$argc -= 2;
		$argv = array_slice($argv, 2);
		if ($argc > 0)
		{
			$action = strtolower(Arr::get($argv, 0));
			$file = Arr::get($argv, 1);
			switch ($action)
			{
				default:
				case 'help':
					$this->_help();
					break;
				case 'start':
					$this->_open_brower();
					break;
				case 'controller':
				case 'model':
				case 'view':
					$dirver = 'Terminal_'.ucfirst($action);
					new $dirver();
					break;
			}
		}
		else
		{
			$this->_welcome();
		}
	}

	/**
	 * Terminal color of font
	 *
	 * @param string $str
	 * @param string $color
	 * @param string $backround
	 * @return string
	 */
	public static function color($str, $color = NULL, $backround = NULL)
	{
		// Load color and background of configuration
		$config = Kohana::config('terminal');

		if (array_key_exists($color, $config['color']))
		{
			$color = $config['color'][$color];
		}

		if (array_key_exists($color, $config['color']))
		{
			$backround = ';'.$config['background'][$backround];
		}

		return "\033[1m\033[".$color.$backround."m".$str."\033[0m";
	}

	protected function _check_path($directory)
	{
		if ( ! is_dir($directory))
		{
			// Create the yearly directory
			mkdir($directory, 0777, TRUE);

			// Set permissions (must be manually set to fix umask issues)
			chmod($directory, 0777);
		}
	}

	protected function _format_name($str)
	{
		if (preg_match('/^[a-z]+$/', $str))
		{
			$str = ucfirst($str);
		}

		return $str;
	}

/****************************************************************/
	protected function _open_brower()
	{
		exec($this->config->brower.' '.URL::base(FALSE));
	}

	protected function _help()
	{
		$str ='   .----------- Kohana Terminal Tools
   |
   |         .------------ Tools action(controller/model/view etc)
   |         |
   |         |            .----------- File name (Directory(/SubDirectory)/File)
   |         |            |
   |         |            |          .----.------.----- Methods aame
   |         |            |          |    |      |
   |         |            |          |    |      |
   |         |            |          |    |      |
./kohana controller template/people get update delete';

		echo Terminal::color($str, 'yellow').PHP_EOL;
	}

	protected function _welcome()
	{
		$str = __('"help" was called incorrectly. Call as "./kohana help".');
		echo Terminal::color($str, 'yellow').PHP_EOL;
	}
}