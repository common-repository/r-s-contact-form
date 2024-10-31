<?php 
/**
 * @package  contactFormPlugin
 */
namespace Inc\Base;

class MessageBaseController
{
	


	public function rscf_last_code()
	{
		$option = get_option( 'russell_message' );
		return isset( $option ) && $option == 'last_code_message' ? true : false;
		
	}
	
	public function rscf_wp_version_check() {
		$wp_version = get_bloginfo( 'version' );
		return ! version_compare( $wp_version, RSCF_MESSAGE_WP_VERSION, '<' ) ? true : false;
		
	}
	
}