<?php 
/**
 * @package  contactFormPlugin
 */
namespace Inc\Api\Callbacks;


class MessageAdminCallbacks
{

	public function rscf_SettingForm()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH . 'views/admin/message_settings_view.php');
	}
	public function rscf_MessageView()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH. "views/admin/message_view.php" );
	}
	public function rscf_MessageDetails()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH. "views/admin/message_details.php" );
	}
	public function rscf_MessageReply()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH. "views/admin/message_reply.php" );
	}
	public function rscf_MessageSpam()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH. "views/admin/message_spam_view.php" );
	}
	public function rscf_MessageTrash()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH. "views/admin/message_trash_view.php" );
	}
	public function rscf_MessageSent()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH. "views/admin/message_sent_view.php" );
	}
	public function rscf_MessageDraft()
	{
		return require_once( RSCF_MESSAGE_PLUGIN_DIR_PATH. "views/admin/message_draft_view.php" );
	}
}