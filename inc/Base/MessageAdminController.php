<?php
/**
 * @package  contactFormPlugin
 */

namespace Inc\Base;

use Inc\Api\MessageSettingsApi;
use Inc\Base\MessageBaseController;
use Inc\Api\Callbacks\MessageCallbacks;
use Inc\Api\Callbacks\MessageProcessCallbacks;
use Inc\Api\Callbacks\MessageDesignCallbacks;
use Inc\Api\Callbacks\MessageAdminCallbacks;


class MessageAdminController extends MessageBaseController
{

  public $settings;

  public $callbacks;

  public $smtp_callbacks;

  public $process_callbacks;

  public $design_callbacks;

  public $subpages = array();


  public function rscf_register()
  {
      if ( version_compare( PHP_VERSION, '5.6.0', '>=' ) ) {
        if ( ! $this->rscf_last_code() ) return;
        if ( ! $this->rscf_wp_version_check() ) return;
        $this->settings = new MessageSettingsApi();

        $this->callbacks = new MessageAdminCallbacks();

        $this->smtp_callbacks = new MessageCallbacks();

        $this->process_callbacks = new MessageProcessCallbacks();

        $this->design_callbacks = new MessageDesignCallbacks();

        $this->setSubpages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        $this->settings->addSubPages($this->subpages)->rscf_register();
      }else{
          add_action( 'admin_notices',  'rscf_version_error_warning');
      }
  }

  public function setSubpages()
  {
    $this->subpages = array(
      array(
        'parent_slug' => 'rscf',
        'page_title' => 'Message Settings',
        'menu_title' => 'Settings',
        'capability' => 'manage_options',
        'menu_slug' => 'rscf-settings',
        'callback' => array($this->callbacks, 'rscf_SettingForm')
      ),
      array(
        'parent_slug' => 'rscf',
        'page_title' => 'Message Details',
        'menu_title' => '',
        'capability' => 'manage_options',
        'menu_slug' => 'rscf-details',
        'callback' => array($this->callbacks, 'rscf_MessageDetails')
      ),
      array(
        'parent_slug' => 'rscf',
        'page_title' => 'Reply',
        'menu_title' => '',
        'capability' => 'manage_options',
        'menu_slug' => 'rscf-reply',
        'callback' => array($this->callbacks, 'rscf_MessageReply')
      ),
      array(
        'parent_slug' => 'rscf',
        'page_title' => 'Spam Message',
        'menu_title' => '',
        'capability' => 'manage_options',
        'menu_slug' => 'rscf-spam',
        'callback' => array($this->callbacks, 'rscf_MessageSpam')
      ),
      array(
        'parent_slug' => 'rscf',
        'page_title' => 'Trash Message',
        'menu_title' => '',
        'capability' => 'manage_options',
        'menu_slug' => 'rscf-trash',
        'callback' => array($this->callbacks, 'rscf_MessageTrash')
      ),
      array(
        'parent_slug' => 'rscf',
        'page_title' => 'Sent Message',
        'menu_title' => '',
        'capability' => 'manage_options',
        'menu_slug' => 'rscf-sent',
        'callback' => array($this->callbacks, 'rscf_MessageSent')
      ),
      array(
        'parent_slug' => 'rscf',
        'page_title' => 'Draft Message',
        'menu_title' => '',
        'capability' => 'manage_options',
        'menu_slug' => 'rscf-draft',
        'callback' => array($this->callbacks, 'rscf_MessageDraft')
      ),
      
    );
  }

  public function setSettings()
  {
    $args = array(
      //Mail
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_secure',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_host',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_port',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_admin_email',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_admin_from_name',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_auth',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_username',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_password',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_charset',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_bcc_email',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_predefined_header',
      ),
      array(
        'option_group' => 'rscf_message_smtp_form_settings_admin',
        'option_name' => 'rscf_message_smtp_predefined_footer',
      ),
      //Process Message
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_form_process_message',
      ),
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_success_message',
      ),
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_error_message',
      ),
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_fname_error',
      ),
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_lname_error',
      ),
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_subject_error',
      ),
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_email_error',
      ),
      array(
        'option_group' => 'rscf_message_form_process_settings',
        'option_name' => 'rscf_message_extra_class',
      ),
      
      //Design
      array(
        'option_group' => 'rscf_message_design_settings',
        'option_name' => 'custom_css_code',
      ),
      array(
        'option_group' => 'rscf_message_design_settings',
        'option_name' => 'custom_js_code',
      ),
    );

    $this->settings->setSettings($args);
  }

  public function setSections()
  {
    $args = array(
      //Mail
      array(
        'id' => 'rscf_message_smtp_settings_index',
        'title' => '',
        'page' => 'rscf_message_smtp_settings_page'
      ),
      //Process Message
      array(
        'id' => 'rscf_message_settings_index',
        'title' => '',
        'page' => 'rscf_message_process_settings'
      ),
      //Design
      array(
        'id' => 'rscf_message_form_style_index',
        'title' => '',
        'page' => 'rscf_message_style_settings'
      ),
    );

    $this->settings->setSections($args);
  }

  public function setFields()
  {
    $args = array(
      //Mail
      array(
        'id' => 'rscf_message_smtp_secure',
        'title' => 'Email Encryption',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_secure',
          'default'  =>   '',
          'placeholder' => 'ssl or tsl',
          'input_type' => 'select',
          'select_option' => array(
             "ssl" => "SSL",
             "tsl"=>"TSL",
          ),
        )
      ),
      array(
        'id' => 'rscf_message_smtp_host',
        'title' => 'SMTP Host',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_host',
          'default'  =>   '',
          'placeholder' => 'smtp.gmail.com',
           'input_type' => 'text',
        )
      ),
      array(
        'id' => 'rscf_message_smtp_port',
        'title' => 'SMTP Port',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_port',
          'default'  =>   '',
          'placeholder' => '465 or 587',
           'input_type' => 'number',
        )
      ),
      array(
        'id' => 'rscf_message_admin_email',
        'title' => 'SMTP Email',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_email',
          'default'  =>   '',
          'placeholder' => 'abusayedrussell@gmail.com',
          'input_type' => 'email',
        )
      ),
      array(
        'id' => 'rscf_message_admin_from_name',
        'title' => 'SMTP Name',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_fromname',
          'default'  =>   '',
          'placeholder' => 'Creatives Theme',
           'input_type' => 'text',
        )
      ),
      array(
        'id' => 'rscf_message_smtp_auth',
        'title' => 'SMTP Auth',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_auth',
          'default'  =>   '',
          'input_type' => 'checkbox',
        )
      ),
       array(
        'id' => 'rscf_message_smtp_username',
        'title' => 'SMTP Username',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_username',
          'default'  =>   '',
          'placeholder' => 'srsohoj@gmail.com',
          'input_type' => 'email',
        )
      ),
      array(
        'id' => 'rscf_message_smtp_password',
        'title' => 'SMTP Password',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_password',
          'default'  =>   '',
          'placeholder' => '123...',
          'input_type' => 'password',
        )
      ),
      array(
        'id' => 'rscf_message_smtp_charset',
        'title' => 'Email Charset',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_charset',
          'default'  =>   'utf-8',
          'placeholder' => 'utf-8',
          'input_type' => 'text',
        )
      ),
      array(
        'id' => 'rscf_message_smtp_bcc_email',
        'title' => 'BCC All Emails To',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_bcc_email',
          'default'  =>   '',
          'placeholder' => '',
          'input_type' => 'text',
        )
      ),
      array(
        'id' => 'rscf_message_smtp_predefined_header',
        'title' => 'Predefined Header',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_predefined_header',
          'default'  =>   '<!doctype html>
                            <html>
                            <head>
                              <meta name="viewport" content="width=device-width" />
                              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                              <style>
                                body {
                                 background-color: #f6f6f6;
                                 font-family: sans-serif;
                                 -webkit-font-smoothing: antialiased;
                                 font-size: 14px;
                                 line-height: 1.4;
                                 margin: 0;
                                 padding: 0;
                                 -ms-text-size-adjust: 100%;
                                 -webkit-text-size-adjust: 100%;
                               }
                               table {
                                 border-collapse: separate;
                                 mso-table-lspace: 0pt;
                                 mso-table-rspace: 0pt;
                                 width: 100%;
                               }
                               table td {
                                 font-family: sans-serif;
                                 font-size: 14px;
                                 vertical-align: top;
                               }
                                   /* -------------------------------------
                                     BODY & CONTAINER
                                     ------------------------------------- */
                                     .body {
                                       background-color: #f6f6f6;
                                       width: 100%;
                                     }
                                     /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */

                                     .container {
                                       display: block;
                                       margin: 0 auto !important;
                                       /* makes it centered */
                                       max-width: 680px;
                                       padding: 10px;
                                       width: 680px;
                                     }
                                     /* This should also be a block element, so that it will fill 100% of the .container */

                                     .content {
                                       box-sizing: border-box;
                                       display: block;
                                       margin: 0 auto;
                                       max-width: 680px;
                                       padding: 10px;
                                     }
                                   /* -------------------------------------
                                     HEADER, FOOTER, MAIN
                                     ------------------------------------- */

                                     .main {
                                       background: #fff;
                                       border-radius: 3px;
                                       width: 100%;
                                     }
                                     .wrapper {
                                       box-sizing: border-box;
                                       padding: 20px;
                                     }
                                     .footer {
                                       clear: both;
                                       padding-top: 10px;
                                       text-align: center;
                                       width: 100%;
                                     }
                                     .footer td,
                                     .footer p,
                                     .footer span,
                                     .footer a {
                                       color: #999999;
                                       font-size: 12px;
                                       text-align: center;
                                     }
                                     hr {
                                       border: 0;
                                       border-bottom: 1px solid #f6f6f6;
                                       margin: 20px 0;
                                     }
                                   /* -------------------------------------
                                     RESPONSIVE AND MOBILE FRIENDLY STYLES
                                     ------------------------------------- */

                                     @media only screen and (max-width: 620px) {
                                       table[class=body] .content {
                                         padding: 0 !important;
                                       }
                                       table[class=body] .container {
                                         padding: 0 !important;
                                         width: 100% !important;
                                       }
                                       table[class=body] .main {
                                         border-left-width: 0 !important;
                                         border-radius: 0 !important;
                                         border-right-width: 0 !important;
                                       }
                                     }
                                   </style>
                                 </head>
                                 <body class="">
                                  <table border="0" cellpadding="0" cellspacing="0" class="body">
                                    <tr>
                                     <td>&nbsp;</td>
                                     <td class="container">
                                      <div class="content">
                                        <!-- START CENTERED WHITE CONTAINER -->
                                        <table class="main">
                                          <!-- START MAIN CONTENT AREA -->
                                          <tr>
                                           <td class="wrapper">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                              <tr>
                                               <td>',
          'placeholder' => '',
          'input_type' => 'textarea_header',
        )
      ),
      array(
        'id' => 'rscf_message_smtp_predefined_footer',
        'title' => 'Predefined Footer',
        'callback' => array($this->smtp_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_smtp_settings_page',
        'section' => 'rscf_message_smtp_settings_index',
        'args' => array(
          'option_name' => 'contact_smtp',
          'label_for' => 'smtp_predefined_footer',
          'default'  =>   '</td>
                             </tr>
                           </table>
                         </td>
                       </tr>
                       <!-- END MAIN CONTENT AREA -->
                     </table>
                     <!-- START FOOTER -->
                     <div class="footer">
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="content-block">
                            <span>{companyname}</span>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <!-- END FOOTER -->
                    <!-- END CENTERED WHITE CONTAINER -->
                  </div>
                </td>
                <td>&nbsp;</td>
              </tr>
            </table>
            </body>
            </html>',
          'placeholder' => '',
          'input_type' => 'textarea_footer',
        )
      ),
      //Process Message
      array(
        'id' => 'rscf_message_form_process_message',
        'title' => 'Form Process Message',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_form_process_message',
          'placeholder' => 'Submission in process, please wait..',
           'default'  =>   'Submission in process, please wait..',
           'input_type' => 'text',
        )
      ),
      array(
        'id' => 'rscf_message_success_message',
        'title' => 'Success Message',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_success_message',
          'placeholder' => 'Message Successfully submitted, thank you!',
           'default'  =>   'Message Successfully submitted, thank you!',
           'input_type' => 'text',
        )
      ),

      array(
        'id' => 'rscf_message_error_message',
        'title' => 'Error Message',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_error_message',
          'placeholder' => 'There was an error trying to send your message. Please try again later.',
           'default'  =>   'There was an error trying to send your message. Please try again later.',
           'input_type' => 'text',

        )
      ),
      array(
        'id' => 'rscf_message_fname_error',
        'title' => 'First Name Error Message',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_fname_error',
          'placeholder' => 'First Name',
           'default'  =>   'Field must not be blank.',
           'input_type' => 'text',

        )
      ),
      array(
        'id' => 'rscf_message_lname_error',
        'title' => 'Last Name Error Message',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_lname_error',
          'placeholder' => 'Last Name',
           'default'  =>   'Field must not be blank.',
           'input_type' => 'text',

        )
      ),
      array(
        'id' => 'rscf_message_subject_error',
        'title' => 'Subject Error Message',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_subject_error',
          'placeholder' => 'Subject',
           'default'  =>   'Field must not be blank.',
           'input_type' => 'text',

        )
      ),
      array(
        'id' => 'rscf_message_email_error',
        'title' => 'Email Error Message',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_email_error',
          'placeholder' => 'E-mail',
           'default'  =>   'Field must not be blank.',
           'input_type' => 'text',

        )
      ),
      array(
        'id' => 'message_error',
        'title' => 'Message Error',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'message_error',
          'placeholder' => 'Message',
           'default'  =>   'Field must not be blank.',
           'input_type' => 'text',

        )
      ),

      array(
        'id' => 'rscf_message_extra_class',
        'title' => 'Extra Class',
        'callback' => array($this->process_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_process_settings',
        'section' => 'rscf_message_settings_index',
        'args' => array(
          'option_name' => 'contact_process',
          'label_for' => 'rscf_message_extra_class',
          'placeholder' => 'eg. Extra Class',
           'default'  =>   'rscf_message_extra_class',
           'input_type' => 'text',
        )
      ),
      //Design
      array(
        'id' => 'custom_css_code',
        'title' => 'Custom Style',
        'callback' => array($this->design_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_style_settings',
        'section' => 'rscf_message_form_style_index',
        'args' => array(
          'option_name' => 'contact_design',
          'label_for' => 'css_code',
          'placeholder' => '',
          'default'  =>   '',
          'input_type' => 'custom_css',
        )
      ),
      array(
        'id' => 'custom_js_code',
        'title' => 'Custom JS',
        'callback' => array($this->design_callbacks, 'rscf_optionField'),
        'page' => 'rscf_message_style_settings',
        'section' => 'rscf_message_form_style_index',
        'args' => array(
          'option_name' => 'contact_design',
          'label_for' => 'js_code',
          'placeholder' => '',
          'default'  =>   '',
          'input_type' => 'custom_js',
        )
      ),
    );

    $this->settings->setFields($args);
  }
}