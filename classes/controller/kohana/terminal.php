<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kohana_Terminal extends Controller {
	/**
	 * Progress one or more command-line options. 
	 *
	 *     // Create a controller "controller_home" and a action named "action_index"
	 *     // stored in path: APPPATH.'/classes/controller/home.php'
	 *     kohana controller home index
	 *
	 *     // Create a model named user.php
	 *     // stored in path: APPPATH.'/classes/model/auth/user.php'
	 *     kohana model auth_user
	 *
	 */
	public function action_index()
	{
		// Instance terminal
		$terminal = new Terminal();

		// Init terminal
		$terminal->init();
	}
}