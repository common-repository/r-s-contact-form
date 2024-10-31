( function( $ ) {

$(window).on('load', function() {
    init_body_class();
    init_page_name_as_class();
    init_table_class();
});
function is_mobile() {
     if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
         return true;
     }
     return false;
}
function init_body_class(){
    if(is_mobile() == true){
        $('.mobile').addClass('mobile-page-small');
    }
}
 function init_page_name_as_class() {
    var pageCurrentUrl = window.location.href;
    var removeDomainSegment = pageCurrentUrl.substr(pageCurrentUrl.lastIndexOf('/') + 1);
    var lastSegment = removeDomainSegment.split('.').slice(0, -1).join('.')
    $('.mobile').addClass('page-'+lastSegment);
}
function init_table_class() {
    var pageCurrentUrl = window.location.href;
    var removeDomainSegment = pageCurrentUrl.substr(pageCurrentUrl.lastIndexOf('/') + 1);
    var lastSegment = removeDomainSegment.split('.').slice(0, -1).join('.')
    $('table').addClass('contact-'+lastSegment);
}

    $("#messageTable").DataTable(
      {
        "ordering": false,
        "language": {
            "lengthMenu": "_MENU_",
            "emptyTable": "Hooray, no message here!",
            "zeroRecords": "No matching records found",
            "info": "_START_-_END_/_TOTAL_",
            "infoEmpty": "",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "loadingRecords" : 'Loading...',
            "search" : '<div class="input-group float-right"><span class="input-group-addon"><span class="fa fa-search"></span></span>',
            "searchPlaceholder" : "Search...",
            "processing" : '<div class="dt-loader"></div>',
            paginate: {
                next: '<span class="pagination-default">&#x276f;</span>',
                previous: '<span class="pagination-default">&#x276e;</span>'
            },

        }
      }

    );
    
    //message view
  jQuery(document).on("click", ".message_view", function () {
      var view_id = jQuery(this).attr("data-id");
       var nonce = jQuery(this).attr("data-nonce");
      var view_message = "action=rscf_message_action&param=view_message&nonce="+ nonce +"&id=" + view_id;
    $.ajax({
        url: ajaxurl,
        type: 'post',
        nonce: nonce,
        data: view_message,
      });
  });
  //message reply view
  jQuery(document).on("click", ".reply_view", function () {
      var view_id = jQuery(this).attr("data-id");
       var nonce = jQuery(this).attr("data-nonce");
      var view_message = "action=rscf_message_action&param=reply_view&nonce="+ nonce +"&id=" + view_id;
    $.ajax({
        url: ajaxurl,
        type: 'post',
        nonce: nonce,
        data: view_message,
      });
  });
  //message spam
  jQuery(document).on("click", ".message_spam", function () {
    var tr = $(this).closest('tr');
    var message_id = jQuery(this).attr("data-id");
    var nonce = jQuery(this).attr("data-nonce");
    var contact_spam = "action=rscf_message_action&param=spam_msg&nonce="+ nonce +"&id=" + message_id;
      $.confirm({
          title: 'Confirm!',
          content: 'Move it to spam?',
          buttons: {
              confirm: function () {
                  $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    nonce: nonce,
                    data: contact_spam,
                    success: function (response) {
                      var data = jQuery.parseJSON(response);
                      var html = '';
                      if (data.status == 1) {
                        html =  data.msg;
                        notifyMessage(html, 'success', 'fa fa-check');
                        tr.css('background-color', '#ff6f00');
                        tr.fadeOut('slow');
                      } else if (data.error == 2) {
                        html = 'Something wrong, try again!';
                        notifyMessage(html, 'warning', 'fa fa-warning');
                      } else if (data.status == 2) {
                        html = data.error;
                        mnotifyMessage(html, 'warning', 'fa fa-warning');
                      }else if (data.status == -1) {
                        html = data.msg;
                        notifyMessage(html, 'danger', 'fa fa-times-circle');
                      }
                    }
                  });
      },
      cancel: function () {
          html = 'Conversation did not move!';
          notifyMessage(html, 'warning', 'fa fa-warning');
      },
          }
      });
  });
  //message trash
  jQuery(document).on("click", ".message_trash", function () {
     var tr = $(this).closest('tr');
      var message_id = jQuery(this).attr("data-id");
      var nonce = jQuery(this).attr("data-nonce");
      var contact_trash = "action=rscf_message_action&param=trash_msg&nonce="+ nonce +"&id=" + message_id;
        $.confirm({
            title: 'Confirm!',
            content: 'Move it to trash?',
            buttons: {
                confirm: function () {
                    $.ajax({
                      url: ajaxurl,
                      type: 'post',
                      nonce: nonce,
                      data: contact_trash,
                      success: function (response) {
                        var data = jQuery.parseJSON(response);
                        var html = '';
                        if (data.status == 1) {
                          html =  data.msg;
                          notifyMessage(html, 'success', 'fa fa-check');
                          tr.css('background-color', '#fc2d42');
                          tr.fadeOut('slow');
                        } else if (data.error == 2) {
                          html = 'Something wrong, try again!';
                          notifyMessage(html, 'warning', 'fa fa-warning');
                        } else if (data.status == 2) {
                          html = data.error;
                          mnotifyMessage(html, 'warning', 'fa fa-warning');
                        }else if (data.status == -1) {
                          html = data.msg;
                          notifyMessage(html, 'danger', 'fa fa-times-circle');
                        }
                      }
                    });
        },
        cancel: function () {
            html = 'Conversation did not move!';
            notifyMessage(html, 'warning', 'fa fa-warning');
        },
            }
        });
  });

  //message move inbox
    jQuery(document).on("click", ".move_to_inbox", function () {
      var tr = $(this).closest('tr');
      var message_id = jQuery(this).attr("data-id");
      var nonce = jQuery(this).attr("data-nonce");
      var contact_spam = "action=rscf_message_action&param=move_inbox_msg&nonce="+ nonce +"&id=" + message_id;
        $.confirm({
            title: 'Confirm!',
            content: 'Move it to inbox?',
            buttons: {
                confirm: function () {
                    $.ajax({
                      url: ajaxurl,
                      type: 'post',
                      nonce: nonce,
                      data: contact_spam,
                      success: function (response) {
                        var data = jQuery.parseJSON(response);
                        var html = '';
                        if (data.status == 1) {
                          html =  data.msg;
                          notifyMessage(html, 'success', 'fa fa-check');
                          tr.css('background-color', '#84c529');
                          tr.fadeOut('slow');
                        } else if (data.error == 2) {
                          html = 'Something wrong, try again!';
                          notifyMessage(html, 'warning', 'fa fa-warning');
                        } else if (data.status == 2) {
                          html = data.error;
                          mnotifyMessage(html, 'warning', 'fa fa-warning');
                        }else if (data.status == -1) {
                          html = data.msg;
                          notifyMessage(html, 'danger', 'fa fa-times-circle');
                        }
                      }
                    });
        },
        cancel: function () {
            html = 'Conversation did not move!';
            notifyMessage(html, 'warning', 'fa fa-warning');
        },
            }
        });
  });
  //message permanent delete
  jQuery(document).on("click", ".message_delete", function () {
      var tr = $(this).closest('tr');
      var message_id = jQuery(this).attr("data-id");
      var nonce = jQuery(this).attr("data-nonce");
      var delete_message = "action=rscf_message_action&param=delete_msg&nonce="+ nonce +"&id=" + message_id;
      $.confirm({
          title: 'Confirm!',
          content: 'Conversation delete permanently?',
          buttons: {
              confirm: function () {
                  $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    nonce: nonce,
                    data: delete_message,
                    success: function (response) {
                      var data = jQuery.parseJSON(response);
                      var html = '';
                      if (data.status == 1) {
                        html =  data.msg;
                        notifyMessage(html, 'success', 'fa fa-check');
                        tr.css('background-color', '#fc2d42');
                        tr.fadeOut('slow');
                      } else if (data.error == 2) {
                        html = 'Something wrong, try again!';
                        notifyMessage(html, 'warning', 'fa fa-warning');
                      } else if (data.status == 2) {
                        html = data.error;
                        mnotifyMessage(html, 'warning', 'fa fa-warning');
                      }else if (data.status == -1) {
                        html = data.msg;
                        notifyMessage(html, 'danger', 'fa fa-times-circle');
                      }
                    }
                  });
      },
      cancel: function () {
          html = 'Conversation did not delete!';
          notifyMessage(html, 'warning', 'fa fa-warning');
      },
          }
      });
  });
  jQuery(document).on("click", ".message_delete_single", function () {
      var message_id = jQuery(this).attr("data-id");
      var nonce = jQuery(this).attr("data-nonce");
      var delete_message = "action=rscf_message_action&param=delete_msg&nonce="+ nonce +"&id=" + message_id;
      $.confirm({
          title: 'Confirm!',
          content: 'Conversation delete permanently?',
          buttons: {
              confirm: function () {
                  $.ajax({
                   url: ajaxurl,
                  type: 'post',
                  data: delete_message,
                    success: function (response) {
                      var data = jQuery.parseJSON(response);
                      var html = '';
                      if (data.status == 1) {
                       html =  data.msg;
                        notifyMessage(html, 'success', 'fa fa-check');
                          window.setTimeout(function () {
                            window.history.back();
                          }, 1000);
                      } else if (data.error == 2) {
                        html = 'Something wrong, try again!';
                        notifyMessage(html, 'warning', 'fa fa-warning');
                      } else if (data.status == 2) {
                        html = data.error;
                        mnotifyMessage(html, 'warning', 'fa fa-warning');
                      }else if (data.status == -1) {
                        html = data.msg;
                        notifyMessage(html, 'danger', 'fa fa-times-circle');
                      }
                    }
                  });
      },
      cancel: function () {
          html = 'Conversation did not delete!';
          notifyMessage(html, 'warning', 'fa fa-warning');
      },
          }
      });
  });
 
    //send reply message
 jQuery(document).ready(function ($) {
  $('#reply_form').on('submit', function (e) {
    e.preventDefault();
    $('.has-error').removeClass('has-error');

    var form = $(this),
      reply_sebject = form.find('#reply_sebject').val(),
      contact_reply = form.find('#contact_reply').val(),
      reply_email = form.find('#reply_email').val(),
      from_email = form.find('#from_email').val(),
      ajaxurl = form.data('url');

    if (reply_sebject === '') {
      $('#reply_sebject').parent().addClass('has-error');
      return;
    }
    if (contact_reply === '') {
      $('#contact_reply').parent().addClass('has-error');
      return;
    }
    if (reply_email === '') {
      $('#reply_email').parent().addClass('has-error');
      return;
    }
    if (from_email === '') {
      $('#from_email').parent().addClass('has-error');
      return;
    }
    var sent_data = "action=rscf_message_action&param=message_reply&" + jQuery("#reply_form").serialize();
    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: sent_data,
      success: function (response) {
        var data = jQuery.parseJSON(response);
        var html = '';
        if (data.status == 1) {
          html =  data.msg;
          notifyMessage(html, 'success', 'fa fa-check');
          jQuery("#reply_form")[0].reset();
        } else if (data.error == 2) {
            fail.fadeIn();
            html = 'Something wrong, try again!';
            notifyMessage(html, 'warning', 'fa fa-warning');
          } else if (data.status == 2 || data.status == -1 || data.status == 3) {
            html = data.error;
          notifyMessage(html, 'warning', 'fa fa-warning');
          }
      }
    });

  });
});
//Compose message
 jQuery(document).ready(function ($) {
  $('#compose_form').on('submit', function (e) {
    e.preventDefault();
    $('.has-error').removeClass('has-error');

    var form = $(this),
      compose_recipient = form.find('#compose_recipient').val(),
      compose_subject = form.find('#compose_subject').val(),
      compose_message = form.find('#compose_message').val(),
      ajaxurl = form.data('url');
      var e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,4})$/);
    if (compose_recipient === '') {
      $('#compose_recipient').parent().addClass('has-error');
      return;
    }
     if (!e_patt.test(compose_recipient)) {
      $('#compose_recipient').parent('.contract-from-group').addClass('has-error-invalidEmail');
      return;
      }
    if (compose_message === '') {
      $('#compose_message').parent().addClass('has-error');
      return;
    }
    
    var compose_data = "action=rscf_message_action&param=compose_send&" + jQuery("#compose_form").serialize();
    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: compose_data,
      beforeSend:function(){
           notifyMessage('Submission in process, please wait..', 'info', 'fa fa-info');
        },
      success: function (response) {
        var data = jQuery.parseJSON(response);
        var html = '';
        if (data.status == 1) {
          html =  data.msg;
          notifyMessage(html, 'success', 'fa fa-check');
          jQuery("#compose_form")[0].reset();
        } else if (data.error == 2) {
            fail.fadeIn();
            html = 'Something wrong, try again!';
           notifyMessage(html, 'warning', 'fa fa-warning');
          } else if (data.status == 2 || data.status == -1 || data.status == 3) {
            html = data.error;
            notifyMessage(html, 'warning', 'fa fa-warning');
          }
      }

    });

  });
});
//save admin smtp info
$('#of_save_admin').on('click', function () {
    var nonce = $('#security').val();
    var serializedReturn = $('#mail_form :input[name]').serialize();
    var data = {
      type: 'save_admin_mail',
      action: 'of_ajax_post_action',
      security: nonce,
      data: serializedReturn
    };
    
    $.post(ajaxurl, data, function (response) {
      if (response == 1) {
       notifyMessage('Option Updated', 'success', 'fa fa-check');
      }else if(response == -1) {
        notifyMessage('Error! Not Saved', 'danger', 'fa fa-times-circle');
      } else {
        notifyMessage('Something wrong, try again!', 'warning', 'fa fa-warning');
      }
    });
    return false;
  });
//save process message
 $('#of_save_process').on('click', function () {
    var nonce = $('#security').val();
    var serializedReturn = $('#process_form :input[name]').serialize();
    var data = {
      type: 'save_admin_process',
      action: 'of_ajax_post_action',
      security: nonce,
      data: serializedReturn
    };
    $.post(ajaxurl, data, function (response) {
      if (response == 1) {
       notifyMessage('Option Updated', 'success', 'fa fa-check');
      } else if(response == -1) {
        notifyMessage('Error! Not Saved', 'danger', 'fa fa-times-circle');
      }else {
        notifyMessage('Something wrong, try again!', 'warning', 'fa fa-warning');
      }
    });
    return false;
  });
//save style message
 $('#of_save_style').on('click', function () {
    var nonce = $('#security').val();
    var serializedReturn = $('#style_process_form :input[name]').serialize();
    var data = {
      type: 'save_admin_front_style',
      action: 'of_ajax_post_action',
      security: nonce,
      data: serializedReturn
    };
    $.post(ajaxurl, data, function (response) {
      if (response == 1) {
         notifyMessage('Option Updated', 'success', 'fa fa-check');
      } else if(response == -1) {
      notifyMessage('Error! Not Saved', 'danger', 'fa fa-times-circle');
      } else {
       notifyMessage('Something wrong, try again!', 'warning', 'fa fa-warning');
      }
    });
    return false;
  });


//Mail Popup
var hideStack =[];
$('.mail-compose').click(function() {
  newMail();
});

function newMail() {
  var width = $('.bottom-panel').width(),
      win = $(["<div class='popup-window new-mail'><div class='header'><div class='title'>New Message<div class='right'><button class='button-grey button-small button-minimize'>＿</button><button class='button-grey button-small button-fullscreen'><i class='fa fa-expand'></i></button><button class='button-grey button-small button-exit'><i class='fa fa-times'></i></button></div></div><div class='min-hide'></div></div><div class='message-body'><div class='form-group'><input class='form-control' type='email' required placeholder='Recipients' id='compose_recipient' name='compose_recipient'/></div><div class='form-group'><input class='form-control' type='text' placeholder='Subject' id='compose_subject' name='compose_subject'/></div><textarea class='min-hide form-control compose_message' placeholder='Message' id='compose_message' name='compose_message'></textarea></div><div class='menu footer min-hide'><button class='btn btn-info pull-right' id='send_compose'>Send</button></div></div>"].join('')
            );
  
  win.appendTo($('.bottom-panel'));
  if (win.height() > window.innerHeight) {
    win.css('height', window.innerHeight+'px');
  }
  hideOverflow(win.width() +  width, win);
}

//minimize
$('.bottom-panel').on('click', '.popup-window .title', function(e) {
  e.preventDefault();
  e.stopPropagation();
  minWindow($(this).closest('.popup-window'));
});

function minWindow(win){
  var width = $('.bottom-panel').width() - win.width(),
      title = win.find('.title');

  if (win.hasClass('minimized')) {
    win.removeClass('minimized');
    hideOverflow(width + win.width(), win);
  } else { // win is not minimized
    win.addClass('minimized').removeClass('fullscreen');
    showHidden(width + win.width(), win);
  }
  toggleButtonText(title, win.hasClass('minimized'));
}

function toggleButtonText(elem, isMin, isFull){
  elem.find('.button-minimize').text(isMin? '—': '_');   
  elem.find('.button-fullscreen i').attr('class', isMin||isFull ? 'fa fa-compress' : 'fa fa-expand');
}

//full screen
$('.bottom-panel').on('click', '.new-mail .button-fullscreen', function(e) {
  e.preventDefault();
  e.stopPropagation();

  var win = $(this).closest('.new-mail'),
      width = $('.bottom-panel').width();

  if (win.hasClass('minimized')) {
    width -= win.width();
    win.removeClass('minimized');
    toggleButtonText(win, false);
    hideOverflow(win.width() + width, win);
  } else if (win.hasClass('fullscreen')) {
    win.removeClass('fullscreen'); 
    $('.overlay').hide();  
    toggleButtonText(win, false);
    hideOverflow(win.width() + width, win);
  } else {
    //if any window is already fullscreen, minimize it
    minWindow($('.popup-window.fullscreen'));

    toggleButtonText(win, false, true);
    win.addClass('fullscreen');  
    $('.overlay').show();  
    showHidden();
    $('.bottom-panel .popup-window:not(.fullscreen)').addClass('minimized');
  }
});

$('.overlay').click(function(e){
  e.preventDefault();
  e.stopPropagation();
  $(this).hide();
  $('.new-mail.fullscreen').removeClass('fullscreen');
});

//exit
$('.bottom-panel').on('click', '.popup-window .button-exit', function(e) {
  e.preventDefault();
  e.stopPropagation();
  var popup = $(this).closest('.popup-window'),
      wrapper = $('.bottom-panel');
  if (popup.hasClass('fullscreen')) {
    $('.overlay').hide();
  }
  popup.remove();  
  showHidden();
});

function hideOverflow(width, newElem){
  var wrapper = $('.bottom-panel'), elem;

  if (wrapper.children('.popup-window').length === 1) { //no elements to hide
    return;
  }

  while(width >= window.innerWidth){ 
    var talkChildren = wrapper.children('.new-talk');

    if (wrapper.children('.new-mail.minimized').length) { 
      elem = wrapper.children('.new-mail.minimized').first();
      width -= elem.width();
      hide(elem);
    } else {
      elem = wrapper.children('.new-mail').first();
      width -= elem.width(); 
      elem.addClass('minimized');  
      width += elem.width();       
    }   
  }

  function hide(elem){
    hideStack.push(elem);
    elem.remove();
  }
}

function showHidden(){
  while(hideStack.length){
    var elem = hideStack[hideStack.length - 1], 
        width = $('.bottom-panel').width();
    $(elem).appendTo($('.bottom-panel'));
    width += $(elem).width();

    if( width >= window.innerWidth){
      $(elem).remove();
      break;
    } else {
      hideStack.pop();
    }
  }
}
$('.small_detail_hide').hide();
    $(".small_details").click(function() {
        $(".small_detail_hide").slideToggle("slow");
    });
} )( jQuery );
function notifyMessage(message,messageType,icon) {
  jQuery.notify(
    {
      // options
      title: messageType.charAt(0).toUpperCase() + messageType.slice(1),
      message: "<br>" + message,
      icon: icon,
      target: "_blank"
    },
    {
      // settings
      element: "body",
      type: messageType,
      showProgressbar: false,
      placement: {
        from: "top",
        align: "right"
      },
      offset: {
        x:25,
        y:50
      },
      spacing: 10,
      z_index: 1031,
      delay: 3300,
      timer: 1000,
      allow_dismiss: true,
      newest_on_top: false,
      mouse_over: 'pause',
      url_target: "_blank",
      mouse_over: null,
      animate: {
        enter: "animated lightSpeedIn",
        exit: "animated lightSpeedOut"
      },
      onShow: null,
      onShown: null,
      onClose: null,
      onClosed: null,
      icon_type: "class"
    }
  );
};
window.addEventListener("load", function() {
   var tabs = document.querySelectorAll("ul.tabs-nav > li");
    for (var i = 0; i < tabs.length; i++) {
      tabs[i].addEventListener("click",switchTab)
    }
    function switchTab(event){
      event.preventDefault();
      document.querySelector("ul.tabs-nav li.active").classList.remove("active");
      document.querySelector(".tab-pane.active").classList.remove("active")
      var clickedTab = event.currentTarget,
          clickedLinked = event.target.getAttribute("href");
          clickedTab.classList.add("active");
          document.querySelector(clickedLinked).classList.add("active")
    }
});