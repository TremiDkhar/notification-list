<?php
/**
 * Notification List
 *
 * @package     NotifyList
 * @author      Tremi Dkhar
 * @copyright   Copyright (c) Tremi Dkhar, 2019
 * @license     GPL-2.0+
 *
 * Plugin Name: Notification List
 * Plugin URI:  https://github.com/TremiDkhar/notification-list
 * Description: Display list of notification or information to the public
 * Version:     0.1.0
 * Author:      Tremi Dkhar
 * Author URI:  https://twitter.com/TremiDkhar
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: notifylist
 */

/**
 * Main Notification List Instance
 *
 * @since 0.1.0
 * @return object Notification_list
 */
class Notification_List {

	private $instance;

	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Notification_List ) ) {

			self::$instance = new Notification_list();
			self::$instance->constants();

		}

		return self::$instance;

	}

	/**
	 * Initialized constants required by the plugins.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function constants() {

		// Plugin Version.
		if ( ! defined( 'NOTIFICATION_LIST_VERSION' ) ) {
			define( 'NOTIFICATION_LIST_VERSION', '0.1.0' );
		}

		// Plugin URI.
		if ( ! defined( 'NOTIFICATION_LIST_URI' ) ) {
			define( 'NOTIFICATION_LIST_URI', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Path.
		if ( ! defined( 'NOTIFICATION_LIST_PATH' ) ) {
			define( 'NOTIFICATION_LIST_PATH', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Apps FIle.
		if ( ! defined( 'NOTIFICATION_LIST_PLUGIN_FILE' ) ) {
			define( 'NOTIFICATION_LIST_PLUGIN_FILE', __FILE__ );
		}
	}
}

/**
 * Get the object from the main class and return the instance
 *
 * @since 0.1.0
 * @return object
 */
function notification_list() {
	return Notification_list::instance();
}

// Get the notification list running.
notification_list();
