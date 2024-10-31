<?php
/**
 * @package  contactFormPlugin
 */
namespace Inc\Base;

class MessageActivate
{
	public static function rscf_activate_message() {
		flush_rewrite_rules();

		$default = array();
		if ( ! get_option( 'rscf' ) ) {
			update_option( 'rscf', array('version:'.RSCF_MESSAGE_VERSION) );
		}
		if ( ! get_option( 'russell_smtp' ) ) {
			update_option( 'russell_smtp', $default );
		}
		if ( ! get_option( 'russell_process' ) ) {
			update_option( 'russell_process', $default );
		}
		if ( ! get_option( 'russell_design' ) ) {
			update_option( 'russell_design', $default );
		}
		if ( ! get_option( 'russell_message' ) ) {
			update_option( 'russell_message', 'last_code_message' );
		}
		
	}
}