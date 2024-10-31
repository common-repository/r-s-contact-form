<?php
/**
 * @package  contactFormPlugin
 */
namespace Inc\Base;

use Inc\Base\MessageBaseController;

class MessageSettingsLinks
{
	public function rscf_register() 
	{
		add_filter( "plugin_action_links_".RSCF_MESSAGE_PLUGIN_BASE, array( $this, 'rscf_settings_link' ) );
	}

	public function rscf_settings_link( $links ) 
	{
		$rscf_base = plugin_basename( __FILE__ );
		$settings_link = '<a href="admin.php?page=rscf-settings">Settings</a>';
		array_push( $links, $settings_link );
		$rscf_base = '<a href="https://www.paypal.me/donate786p" target="_blank" title="Donate">'.esc_html__( 'Donate', 'imop' ).'</a>';
            array_push( $links, $rscf_base );
		return $links;
	}
}