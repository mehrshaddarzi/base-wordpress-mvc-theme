<?php
namespace App\Config;

class Setup {

	public function __construct() {

	    /* theme suppport */
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );

		/* Text domain */
		//add_action( 'after_setup_theme', array( $this , 'load_text_domain' ) );

		/* Register Nav Menu */
		//add_action( 'after_setup_theme', array( $this , 'setup_menu' ) );

		/* Editor Style */
		//add_action( 'after_setup_theme', array( $this , 'editor_style' ) );

	}

	/*
	 * Language Setup
	 */
	public function load_text_domain(){
		load_theme_textdomain( 'name_text_domain', get_template_directory() . '/languages' );
    }

    /*
     * setup Menu
     */
    public function setup_menu(){
	    register_nav_menus( array(
		    'primary' => __( 'Primary Navigation', 'twentytwelve' ),
		    'Secondary' => __( 'Secondary Navigation', 'twentytwelve' ),
	    ) );
    }

    /*
     * Editor style
     */
    public function editor_style(){
	    add_editor_style( get_stylesheet_uri() );
    }


}