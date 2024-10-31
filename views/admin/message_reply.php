<div id="wrapper" class="mobile">
  <div class="content">
    <div class="row">
        <div class="col-md-2">
            <div class="panel_s">
                <div class="panel-body">
                     <button class='btn-compose mail-compose'> + Compose</button>
                    <ul class="nav navbar-pills nav-tabs nav-stacked" role="tablist">
                        <li class=''>
                            <a href="admin.php?page=rscf"> <i class="fa fa-inbox"></i> <?php esc_html_e('Inbox','contact'); ?>
                                <?php if (rscf_unread_messages() > 0): ?>
                             <span class="message_count message_count_new margin-left-new"><?php echo esc_html(rscf_unread_messages(),'contact'); ?><span class="unread typetext"><?php esc_html_e('N','contact'); ?></span></span>
                         <?php endif; ?>
                            <span class="message_count message_count_inbox"><?php echo esc_html(rscf_total_messages('inbox'),'contact'); ?><span class="read typetext "></span></span>
                         </a>
                        </li>
                        <li class=''>
                            <a href="admin.php?page=rscf-sent"><i class="fa fa-envelope-o"></i> <?php esc_html_e('Sent','contact'); ?> <span class="message_count message_count_sent"><?php echo esc_html(rscf_total_messages('rscf-sent'),'contact'); ?></span></a>
                        </li>
                        <li class=''>
                            <a href="admin.php?page=rscf-draft"><i class="fa fa-file-text-o"></i> <?php esc_html_e('Draft','contact'); ?> <span class="message_count message_count_draft"><?php echo esc_html(rscf_total_messages('rscf-draft'),'contact'); ?></span></a>
                        </li>
                        <li class=''>
                            <a href="admin.php?page=rscf-spam"><i class="fa fa-filter"></i> <?php esc_html_e('Spam','contact'); ?> <span class="message_count message_count_spam"><?php echo esc_html(rscf_total_messages('inbox_spam'),'contact'); ?></span></a>
                        </li>
                        <li class=''>
                            <a href="admin.php?page=rscf-trash"><i class="fa fa-trash-o"></i> <?php esc_html_e('Trash','contact'); ?> <span class="message_count message_count_trash"><?php echo esc_html(rscf_total_messages('inbox_trash'),'contact'); ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-10">
        	<?php
				$view_id = isset($_GET['id'])? intval($_GET['id']): 0;
				$messageById = rscf_get_message_by_id($view_id);
			?>
            <div class="panel_s">
                <?php include 'compose.php';?>
                <div class="panel-body">
                <div class="_buttons">
              <span class="message-heading mright5 test pull-left display-block"><?php echo esc_html_e( 'Reply From: '.ucfirst(rscf_message_display_name(get_current_user_id())), 'contact' ); ?></span>
              </div>
              </div>
	          <div class="panel-body">
	            <div class="col-md-12">
                    <div class="pull-right message_details_popup">
                        <small class="font-medium-xs small_details">Details <i class="fa fa-caret-down" aria-hidden="true"></i></small>
                        <div class="clearfix"> </div>
                        <ul class="small_detail_hide">
                            <?php if ($messageById['msg_status'] == 'rscf-sent'): ?>
                              <li><span class="left-text"><?php esc_html_e( 'From:', 'conatct' ); ?></span> <span><strong><?php echo esc_html__( rscf_message_display_name($messageById['auth_id']),'contact' ); ?></strong> < <?php echo esc_html__( rscf_message_smtp_data('smtp_email'),'contact' ); ?> ></span></li>
                                <li class="divider"></li>
                                <li><span class="left-text"><?php esc_html_e( 'To:', 'conatct' ); ?></span> <span><?php echo esc_html__( rscf_message_smtp_data('smtp_email'),'contact' ); ?></span></li>
                                <li class="divider"></li>
                                <li><span class="left-text"><?php esc_html_e( 'Subject:', 'conatct' ); ?></span> <span><?php echo esc_html__( $messageById['subject'],'contact' ); ?></span></li>
                                <li class="divider"></li>
                                <li><span class="left-text"><?php esc_html_e( 'Date:', 'conatct' ); ?></span> <span><?php $date=date_create($messageById['msg_date']); echo date_format($date,"M, d, Y H:i:s A"); ?></span></li>
                                <li class="divider"></li>
                                <li><span class="left-text"><?php esc_html_e( 'Send By:', 'conatct' ); ?></span> <span><?php echo esc_url( site_url() );?></span> </li>
                                <li class="divider"></li>
                                <?php else: ?>
                              <li><span class="left-text"><?php esc_html_e( 'From:', 'contact' ); ?></span> <span><strong><?php echo esc_html__( $messageById['sender_name'], 'contact' ); ?></strong> < <?php echo $messageById['email']; ?> ></span></li>
                              <li class="divider"></li>
                              <li><span class="left-text"><?php esc_html_e( 'To:', 'contact' ); ?></span> <span><?php echo esc_html__( rscf_message_smtp_data('smtp_email'), 'contact' ); ?></span></li>
                              <li class="divider"></li>
                              <li><span class="left-text"><?php esc_html_e( 'Subject:', 'contact' ); ?></span> <span><?php echo esc_html__( $messageById['subject'], 'contact' ); ?></span></li>
                              <li class="divider"></li>
                              <li><span class="left-text"><?php esc_html_e( 'Date:', 'contact' ); ?></span> <span><?php $date=date_create($messageById['msg_date']); echo date_format($date,"M, d, Y H:i:s A"); ?></span></li>
                              <li class="divider"></li>
                              <li><span class="left-text"><?php esc_html_e( 'Send By:', 'contact' ); ?></span> <span><?php echo esc_url(site_url());?></span> </li>
                              <li class="divider"></li>
                                <?php endif ?>
                        </ul>
                    </div>
                    <hr>
                
                        <form id="reply_form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
                        <input type="hidden" id="reply_name" name="reply_name" class="form-control" value="<?php echo $messageById['sender_name']; ?>">
                        <?php 
                        $senderEmail = '';

                        if(isset($messageById['email']) && !empty($messageById['email'])){
                          $senderEmail = $messageById['email'];
                        }
               ?> 
                        <div class="form-group">
                            <label for="reply_email" class="control-label">To</label>
                            <input type="text" id="reply_email" name="reply_email" class="form-control" value="<?php echo $senderEmail; ?>">
                        </div>
                        <div class="form-group">
                            <label for="from_email" class="control-label">From</label>
                            <input type="text" id="from_email" name="from_email" class="form-control" value="<?php echo rscf_message_smtp_data('smtp_email'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="reply_sebject" class="control-label">Subject</label>
                            <input type="text" id="reply_sebject" name="reply_sebject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="rscf-reply" class="control-label">Message</label>
                            <textarea id="rscf-reply" name="rscf-reply" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
	          </div>
              <div class="panel-body">
                <div class="_buttons"> 
                    <button  onclick="window.history.back();" class="btn btn-warning mright5 test pull-left display-block"><i class="fa fa-undo"></i> <?php echo esc_html_e( 'Back','contact' ); ?></button>
                    <button class="btn btn-info mright5 test pull-right display-block" id="reply_send"><i class="fa fa-reply"></i> <?php echo esc_html_e( 'Reply','contact' ); ?></button>
                    <!-- <button class="btn btn-info mright5 test pull-right display-block" id="draft_send"><i class="fa fa-file-text-o"></i> <?php echo esc_html_e( 'Draft','contact' ); ?></button> -->
                </div>
              </div>
          </form>
            </div>
        </div>
    </div>
  </div>
</div>
