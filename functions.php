<?php
/*
 * Loading composer autoload
 */
require "lib/autoload.php";


/*
 * List Class Provider
 */
$provider = [

	//Load Base class template
	'fornt_end_template' => '\App\Config\Front',
	'hook_template' => '\App\Config\Hook',
	'setup_template' => '\App\Config\Setup',
	'widget_template' => '\App\Config\Widget',
	'ajax_template' => '\App\Ajax',
	'bootstrap_template' => '\App\Bootstrap',
	'this_template' => '\App\Template',

	//Load class Admin and Login Page
	'app_login_page' => '\App\Admin\LoginPage',
	'app_ui_admin' => '\App\Admin\Ui',
	'app_user_admin' => '\App\Admin\User',
	'app_adminbar' => '\App\Admin\AdminBar',
	'app_adminmenu' => '\App\Admin\MenuBar',
	'app_admin_dashboard' => '\App\Admin\Dashboard',

	//Custom Class This Project
	/*
	 * this place custom App
	 */

	//Load Wordpress theme
	'wp_index' => '\App\Wordpress\Index',
	'wp_404' => '\App\Wordpress\Page_404',
	'wp_archive' => '\App\Wordpress\Archive',
	'wp_category' => '\App\Wordpress\Category',
	'wp_page' => '\App\Wordpress\Page',
	'wp_single' => '\App\Wordpress\Single',
	'wp_search' => '\App\Wordpress\Search',
	'wp_comment' => '\App\Wordpress\Comment',
];

/*
 * Load All class Privider
 */
foreach($provider as $var_name => $class_name) {
	${$var_name} = new $class_name;
}