<?php
namespace App\Admin;

class User {


	public function __construct() {



		add_action( 'admin_init', array( $this, 'my_limit_admin_color_options'), 1 );
		add_filter( 'get_user_option_admin_color', array( $this, 'my_force_user_color') );
	}

	/*
	 * Remove color Scheme Select in option
	 */
	public function my_limit_admin_color_options(){
		global $_wp_admin_css_colors;
		/* Get fresh color data */
		$fresh_color_data = $_wp_admin_css_colors['fresh'];
		/* Remove everything else */
		$_wp_admin_css_colors = array( 'fresh' => $fresh_color_data );
	}

	/*
	 * Default Fresh color Scheme
	 */
	public function my_force_user_color( $color ){
		return 'fresh';
	}

	/*
	 * Show display Role
	 */
	public function filter_default_wp_role_displayname($user_role) {
		if($user_role =='Super Admin') { return 'مدیر ارشد'; }
		elseif($user_role =='Administrator') { return 'مدیر سایت'; }
		elseif($user_role =='Editor') { return 'ویرایشگر'; }
		elseif($user_role =='Subscriber') { return 'مشترک'; }
		elseif($user_role =='Contributor') { return 'مشارکت کننده'; }
		elseif($user_role =='Author') {
			return 'نویسنده';
		} else {
			return $user_role;
		}
	}


}