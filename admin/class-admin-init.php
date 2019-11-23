<?php
/**
 * Initialize all the plugin basics setup.
 * 
 * @package		NotifyList
 * @author		Tremi Dkhar
 * @since 		0.1.0
 * @license 	GPL-2.0+
 * @copyright 	Copyright (c) 2019, Tremi Dkhar
 */
class Notification_List_Admin {

	public function __construct() {

		// Register notification list custom post type
		$this->register_cpt();
	}

	public function register_cpt() {
	}
}