<?php
namespace App\Config;

class Image {

	const MAX_UPLOAD_SIZE = 5; //MB
	const jpeg_quality = 75;

	public function __construct() {

		add_action( 'after_setup_theme', array( $this, 'image_size') );
		add_filter( 'jpeg_quality', array( $this, 'filter_jpeg_quality') );
		add_filter( 'upload_size_limit', array( $this, 'filter_site_upload_size_limit'), 20 );
		add_filter( 'intermediate_image_sizes_advanced', array( $this, 'remove_default_image_sizes') );
	}

	/*
	 * image size list
	 */
	public function image_size(){
		//add_image_size( 'thumb-owl', 205, 205, true );
//	add_image_size( 'thumb-150', 150, 150, true);
//	add_image_size( 'thumb-120', 120, 120, true);
//	add_image_size( 'thumb-100', 100, 100, true );
//	add_image_size( 'thumb-250', 250, 250, true );
//   // add_image_size( 'thumb-150', 150, 150, true ); //wordpress thumbail
//   add_image_size( 'thumb-60', 60, 60, true);
//		//add_image_size( 'thumb-editor', 500, 9999, true );
//remove_image_size( 'thumb-editor');
		//remove_image_size('large');
		//remove_image_size('medium_large');
	}

	/*
	 * Remove Default Size wordpress
	 */
	public function remove_default_image_sizes( $sizes ) {

		/* Default WordPress */
		//unset( $sizes[ 'thumbnail' ]);          // Remove Thumbnail (150 x 150 hard cropped)
		unset( $sizes[ 'medium' ]);          // Remove Medium resolution (300 x 300 max height 300px)
		unset( $sizes[ 'medium_large' ]);    // Remove Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
		//unset( $sizes[ 'large' ]);           // Remove Large resolution (1024 x 1024 max height 1024px)

		/* With WooCommerce */
		unset( $sizes[ 'shop_thumbnail' ]);  // Remove Shop thumbnail (180 x 180 hard cropped)
		unset( $sizes[ 'shop_catalog' ]);    // Remove Shop catalog (300 x 300 hard cropped)
		unset( $sizes[ 'shop_single' ]);     // Shop single (600 x 600 hard cropped)

		return $sizes;
	}

	/*
	 * Change jPeg Quality
	 */
	public function filter_jpeg_quality(){
	    return self::jpeg_quality;
    }

	/*Max size Upload*/
	public function filter_site_upload_size_limit( $size ) {
	    //50 MB
		$size = 1024 * self::MAX_UPLOAD_SIZE * 10000;
		return $size;
	}


}