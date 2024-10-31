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
          <?php include 'compose.php';?>
          <?php
          $view_id = isset($_GET['id'])? intval($_GET['id']): 0;
          $messageById = rscf_get_message_by_id($view_id);
        ?>
        <?php if ($messageById['msg_status'] == 'rscf-sent'): ?>
            <?php include 'include/sent_details.php';?>
        <?php else: ?>
          <?php include 'include/inbox_details.php';?>
        <?php endif ?>

        </div>
    </div>
  </div>
</div>
