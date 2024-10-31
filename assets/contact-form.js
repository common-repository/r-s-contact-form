jQuery(document).ready(function ($) {
  /* contact form submission */
  $('#contactForm').on('submit', function (e) {

    e.preventDefault();
    $('.has-error-contact').removeClass('has-error-contact');
    $('.js-show-feedback').removeClass('js-show-feedback');

    var form = $(this),
      fname = form.find('#fname').val(),
      lname = form.find('#lname').val(),
      email = form.find('#email').val(),
      subject = form.find('#subject').val(),
      message = form.find('#message').val(),
      ajaxurl = form.data('url');
      console.log(email);
      var e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,4})$/);
    
    if (fname === '') {
      $('#fname').parent('.contract-from-group').addClass('has-error-contact');
      return;
    }

    if (lname === '') {
      $('#lname').parent('.contract-from-group').addClass('has-error-contact');
      return;
    }

    if (email === '') {
      $('#email').parent('.contract-from-group').addClass('has-error-contact');
      return;
    }

    if (!e_patt.test(email)) {
      $('#email').parent('.contract-from-group').addClass('has-error-invalidEmail');
      return;
      }

    if (subject === '') {
      $('#subject').parent('.contract-from-group').addClass('has-error-contact');
      return;
    }
    if (message === '') {
      $('#message').parent('.contract-from-group').addClass('has-error-contact');
      return;
    }


    form.find('input, button, textarea').attr('disabled', 'disabled');
    $('.js-form-submission').addClass('js-show-feedback');

    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        fname: fname,
        lname: lname,
        subject: subject,
        email: email,
        message: message,
        action: 'save_user_message_settings'
      },
      success: function (response) {
        var data = jQuery.parseJSON(response);
        if (data.status == 1) {
          setTimeout(function () {
            $('.js-form-submission').removeClass('js-show-feedback');
            $('.js-form-success').addClass('js-show-feedback');
            $('#contactPopUp').css('display','block');
            form.find('input, button, textarea').removeAttr('disabled').val('');
            $('#contactForm')[0].reset();
          }, 1500);

        }else if(data.status == 2){
           setTimeout(function () {
            $('.js-form-submission').removeClass('js-show-feedback');
            $('.js-form-error').addClass('js-show-feedback');
            form.find('input, button, textarea').removeAttr('disabled');
          }, 1500);
        }
      }

    });

  });
  jQuery(document).on("click", ".successful-popup-wrap", function () {
    var error_popup = $('.successful-popup-wrap');
    var error_back = $('.success_back');
    error_popup.fadeOut();
    error_back.fadeOut();
  });
});

