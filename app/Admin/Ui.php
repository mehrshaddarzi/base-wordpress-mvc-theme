<?php
namespace App\Admin;

class Ui {

	//Admin Bar varible
	public $wp_admin_bar;
	public $my_admin_page;
	const DESIGN_COMPANY_SITE = "http://ayanderohan.net";
	const DESIGN_COMPANY = "آینده روشن ایرانیان";
	const PAGE_NOT_SHOW = '';
	const PRIMARY_COLOR = "#3498db";
	const SECOND_COLOR = "#2581bf";
	/* Green 35B621 107300 */
	/*  black 565656 040303 */
	/*  red  d22323 800000 */

	public function __construct() {

		$this->wp_admin_bar = & $GLOBALS['wp_admin_bar'];
		$this->my_admin_page = & $GLOBALS['my_admin_page'];

		add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style') );
		add_filter('clean_url',array( $this,'unclean_url'),10,3);
		add_action('admin_footer', array( $this,'do_action_footer_sript'));
		add_action('jquery_admin_footer', array( $this,'exit_jquery_swwet_alert'));
		add_filter( 'update_footer', array( $this,'my_footer_version'), 11 );
		add_filter('admin_footer_text', array( $this,'remove_footer_admin'));
		add_filter('admin_title', array( $this,'my_admin_title'), 10, 2);
		add_filter( 'parse_query', array( $this,'exclude_pages_from_admin') );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_theme_style') );
		add_filter( 'update_footer', '__return_empty_string', 11 );
		add_action('admin_head', array( $this, 'remove_help_tabs'));
		add_action('current_screen', array( $this, 'add_default_icon_wrap'));


	}

	//remove help tab admin
	function remove_help_tabs() {
		$screen = get_current_screen();
		$screen->remove_help_tabs();
	}

	//color scheme wordpress Admin
	public function admin_theme_style() {

		$fau_primary    = self::PRIMARY_COLOR;
		$fau_primary = apply_filters( 'primary_color_wp_admin', $fau_primary );

        $fau_secondary    = self::SECOND_COLOR;
		$fau_secondary = apply_filters( 'second_color_wp_admin', $fau_secondary );

		wp_enqueue_style( 'fau-admin-bar-style', get_template_directory_uri() . '/asset/admin/base/fau_styles_adminbar.css' );
		wp_enqueue_style( 'fau-admin-style', get_template_directory_uri() . '/asset/admin/base/fau_styles_admin.css' );

		//admin bar
		$admin_bar_css = "
    #wpadminbar {
      background: {$fau_primary};
    }
    #wpadminbar .menupop .ab-sub-wrapper,#wpadminbar .shortlink-input {
      background: {$fau_primary};
    }
  ";
		wp_add_inline_style( 'fau-admin-bar-style', $admin_bar_css );

	//theme
	$admin_css = "
    a,
    input[type=checkbox]:checked:before,
    .view-switch a.current:before {
      color: {$fau_primary}
    }
    a { text-decoration:none; }
    a:hover {
      color: {$fau_secondary}
    }

    #adminmenu li a:focus div.wp-menu-image:before,#adminmenu li.opensub div.wp-menu-image:before,#adminmenu li:hover div.wp-menu-image:before {
      color:  {$fau_primary}!important;
    }

    #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head,#adminmenu .wp-menu-arrow,#adminmenu .wp-menu-arrow div,#adminmenu li.current a.menu-top,#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,.folded #adminmenu li.current.menu-top,.folded #adminmenu li.wp-has-current-submenu,/* Hover actions */
    #adminmenu li.menu-top:hover,#adminmenu li.opensub>a.menu-top,#adminmenu li>a.menu-top:focus {
      background: {$fau_primary};
      background:#FFF
    }

    #adminmenu .opensub .wp-submenu li.current a,#adminmenu .wp-submenu li.current,#adminmenu .wp-submenu li.current a,#adminmenu .wp-submenu li.current a:focus,#adminmenu .wp-submenu li.current a:hover,#adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a,#adminmenu .wp-submenu .wp-submenu-head,/* Dashicons */
    #adminmenu .current div.wp-menu-image:before,#adminmenu .wp-has-current-submenu div.wp-menu-image:before,#adminmenu a.current:hover div.wp-menu-image:before,#adminmenu a.wp-has-current-submenu:hover div.wp-menu-image:before,#adminmenu li.wp-has-current-submenu:hover div.wp-menu-image:before, #adminmenu li:hover div.wp-menu-image:before {
      color: {$fau_primary}
    }

    #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu div.wp-menu-name {
      color: {$fau_primary}
    }
  
    #adminmenu div.wp-menu-name {
    padding: 6px 0;
}
    .wrap .add-new-h2,.wrap .add-new-h2:active {
      background: {$fau_primary};
    }
    .wrap .add-new-h2:hover {
      background: {$fau_secondary}
    }
   /* div.updated { border-right: 5px solid  {$fau_primary}; } */
    .wp-core-ui .button:hover,.wp-core-ui .button-secondary:hover,.wp-core-ui .button-primary {
      background: {$fau_primary};
    }
    .wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover {
      background: {$fau_primary};
      box-shadow: 0 1px 0 {$fau_primary}, 0 0 2px 1px {$fau_primary};
    }
    .composer-switch a,.composer-switch a:visited,.composer-switch a.wpb_switch-to-front-composer,.composer-switch a:visited.wpb_switch-to-front-composer,.composer-switch .logo-icon {
      background-color: {$fau_primary}!important;
    }
    .composer-switch .vc-spacer, .composer-switch a.wpb_switch-to-composer:hover, .composer-switch a:visited.wpb_switch-to-composer:hover, .composer-switch a.wpb_switch-to-front-composer:hover, .composer-switch a:visited.wpb_switch-to-front-composer:hover {
      background-color:  {$fau_secondary}!important;
    }
    .wrap h2 {
    color: {$fau_primary} !important;
    }
    .wrap h2 span {
    color: #23282d;
    }

  ";
		wp_add_inline_style( 'fau-admin-style', $admin_css );
}

	// Hide Admin Page From Admin
	public function exclude_pages_from_admin($query) {
		global $pagenow,$post_type;
		if (is_admin() && $pagenow=='edit.php' && $post_type =='page') {
			$query->query_vars['post__not_in'] = array(self::PAGE_NOT_SHOW);
		}
	}

    //Add Css To Admin All Page
	public function load_custom_wp_admin_style() {

		//font awesome
		wp_register_style( 'awesome-font', get_template_directory_uri().'/asset/admin/font-awesome-4.7.0/css/font-awesome.min.css', false );
		wp_enqueue_style( 'awesome-font' );

		//load Pace
		wp_enqueue_script( 'pace-loading', get_template_directory_uri().'/asset/admin/pace/pace.min.js?data-pace-options=yes' );

		//load Swet Alert 2
		wp_register_style( 'sweet-alert-2', get_template_directory_uri().'/asset/admin/sweetalert2/sweetalert2.min.css', false );
		wp_enqueue_style( 'sweet-alert-2' );
		wp_enqueue_script( 'sweet-alert-2', get_template_directory_uri().'/asset/admin/sweetalert2/sweetalert2.min.js' );

		//wp_deregister_script( 'thickbox' );
		//wp_deregister_style( 'thickbox' );
	}

	/* Add option to load Pace in data attribute*/
	public function unclean_url( $good_protocol_url, $original_url, $_context){
		if (false !== strpos($original_url, 'data-pace-options')){
			remove_filter('clean_url', array( $this, 'unclean_url'),10,3);
			$url_parts = parse_url($good_protocol_url);
			return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . "' data-pace-options='{ \"ajax\": false }";
		}
		return $good_protocol_url;
	}

	//admin footer Script do_action
    public function do_action_footer_sript(){
	    ?>
        <script>
            jQuery(document).ready(function($){
			    <?php do_action('jquery_admin_footer'); ?>
            });
        </script>
	    <?php
    }

    //add jquery exit From Admin
    public function exit_jquery_swwet_alert(){
        //Jquey Exit From Admin wordpress
        echo '
       $(document).on("click","li#wp-admin-bar-exit-left-menu a",function() {
           swal({
              title: \'خروج از مدیریت\',
              text: "آیا واقعا میخواهید از مدیریت خارج شوید ؟",
              type: \'warning\',
              showCancelButton: true,
              confirmButtonText: \'خروج\',
              cancelButtonText: \'بازگشت\',
            }).then(function () {
                window.location.href = "'.str_replace("&amp;","&", wp_logout_url() ).'";
            });
        });
       ';

        //remove text (jam kardan fehrest)
        echo 'jQuery("span.collapse-button-label").html("");';

        //change name setting page
        echo 'jQuery("button#show-settings-link").html("نمایش");';

        //add line after wrap h1
	    echo 'jQuery( "<div class=\'seprate_title\'></div>" ).insertAfter( ".wrap h1" );';

	    //icon in wrap h1
        if(has_action( 'adminpage_icon' )) {
	        echo 'var page_name_wrap = jQuery( ".wrap h1" ).text();';
	        echo 'jQuery( ".wrap h1" ).html("<i class=\'';
	        do_action('adminpage_icon');
	        echo ' wrap_h1_icon\'></i>" + page_name_wrap);';
        }

}

	//change admin copyright
	public function remove_footer_admin () {
		echo ' طراحی و پشتیبانی : <a href="'.self::DESIGN_COMPANY_SITE.'" target="_blank">'.self::DESIGN_COMPANY.'</a> ';
	}
	public function my_footer_version() {return '';}

	//Admin title
	public function my_admin_title($admin_title, $title) {
	    return get_bloginfo('name').' &bull; '.$title;
	}

    /*
     * Add Default icon Wrap
     */
    public function add_default_icon_wrap(){
	    if (is_admin()) {
	        $screen = get_current_screen();
	        $array = [
	          'dashboard' => 'fa-dashboard',
	          'edit-post' => 'fa-pencil',
	          'post' => 'fa-pencil',
	          'edit-category' => 'fa-unlink',
	          'edit-post_tag' => 'fa-tag',
	          'upload' => 'fa-upload',
	          'media' => 'fa-upload',
	          'edit-page' => 'fa-pencil',
	          'page' => 'fa-pencil',
	          'edit-comments' => 'fa-comment',
	          'themes' => 'fa-paint-brush',
	          'widgets' => 'fa-th-large',
	          'nav-menus' => 'fa-th-list',
	          'plugins' => 'fa-plug',
	          'users' => 'fa-users',
	          'profile' => 'fa-user',
	          'options-general' => 'fa-cog',
	          'options-writing' => 'fa-cog',
	          'options-reading' => 'fa-cog',
	          'options-discussion' => 'fa-cog',
	          'options-media' => 'fa-cog',
	          'options-permalink' => 'fa-cog',
            ];
            foreach($array as $screen_id => $icon_wrap) {
	            if ($screen->id == $screen_id) {
	                add_action('adminpage_icon', function() use ($screen_id, $array) {
                        echo "fa {$array[$screen_id]}";
	                });
	            }
            }
	    }
    }

}