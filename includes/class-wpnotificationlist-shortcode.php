<?php
/**
 * Create a shortcode for displaying the notification list
 *
 * @package     WPNotificationList
 * @author      Tremi Dkhar
 * @since       0.3.0
 * @license     GPL-2.0+
 * @copyright   Copyright (c) 2020, Tremi Dkhar
 */

class WPNotificationList_Shortcode {

	/**
	 * Holds the default argument of the shortcode, populate in the constructor
	 *
	 * @since 0.3.0
	 * @var array
	 */
	private $default_atts = array();
	
	/**
	 * Constructor. Setting the default attributes for the constructor
	 * 
	 * @since 0.3.0
	 * @return void
	 */
	public function __construct() {

		$this->default_atts = array(
			'no_of_notification'	=> 10,
			'show_archive_link'  => true,
			'order_list'         => true,
			'display_type'       => 'the_title',
		);

		add_shortcode( 'wpnotificationlist', array( $this, 'shortcode' ) );

	}

	function shortcode( $atts ) {
		
		$atts = shortcode_atts( $this->default_atts, $atts );

		$notifications = new WP_Query(
			array(
				'post_type'      => 'wpnotificationlist',
				'posts_per_page' => $atts['no_of_notification'],
				'post_status'    => 'publish',
			)
		);

		if ( ! ( $notifications->have_posts() ) ) {
			return;
		}

		if ( true === $atts['order_list'] ) {
			$tag['open']  = '<ol>';
			$tag['close'] = '</ol>';
		} else {
			$tag['open']  = '<ul>';
			$tag['close'] = '</ul>';
		}

		ob_start();
		echo $tag['open']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		while ( $notifications->have_posts() ) {
			$notifications->the_post();
			?>
			<li>
		 		<?php
				switch ( $atts['display_type'] ) { // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					case 'the_title':
						printf( '<a href="%1$s" title="%2$s">%2$s</a>', get_the_permalink(), get_the_title() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						break;
					case 'the_excerpt':
						the_excerpt();
						break;
					case 'the_content':
						the_content();
						break;
					default:
						return;
				}
				?>
			</li>
			<?php
		}
		echo $tag['close']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( true === $atts['show_archive_link'] ) {
			printf( '<p><a href="%1$s" class="wp-notification-list" title="%2$s">%2$s</a></p>', esc_url( get_post_type_archive_link( 'wpnotificationlist' ) ), esc_attr__( 'View All Notification', 'wpnotificationlist' ) );
		}
		return ob_get_clean();
	}
}