<?php
/**
 * Widget to display the list of notification
 *
 * @package WPNotificationList
 * @subpackage Widget
 * @author Tremi Dkhar
 * @since 0.1.0
 * @copyright Copyright (c) 2020, Tremi Dkhar
 */

/**
 * Widget Class to Display Farewell message
 *
 * @since 0.1.0
 */
class WPNotificationList_Widget_Display extends WP_Widget {

	/**
	 * Holds the widget defaults settings, populated in constructor
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $defaults;

	/**
	 * Constructor. Set the widget defaults option and create a widget.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct() {

		$this->defaults = array(
			'title'              => __( 'Notifications', 'wpnotificationlist' ),
			'no_of_notification' => 10,
			'show_archive_link'  => true,
			'order_list'         => true,
			'display_type'       => 'the_title',
		);

		$widget_options = array(
			'classname'   => 'widget_wpnotificationlist',
			'description' => __( 'Display the list of notification', 'wpnotificationlist' ),
		);

		parent::__construct( 'widget_wpnotificationlist', __( 'WP Notification List', 'wpnotificationlist' ), $widget_options );
	}

	/**
	 * Update a Particular instance of widget.
	 *
	 * @since 0.1.0
	 * @param array $new_instance New settings for this instance as input by the user.
	 * @param array $old_instance Old settings of this instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$new_instance['title']              = sanitize_text_field( $new_instance['title'] );
		$new_instance['no_of_notification'] = (int) $new_instance['no_of_notification'];
		$new_instance['order_list']         = isset( $new_instance['order_list'] ) ? true : false;
		$new_instance['show_archive_link']  = isset( $new_instance['show_archive_link'] ) ? true : false;
		$new_instance['display_type']       = sanitize_text_field( $new_instance['display_type'] );

		return $new_instance;
	}

	/**
	 * Echo the widget settigs update form
	 *
	 * @since 0.1.0
	 * @param array $instance Current settings of the instance.
	 * @return void
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( $instance, $this->defaults );

		$display_types = array(
			'the_title'   => 'Title Only',
			'the_excerpt' => 'Excerpt',
			'the_content' => 'Full Content',
		);

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpnotificationlist' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_notification' ) ); ?>"><?php esc_html_e( 'No of Notification to be display:', 'wpnotificationlist' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'no_of_notification' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_notification' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['no_of_notification'] ); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'order_list' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order_list' ) ); ?>" <?php checked( $instance['order_list'] ); ?> /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'order_list' ) ); ?>"><?php esc_html_e( 'Display in order list', 'wpnotificationlist' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_archive_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_archive_link' ) ); ?>" <?php checked( $instance['show_archive_link'] ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_archive_link' ) ); ?>"><?php esc_html_e( 'Show Archive Link', 'wpnotificationlist' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display_type' ) ); ?>"><?php esc_html_e( 'Display Type:', 'wpnotificationlist' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_type' ) ); ?>">
				<?php
				foreach ( $display_types as $display_type => $value ) {
					printf( '<option value="%s" %s>%s</option>', esc_attr( $display_type ), selected( $display_type, $instance['display_type'] ), esc_html( $value ) );
				}
				?>
			</select>
		</p>
		<?php
	}

	/**
	 * Echo the widget
	 *
	 * @since 0.1.0
	 * @param array $args Display argument including `before_title`, `after_title`, `before_widget` and  `after_widget`.
	 * @param array $instance The settings for the particular instance of the widget.
	 * @return void
	 */
	public function widget( $args, $instance ) {

		// Exit if the display type is empty.
		if ( empty( $instance['display_type'] ) ) {
			return;
		}

		$notifications = new WP_Query(
			array(
				'post_type'      => 'wpnotificationlist',
				'posts_per_page' => $instance['no_of_notification'],
				'post_status'    => 'publish',
			)
		);

		if ( ! ( $notifications->have_posts() ) ) {
			return;
		}

		if ( true === $instance['order_list'] ) {
			$tag['open']  = '<ol>';
			$tag['close'] = '</ol>';
		} else {
			$tag['open']  = '<ul>';
			$tag['close'] = '</ul>';
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo $tag['open']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		while ( $notifications->have_posts() ) {
			$notifications->the_post();
			?>
			<li>
				<?php
				switch ( $instance['display_type'] ) { // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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

		if ( true === $instance['show_archive_link'] ) {
			printf( '<a href="%1$s" class="wp-notification-list" title="%2$s">%2$s</a>', esc_url( get_post_type_archive_link( 'wpnotificationlist' ) ), esc_attr__( 'View All Notification', 'wpnotificationlist' ) );
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
