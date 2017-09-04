<?php
namespace App;

class Ajax {

	private $wpdb;

	public function __construct() {

		$this->wpdb = & $GLOBALS['wpdb'];

		$list_function = [
            //'test_ajax'
        ];

		foreach ($list_function as $method) {
			add_action( 'wp_ajax_'.$method, array( $this, $method ) );
			add_action( 'wp_ajax_nopriv_'.$method, array( $this, $method ) );
		}

	}

	public function test_ajax(){
		if ( defined('DOING_AJAX') && DOING_AJAX) {

			$result = array();
			$result['result'] = "true";
			$result['text'] = "";

			wp_send_json($result);
			exit;
		}
		die();

	}




}
