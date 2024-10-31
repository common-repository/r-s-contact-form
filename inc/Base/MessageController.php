<?php
/**
 * @package  contactFormPlugin
 */

namespace Inc\Base;

use Inc\Base\MessageBaseController;


class MessageController extends MessageBaseController
{

  
  public function rscf_register()
  {

    
    //shortcode
    add_shortcode( 'show_contact_form', array( &$this, 'rscf_message_settings_data'), 1000 );

    //save contact
    add_action('wp_ajax_nopriv_save_user_message_settings', array(&$this, 'rscf_message_save_front'));
    add_action('wp_ajax_save_user_message_settings', array(&$this, 'rscf_message_save_front'));

    add_action( 'wp_enqueue_scripts', array( $this, 'rscf_message_front_enqueue' ) );

  }

  public function rscf_message_front_enqueue() {
    wp_enqueue_style("contact-front", rscf_message_plugin_url('/assets/contact-form.css'), array(), RSCF_MESSAGE_VERSION, false);
    wp_enqueue_script("contact-js-front", rscf_message_plugin_url('/assets/contact-form.js'), '', RSCF_MESSAGE_VERSION, true);
  }


  /* CONTACT FORM */

  function rscf_message_settings_data($atts, $content = null)
  {

    $atts = shortcode_atts(
      array(),
      $atts,
      'show_contact_settings'
    );

    ob_start();
    do_action('custom_css_code');
    include( RSCF_MESSAGE_PLUGIN_DIR_PATH . 'views/contact/contact-form.php');
    do_action('custom_js_code');
    return ob_get_clean();

  }

  function rscf_message_save_front()
  {
    $smtp_secure = rscf_message_smtp_data('smtp_secure');
    $smtp_host = rscf_message_smtp_data('smtp_host');
    $smtp_port = rscf_message_smtp_data('smtp_port');
    $smtp_email = rscf_message_smtp_data('smtp_email');
    $smtp_fromname = rscf_message_smtp_data('smtp_fromname');
    $smtp_auth = rscf_message_smtp_data('smtp_auth');
    $smtp_username = rscf_message_smtp_data('smtp_username');
    $smtp_password = rscf_message_smtp_data('smtp_password');
    $smtp_charset = rscf_message_smtp_data('smtp_charset');
    $smtp_predefined_header = rscf_message_smtp_data('smtp_predefined_header');
    $smtp_predefined_footer = rscf_message_smtp_data('smtp_predefined_footer');

    $fname = sanitize_text_field($_POST['fname']);
    $lname = sanitize_text_field($_POST['lname']);
    $contact_subject = sanitize_text_field($_POST['subject']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_text_field($_POST['message']);
    $title = $fname.' '.$lname;
    $args = array(
      'post_title' => $title,
      'post_content' => $message,
      'post_excerpt' => 'inbox_new',
      'post_status' => 'inbox',
      'post_type' => 'russell-contact',
      'meta_input' => array(
        '_contact_email_value_key' => $email,
        '_contact_subject_value_key' => $contact_subject,
      ),
    );
    if ($smtp_host == '' || $smtp_secure == '' || $smtp_port == '' || $smtp_email == '' || $smtp_fromname == '' || $smtp_auth == '' || $smtp_username == '' || $smtp_password == '' || $smtp_charset == '' || $smtp_predefined_header == '' || $smtp_predefined_footer == '' ) {
            echo json_encode( array( "status" => 2, "error" => "Please Configure SMTP settings!" ) );
          }else{
            $postID = wp_insert_post($args);

            if ($postID !== 0) {
              $to =  rscf_message_smtp_data('smtp_email');
              $subject = $contact_subject;

              $headers[] = 'From: ' . ucfirst(get_bloginfo('name')) . ' <' . $email . '>'; // 'From: R S RUSSELL <abusayedrussell@gmail.com>'
              $headers[] = 'Reply-To: ' . $title . ' <' . $email . '>';
              $headers[] = 'Content-Type: text/html: charset=UTF-8';

              wp_mail($to, $subject, $message, $headers);
            }

            echo json_encode( array( "status" => 1, "msg" => "Message Successfully submitted, thank you!" ) );
        }
    die();
  }

}