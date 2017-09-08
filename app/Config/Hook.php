<?php
namespace App\Config;

class Hook {

	//Admin Bar varible
	public $wp_admin_bar;
	
	public function __construct() {

		$this->redux = & $GLOBALS[Front::REDUX];
		$this->wp_admin_bar = & $GLOBALS['wp_admin_bar'];
		add_action( 'wp_print_styles',  array( $this, 'my_deregister_styles' ), 100 );

		/* contact 7*/
		add_action( 'wp_print_styles',  array( $this, 'c7_deregister_styles'), 100 );
		add_action( 'wp_print_scripts', array( $this, 'c7_deregister_javascript'), 100 );


		/* Base Wordpress */
		add_action('init', array( $this, 'crunchify_clean_header_hook'));
		remove_action('rest_api_init', 'wp_oembed_register_route');
		remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
		remove_action('wp_head', 'wp_oembed_add_host_js');
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
		remove_action( 'wp_head', 'wp_resource_hints', 2 );
		remove_action('wp_head', 'wp_generator');
		add_action('init', array( $this, 'removeHeadLinks'));
		remove_action('wp_head','feed_links_extra', 3);
		remove_action('wp_head','feed_links', 2);

		/*theme*/
		add_action( 'widgets_init', array( $this, 'twentyten_remove_recent_comments_style') );

		/* plugin */
		remove_action('wp_head', 'se_global_head');
		remove_action( 'wp_head', 'get_ssba_style' );
		remove_filter( 'the_content', 'show_share_buttons');
		add_action( 'wp_print_scripts',  array( $this, 'remove_ssba_in_home'), 100 );

		add_action( 'wp_before_admin_bar_render', array( $this, 'remove_yoast_admin_bar_render') );
		add_action('admin_head',  array( $this, 'remove_ltr_dunamic_widget'));
      
      	/*Pretty Photo*/
        //add_filter('the_content', array( $this, 'prettyphoto_rel_replace') );

	}
  
  	/*Pretty prettyphoto*/
    public function prettyphoto_rel_replace ($content) {
	    global $post;
        $pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
        $replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto[%LIGHTID%]"$6>';
        $content = preg_replace($pattern, $replacement, $content);
        $content = str_replace("%LIGHTID%", $post->ID, $content);
        return $content;
    }

	public function twentyten_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}

	public function removeHeadLinks() {
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
	}

	public function crunchify_clean_header_hook(){
		wp_deregister_script( 'comment-reply' );
		wp_deregister_script( 'front_end_script.js' );
	}


	public function remove_ssba_in_home(){
		if (is_home() or is_category()) {
			wp_deregister_script( 'ssba' );
			wp_deregister_script( 'ssba-sharethis' );
		}
	}

	public function my_deregister_styles()    {
		if (is_home() or is_category()) {
			wp_deregister_style( 'dashicons' );
			wp_deregister_style( 'contact-form-7-rtl' );
			wp_deregister_style( 'cptch_stylesheet' );
			wp_deregister_style( 'cptch_desktop_style' );
			wp_dequeue_style('ssbaFont');
		}
		wp_dequeue_style('bfa-font-awesome');
	}

	/*contact 7 Form*/
	public function c7_deregister_styles() {
		$page_array = explode(',', $this->redux['allow-page-contact-7']);

		if ( ! is_page( $page_array ) ) {
			wp_deregister_style( 'contact-form-7' );
			wp_deregister_style( 'contact-form-7-rtl' );
		}
	}

	// Deregister Contact Form 7 JavaScript files on all pages without a form
	public function c7_deregister_javascript() {
		$page_array = explode(',', $this->redux['allow-page-contact-7']);

		if ( ! is_page( $page_array ) ) {
			wp_deregister_script( 'contact-form-7' );
		}
	}

	/*yoast*/
	public function remove_yoast_admin_bar_render() {
		$this->wp_admin_bar->remove_menu('wpseo-menu');
	}

	/*Dynamic widget and acf Tab*/
	public function remove_ltr_dunamic_widget(){
		echo '
		<style>
		.hl > li { float: right !important;}
		.dynwid_conf { direction:ltr; text-align:left; }
		</style>
		';
	}

}
