<?php
/**
 * @package  contactFormPlugin
 */

namespace Inc\Base;

use Inc\Base\MessageBaseController;

/**
 *
 */
class MessageEnqueue{
	public function rscf_register() {
		add_action('admin_enqueue_scripts', array( $this, 'rscf_message_admin_style' ) );
		if (is_admin() && !empty($_GET["page"]) && ($_GET["page"] == "rscf") || (isset($_GET['page']) && $_GET['page']=='rscf-settings') || (isset($_GET['page']) && $_GET['page']=='rscf-details')  || (isset($_GET['page']) && $_GET['page']=='rscf-reply')  || (isset($_GET['page']) && $_GET['page']=='rscf-spam')  || (isset($_GET['page']) && $_GET['page']=='rscf-trash')  || (isset($_GET['page']) && $_GET['page']=='rscf-sent')  || (isset($_GET['page']) && $_GET['page']=='rscf-draft') ) {
           add_action( 'admin_enqueue_scripts', array( $this, 'rscf_message_enqueue' ) );
        }
	}

	public function rscf_message_enqueue($hook) {
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		$page_slug = !empty($_GET["page"]) && $_GET["page"] == "rscf" ? $_GET["page"] : '';

		if ( ((!empty($_GET["page"])) && ( $_GET["page"] == "rscf") ) || ( $_GET['page'] == 'rscf-settings' || $_GET['page'] == 'rscf-details' || $_GET['page'] == 'rscf-reply' || $_GET['page'] == 'rscf-spam' || $_GET['page'] == 'rscf-trash' || $_GET['page'] == 'rscf-sent' || $_GET['page'] == 'rscf-draft' )) {
		
		wp_enqueue_script('jquery');
		wp_enqueue_style("contact-font",  rscf_message_plugin_url('/assets/css/font-awesome.min.css'), array(), RSCF_MESSAGE_VERSION, false);
		wp_enqueue_style("contact-reset", rscf_message_plugin_url('/assets/css/reset.css'), array(), RSCF_MESSAGE_VERSION, false);
		wp_enqueue_style("contact-robot", rscf_message_plugin_url('/assets/css/roboto/roboto.css'), array(), RSCF_MESSAGE_VERSION, false);
		wp_enqueue_style("contact-vendor", rscf_message_plugin_url('/assets/css/vendor.css'), array(), RSCF_MESSAGE_VERSION, false);
		wp_enqueue_style("contact-animate", rscf_message_plugin_url('/assets/plugins/notify/animate.css'), array(), RSCF_MESSAGE_VERSION, false);
		wp_enqueue_style("contact-confirm", rscf_message_plugin_url('/assets/plugins/notify/jquery-confirm.min.css'), array(), RSCF_MESSAGE_VERSION, false);
		wp_enqueue_style("contact", 		rscf_message_plugin_url('/assets/css/contact-main.css'), array(), RSCF_MESSAGE_VERSION, false);

		wp_enqueue_script("contact-boots", rscf_message_plugin_url('/assets/plugins/bootstrap/js/bootstrap.min.js'), '', RSCF_MESSAGE_VERSION, true);
		wp_enqueue_script("contact-datatable", rscf_message_plugin_url('/assets/plugins/datatables/datatables.min.js'), '', RSCF_MESSAGE_VERSION, true);	
		wp_enqueue_script("contact-notify", rscf_message_plugin_url('/assets/plugins/notify/notify.min.js'), '', RSCF_MESSAGE_VERSION, true);		
		wp_enqueue_script("contact-confirm", rscf_message_plugin_url('/assets/plugins/notify/jquery-confirm.min.js'), '', RSCF_MESSAGE_VERSION, true);		
		wp_enqueue_script("contact-main", rscf_message_plugin_url('/assets/plugins/app-build/main.js'), '', RSCF_MESSAGE_VERSION, true);
		wp_enqueue_script("contact-bulk", rscf_message_plugin_url('/assets/plugins/app-build/bulk.js'), '', RSCF_MESSAGE_VERSION, true);
	
		}

	}
	//Admin Css
	public function rscf_message_admin_style() {
		?>
		<style>
			#toplevel_page_rscf li:nth-child(4),
			#toplevel_page_rscf li:nth-child(5),
			#toplevel_page_rscf li:nth-child(6),
			#toplevel_page_rscf li:nth-child(7),
			#toplevel_page_rscf li:nth-child(8),
			#toplevel_page_rscf li:nth-child(9)
			{display: none;}
			#toplevel_page_rscf > ul > li.current{border-radius: 0;background:#e9ebef;}
			#toplevel_page_rscf > ul > li.current > a.current{font-weight: 400 !important; color:#000000}
			#toplevel_page_rscf > ul > li.current > a:hover{font-weight: 400 !important; color:#000000!important;}
		</style>
	<?php }

}