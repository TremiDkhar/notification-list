<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Plugin Name: WP Notification List
 * Plugin URI:  https://github.com/TremiDkhar/wp-notification-list
 * Description: Display list of notification or information to the public.
 * Version:     0.3.0
 * Author:      Tremi Dkhar
 * Author URI:  https://github.com/TremiDkhar
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpnotificationlist
 *
 * @package     WPNotificationList
 * @author      Tremi Dkhar
 * @copyright   Copyright (c) Tremi Dkhar, 2020
 * @license     GPL-2.0+
 */

/**
 * Main Notification List Instance
 *
 * @since 0.1.0
 * @return object WPNotificationList
 */
final class WPNotificationList {

	/**
	 * Holds instance of WPNotificationList
	 *
	 * @var object WPNotificationList
	 */
	public static $instance;

	/**
	 * CPT Object
	 *
	 * @var object WPNotificationList_Register_CPT
	 */
	private $cpt;

	/**
	 * Main WPNotificationList instance
	 *
	 * Insure that only one instance of WPNotificationList exists in memory at any one time.
	 * Also prevent needing to define globals all over the place.
	 *
	 * @since 0.1.0
	 * @return object WPNotificationList
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self();
			self::$instance->constants();
			self::$instance->includes();

			self::$instance->cpt = new WPNotificationList_Register_CPT();
			self::$instance->shortcode = new WPNotificationList_Shortcode();

			add_action( 'widgets_init', array( self::$instance, 'register_widget' ) );

		}

		return self::$instance;

	}

	/**
	 * Initialized constants required by the plugins.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function constants() {

		// Plugin Version.
		if ( ! defined( 'WPNOTIFICATIONLIST_VERSION' ) ) {
			define( 'WPNOTIFICATIONLIST_VERSION', '0.1.0' );
		}

		// Plugin URI.
		if ( ! defined( 'WPNOTIFICATIONLIST_URI' ) ) {
			define( 'WPNOTIFICATIONLIST_URI', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Path.
		if ( ! defined( 'WPNOTIFICATIONLIST_PATH' ) ) {
			define( 'WPNOTIFICATIONLIST_PATH', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Apps FIle.
		if ( ! defined( 'WPNOTIFICATIONLIST_PLUGIN_FILE' ) ) {
			define( 'WPNOTIFICATIONLIST_PLUGIN_FILE', __FILE__ );
		}
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 0.1.0
	 * @return void
	 */
	private function includes() {
		require_once WPNOTIFICATIONLIST_PATH . 'includes/class-wpnotificationlist-register-cpt.php';
		require_once WPNOTIFICATIONLIST_PATH . 'includes/class-wpnotificationlist-widget-display.php';
		require_once WPNOTIFICATIONLIST_PATH . 'includes/class-wpnotificationlist-shortcode.php';
	}

	/**
	 * Register the widget
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function register_widget() {
		register_widget( 'WPNotificationList_Widget_Display' );

	}
}

/**
 * Get the object from the main class and return the instance
 *
 * @since 0.1.0
 * @return object
 */
function WPNotificationList() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return WPNotificationList::instance();
}

// Get the notification list running.
WPNotificationList();
