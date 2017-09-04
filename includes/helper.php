<?php

/*check Parent or children category*/
function category_has_parent($catid){
	$category = get_category($catid);
	if ($category->category_parent > 0){
		return true;
	}
	return false;
}

function has_children_cat($cat_id) //دارد زیر مجموعه
{
	$children = get_terms(
		'category',
		array( 'parent' => $cat_id, 'hide_empty' => false )
	);
	if ($children){
		return true;
	}
	return false;
}

/*
 * Output Buffering
 * Buffers the entire WP process, capturing the final output for manipulation.*/
function sanitize_output($buffer) {

	// Searching textarea and pre
	preg_match_all('#\<textarea.*\>.*\<\/textarea\>#Uis', $buffer, $foundTxt);
	preg_match_all('#\<pre.*\>.*\<\/pre\>#Uis', $buffer, $foundPre);

	// replacing both with <textarea>$index</textarea> / <pre>$index</pre>
	$buffer = str_replace($foundTxt[0], array_map(function($el){ return '<textarea>'.$el.'</textarea>'; }, array_keys($foundTxt[0])), $buffer);
	$buffer = str_replace($foundPre[0], array_map(function($el){ return '<pre>'.$el.'</pre>'; }, array_keys($foundPre[0])), $buffer);

	// your stuff
	$search = array(
		'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		'/[^\S ]+\</s',  // strip whitespaces before tags, except space
		'/(\s)+/s'       // shorten multiple whitespace sequences
	);

	$replace = array(
		'>',
		'<',
		'\\1'
	);

	$buffer = preg_replace($search, $replace, $buffer);

	// Replacing back with content
	$buffer = str_replace(array_map(function($el){ return '<textarea>'.$el.'</textarea>'; }, array_keys($foundTxt[0])), $foundTxt[0], $buffer);
	$buffer = str_replace(array_map(function($el){ return '<pre>'.$el.'</pre>'; }, array_keys($foundPre[0])), $foundPre[0], $buffer);

	return $buffer;
}

/*
 * telegram Seo
 */
/*Telegram Seo Link*/
//add_action('wp_head','telegram_seo_link');
function telegram_seo_link(){
	$img = get_stylesheet_directory_uri() . '/images/telegram.png';

	if (is_single() || is_page()) {
		global $post;
		if ( has_post_thumbnail() ) {
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumb-60');
			$img = $thumb[0];
		}
		$content = mb_substr(wp_strip_all_tags(strip_shortcodes(get_post( $post->ID, ARRAY_A )['post_content'])), 0, 130);

		echo '<meta property="og:title" content="'.get_the_title($post->ID).'" />
<meta property="og:site_name" content="BuyMarketing.ir"/>
<meta property="og:description" content="'.$content.'" />
<meta property="og:image" content="'.$img.'" />
		';
	} else {

		$title=	get_bloginfo('name'); //home page
		if (is_category()) {
			global $cat;
			$title=	get_cat_name( $cat );
		}
		echo '<meta property="og:title" content="'.$title.'" />
<meta property="og:site_name" content="BuyMarketing.ir"/>
<meta property="og:description" content="'.get_bloginfo('description').'" />
<meta property="og:image" content="'.$img.'" />
		';
	}
}