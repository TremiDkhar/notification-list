<?php
/**
 * Initialize all the plugin basics setup.
 *
 * @package     WPNotificationList
 * @author      Tremi Dkhar
 * @since       0.1.0
 * @license     GPL-2.0+
 * @copyright   Copyright (c) 2020, Tremi Dkhar
 */

/**
 * Main class to holds all the necessary information and register the cpt
 *
 * @since 0.1.0
 */
class WPNotificationList_Register_CPT {

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct() {
		// Register notification list custom post type.
		add_action( 'init', array( $this, 'register_cpt' ) );
	}

	/**
	 * Callback function to register the CPT
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function register_cpt() {
		$labels = array(
			'name'                  => _x( 'Notification Lists', 'Post Type General Name', 'wpnotificationlist' ),
			'singular_name'         => _x( 'Notification List', 'Post Type Singular Name', 'wpnotificationlist' ),
			'menu_name'             => __( 'Notification List', 'wpnotificationlist' ),
			'name_admin_bar'        => __( 'Notification List', 'wpnotificationlist' ),
			'archives'              => __( 'Notification List Archives', 'wpnotificationlist' ),
			'attributes'            => __( 'Notification Attributes', 'wpnotificationlist' ),
			'parent_item_colon'     => __( 'Parent Item:', 'wpnotificationlist' ),
			'all_items'             => __( 'All Notification List', 'wpnotificationlist' ),
			'add_new_item'          => __( 'Add New Notification', 'wpnotificationlist' ),
			'add_new'               => __( 'Add New', 'wpnotificationlist' ),
			'new_item'              => __( 'New Notification', 'wpnotificationlist' ),
			'edit_item'             => __( 'Edit Notification', 'wpnotificationlist' ),
			'update_item'           => __( 'Update Notification', 'wpnotificationlist' ),
			'view_item'             => __( 'View Notification', 'wpnotificationlist' ),
			'view_items'            => __( 'View Notification', 'wpnotificationlist' ),
			'search_items'          => __( 'Search Notification', 'wpnotificationlist' ),
			'not_found'             => __( 'Not found', 'wpnotificationlist' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wpnotificationlist' ),
			'featured_image'        => __( 'Featured Image', 'wpnotificationlist' ),
			'set_featured_image'    => __( 'Set featured image', 'wpnotificationlist' ),
			'remove_featured_image' => __( 'Remove featured image', 'wpnotificationlist' ),
			'use_featured_image'    => __( 'Use as featured image', 'wpnotificationlist' ),
			'insert_into_item'      => __( 'Insert into Notification', 'wpnotificationlist' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Notification', 'wpnotificationlist' ),
			'items_list'            => __( 'Notification List', 'wpnotificationlist' ),
			'items_list_navigation' => __( 'Notification List navigation', 'wpnotificationlist' ),
			'filter_items_list'     => __( 'Filter Notification List', 'wpnotificationlist' ),
		);

		$args = array(
			'label'               => __( 'Notification List', 'wpnotificationlist' ),
			'description'         => __( 'Display public notification to the public', 'wpnotificationlist' ),
			'labels'              => $labels,
			'show_in_rest'		  => true,
			'supports'            => array( 'title', 'editor' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-list-view',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite'			  => array(
				'slug'		=> 'notification',
				'with_front' => false,
			),
		);

		register_post_type( 'wpnotificationlist', $args );
	}
}
