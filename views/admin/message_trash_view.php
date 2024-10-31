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
                        <li class='active'>
                            <a href="admin.php?page=rscf-trash"><i class="fa fa-trash-o"></i> <?php esc_html_e('Trash','contact'); ?> <span class="message_count message_count_trash"><?php echo esc_html(rscf_total_messages('inbox_trash'),'contact'); ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="panel_s">
                 <?php include 'compose.php';?>
                <div class="panel-body">
                <div class="_buttons">
              <span class="btn btn-info mright5 test pull-left display-block"><?php esc_html_e( 'Trash', 'contact' ); ?></span>
              </div>
              </div>
          <div class="panel-body">
            <table id="messageTable" class="table">
                     <thead style="display: none;">
                        <tr>
                            <th width="10"><?php esc_html_e( '#', 'contact' ) ?></th>
                            <th><?php esc_html_e( 'Name', 'contact' ) ?></th>
                            <th><?php esc_html_e( 'Message', 'contact' ) ?></th>
                            <th><?php esc_html_e( 'Option', 'contact' ) ?></th>
                        </tr>
                    </thead>
                    <div class="bulk-body">
                      <div class="_buttons">
                        <input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce( 'bulk_move' ); ?>"/>
                          <div class="checkbox mass_select_all_wrap pull-left display-block">
                            <input type="checkbox" id="mass_select_all" class="checked">
                            <label></label>
                        </div>
                         <button id="bulk_inbox" type="button" class="bulk-btn move-color pull-left display-block mright5" title="Move to inbox" style="display: none"> <i class="fa fa-undo"></i></button>

                        <button id="bulk_spam" type="button" class="bulk-btn move-color pull-left display-block mright5" title="Move to spam" style="display: none"> <i class="fa fa-wrench"></i></button>

                          <button id="bulk_per" type="button" class="bulk-btn move-color pull-left display-block mright5" title="Rermanently Remove" style="display: none"> <i class="fa fa-remove"></i></button>
                         </div>
                         </div>
                    <tbody>
                        <?php $i = 0; foreach ( rscf_get_messages('inbox_trash') as $value): $i++;?>
                  
                        <tr class="<?php echo $value->view_status == 'inbox_new' ? 'new_message' : 'old_message'?>" id="<?php echo $value->msg_id; ?>">
                            <td width="10">
                                <div class="checkbox">
                                <input type="checkbox" onClick="checkbox_is_checked()" class="bulk_move" value="<?php echo $value->msg_id; ?>" /><label></label>
                            </div>
                          </td>
                            <td class="sender_name"><a class="link_color" href="admin.php?page=rscf-details&id=<?php echo $value->msg_id; ?>">To: <?php echo $value->email; ?></a> <span class="message_time"><?php echo esc_html(rscf_time_ago($value->msg_date), 'contact'); ?></span></td>
                            <td><a class="link_color message_view" href="admin.php?page=rscf-details&id=<?php echo $value->msg_id; ?>" data-id="<?php echo $value->msg_id; ?>"><?php echo esc_html( rscf_messageShorten($value->message,100), 'contact' ); ?></a></td>
                            <td class="option_button">
                                <a href="admin.php?page=rscf-details&id=<?php echo $value->msg_id; ?>" data-id="<?php echo $value->msg_id; ?>" data-nonce="<?php echo wp_create_nonce('view_contact_nonce') ?>" class="btn btn-default btn-icon message_view" title="View"><i class="fa fa-eye"></i></a>

                                <a href="admin.php?page=rscf-reply&id=<?php echo $value->msg_id; ?>" data-id="<?php echo $value->msg_id; ?>" data-nonce="<?php echo wp_create_nonce('reply_contact_nonce') ?>" class="btn btn-default btn-icon reply_view" title="Reply"><i class="fa fa-reply"></i></a>

                                <a href="javascript:void(0)" data-id="<?php echo $value->msg_id; ?>" data-nonce="<?php echo wp_create_nonce('inbox_contact_nonce') ?>" class="btn btn-default move_to_inbox btn-icon" title="Move to inbox"><i class="fa fa-undo"></i></a>

                                <a href="javascript:void(0)" data-id="<?php echo $value->msg_id; ?>" data-nonce="<?php echo wp_create_nonce('spam_contact_nonce') ?>" class="btn btn-default message_spam btn-icon" title="Move to spam"><i class="fa fa-wrench"></i></a>

                                <a href="javascript:void(0)" data-id="<?php echo $value->msg_id; ?>" data-nonce="<?php echo wp_create_nonce('delete_contact_nonce') ?>" class="btn btn-danger message_delete btn-icon" title="Rermanently Remove "><i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                         <?php endforeach ?>
                    </tbody>
                </table>
          </div>
            </div>
        </div>
    </div>
  </div>
</div>
