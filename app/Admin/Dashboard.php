<?php
namespace App\Admin;

class Dashboard {

	public function __construct() {

		/* Option */
		remove_action('welcome_panel', 'wp_welcome_panel');
		add_filter('screen_layout_columns', array( $this, 'shapeSpace_screen_layout_columns'));
		add_filter('get_user_option_screen_layout_dashboard', array( $this, 'shapeSpace_screen_layout_dashboard'));
		//add_action( 'admin_title' ,  array( $this, 'change_dashboard_title') );
		//add_action( 'admin_menu' , array( $this, 'change_dashboard_menu' ) );

		/* Remove dashboard */
		add_action( 'wp_dashboard_setup',  array( $this, 'remove_dashboard_widgets') );

		/* Add Extra */
		add_action('wp_dashboard_setup', array( $this, 'my_custom_dashboard_widgets'));

	}


	/*
    * change column Grid Meta Box in admin Panel
	 */
	public function shapeSpace_screen_layout_columns($columns) {
		$columns['dashboard'] = 1;
		$columns['dashboard'] = 2;
		return $columns;
	}

	/*
	 * add_filter('get_user_option_screen_layout_{$post_type}', 'your_callback' );
	 */
	public function shapeSpace_screen_layout_dashboard() { return 1; }

	/*
	 * Remove Dashboard
	 */
	public function remove_dashboard_widgets() {

		//Default Wordpress
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );   // Right Now
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );   // Right Now
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  // Incoming Links
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   // Plugins
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  // Recent Drafts
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
		// use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.

		//Plugin wordpress
		remove_meta_box( 'wpp_planet_widget', 'dashboard', 'normal' );
		remove_meta_box( 'semperplugins-rss-feed', 'dashboard', 'normal' );


	}

	/*
	 * change title in Dashboard Page
	 */
	function change_dashboard_title( $admin_title ) {
		global $current_screen;
		global $title;
		if( $current_screen->id != 'dashboard' ) {
			return $admin_title;
		}
		$change_title = 'گزارش';
		$admin_title = str_replace( __( 'Dashboard' ) , $change_title , $admin_title );
		$title = $change_title;
		return $admin_title;
	}

	/*
	 * change Menu Name Dashboard
	 */
	function change_dashboard_menu() {
		global $menu;
		foreach( $menu as $key => $menu_setting ) {
			$menu_slug = $menu_setting[2];
			if( empty( $menu_slug ) ) {
				continue;
			}
			if( $menu_slug != 'index.php' ) {
				continue;
			}
			$menu[ $key ][0] = 'گزارش';
			break;
		}
	}


	/*
	 * add extra Dashboard
	 */
	public function my_custom_dashboard_widgets() {
		wp_add_dashboard_widget('widget_id_this', per_number('عنوان یاکس'), array( $this, 'custom_dashboard_help' ));
	}
	public function custom_dashboard_help(){
		echo 'dashboar this';
	}



}