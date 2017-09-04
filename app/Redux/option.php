<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "redux_option";

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /*
     *
     * --> Action hook examples
     *
     */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

	
	
	
    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */
    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'تنظیمات پوسته', 'redux-framework-demo' ),
        'page_title'           => __( 'تنظیمات پوسته', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => '',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
       'footer_credit'     => '&nbsp;',

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
   // $args['admin_bar_links'][] = array(
    //    'id'    => 'redux-extensions',
    //    'href'  => 'reduxframework.com/extensions',
    //    'title' => __( 'Extensions', 'redux-framework-demo' ),
  //  );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
   // $args['share_icons'][] = array(
  //      'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
   //     'title' => 'Visit us on GitHub',
  //      'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
  //  );
   

    // Panel Intro text -> before the form
 
        $args['intro_text'] = __( '<span class="dashicons dashicons-admin-generic"></span><span class="yekan"> تنظیمات قالب '.$theme->get( 'Name' ).'</span>', 'redux-framework-demo' );
    

    // Add content after the form.
   // $args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo' );

   Redux::setExtensions( $opt_name, str_replace('\\','/',get_template_directory() ). '/includes/ReduxCore/inc/extensions/redux-vendor-support/vendor_support/'  );
   
	Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    //$tabs = array(
   //     array(
    //        'id'      => 'redux-help-tab-1',
    //        'title'   => __( 'Theme Information 1', 'redux-framework-demo' ),
   //         'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
    //    ),
   //     array(
   //         'id'      => 'redux-help-tab-2',
   //         'title'   => __( 'Theme Information 2', 'redux-framework-demo' ),
  //          'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
   //     )
  //  );
   // Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
   // $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
   // Redux::setHelpSidebar( $opt_name, $content );

    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
	
    Redux::setSection( $opt_name, array(
        'title' => __( 'تنظیمات پایه', 'redux-framework-demo' ),
        'id'    => 'basic',
        'desc'  => __( 'تنظیمات کلی حالت نمایش قالب وب سایت', 'redux-framework-demo' ),
        'icon'  => 'el el-home',
		'fields'  => array(
		   
//***************************************************************************آیکون سایت	
		   array(
					'id'       => 'gcb-icon-site',
					'type'     => 'media', 
					'url'      => true,
					'title'    => "آیکون سایت",
					'desc'     => "Format .png File | 32*32 pixel",
					'subtitle' => "آیکون کوچک نمایش در کنار آدرس بار مرورگر",
					'default'  => array(
						'url'=> get_bloginfo('template_directory').'/images/icon/icon.png'
					)
				
				),
				
				
				
			
				
//***************************************************************************چیدمان سایدبار	
			array(
                'id'       => 'section-sidebar-chideman',
                'type'     => 'section',
                'title'    => "چیدمان صفحه سایت",
                'subtitle' => "لطفا نحوه ی حالت سایدبار را مشخص کنید",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
			
			
			array(
                'id'       => 'sidebar-place',
                'type'     => 'button_set',
                'title'    => "مکان سایدبار",
                'subtitle' => "",
                'desc'     => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                     '1' => 'سمت راست',
                    '2' => 'سمت چپ',
                ),
                'default'  => '1'
            ),
			
			
			array(
                'id'       => 'sidebar-layout-category',
                'type'     => 'button_set',
                'title'    => "صفحه دسته ها",
                'subtitle' => "",
                'desc'     => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                     '1' => 'تک سایدبار',
                    '2' => 'بدون سایدبار',
                ),
                'default'  => '2'
            ),
			
		array(
				'id'       => 'sidebar-layout-category-not-id',
				'type'     => 'text',
				'title'    => "جداسازی برخی دسته ها",
				'subtitle' => "آی دی دسته هایی که نمیخواهید از قانون بالا پیروی کنند وارد نمائید",
				'desc'  => "آی دی دسته ها بدون فاصله با کاما جدا شوند مثلا : 4,25",
				'class' => 'ltr-input',
				'default'  => ''
		),
			
		array(
                'id'       => 'sidebar-layout-search',
                'type'     => 'button_set',
                'title'    => "صفحه جستجو",
                'subtitle' => "",
                'desc'     => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                     '1' => 'تک سایدبار',
                    '2' => 'بدون سایدبار',
                ),
                'default'  => '2'
           ),
			
		array(
                'id'       => 'sidebar-layout-archive',
                'type'     => 'button_set',
                'title'    => "صفحه آرشیو و برچسب ها",
                'subtitle' => "",
                'desc'     => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'تک سایدبار',
                    '2' => 'بدون سایدبار',
                ),
                'default'  => '1'
            ),
			
		array(
                'id'     => 'help-sidebar-for-page',
                'type'   => 'info',
                'notice' => false,
                'style'  => '',
                'icon'   => 'el el-info-circle',
               'title' => "چیدمان سایدبار در صفحه نوشته ها و برگه ها",
                'desc'  => "برای تنظیمات سایدبار اختصاصی برای هر برگه یا نوشته ایجاد شده در صفحه مربوطه از باکس تنظیمات نمایش استفاده شود"
        ),
		
		
		//**************************************************************************رنگ ها		
			array(
                'id'       => 'section-color-site',
                'type'     => 'section',
                'title'    => "تنظیمات رنگ سایت",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),

			array(
                'id'       => 'base-color',
                'type'     => 'color',
                'title'    => "رنگ پایه وب سایت",
				'transparent' => true,
				'subtitle' => "",
                'desc'     => "Default is : #ef8e13",
                'default'  => '#ef8e13',
            ),
			array(
                'id'       => 'base-blue',
                'type'     => 'color',
                'title'    => "رنگ پایه دوم",
				'transparent' => true,
				'subtitle' => "",
                'desc'     => "Default is : #0c2444",
                'default'  => '#0c2444',
            ),
			
			array(
                'id'       => 'base-gray',
                'type'     => 'color',
                'title'    => "رنگ پایه خاکستری",
				'transparent' => true,
				'subtitle' => "",
                'desc'     => "Default is : #f5f5f5",
                'default'  => '#f5f5f5',
            ),
		
		array(
                'id'       => 'text-color',
                'type'     => 'color',
                'title'    => "رنگ متن سایت",
				'transparent' => true,
				'subtitle' => "",
                'desc'     => "Default is : #636363",
                'default'  => '#636363',
            ),
		
		
		) /*For All field*/
    ) );

//Line Joda
Redux::setSection( $opt_name, array('id'   => 'presentation-divide-sample4','type' => 'divide',) );



		Redux::setSection( $opt_name, array(
        'title' => __( 'اطلاع رسانی', 'redux-framework-demo' ),
        'id'    => 'Topbar',
        'desc'  => "",
        'icon'  => 'el el-asterisk',
		'fields'  => array(
        
//********************************************************************راست تاپ بار
	
		array(
                'id'       => 'section-ticker-site',
                'type'     => 'section',
                'title'    => "تنظیمات بخش اطلاع رسانی",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

		
			array(
				'id'       => 'title-ticker',
				'type'     => 'text',
				'title'    => "عنوان بخش",
				'subtitle' => "",
				'validate' => '',
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => 'برگزیده ها : '
			),
			
			array(
                'id'       => 'ticker-number-show',
                'type'     => 'select',
                'title'    => "تعداد مطالب در اطلاع رسانی",
                'subtitle' => "تعیین تعداد مطالبی که در بخش اطلاع رسانی اسلاید می شود",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'options'  => array(
                    '1' => 1,
                    '3' => 3,
                    '5' => 5,
                    '7' => 7,
                    '10' => 10
                ),
                'default'  => '3'
            ),
			
			array(
				'id' => 'ticker-help',
                'type'   => 'info',
				'style' => 'success',
                'notice' => false,
                'desc' => "جهت نمایش مطلب در بخش اطلاع رسانی کافیست در زمان انتشار تیک گزینه نمایش در بخش آخرین اخبار را برای مطلب مورد نظر فعال کنید",
            )
		
			
		) /*For All field*/
    ) );



	
//***************************************************************شبکه های اجتماعی
	Redux::setSection( $opt_name, array(
        'title' => __( 'شبکه های اجتماعی', 'redux-framework-demo' ),
        'id'    => 'social-site',
        'desc'  => "شبکه های اجتماعی",
        'icon'  => 'el el-twitter',
		'fields'  => array(

		
		array(
                'id'       => 'section-top-bar-left-social',
                'type'     => 'section',
                'title'    => "شبکه های اجتماعی",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
		

		array(
				'id'       => 'rss-link',
				'type'     => 'text',
				'title'    => "آدرس خبرخوان",
				'subtitle' => "",
				'desc'     => "بطور مثال : http://yoursite.com/feed/",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
		array(
				'id' => 'social-link-help',
                'type'   => 'info',
                'notice' => false,
                'style'  => '',
                'icon'   => 'el el-info-circle',
                'desc' => "خالی گزاشتن هر فیلد به منزله ی عدم نمایش آن است",
         ),
		 
		 array(
				'id'       => 'googleplus-link',
				'type'     => 'text',
				'title'    => "گوگل پلاس",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
		
		array(
				'id'       => 'facebook-link',
				'type'     => 'text',
				'title'    => "فیس بوک",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		

		array(
				'id'       => 'twitter-link',
				'type'     => 'text',
				'title'    => "توئیتر",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
				
		array(
				'id'       => 'instagram-link',
				'type'     => 'text',
				'title'    => "اینستاگرام",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
		array(
				'id'       => 'telegram-link',
				'type'     => 'text',
				'title'    => "تلگرام",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
	
		
	/*	array(
				'id'       => 'sitemap-link',
				'type'     => 'text',
				'title'    => "نقشه سایت",
				'subtitle' => "",
				'desc'     => "بطور مثال : http://yoursite.com/sitemap.xml",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),*/
		

		) /*For All field*/
    ) );

		
	
		Redux::setSection( $opt_name, array(
        'title' => __( 'تنظیمات هدر سایت', 'redux-framework-demo' ),
        'id'    => 'header-site',
        'desc'  => "تنظیمات سربرگ وب سایت",
        'icon'  => 'el el-puzzle',
		'fields'  => array(
		
//***************************************************************لوگوی سایت

	array(
				'id'       => 'h1-description',
				'type'     => 'text',
				'title'    => "توضیح h1 صفحه اصلی",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => get_bloginfo('name')
			),
			
			
			array(
					'id'       => 'logo-right',
					'type'     => 'media', 
					'url'      => true,
					'title'    => "لوگوی سایت",
					'desc'     => "Format  .png | 193*81 pixel<br>",
					'subtitle' => "لوگوی وب سایت",
					'default'  => array(
						'url'=> get_bloginfo('template_directory').'/images/logo.png'
					)
			),
			
			array(
				'id'       => 'logo-description',
				'type'     => 'text',
				'title'    => "پیام لوگوی وب سایت",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => get_bloginfo('name')
			),
			
			
//***************************************************************منوی اصلی سایت
		array(
                'id'       => 'section-menu-site',
                'type'     => 'section',
                'title'    => "منوی سایت",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),

		
			array(
                'id'       => 'main-menu-id',
                'type'     => 'select',
                'data'     => 'menus',
                'title'    => "انتخاب منو هدر سایت",
                'subtitle' => "",
                'desc'     => "از لیست هایی که در بخش فهرست ایجاد نموده اید یک مورد را جهت نمایش در هدر سایت انتخاب کنید"
            ),
			
			
			
			array(
                'id'       => 'section-menu-sitfdfe',
                'type'     => 'section',
                'title'    => "آیکون ها",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
		
		array(
				'id'       => 'topicon1',
				'type'     => 'text',
				'title'    => "نام آیکون"." 1",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => 'fa-rss'
		),
		
			array(
				'id' => 'home-page-hehglp',
                'type'   => 'info',
				'style' => 'warning',
                'notice' => false,
                'desc' => "لیست کامل آیکون ها در این 
				<a style='text-decoration:none;' href='http://fontawesome.io/cheatsheet/' target='_blank'>
				صفحه
				</a>
				قابل نمایش است
				",
         ),
			
		array(
				'id'       => 'topiconlink1',
				'type'     => 'text',
				'title'    => "لینک آیکون"." 1",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => get_bloginfo('url').'/feed'
		),	
		
		array(
				'id'       => 'topseo1',
				'type'     => 'text',
				'title'    => "عنوان سئو"." 1",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => 'خبرخوان'
		),
			
		array(
				'id'       => 'topicon2',
				'type'     => 'text',
				'title'    => "نام آیکون"." 2",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => 'fa-google-plus'
		),
			
		array(
				'id'       => 'topiconlink2',
				'type'     => 'text',
				'title'    => "لینک آیکون"." 2",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => '#'
		),		
		
		array(
				'id'       => 'topseo2',
				'type'     => 'text',
				'title'    => "عنوان سئو"." 2",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => 'گوگل پلاس'
		),
		
		array(
				'id'       => 'topicon3',
				'type'     => 'text',
				'title'    => "نام آیکون"." 3",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => 'fa-twitter'
		),
			
		array(
				'id'       => 'topiconlink3',
				'type'     => 'text',
				'title'    => "لینک آیکون"." 3",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => '#'
		),	
		
		array(
				'id'       => 'topseo3',
				'type'     => 'text',
				'title'    => "عنوان سئو"." 3",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => 'توئیتر'
		),
		
			array(
				'id'       => 'topicon4',
				'type'     => 'text',
				'title'    => "نام آیکون"." 4",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => 'fa-facebook'
		),
			
		array(
				'id'       => 'topiconlink4',
				'type'     => 'text',
				'title'    => "لینک آیکون"." 4",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => '#'
		),	
		
		
		array(
				'id'       => 'topseo4',
				'type'     => 'text',
				'title'    => "عنوان سئو"." 4",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => 'فیس بوک'
		),
		
			
		) /*For All field*/
    ) );
	
	
	
	
//***************************************************************فوتر سایت
Redux::setSection( $opt_name, array(
        'title' => __( 'تنظیمات فوتر سایت', 'redux-framework-demo' ),
        'id'    => 'Footer-site',
        'desc'  => "",
        'icon'  => 'el el-braille',
		'fields'  => array(
		
		
		
		array(
                'id'       => 'menu-footer-site-select',
                'type'     => 'select',
                'data'     => 'menus',
                'title'    => "انتخاب منو فوتر سایت",
                'subtitle' => "",
                'desc'     => "از لیست هایی که در بخش فهرست ایجاد نموده اید یک مورد را جهت نمایش در فوتر سایت انتخاب کنید"
            ),
		
		
			
			
				array(
				'id'       => 'footer-copyright',
				'type'     => 'text',
				'title'    => "متن کپی رایت",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => '',
				'default'  => 'تمامی حقوق مادی و معنوی این وب سایت محفوظ است'
			),
			
			

			
			
			
		) /*For All field*/
    ) );
	

Redux::setSection( $opt_name, array('id'   => 'presentation-divide-sample7xs','type' => 'divide',) );


/*******************************************************صفحه تماس با ما'*/
Redux::setSection( $opt_name, array(
        'title' => __( 'بخش ارتبا با ما', 'redux-framework-demo' ),
        'id'    => 'contact-site',
        'desc'  => "",
        'icon'  => 'el el-phone',
		'fields'  => array(
		
		array(
				'id'       => 'title-contact',
				'type'     => 'text',
				'title'    => "عنوان بخش",
				'class' => 'rtl-input',
				'validate' => 'not_empty',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'تماس با ما'
		),
		
		array(
				'id' => 'social-link-2323help',
                'type'   => 'info',
                'notice' => false,
                'style'  => '',
                'icon'   => 'el el-info-circle',
                'desc' => "خالی گزاشتن هر فیلد به منزله ی عدم نمایش آن است",
         ),
		
		
		array(
				'id'       => 'site-co',
				'type'     => 'text',
				'title'    => "نام مدیریت",
				//'validate' => 'not_empty',
				//'msg'      => 'فیلد خالی را پر کنید',
				'class' => 'rtl-input',
				'default'  => ''
		),
		
		/*array(
				'id'       => 'address-co',
				'type'     => 'text',
				'title'    => "آدرس",
				//'validate' => 'not_empty',
				//'msg'      => 'فیلد خالی را پر کنید',
				'class' => 'rtl-input',
				'default'  => 'ایران'
		),*/
		
		array(
				'id'       => 'tel-co',
				'type'     => 'text',
				'title'    => "تلفن تماس",
				'class' => 'ltr-input',
				//'validate' => 'not_empty',
				//'msg'      => 'فیلد خالی را پر کنید',
				'default'  => '011xxxxx'
		),
		
		/*array(
				'id'       => 'fax-co',
				'type'     => 'text',
				'title'    => "فکس",
				'class' => 'ltr-input',
				//'validate' => 'not_empty',
				//'msg'      => 'فیلد خالی را پر کنید',
				'default'  => '011xxxxxx'
		),*/
		
		array(
				'id'       => 'email-co',
				'type'     => 'text',
				'title'    => "پست الکترونیک",
				'class' => 'ltr-input',
				//'validate' => 'not_empty',
				//'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'Email@site.com'
		),
		
		array(
                'id'       => 'link-contact-us-page',
                'type'     => 'select',
                'data'     => 'page',
                'title'    => "انتخاب برگه تماس با ما",
                'subtitle' => "",
                'desc'     => ""
        ),
		
		array(
				'id'       => 'contact-7-shortcode',
				'type'     => 'text',
				'title'    => "شورت کد فرم تماس با ما",
				'class' => 'ltr-input',
				'validate' => 'not_empty',
				'desc' => '<span dir="ltr">Example : [contact-form-7 id="353" title="form"]</span>' ,
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => ''
		),
		
		array(
				'id'       => 'allow-page-contact-7',
				'type'     => 'text',
				'title'    => "برگه های حاوی فرم پلاگین Contact 7",
				'subtitle' => "لیست آی دی صفحاتی که در آن از فرم ساز contact 7 استفاده شده است وارد نمائید",
				'desc'  => "آی دی برگه ها را بدون فاصله با کاما جدا شوند مثلا : 4,25",
				'class' => 'ltr-input',
				'default'  => ''
		),
		
	/*	array(
                'id'       => 'allow-googla-map',
                'type'     => 'button_set',
                'title'    => "فعال سازی نقشه گوگل",
                'subtitle' => "",
                'desc'     => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیرفعال',
                ),
                'default'  => '2'
            ),
			
		array(
                'id'     => 'social-section-google',
                'type'   => 'info',
                'notice' => false,
                'style'  => '',
                'icon'   => 'el el-info-circle',
               'title' => "نمایش در نقشه گوگل",
                'desc'  => "جهت دریافت مشخصات نقشه میتوانید از <a href='http://www.latlong.net/' style='text-decoration:none;' target='_blank'>این وب سایت</a> استفاده نمایید"
        ),
		
		array(
				'id'       => 'google-lat',
				'type'     => 'text',
				'title'    => "Lat",
				'class' => 'ltr-input',
				'default'  => ''
		),
		
		array(
				'id'       => 'google-lng',
				'type'     => 'text',
				'title'    => "Long",
				'class' => 'ltr-input',
				'default'  => ''
		),
		
		array(
				'id'       => 'google-map-title',
				'type'     => 'text',
				'title'    => "عنوان نشانه گوگل",
				'class' => 'rtl-input',
				'default'  => 'عنوان مکان یا نام دفتر'
		),*/
		
		
		
		
				
		array(
                'id'       => 'section-contact-left-social',
                'type'     => 'section',
                'title'    => "شبکه های اجتماعی",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
		

		array(
				'id'       => 'co-rss-link',
				'type'     => 'text',
				'title'    => "آدرس خبرخوان",
				'subtitle' => "",
				'desc'     => "بطور مثال : http://yoursite.com/feed/",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
		array(
				'id' => 'co-social-link-help',
                'type'   => 'info',
                'notice' => false,
                'style'  => '',
                'icon'   => 'el el-info-circle',
                'desc' => "خالی گزاشتن هر فیلد به منزله ی عدم نمایش آن است",
         ),
		 
		 array(
				'id'       => 'co-googleplus-link',
				'type'     => 'text',
				'title'    => "گوگل پلاس",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
		
		array(
				'id'       => 'co-facebook-link',
				'type'     => 'text',
				'title'    => "فیس بوک",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		

		array(
				'id'       => 'co-twitter-link',
				'type'     => 'text',
				'title'    => "توئیتر",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
				
		array(
				'id'       => 'co-instagram-link',
				'type'     => 'text',
				'title'    => "اینستاگرام",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
		array(
				'id'       => 'co-telegram-link',
				'type'     => 'text',
				'title'    => "تلگرام",
				'subtitle' => "",
				'desc'     => "",
				'class' => 'ltr-input',
				'msg'      => '',
				'default'  => ''
		),
		
		
		
		
		
		)
) );



//***************************************************************کمپوننت صفحه اصلی
Redux::setSection( $opt_name, array(
        'title' => __( 'صفحه اصلی', 'redux-framework-demo' ),
        'id'    => 'component-slidefgdgnashxx-base-site',
        'desc'  => "",
        'icon'  => 'el el-stackoverflow',
		'fields'  => array(
		
		array(
                'id'       => 'sectiodn-sherfdatha-site',
                'type'     => 'section',
                'title'    => "تب های صفحه اصلی",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),	
		
		
		array(
                'id'            => 'number-horizental-special-tab',
                'type'          => 'slider',
                'title'         => "تعداد تب در Horizental Special Tab",
                'subtitle'      => "",
                'desc'          => "",
                'default'       => 1,
                'min'           => 1,
                'step'          => 1,
                'max'           => 5,
                'display_value' => 'text'
          ),
		
		array(
				'id'       => 'vtab-title-1',
				'type'     => 'text',
				'title'    => "عنوان تب "."1",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'عنوان فیلد',
				'required' => array( 'number-horizental-special-tab', '>=', 1 )
			),
			
		array(
                'id'      => 'vtab-text-1',
                'type'    => 'editor',
                'title'   => "محتویات تب "."1",
                'default' => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 10,
                    'teeny'         => false,
                    'quicktags'     => false,
                ),
				'required' => array( 'number-horizental-special-tab', '>=', 1 )
            ),
			
			array(
				'id'       => 'vtab-title-2',
				'type'     => 'text',
				'title'    => "عنوان تب "."2",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'عنوان فیلد',
				'required' => array( 'number-horizental-special-tab', '>=', 2 )
			),
			
			array(
                'id'      => 'vtab-text-2',
                'type'    => 'editor',
                'title'   => "محتویات تب "."2",
                'default' => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 10,
                    'teeny'         => false,
                    'quicktags'     => false,
                ),
				'required' => array( 'number-horizental-special-tab', '>=', 2 )
            ),
			
			array(
				'id'       => 'vtab-title-3',
				'type'     => 'text',
				'title'    => "عنوان تب "."3",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'عنوان فیلد',
				'required' => array( 'number-horizental-special-tab', '>=', 3 )
			),
			
			array(
                'id'      => 'vtab-text-3',
                'type'    => 'editor',
                'title'   => "محتویات تب "."3",
                'default' => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 10,
                    'teeny'         => false,
                    'quicktags'     => false,
                ),
				'required' => array( 'number-horizental-special-tab', '>=', 3 )
            ),
			
			
			array(
				'id'       => 'vtab-title-4',
				'type'     => 'text',
				'title'    => "عنوان تب "."4",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'عنوان فیلد',
				'required' => array( 'number-horizental-special-tab', '>=', 4 )
			),
			array(
                'id'      => 'vtab-text-4',
                'type'    => 'editor',
                'title'   => "محتویات تب "."4",
                'default' => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 10,
                    'teeny'         => false,
                    'quicktags'     => false,
                ),
				'required' => array( 'number-horizental-special-tab', '>=', 4 )
            ),
			
			
			array(
				'id'       => 'vtab-title-5',
				'type'     => 'text',
				'title'    => "عنوان تب "."5",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'عنوان فیلد',
				'required' => array( 'number-horizental-special-tab', '>=', 5 )
			),
			array(
                'id'      => 'vtab-text-5',
                'type'    => 'editor',
                'title'   => "محتویات تب "."5",
                'default' => '',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 10,
                    'teeny'         => false,
                    'quicktags'     => false,
                ),
				'required' => array( 'number-horizental-special-tab', '>=', 5 )
            ),
			
			
		array(
                'id'       => 'srrteection-sherfdatha-site',
                'type'     => 'section',
                'title'    => "خدمات ما",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),	
			
		array(
				'id' => 'homfdsf',
                'type'   => 'info',
				'style' => 'success',
                'notice' => false,
                'desc' => "Use shortcode [khadamat] in Your Editor. | image size 130*130",
         ),
		 
		 
		 array(
				'id'          => 'slideshow-khadamat',
				'type'        => 'slides',
				'title'       => "لیست خدمات",
				'subtitle'    => "",
				'desc'        => "",
				'show' => array(
				'title' => true,
				'description' => true,
				'url' => true,
				),
				'placeholder' => array(
					'title'           => "عنوان",
					'description'     => "توضیحات",
					'url'             => "Ex : http://www.google.com",
				)
			),
		array(
                'id'       => 'section-sherfdatha-site',
                'type'     => 'section',
                'title'    => "پادکست",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),	
		  
		  array(
				'id'       => 'title-padcast-site',
				'type'     => 'text',
				'title'    => "عنوان بخش",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'پادکست ها'
			),
			
			array(
                'id'       => 'number-padcast-show',
                'type'     => 'spinner',
                'title'    => "تعداد مطالب قابل نمایش",
                'subtitle' => "",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'default' => '4',
                'min'     => '4',
                'step'    => '1',
                'max'     => '12'
            ),
			
	array(
                'id'       => 'padcast-cat',
                'type'     => 'select',
                'data'     => 'category',
                'title'    => "انتخاب دسته پادکست",
        ),
		
		
		
		array(
                'id'       => 'section-sherfdfsdfsdffdatha-site',
                'type'     => 'section',
                'title'    => "وبلاگ",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),	
		  
		  array(
				'id'       => 'title-blog-site',
				'type'     => 'text',
				'title'    => "عنوان بخش",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'وبلاگ'
			),
			
		array(
                'id'       => 'blog-cat',
                'type'     => 'select',
                'data'     => 'category',
                'title'    => "انتخاب دسته بلاگ",
        ),
		
		
		 array(
				'id'       => 'ch-blog-title',
				'type'     => 'text',
				'title'    => "محدودیت تعداد کاراکتر وبلاگ",
				'validate' => '',
				'class' => 'ltr-input',
				//'msg'      => 'فیلد خالی را پر کنید',
				'default'  => '62'
			),
		
		
		
		array(
                'id'       => 'sectiodfd-site',
                'type'     => 'section',
                'title'    => "فروشگاه",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),	
		  
		  array(
				'id'       => 'title-shop-site',
				'type'     => 'text',
				'title'    => "عنوان بخش",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'فروشگاه'
			),
			
		array(
                'id'       => 'shop-cat',
                'type'     => 'select',
                'data'     => 'category',
                'title'    => "انتخاب دسته بلاگ",
        ),
		
		
		 array(
				'id'       => 'ch-sho-title',
				'type'     => 'text',
				'title'    => "محدودیت کاراکتر عنوان",
				'validate' => '',
				'class' => 'ltr-input',
				//'msg'      => 'فیلد خالی را پر کنید',
				'default'  => '48'
			),
		
		
		array(
                'id'       => 'number-shop-show',
                'type'     => 'spinner',
                'title'    => "تعداد مطالب قابل نمایش",
                'subtitle' => "",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'default' => '4',
                'min'     => '4',
                'step'    => '1',
                'max'     => '12'
            ),
		

			

		) /*For All field*/
 ) );

 
 
 //***************************************************************کمپوننت صفحه اصلی
Redux::setSection( $opt_name, array(
        'title' => __( 'فروشگاه کاربران', 'redux-framework-demo' ),
        'id'    => 'componehjse-site',
        'desc'  => "",
        'icon'  => 'el el-user',
		'fields'  => array(
		
		array(
				'id'       => 'zarinpal-id',
				'type'     => 'text',
				'title'    => "کد مرچنت زرین پال",
				'class' => 'ltr-input',
				'validate' => 'not_empty',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'XXXXXXXXXXXX'
		),

		
		array(
				'id'       => 'year1-pol',
				'type'     => 'text',
				'title'    => "هزینه اشتراک ماهیانه",
				'desc'    => "مبلغ به تومان وارد شود",
				'class' => 'ltr-input',
				'validate' => 'not_empty',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => '100'
		),
		
		array(
                'id'       => 'link-low-page',
                'type'     => 'select',
                'data'     => 'page',
                'title'    => "برگه قوانین سایت",
                'subtitle' => "",
                'desc'     => ""
        ),
		
		array(
                'id'       => 'link-soal-page',
                'type'     => 'select',
                'data'     => 'page',
                'title'    => "برگه سوالات متداول",
                'subtitle' => "",
                'desc'     => ""
        ),

		  
		  array(
				'id'       => 'add-to-c',
				'type'     => 'text',
				'title'    => "دکمه افزودن",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'افزودن به سبد خرید'
			),
			
array(
				'id'       => 'add-d1',
				'type'     => 'text',
				'title'    => "عنوان کتابچه",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'کتابچه PDF'
			),
			
			array(
				'id'       => 'add-d2',
				'type'     => 'text',
				'title'    => "عنوان صدا",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'پادکست صوتی'
			),
			
			
			array(
				'id'       => 'add-d3',
				'type'     => 'text',
				'title'    => "ویدئو",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'ویدئو آموزشی'
			),
			
		
			array(
				'id'       => 'add-d-worksheet',
				'type'     => 'text',
				'title'    => "عنوان تمرین",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'تمرینات آموزشی'
			),

			array(
				'id'       => 'add-d-worksheet-text',
				'type'     => 'textarea',
				'title'    => "متن تمرین",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'این محصول دارای تمرینات آموزشی حاوی یک WorkSheet به فرمت PDF یا بصورت چاپی می باشد'
			),
			
			array(
				'id'       => 'send-post-j',
				'type'     => 'textarea',
				'title'    => "متن تکمیل اطلاعات",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'توجه : کاربر گرامی در صورتی که اطلاعات پستی خود را وارد ننموده اید با کلیک روی این گزینه اطلاعات تماس خود را جهت ارائه پشتیبانی و ارسال مرسوله وارد نمائید'
			),
			
			
			array(
				'id'       => 'send-cart-j',
				'type'     => 'textarea',
				'title'    => "متن کارت به کارت",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'در صورت پرداخت وجه ،  به صورت کارت به کارت یا واریز به حساب میتوانید اطلاعات حساب بانکی را در این صفحه دریافت نموده و پس از واریز وجه ، ما را از طریق تماس تلفنی مطلع سازید'
			),
			
			
			array(
				'id'       => 'vip-error',
				'type'     => 'textarea',
				'title'    => "متن عدم دسترسی اعضا ویژه",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'کاربر گرامی این قسمت تنها برای اعضای ویژه قابل دسترس می باشد ، جهت نمایش لطفا در سایت عضو شوید'
			),
			
			array(
				'id'       => 'mailmarket',
				'type'     => 'textarea',
				'title'    => "متن پیشفرض دریافت اطلاعات از ایمیل مارکتینگ",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'کاربر گرامی جهت دانلود فایل ، پست الکترونیک خود را وارد نمائید'
			),
			

		) /*For All field*/
 ) );

 
 
 
 
 

//***************************************************************شرکت های فعال
Redux::setSection( $opt_name, array(
        'title' => __( 'همکاران ما', 'redux-framework-demo' ),
        'id'    => 'component-slidenashxx-base-site',
        'desc'  => "",
        'icon'  => 'el el-view-mode',
		'fields'  => array(
		
		array(
                'id'       => 'section-sherkatha-site',
                'type'     => 'section',
                'title'    => "همکاران ما",
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),	
		  
		  array(
				'id'       => 'title-hamian-site',
				'type'     => 'text',
				'title'    => "عنوان بخش",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => 'همکاران ما'
			),
			
			 
	/*		array(
				'id'       => 'time-slideshow-hamian',
				'type'     => 'text',
				'title'    => "مدت زمان نمایش",
				'desc'     => "مدت زمان تاخیر نمایش هر اسلاید به میلی ثانیه",
				'validate' => 'not_empty',
				'class' => 'ltr-input',
				'msg'      => 'فیلد خالی را پر کنید',
				'default'  => '4000'
		),*/
		
		array(
				'id'          => 'slideshow-hamian',
				'type'        => 'slides',
				'title'       => "لیست لوگوی شرکت ها",
				'subtitle'    => "",
				'desc'        => "",
				'show' => array(
				'title' => true,
				'description' => false,
				'url' => true,
				),
				'placeholder' => array(
					'title'           => "تیتر عکس",
					'description'     => "توضیح عکس جهت سئو تصویر",
					'url'             => "Ex : http://www.google.com",
				),
			),
			
			array(
                'id'       => 'number-mobile-hamian',
                'type'     => 'spinner',
                'title'    => "نمایش تعداد لوگوها در حالت ریسپانسیو",
                'subtitle' => "",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'default' => '4',
                'min'     => '4',
                'step'    => '4',
                'max'     => '12'
            )

		) /*For All field*/
 ) );









Redux::setSection( $opt_name, array('id'   => 'presentation-divide-sample7','type' => 'divide',) );	
	


 /*******************************************************استایل'*/
Redux::setSection( $opt_name, array(
        'title' => "استایل اختصاصی",
        'id'    => 'editor-Css-javascript',
        'icon'  => 'el el-edit',
		 'fields'     => array(
		 
		 	array(
                'id'       => 'allow-css-site',
                'type'     => 'button_set',
                'title'    => "فعال سازی Css",
                'subtitle' => "نمایش سی اس اس اختصاصی شما",
                'desc'     => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیرفعال',
                ),
                'default'  => '2'
            ),
		 
            array(
                'id'       => 'css-site',
                'type'     => 'ace_editor',
                'title'    => "استایل اختصاصی",
                'subtitle' => "متن استایل را وارد نمائید",
                'mode'     => 'css',
                'theme'    => 'monokai',
                'desc'     => '',
                'default'  => "#header{\n   margin: 0 auto;\n}"
            ),
			
			array(
                'id'       => 'allow-java-site',
                'type'     => 'button_set',
                'title'    => "فعال سازی java",
                'subtitle' => "نمایش کد جی کوئری / جاوا اختصاصی شما",
                'desc'     => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیرفعال',
                ),
                'default'  => '2'
            ),
			
			
            array(
                'id'       => 'java-site',
                'type'     => 'ace_editor',
                'title'    => "جاوا اختصاصی",
                'subtitle' => "متن جاوا اختصاصی شما",
                'mode'     => 'javascript',
                'theme'    => 'chrome',
                'desc'     => '',
                'default'  => "(function( $ ) {\n\n})( jQuery );"
            ),
           


        )
		
    ) );
	
	
	    Redux::setSection( $opt_name, array(
        'title' => "تنظیمات صفحه 404",
        'id'    => 'page-404',
        'icon'  => 'el el-warning-sign',
		 'fields'     => array(

			array(
                'id'       => 'allow-404',
                'type'     => 'button_set',
                'title'    => "عملکرد صفحه 404",
                'subtitle' => "",
                'desc'     => "مشخص کنید در مواقع ایجاد صفحه 404 وب سایت چگونه عمل کند",
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'نمایش صفحه 404',
                    '2' => 'انتقال کاربر به صفحه اصلی',
                ),
                'default'  => '1'
            ),
			
			array(
				'id'       => 'title-404',
				'type'     => 'text',
				'title'    => "عنوان صفحه 404",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'یافت نشد !'
			),
			
			
			
			array(
                'id'      => 'text-404',
                'type'    => 'editor',
                'title'   => "محتوای صفحه 404",
				'subtitle' => "",
                'default' => '<p style="text-align:center; padding:40px 0px;"><img src="'.get_bloginfo('template_directory').'/include/404.png" alt="404 Not Found"></p>',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 15,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => false,
                )
            ),
			
			

        )
		
    ) );
	
	
	
Redux::setSection( $opt_name, array(
        'title' => __( 'صفحه نوشته ها', 'redux-framework-demo' ),
        'id'    => 'singlepage-site',
        'desc'  => "",
        'icon'  => 'el el-screen',
		'fields'  => array(
		
		/*array(
                'id'       => 'breadcrumbs-net-view',
                'type'     => 'section',
                'title'    => 'تنظیمات Breadcrumbs',
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		
		array(
                'id'       => 'allow-breadcrumbs',
                'type'     => 'button_set',
                'title'    => "نمایش Breadcrumbs",
                'subtitle' => "نمایش مسیر ارجاع کاربر در داخل سایت",
                'desc'     => "",
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیر فعال',
                ),
                'default'  => '1'
         ),*/
		
		array(
				'id'       => 'title-home-breadcrumbs',
				'type'     => 'text',
				'title'    => "عنوان مبدا",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'خانه'
		),
		
		/*array(
                'id'       => 'social-net-view',
                'type'     => 'section',
                'title'    => 'محتوای قابل نمایش',
                'subtitle' => "مشخص کنید در صفحه نوشته چه مواردی به نمایش در بیاید",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		
		array(
				'id'       => 'signle-check',
				'type'     => 'checkbox',
				'title'    => "انتخاب موارد", 
				'subtitle' => "",
				'desc'     => "",
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => 'لیدر خبر',
					//'2' => 'محتوای مختصر',
					'3' => 'شناسه خبر',
					'4' => 'تاریخ انتشار',
					'5' => 'دسته مطلب',
					'6' => 'نویسنده مطلب',
					'7' => 'برچسب ها',
					'8' => 'تعداد بازدید',
				),
				//See how default has changed? you also don't need to specify opts that are 0.
				'default' => array(
					'1' => '1',
					//'2' => '1',
					'3' => '1',
					'4' => '1',
					'5' => '1',
					'6' => '0',
					'7' => '1',
					'8' => '0'
				)
		),*/

		array(
				'id'       => 'title-tag-single',
				'type'     => 'text',
				'title'    => "عنوان بلاک برچسب ها",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'برچسب ها'
			),


	/*	array(
                'id'       => 'social-net',
                'type'     => 'section',
                'title'    => 'شبکه های اجتماعی',
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
			
		array(
                'id'       => 'allow-social',
                'type'     => 'button_set',
                'title'    => "فعال سازی دکمه اشتراگ",
                'subtitle' => "",
                'desc'     => "دکمه ی اشتراگ گذاری مطلب در شبکه های اجتماعی",
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیر فعال',
                ),
                'default'  => '2'
            ),*/
			
			/*array(
			//	'id'       => 'title-social',
			//	'type'     => 'text',
			//	'title'    => "عنوان باکس شبکه های اجتماعی",
			//	'subtitle' => "",
			///	'class' => 'rtl-input',
			//	'validate' => 'not_empty',
			//	'msg'      => 'فیلدرا پر کنید',
				'default'  => 'اشتراک گذاری مطلب',
				'required' => array( 'allow-social', '=', 1 )
			),
			
			 array(
                'id'       => 'select-social',
                'type'     => 'button_set',
                'title'    => "انتخاب شبکه اجتماعی",
                'subtitle' => "کدام شبکه های اجتماعی به نمایش در آید",
                'desc'     => "",
                'multi'    => true,
                'options'  => array(
                    '1' => 'فیس بوک',
                    '2' => 'توئیتر',
                    '3' => 'گوگل پلاس',
                    '4' => 'لینکدین'
                ),
                'default'  => array( '1', '2', '3' ),
				'required' => array( 'allow-social', '=', 1 )
            ),*/
			
			
		array(
                'id'       => 'help-publicated-in-category',
                'type'     => 'section',
                'title'    => 'بخش مطالب مشابه',
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
		
		/*	array(
                'id'       => 'allow-other-in-category',
                'type'     => 'button_set',
                'title'    => "مطالب مشابه",
                'subtitle' => "نمایش مطالب مرتبط با موضوع",
                'desc'     => "",
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیر فعال',
                ),
                'default'  => '1'
            ),*/
			
			array(
				'id'       => 'other-in-category-title',
				'type'     => 'text',
				'title'    => "عنوان باکس",
				'subtitle' => "",
				'class' => 'rtl-input',
				'validate' => 'not_empty',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'در همین زمینه میخوانید ...'
			),
			
			
			/*array(
                'id'       => 'other-in-category-template',
                'type'     => 'button_set',
                'title'    => "نحوه ی نمایش لیست مطالب",
                'subtitle' => "",
                'desc'     => "",
                'options'  => array(
                    '1' => 'لیست آخرین عناوین',
                    '2' => 'عناوین به همراه تصاویر شاخص',
                ),
                'default'  => '1'
            ),*/
			
			
		array(
                'id'       => 'number-related-in-category',
                'type'     => 'spinner',
                'title'    => "تعداد مطالب قابل نمایش در این بخش",
                'subtitle' => "تعداد مطالبی که به عنوان مطالب مشابه معرفی می شوند",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'default' => '6',
                'min'     => '1',
                'step'    => '1',
                'max'     => '15',
				'required' => array( 'other-in-category-template', '=', 1 )
            ),

			
		/*array(
                'id'       => 'option-comment-net',
                'type'     => 'section',
                'title'    => 'بخش نظرات سایت',
                'subtitle' => "",
                'indent'   => true, // Indent all options below until the next 'section' option is set.
		),
			
		array(
                'id'       => 'allow-comment',
                'type'     => 'button_set',
                'title'    => "نظرات کاربران",
                'subtitle' => "نمایش ارسال دیدگاه",
                'desc'     => "این گزینه برای نمایش نظرات در تمامی مطالب وب سایت می باشد",
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیر فعال',
                ),
                'default'  => '1'
            ),
			
			array(
                'id'       => 'comment-template-site',
                'type'     => 'button_set',
                'title'    => "انتخاب قالب نظرات",
                'subtitle' => "",
                'desc'     => "",
                'options'  => array(
                    '1' => 'Responsive',
                    '2' => 'Boxing',
                ),
                'default'  => '1'
            ),
			
			array(
				'id'       => 'comment-title',
				'type'     => 'text',
				'title'    => "عنوان باکس",
				'subtitle' => "",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'ارسال دیدگاه'
			),
			
			array(
				'id'       => 'comment-date-format',
				'type'     => 'text',
				'title'    => "فرمت نمایش تاریخ",
				'subtitle' => "طریقه نمایش تاریخ نظر",
				'desc'     => "<a style='text-decoration:none;' target='_Blank' href='https://codex.wordpress.org/Formatting_Date_and_Time'>راهنمای مستندات تاریخ</a>",
				'validate' => 'not_empty',
				'class' => 'ltr-input',
				'msg'      => 'فرمت تاریخ را وارد نمائید',
				'default'  => 'l j F Y'
			)*/

		) /*For All field*/
    ) );

	
	
	    Redux::setSection( $opt_name, array(
        'title' => "نتایج و آرشیو اطلاعات",
        'id'    => 'search-archive-page',
        'icon'  => 'el el-search',
		'fields'     => array(

		
		array(
                'id'       => 'allow-wp-navi',
                'type'     => 'button_set',
                'title'    => "فعال سازی Page Navi",
                'subtitle' => "نمایش لیست صفحات دیگر در سایت",
                'desc'     => "",
                'options'  => array(
                    '1' => 'فعال',
                    '2' => 'غیر فعال',
                ),
                'default'  => '1'
        ),
		
		array(
				'id'       => 'date-format-wp-page',
				'type'     => 'text',
				'title'    => "فرمت نمایش تاریخ",
				'subtitle' => "ففرمت نمایش تاریخ در صفحات وب سایت",
				'desc'     => "<a style='text-decoration:none;' target='_Blank' href='https://codex.wordpress.org/Formatting_Date_and_Time'>راهنمای مستندات تاریخ</a>",
				'validate' => 'not_empty',
				'class' => 'ltr-input',
				'msg'      => 'فرمت تاریخ را وارد نمائید',
				'default'  => 'l j F Y'
		),
			
			
		array(
                'id'       => 'section-sokhan-in search',
                'type'     => 'section',
                'title'    => "صفحه جستجوی وب سایت",
                'subtitle' => "",
                'indent'   => true,
         ),
		 
		 array(
				'id'       => 'search-title',
				'type'     => 'text',
				'title'    => "پیشوند عنوان جستجو در سایت",
				'subtitle' => "",
				'desc'     => "این عبارت در عنوان صفحه قبل از عبارت وارد شده به نمایش در می آید به عنوان مثال - تنایج جستجو عبارت سایت",
				'validate' => 'not_empty',
				'class' => 'rtl-input',
				'msg'      => 'فیلدرا پر کنید',
				'default'  => 'نتایج جستجو عبارت'
			),
			
			
			array(
				'id'       => 'not-in-search-cat',
				'type'     => 'text',
				'title'    => "جداسازی برخی دسته ها",
				'subtitle' => "آی دی دسته هایی که نمیخواهید در صفحه جستجو باشند را وارد نمائید",
				'desc'  => "آی دی دسته ها بدون فاصله با کاما جدا شوند مثلا : 4,25",
				'class' => 'ltr-input',
				'default'  => '1'
		),

		 array(
                'id'       => 'number-search-page',
                'type'     => 'spinner',
                'title'    => "تعداد مطالب قابل نمایش",
                'subtitle' => "تعداد مطالبی که در صفحه جستجو به نمایش در می آید",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'default' => '6',
                'min'     => '1',
                'step'    => '1',
                'max'     => '25',
            ),

			array(
                'id'      => 'search-not-eror',
                'type'    => 'editor',
                'title'   => "خطای جستجو سایت",
				'subtitle' => "زمانی که نتیجه جستجو در سایت هیچ موردی در برنداشت",
                'default' => '<p style="text-align:center; padding:20px 0px;">هیچ موردی یافت نشد</p>',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 4,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => false,
                )
            ),

	array(
                'id'       => 'section-archive-pave',
                'type'     => 'section',
                'title'    => "صفحه آرشیو مطالب",
                'subtitle' => "",
                'indent'   => true,
         ),
			
				 array(
                'id'       => 'number-archive-page',
                'type'     => 'spinner',
                'title'    => "تعداد مطالب در آرشیو",
                'subtitle' => "تعداد مطالبی که در صفحه آرشیو به نمایش در می آید",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'default' => '20',
                'min'     => '1',
                'step'    => '1',
                'max'     => '25',
            ),
			
			array(
                'id'      => 'archive-not-eror',
                'type'    => 'editor',
                'title'   => "خطای آرشیو سایت",
				'subtitle' => "زمانی که صفحه آرشیو مطلبی برای ارائه نداشته باشد",
                'default' => '<p style="text-align:center; padding:20px 0px;">هیچ موردی یافت نشد</p>',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 3,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => false,
                )
            ),
			
		array(
                'id'       => 'section-category-pave',
                'type'     => 'section',
                'title'    => "صفحه نمایش دسته ها",
                'subtitle' => "",
                'indent'   => true,
         ),
			
			array(
                'id'       => 'number-category-page',
                'type'     => 'spinner',
                'title'    => "تعداد مطالب قابل نمایش هر دسته",
                'subtitle' => "تعداد مطالبی که در صفحه دسته ها برای هر موضوع به نمایش در می آید",
                'desc'     => "&nbsp;",
                //Must provide key => value pairs for select options
                'default' => '10',
                'min'     => '1',
                'step'    => '1',
                'max'     => '25',
            ),

			array(
                'id'      => 'category-not-eror',
                'type'    => 'editor',
                'title'   => "خطای صفحه دسته ها",
				'subtitle' => "زمانی که تعداد مطالب در دسته ی مربوطه برابر با صفر باشد",
                'default' => '<p style="text-align:center; padding:20px 0px;">هیچ خبری با این موضوع به ثبت نرسیده است</p>',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => true,
                    'textarea_rows' => 5,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => false,
                )
            ),
			
			

        )
		
    ) );
	
	
	
	


	Redux::setSection( $opt_name, array(
        'title' => "غیرفعال کردن سایت",
        'id'    => 'disabled-website',
        'icon'  => 'el el-wrench',
		 'fields'     => array(
		 
		 array(
                'id'     => 'disabled-site-notifice',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'warning',
                'icon'   => 'el el-info-circle',
               'title' => "غیر فعال سازی وب سایت",
                'desc'  => "در مواقع ضروری با فعال سازی این گزینه می توانید با ایجاد یک پیام اضطراری موقتا وب سایت را غیر قابل مشاهده کنید"
            ),
		 
		 
		 	array(
                'id'       => 'disable-all-site',
                'type'     => 'button_set',
                'title'    => "غیرفعال سازی وب سایت",
                'subtitle' => "",
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'بله',
                    '2' => 'خیر',
                ),
                'default'  => '2'
            ),
		 
          
		  array(
                'id'      => 'text-disabled-site',
                'type'    => 'editor',
                'title'   => "متن غیر فعال سازی سایت",
				'subtitle' => "",
                'default' => '<p style="text-align:center;">این متن حاوی پیامی است که کاربران به محض ورود دریافت خواهند کرد</p>',
                'args'    => array(
                    'wpautop'       => false,
                    //'media_buttons' => false,
                    'textarea_rows' => 9,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => false,
                )
            )



        )
		
    ) );
	
	
 

	



    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'redux-framework-demo' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content'  => file_get_contents( dirname( __FILE__ ) . '/../README.md' )
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    function compiler_action( $options, $css, $changed_values ) {
        echo '<h1>The compiler hook has run!</h1>';
        echo "<pre>";
        print_r( $changed_values ); // Values that have changed since the last save
        echo "</pre>";
        //print_r($options); //Option values
        //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    function dynamic_section( $sections ) {
        //$sections = array();
        $sections[] = array(
            'title'  => __( 'Section via hook', 'redux-framework-demo' ),
            'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
            'icon'   => 'el el-paper-clip',
            // Leave this as a blank section, no options just some intro text set above.
            'fields' => array()
        );

        return $sections;
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    function change_arguments( $args ) {
        $args['dev_mode'] = false;

        return $args;
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    function change_defaults( $defaults ) {
        $defaults['str_replace'] = 'Testing filter hook!';

        return $defaults;
    }

    // Remove the demo link and the notice of integrated demo from the redux-framework plugin
    function remove_demo() {

        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            remove_filter( 'plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2 );

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
        }
    }
