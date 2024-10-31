<div id="wrapper" class="mobile">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body _buttonss">
              <h4 class="message-heading pull-left display-block">Change Settings</h4>
            </div>
          <div class="panel-body">
          <div class="tab-content">
            <div class="row">
              <div class="col-md-12">
               <ul class="nav nav-tabs tabs-nav" role="tablist">
                  <li role="presentation" class="active"> 
                    <a href="#admin_settings" aria-controls="admin_settings" role="tab" data-toggle="tab">
                      SMTP Settings
                  </a>
                </li>
                  <li role="presentation"> 
                    <a href="#contact_process" aria-controls="contact_process" role="tab" data-toggle="tab">
                    Message 
                  </a> 
                </li>
                <li role="presentation"> 
                    <a href="#contact_style" aria-controls="contact_style" role="tab" data-toggle="tab">
                    Design 
                  </a> 
                </li>
                <li role="presentation"> 
                    <a href="#contact_shortcode" aria-controls="contact_shortcode" role="tab" data-toggle="tab">
                    Shortcode 
                  </a> 
                </li>
                  <li role="presentation"> 
                    <a href="#contact_documentation" aria-controls="contact_documentation" role="tab" data-toggle="tab">
                    Documentation 
                  </a> 
                </li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="admin_settings">
                    <div class="col-md-6">
                      <?php do_action('rscf_message_admin_email_setting'); ?>
                    </div>
                    <div class="col-md-6">
                   <?php do_action('rscf_message_admin_support'); ?>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="contact_process">
                  <div class="col-md-6">
                    <?php do_action('rscf_message_admin_process_setting'); ?>
                  </div>
                  <div class="col-md-6">
                   <?php do_action('rscf_message_admin_support'); ?>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="contact_style">
                  <div class="col-md-8">
                    <?php do_action('rscf_message_form_style'); ?>
                  </div>
                  <div class="col-md-4">
                   <?php do_action('rscf_message_admin_support'); ?>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="contact_shortcode">
                  <div class="col-md-8">
                    <?php do_action('rscf_message_admin_message_shortcode'); ?>
                  </div>
                  <div class="col-md-4">
                   <?php do_action('rscf_message_admin_support'); ?>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="contact_documentation">
                  <div class="col-md-8">
                    <?php do_action('rscf_message_admin_message_document'); ?>
                  </div>
                  <div class="col-md-4">
                   <?php do_action('rscf_message_admin_support'); ?>
                  </div>
                </div>
              </div>                         
              </div>
            </div>
          </div>
         </div>
        </div>
      </div>
    </div>
  </div>
</div>

