( function( $ ) {
	//Bulk select
	jQuery(document).on("click", "#mass_select_all", function () {
        if ($("#mass_select_all").is(':checked')) {
          $("input[type=checkbox]").each(function () {
            $(this).attr("checked", true);
          });
          $("#bulk_inbox").show();
          $("#bulk_spam").show();
          $("#bulk_trash").show();
          $("#bulk_per").show();
        } else {
          $("input[type=checkbox]").each(function () {
            $(this).attr("checked", false);
          });
          $("#bulk_inbox").hide();
          $("#bulk_spam").hide();
          $("#bulk_trash").hide();
          $("#bulk_per").hide();
        }
      });
	
	//bulk inbox
	jQuery(document).on("click", "#bulk_inbox", function () {
     var nonce = $('#security').val();
        var id = [];
        $('.bulk_move:checked').each(function(i){
            id[i] = $(this).val();
        });
        //id.shift();
        var data = {
            type: 'bulk_inbox_action',
            action: 'of_ajax_bulk_action',
            security: nonce,
            data: {data:id},
          };
		if(id.length === 0){
	        $.alert({
	            title: 'Warning!',
	            theme: 'white',
	            content: 'Please Select atleast one!',
	             animation: 'scaleY',
	             closeAnimation: 'scale',
	             icon: 'fa fa-warning',
	        });
	      }else{
		      $.confirm({
		          title: 'Confirm!',
		          content: 'Move it to inbox?',
		          buttons: {
		              confirm: function () {
		                  $.post(ajaxurl, data, function (response) {
		                  if(response == 1){
		                  notifyMessage('Conversation marked as inbox.', 'success', 'fa fa-check');
		                    for(var i=0; i<id.length; i++)
		                    {
		                     $('tr#'+id[i]+'').css('background-color', '#84c529');
		                     $('tr#'+id[i]+'').fadeOut('slow');
		                    }
		                  }else{
		                  notifyMessage('Something wrong, try again!', 'warning', 'fa fa-warning');
		                  }
		                  });
		      },
		      cancel: function () {
		          html = 'Conversation did not move!';
		          notifyMessage(html, 'warning', 'fa fa-warning');
		      },
		          }
		      });
    }
  });
	//bulk spam
	jQuery(document).on("click", "#bulk_spam", function () {
     var nonce = $('#security').val();
        var id = [];
         $('.bulk_move:checked').each(function(i){
            id[i] = $(this).val();
        });
        //id.shift();
         var data = {
            type: 'bulk_spam_action',
            action: 'of_ajax_bulk_action',
            security: nonce,
            data: {data:id},
          };
    if(id.length === 0){
          $.alert({
              title: 'Warning!',
              theme: 'white',
              content: 'Please Select atleast one!',
               animation: 'scaleY',
               closeAnimation: 'scale',
               icon: 'fa fa-warning',
          });
        }else{
          $.confirm({
              title: 'Confirm!',
              content: 'Move it to spam?',
              buttons: {
                confirm: function () {
                    $.post(ajaxurl, data, function (response) {
                    if(response == 1){
                  notifyMessage('Conversation marked as spam.', 'success', 'fa fa-check');
                    for(var i=0; i<id.length; i++)
                    {
                     $('tr#'+id[i]+'').css('background-color', '#ff6f00');
                     $('tr#'+id[i]+'').fadeOut('slow');
                    }
                  }else{
                  notifyMessage('Something wrong, try again!', 'warning', 'fa fa-warning');
                  }
                });
          },
          cancel: function () {
              html = 'Conversation did not move!';
              notifyMessage(html, 'warning', 'fa fa-warning');
          },
              }
          });
    }
  });
	//bulk trash
	jQuery(document).on("click", "#bulk_trash", function () {
     var nonce = $('#security').val();
        var id = [];
         $('.bulk_move:checked').each(function(i){
            id[i] = $(this).val();
        });
        //id.shift();
         var data = {
            type: 'bulk_trash_action',
            action: 'of_ajax_bulk_action',
            security: nonce,
            data: {data:id},
          };
    if(id.length === 0){
          $.alert({
              title: 'Warning!',
              theme: 'white',
              content: 'Please Select atleast one!',
               animation: 'scaleY',
               closeAnimation: 'scale',
               icon: 'fa fa-warning',
          });
        }else{
          $.confirm({
              title: 'Confirm!',
              content: 'Move it to trash?',
              buttons: {
                confirm: function () {
                $.post(ajaxurl, data, function (response) {
                if(response == 1){
              notifyMessage('Conversation marked as trash.', 'success', 'fa fa-check');
                for(var i=0; i<id.length; i++)
                {
                 $('tr#'+id[i]+'').css('background-color', '#fc2d42');
                 $('tr#'+id[i]+'').fadeOut('slow');
                }
              }else{
              notifyMessage('Something wrong, try again!', 'warning', 'fa fa-warning');
              }
              });
          },
          cancel: function () {
              html = 'Conversation did not move!';
              notifyMessage(html, 'warning', 'fa fa-warning');
          },
              }
          });
    }
  });
	//bulk permanent delete
	jQuery(document).on("click", "#bulk_per", function () {
     var nonce = $('#security').val();
        var id = [];
         $('.bulk_move:checked').each(function(i){
            id[i] = $(this).val();
        });
        //id.shift();
         var data = {
            type: 'bulk_permanent_del_action',
            action: 'of_ajax_bulk_action',
            security: nonce,
            data: {data:id},
          };
    if(id.length === 0){
          $.alert({
              title: 'Warning!',
              theme: 'white',
              content: 'Please Select atleast one!',
               animation: 'scaleY',
               closeAnimation: 'scale',
               icon: 'fa fa-warning',
          });
        }else{
          $.confirm({
              title: 'Confirm!',
              content: 'Conversation delete permanently?',
              buttons: {
                confirm: function () {
               $.post(ajaxurl, data, function (response) {
                  if(response == 1){
                notifyMessage('Conversation deleted forever.', 'success', 'fa fa-check');
                  for(var i=0; i<id.length; i++)
                  {
                   $('tr#'+id[i]+'').css('background-color', '#fc2d42');
                   $('tr#'+id[i]+'').fadeOut('slow');
                  }
                }else{
                notifyMessage('Something wrong, try again!', 'warning', 'fa fa-warning');
                }
                });
          },
          cancel: function () {
              html = 'Conversation did not delete!';
              notifyMessage(html, 'warning', 'fa fa-warning');
          },
              }
          });
    }
  });
} )( jQuery );
function checkbox_is_checked() {
    if (jQuery(".bulk_move:checked").length > 0) {
     jQuery("#bulk_inbox").show();
     jQuery("#bulk_spam").show();
     jQuery("#bulk_trash").show();
     jQuery("#bulk_per").show();
    } else {
     jQuery("#bulk_inbox").hide();
     jQuery("#bulk_spam").hide();
     jQuery("#bulk_trash").hide();
     jQuery("#bulk_per").hide();
    }
  }