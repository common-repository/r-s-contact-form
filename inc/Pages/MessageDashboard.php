<?php 
/**
 * @package  contactFormPlugin
 */
namespace Inc\Pages;

use Inc\Api\MessageSettingsApi;
use Inc\Base\MessageBaseController;
use Inc\Api\Callbacks\MessageAdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class MessageDashboard extends MessageBaseController
{
	public $settings;

	public $callbacks;

	public $pages = array();

	public function rscf_register()
	{
		if ( version_compare( PHP_VERSION, '5.6.0', '>=' ) ) {
		if ( ! $this->rscf_last_code() ) return;
		if ( ! $this->rscf_wp_version_check() ) return;
		$this->settings = new MessageSettingsApi();

		$this->callbacks = new MessageAdminCallbacks();

		$this->setPages();

		$this->settings->addPages( $this->pages )->withSubPage( 'Messages' )->rscf_register();
		}else{
          add_action( 'admin_notices',  'rscf_version_error_warning');
      }
	}


	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'Inbox Message', 
				'menu_title' => 'Message <span classs="message_count_new_menu">'.rscf_unread_messages().'<span>', 
				'capability' => 'manage_options', 
				'menu_slug' => 'rscf', 
				'callback' => array( $this->callbacks, 'rscf_MessageView' ), 
				'icon_url' => 'dashicons-email', 
				'position' => 25
			)
		);
	}


}