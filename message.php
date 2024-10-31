<?php
/**
 * @package  contactFormPlugin
 */
/*
Plugin Name: R S Contact Form
Plugin URI: https://creativestheme.com
Description: Excellent Ajax Contact Form! A practical contact form plug-in that works well with great flexibility.
Version: 1.0.2
Author: Abu Sayed Russell
Author URI: https://facebook.com/abu.sayed.russell.036
License: GPLv3 or later
Domain Path: /languages/
Text Domain: contact
*/


// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );


if (!defined("RSCF_MESSAGE_VERSION"))
    define("RSCF_MESSAGE_VERSION", '1.0.2');

if (!defined("RSCF_MESSAGE_WP_VERSION"))
    define("RSCF_MESSAGE_WP_VERSION", '5');

if (!defined("RSCF_PHP_VERSION"))
    define("RSCF_PHP_VERSION", '5.6.0');

if (!defined("RSCF_MESSAGE_FILE"))
    define("RSCF_MESSAGE_FILE", __FILE__);

if (!defined("RSCF_MESSAGE_PLUGIN_BASE"))
    define("RSCF_MESSAGE_PLUGIN_BASE", plugin_basename(RSCF_MESSAGE_FILE));

if (!defined("RSCF_MESSAGE_PLUGIN_DIR_PATH"))
    define("RSCF_MESSAGE_PLUGIN_DIR_PATH", plugin_dir_path(RSCF_MESSAGE_FILE));

if (!defined("RSCF_MESSAGE_PLUGIN_DIR_URL"))
    define("RSCF_MESSAGE_PLUGIN_DIR_URL", plugin_dir_url(RSCF_MESSAGE_FILE));

if (!defined("RSCF_MESSAGE_PLUGIN_IMAGE"))
    define("RSCF_MESSAGE_PLUGIN_IMAGE", RSCF_MESSAGE_PLUGIN_DIR_URL . 'assets/images/');

// Require once the Composer Autoload
if ( version_compare( PHP_VERSION, RSCF_PHP_VERSION, '>=' ) ) {
    require_once ( RSCF_MESSAGE_PLUGIN_DIR_PATH . '/vendor/autoload.php' );
}else{
    add_action( 'admin_notices',  'rscf_version_error_warning');
}

function rscf_version_error_warning( ) {
        $php_version = phpversion();
         ?>
        <div class="notice notice-warning mmwps-warning">
         <p><?php echo sprintf( __("Your current PHP version is <strong> $php_version </strong>. You need to upgrade your PHP version to <strong> ".RSCF_PHP_VERSION." or later</strong> to run R S Contact Form.", "contact" ) ); ?></p>
        </div>
    <?php
}
include('inc/Helper/helper.php');
/**
 * The code that runs during plugin activation
 */
if ( version_compare( PHP_VERSION, RSCF_PHP_VERSION, '>=' ) ) {
    function rscf_activate_message() {
    	Inc\Base\MessageActivate::rscf_activate_message();
    }
    register_activation_hook( __FILE__, 'rscf_activate_message' );
}
/**
 * The code that runs during plugin deactivation
 */
if ( version_compare( PHP_VERSION, RSCF_PHP_VERSION, '>=' ) ) {
    function rscf_deactivate_message() {
    	Inc\Base\MessageDeactivate::rscf_deactivate_message();
    }
    register_deactivation_hook( __FILE__, 'rscf_deactivate_message' );
}
/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::rscf_registerServices();
}
 

define( 'SMTP_HOST', rscf_message_smtp_data('smtp_host') ); 
define( 'SMTP_AUTH', rscf_message_smtp_data('smtp_auth') );
define( 'SMTP_PORT', rscf_message_smtp_data('smtp_port') );
define( 'SMTP_SECURE', rscf_message_smtp_data('smtp_secure') );
define( 'SMTP_USERNAME', rscf_message_smtp_data('smtp_username') ); 
define( 'SMTP_PASSWORD', rscf_message_smtp_data('smtp_password') );
define( 'SMTP_FROM',     rscf_message_smtp_data('smtp_email') );
define( 'SMTP_FROMNAME', rscf_message_smtp_data('smtp_fromname') );

add_action( 'phpmailer_init', 'rscf_message_smtp_email' );

function rscf_message_smtp_email( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = SMTP_HOST;
    $phpmailer->SMTPAuth   = SMTP_AUTH;
    $phpmailer->Port       = SMTP_PORT;
    $phpmailer->SMTPSecure = SMTP_SECURE;
    $phpmailer->Username   = SMTP_USERNAME;
    $phpmailer->Password   = SMTP_PASSWORD;
    $phpmailer->From       = SMTP_FROM;
    $phpmailer->FromName   = SMTP_FROMNAME;
    $phpmailer->isHTML( true );

}
add_filter( 'wp_mail_content_type', 'set_html_content_type' );