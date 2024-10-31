<?php 
/**
 * @package  contactFormPlugin
 */
namespace Inc\Base;

class MessageCommonController
{
	
	public function rscf_register() {
		$option = get_option( 'russell_message' );
		if($option != 'last_code_message'){
			add_action( 'admin_notices', array( $this, 'rscf_dev_warning' ) );
		}
		add_action( 'admin_notices', array( $this, 'rscf_dev_wp_version_error_warning' ) );
	}
	
	public function rscf_dev_warning( ) {
         ?>
       <style>
		strong { font-weight: bolder; }
		.notices-warning { color: #333333; background-color:#ffffff; border-color:#ffeeba;}
		.contact-notices {
		    position: relative;
		    padding: 0 15px;
		    padding-right: 1.25rem;
		    margin-bottom: 1rem;
		    border: 4px solid 
		    transparent;
		    border-top-color: transparent;
		    border-right-color: transparent;
		    border-bottom-color: transparent;
		    border-left-color: #ffba00;
		    border-radius: .25rem;
		    width: 96%;
		    margin-top: 15px;
		}
		.close { font-size: 1.5rem; font-weight: 700; line-height: 1; color: #000; text-shadow: 0 1px 0 #fff;
		}
		button.close:focus {  outline: 0;}
		.contact-notices-dismissible .close { position: absolute;top: 0;right: 0;padding: 7px;color: inherit;}
		.close:not(:disabled):not(.disabled) { cursor: pointer;}
		button.close {padding: 0;background-color:  transparent;border: 0;-webkit-appearance: none;}
		 </style>
	  <script>
	    jQuery( document ).ready(function(){
	      jQuery( ".close" ).click(function() {
	        jQuery( ".contact-notices-dismissible" ).fadeOut( "slow", function() {
	          jQuery( ".contact-notices-dismissible" ).remove();
	        });
	        jQuery( this ).fadeOut( "slow", function() {
	          jQuery( this ).remove();
	        });
	      });
	    });
	  </script>
	<div class="contact-notices notices-warning contact-notices-dismissible">
	<p>
	<?php
	    echo sprintf(__( 'Something missing when install the plugin, Please re-install R S Contact Form Plugin!. Please <a href="%1$s">Plugins</a>', 'contact' ),
	        admin_url( 'plugins.php' )
	    );
	?>
	</p>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
    <?php
	}

	public function rscf_dev_wp_version_error_warning() {
    	$WPversion = get_bloginfo( 'version' );

	    if ( ! version_compare( $WPversion, RSCF_MESSAGE_WP_VERSION, '<' ) ) {
	        return;
	    }
		?>
	  <style>
		strong { font-weight: bolder; }
		.notices-warning { color: #333333; background-color:#ffffff; border-color:#ffeeba;}
		.contact-notices {
		    position: relative;
		    padding: 0 15px;
		    padding-right: 1.25rem;
		    margin-bottom: 1rem;
		    border: 4px solid 
		    transparent;
		    border-top-color: transparent;
		    border-right-color: transparent;
		    border-bottom-color: transparent;
		    border-left-color: #ffba00;
		    border-radius: .25rem;
		    width: 96%;
		    margin-top: 15px;
		}
		.close { font-size: 1.5rem; font-weight: 700; line-height: 1; color: #000; text-shadow: 0 1px 0 #fff;
		}
		button.close:focus {  outline: 0;}
		.contact-notices-dismissible .close { position: absolute;top: 0;right: 0;padding: 7px;color: inherit;}
		.close:not(:disabled):not(.disabled) { cursor: pointer;}
		button.close {padding: 0;background-color:  transparent;border: 0;-webkit-appearance: none;}
		 </style>
	  <script>
	    jQuery( document ).ready(function(){
	      jQuery( ".close" ).click(function() {
	        jQuery( ".contact-notices-dismissible" ).fadeOut( "slow", function() {
	          jQuery( ".contact-notices-dismissible" ).remove();
	        });
	        jQuery( this ).fadeOut( "slow", function() {
	          jQuery( this ).remove();
	        });
	      });
	    });
	  </script>
	<div class="contact-notices notices-warning contact-notices-dismissible">
	  <p><?php
	    echo sprintf(
	        __( 'R S Contact Form %1$s requires WordPress %2$s or higher. Please <a href="%3$s">update WordPress</a>.', 'contact' ),
	        RSCF_MESSAGE_VERSION,
	        RSCF_MESSAGE_WP_VERSION,
	        admin_url( 'update-core.php' )
	    );
	?></p>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<?php
	}
}