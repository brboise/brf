<?php
/*
   Plugin Name: BRF
   Plugin URI: http://wordpress.org/extend/plugins/brf/
   Version: 0.1
   Author: Robby Milo
   Description: Removing Innovado's crap.
   Text Domain: brf
   License: GPLv3
  */

//Remove Innovado Scripts
function bluerock_dequeue_script() {
    wp_dequeue_script( 'fitvids' );
    wp_dequeue_script( 'easing' );
    wp_dequeue_script( 'superfish' );
    wp_dequeue_script( 'waypoints' );
    wp_dequeue_script( 'waypoints-sticky' );
    wp_dequeue_script( 'functions' );
    wp_dequeue_script( 'prettyPhoto' );
    wp_dequeue_script( 'twitter' );
    wp_dequeue_style( 'prettyPhoto' );
    wp_dequeue_style( 'boxes' );

}
add_action( 'wp_enqueue_scripts', 'bluerock_dequeue_script', 100 );

function bluerock_remove_printscripts() {
    remove_action( 'wp_footer', 'minti_js_custom', 100 );
    remove_action( 'wp_enqueue_scripts', 'my_styles_method' );
}

add_action( 'init', 'bluerock_remove_printscripts' );

//Register Additional Footer Area
function bluerock_footer() {

	register_sidebar( array(
		'name'          => 'Bluerock Footer',
		'id'            => 'bluerock_footer',
		'before_widget' => '<div class="copyright-text">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
add_action( 'widgets_init', 'bluerock_footer' );


/*
Plugin Name: Disable Emojis
Plugin URI: https://geek.hellyer.kiwi/plugins/disable-emojis/
Description: Disable Emojis
Version: 1.5
Author: Ryan Hellyer
Author URI: https://geek.hellyer.kiwi/
License: GPL2

------------------------------------------------------------------------
Copyright Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/


/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
