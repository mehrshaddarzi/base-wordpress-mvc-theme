<?php
namespace App\Config;

class Front {

	//Redux Framework Varible
	private $wpdb;
	public $redux;
	const REDUX = "redux_option";
	const COMPRESS_HTML = false;
	const USE_SESSION = true;
	const CSS_FUNCTION = "less"; //this place [less/sass/css]

	public function __construct() {

		$this->redux = & $GLOBALS[self::REDUX];
		$this->wpdb = & $GLOBALS['wpdb'];

		if(self::COMPRESS_HTML ===true) add_action('init', array( $this, 'compress_html'));
		if(self::USE_SESSION ===true) add_action('init', array( $this, 'init_sessions'));
		if(self::CSS_FUNCTION =="sass") add_filter('wp_scss_variables', array( $this, 'sass_varible'));
		if(self::CSS_FUNCTION =="less") add_filter('wp_enqueue_scripts', array( $this, 'less_varible'));

		add_action('wp_head', array( $this, 'icon_site'));
		add_action('pre_get_posts', array( $this, 'custom_posts_per_page'));
		add_action('wp_head', array( $this, 'add_css_site'));
		add_action('wp_head', array( $this, 'add_jquery_site'));
		add_action('wp', array( $this, 'load_cdn_jquery'));
		add_action( 'wp_default_scripts', array( $this, 'cedaro_dequeue_jquery_migrate') );
		add_action( 'wp_enqueue_scripts', array( $this, 'register'));
		add_action('template_redirect', array( $this, 'inherit_cat_template') );
		//add_action('wp_head', array( $this, 'add_less_site'));

		add_filter( 'style_loader_src', array( $this, 'remove_cssjs_ver'), 10, 2 );
		add_filter( 'script_loader_src', array( $this, 'remove_cssjs_ver'), 10, 2 );
	}

	/*
	 * inital Session
	 */
	public function init_sessions() {
		if ( ! session_id() ) {
			session_start();
		}
	}

	/*
	 * Placeholder Image
	 */
	public function placeholdit($width,$height,$back = 'f8f8f8',$fontcolor = 'b6b6b6') {
		//placeholder.php?size=400x150&bg=eee&fg=999&text=Generated+image
		return get_stylesheet_directory_uri().'/includes/placeholder/placeholder.php?size='.$width.'x'.$height.'&bg='.$back.'&fg='.$fontcolor;
	}

	/* Icon Site */
	public function icon_site(){
echo '<link rel="icon" type="image/png" href="'.$this->redux['gcb-icon-site']['url'].'">'."\n";
	}

	/*Version style Css*/
	function my_wp_default_styles($styles)
	{
		//use release date for version
		//$styles->default_version = "3.2";
	}
	//add_action("wp_default_styles", "my_wp_default_styles");

	/* remove ?ver from Css and script */
	function remove_cssjs_ver( $src ) {
		if( strpos( $src, '?ver=' ) )
			$src = remove_query_arg( 'ver', $src );
		return $src;
	}

	//Get CDN Jquery
	function load_cdn_jquery(){
		if (!is_admin()) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', 'https://code.jquery.com/jquery-latest.min.js', true, 'latest-yolo' );
			wp_enqueue_script( 'jquery' );
		}

	}

	//Remove Migration
	function cedaro_dequeue_jquery_migrate( $scripts ) {
			if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
				$jquery_dependencies = $scripts->registered['jquery']->deps;
				$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
			}
		}

	/* Add Css and javascript site */
	function register(){

		/*
		 * Less Example Load -> (wp-less)
		add_less_var( 'base-color', $this->redux['base-color'] );
		//if ( ! is_admin() ) wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/style.less' );
		 */

		/*
		 * Sass Example Load
		function wp_scss_set_variables(){
		    $variables = array(
		        'black' => '#000',
		        'white' => '#fff'
		    );
		    return $variables;
		}
		add_filter('wp_scss_variables','wp_scss_set_variables');
		define('WP_SCSS_ALWAYS_RECOMPILE', true);

		 */

		//Js
		wp_enqueue_script('class-js', get_template_directory_uri() . '/js/website.min.js', array('jquery'), '', false);
		if ( is_single() )
			wp_enqueue_script('lightbox-js', get_template_directory_uri() . '/class/bootstrap-lightbox/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'), '', false);
		wp_enqueue_script('Main-js', get_template_directory_uri() . '/js/market.min.js', array('jquery'), '', false);
		wp_enqueue_script('Ticker-News', get_template_directory_uri() . '/js/ticker.js', array('jquery'), '', true);

		//localize Url Wp
		wp_localize_script( 'Main-js', 'ajaxurl', home_url() );

	}

	/* Add Sass Varible */
	public function sass_varible(){
		$variables = array(
			'black' => '#000',
			'white' => '#fff'
		);
		return $variables;
	}

	/* Add Less Varible */
	public function less_varible(){
		//add_less_var( 'base-color', $this->redux['base-color'] );
	}

	/* Add Less site */
	function add_less_site() {
		echo '<link rel="stylesheet/less" type="text/css" href="'.get_template_directory_uri() .'/style.less" />'."\n";
		echo '<script src="'.get_template_directory_uri() .'/less/less.min.js"></script>'."\n";
	}

	/*Custom Post Per page Loop*/
	function custom_posts_per_page($query) {
		if (is_search() && $query->is_main_query()) {
			$query->set('posts_per_page', $this->redux['number-search-page']);
		}
		if (is_archive() && $query->is_main_query()) {
			$query->set('posts_per_page', $this->redux['number-archive-page']);
		}
		if (is_category() && $query->is_main_query()) {
			$query->set('posts_per_page', $this->redux['number-category-page']);
		}
	}

	/*Css site*/
	function add_css_site() {
		if ($this->redux['allow-css-site'] ==1) { /*add css to site*/
			echo "\n<style>\n".$this->redux['css-site']."\n</style>\n";
		}
	}

	/*Jquery and java site*/
	function add_jquery_site() {
		if ($this->redux['allow-java-site'] ==1) { /*add java to site*/
			echo "\n<script type='text/javascript'>\n".$this->redux['java-site']."\n</script>\n";
		}
	}

	/* disable Site */
	function check_disabled_site() {
		if ($this->redux['disable-all-site'] ==1 and !is_user_logged_in()) { /*Site is Disabled*/

		echo '
		<!DOCTYPE html>
		<html dir="rtl" lang="fa-IR">
		<head>
		<meta charset="UTF-8" />
		<title>'.get_bloginfo("name").'</title>
		</head>
		<body style="background-color:#ececec;">
		<div style="font:9pt tahoma; direction:rtl; width:50%; margin:13% auto; padding:15px; min-height:80px; background-color:#fff; border-radius:10px;">
		'.$this->redux['text-disabled-site'].'
		</div>
		</body>
		</html>
		';
			exit;
			}
	}

	/* use Parent Template category */
	public function inherit_cat_template() {
		if (is_category()) {
			$catid = get_query_var('cat');
			if ( file_exists(TEMPLATEPATH . '/category-' . $catid . '.php') ) {
				include( TEMPLATEPATH . '/category-' . $catid . '.php');
				exit;
			}
			$cat = &get_category($catid);
			$parent = $cat->category_parent;
			while ($parent){
				$cat = &get_category($parent);
				if ( file_exists(TEMPLATEPATH . '/category-' . $cat->cat_ID . '.php') ) {
					include (TEMPLATEPATH . '/category-' . $cat->cat_ID . '.php');
					exit;
				}
				$parent = $cat->category_parent;
			}
		}
	}

	/*
	 * compress Html
	 */
	public function compress_html(){

ob_start();
add_action('shutdown', function() {
    $final = '';
    $levels = ob_get_level();
    for ($i = 0; $i < $levels; $i++) { $final .= ob_get_clean(); }
    echo apply_filters('final_output', $final);
}, 0);
add_filter('final_output', function($output) {

if (!is_admin()) {

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (strpos($url,'.xml') !== false) {
    return $output;
} elseif(is_feed()) { return $output; } else {

$copyright = '<!DOCTYPE html>
<!--
Project Name : BuyMarket
Powered By : MizbanSystem Khazar (www.irwebdesign.ir)
Design And Developer : Mehrshad Darzi (http://tlgrm.me/mehrshaddarzi)
-->'."\n";
	//$output = preg_replace('/<!--(.|\s)*?-->/', '', $output);
	//$output = str_replace(array("\r\n", "\r", "\n"), "", $output);
	if (is_home()) {
		$output = str_replace(array("\r\n", "\r", "\n"), "", $output);
	} else {
		$output = sanitize_output($output);
	}
	//$output = str_replace(PHP_EOL, null, $output);
	return $copyright.$output;
}

} else {
	return $output;
}

});


	}


}