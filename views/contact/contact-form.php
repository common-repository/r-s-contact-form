<?php

$rscf_message_form_process_message = empty(rscf_message_front_message_data( 'rscf_message_form_process_message' )) ? 'Submission in process, please wait..' : rscf_message_front_message_data( 'rscf_message_form_process_message' );
$rscf_message_success_message = empty(rscf_message_front_message_data( 'rscf_message_success_message' )) ? 'Message Successfully submitted, thank you!' : rscf_message_front_message_data( 'rscf_message_success_message' );
$rscf_message_error_message = empty(rscf_message_front_message_data( 'rscf_message_error_message' )) ? 'There was an error trying to send your message. Please try again later.' : rscf_message_front_message_data( 'rscf_message_error_message' );
$rscf_message_fname_error = empty(rscf_message_front_message_data( 'rscf_message_fname_error' )) ? 'Field must not be blank.' : rscf_message_front_message_data( 'rscf_message_fname_error' );
$rscf_message_lname_error = empty(rscf_message_front_message_data( 'rscf_message_lname_error' )) ? 'Field must not be blank.' : rscf_message_front_message_data( 'rscf_message_lname_error' );
$rscf_message_subject_error = empty(rscf_message_front_message_data( 'rscf_message_subject_error' )) ? 'Field must not be blank.' : rscf_message_front_message_data( 'rscf_message_subject_error' );
$rscf_message_email_error = empty(rscf_message_front_message_data( 'rscf_message_email_error' )) ? 'Field must not be blank.' : rscf_message_front_message_data( 'rscf_message_email_error' );
$message_error = empty(rscf_message_front_message_data( 'message_error' )) ? 'Field must not be blank.' : rscf_message_front_message_data( 'message_error' );
$rscf_message_extra_class = empty(rscf_message_front_message_data( 'rscf_message_extra_class' )) ? '' : rscf_message_front_message_data( 'rscf_message_extra_class' );

?>
<form id="contactForm" class="contact-form <?php echo $rscf_message_extra_class; ?>" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
  <div class="text-left">
    <small class="text-info form-control-msg js-form-submission"><?php echo $rscf_message_form_process_message; ?></small>
    <small class="text-danger form-control-msg js-form-error"><?php echo $rscf_message_error_message; ?></small>
    <div class="successful-popup-wrap" id="contactPopUp" style="display: none">
      <div class="successful-popup">
        <a href="#" class="close-icon"><img src="<?php echo RSCF_MESSAGE_PLUGIN_IMAGE . 'close_icon.png'; ?>" alt="close_icon"></a>
        <img src="<?php echo RSCF_MESSAGE_PLUGIN_IMAGE . 'thanku.png'; ?>" alt="Thanku Image">
        <h3 class="popup_title">Thank You!</h3>
        <p class="popup_message"><?php echo $rscf_message_success_message; ?></p>
        <a class="success-popup success_back" href="#">Back</a>
      </div>
    </div>
  </div>
  <div class="contract-from-group custom-form-group pull-left">
    <input type="text" class="inp-from reply-inp" placeholder="First Name *" id="fname" name="fname">
    <small class="text-danger form-control-msg"><?php echo $rscf_message_fname_error; ?></small>
  </div>
  <div class="contract-from-group custom-form-group pull-left">
    <input type="text" class="inp-from reply-inp" placeholder="Last Name *" id="lname" name="lname">
    <small class="text-danger form-control-msg"><?php echo $rscf_message_lname_error; ?></small>
  </div>
  <div class="contract-from-group custom-form-group pull-left">
    <input type="text" class="inp-from reply-inp" placeholder="Your Email *" id="email" name="email">
    <small class="text-danger form-control-msg"><?php echo $rscf_message_email_error; ?></small>
    <small class="text-danger form-control-msg-email">Please Enter Valid Email Address</small>
  </div>
  <div class="contract-from-group custom-form-group pull-left">
    <input type="text" class="inp-from reply-inp" placeholder="Subject *" id="subject" name="subject">
    <small class="text-danger form-control-msg"><?php echo $rscf_message_subject_error; ?></small>
  </div>
  <div class="contract-from-group form-group">
    <textarea name="message" id="message" class="inp-from txt-box reply-inp repl-msg" placeholder="Your Message *"></textarea>
    <small class="text-danger form-control-msg"><?php echo $message_error; ?></small>
  </div>
  <div class="contract-from-group">
    <button type="stubmit" class="btn-contact contact-button">Send Message</button>
  </div>
</form>