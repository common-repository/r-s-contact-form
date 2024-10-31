<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  contactFormPlugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

   function russell_contact_plugin_delete_with_data() {
	global $wpdb;
	delete_option('rscf');
	delete_option('russell_smtp');
	delete_option('russell_process');
	delete_option('russell_design');
	delete_option('russell_message');

	$posts = get_posts(
	    array(
	        'numberposts' => -1,
	        'post_type' => 'russell-contact',
	        'post_status' => 'any',
	    )
	);
   
    foreach ( $posts as $post ) {
        wp_delete_post( $post->ID, true );
    }
}

russell_contact_plugin_delete_with_data();
