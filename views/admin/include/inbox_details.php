            <div class="panel_s">
                <div class="panel-body">
                <div class="_buttons">
              <span class="message-heading mright5 test pull-left display-block"><?php echo esc_html_e( 'From: '.$messageById['email'], 'contact' ); ?></span>
              <a href="admin.php?page=rscf-reply&id=<?php echo $messageById['msg_id']; ?>" class="btn btn-info mright5 test pull-right display-block marlegt5"><i class="fa fa-reply"></i> <?php echo esc_html_e( 'Reply','contact' ); ?></a>
              <a href="javascript:void(0)"  onclick="window.history.back();" class="btn btn-warning mright5 test pull-right display-block marlegt5"><i class="fa fa-undo"></i> <?php echo esc_html_e( 'Back','contact' ); ?></a>
             
              </div>
              </div>
            <div class="panel-body">
              <h4 class="message_subject"><?php echo esc_html( $messageById['subject'],'contact' ); ?></h4>
              <div class="messagess-details">
                <p><strong><?php echo esc_html( $messageById['sender_name'],'contact' ); ?></strong> < <?php echo esc_html( $messageById['email'],'contact' ); ?> ></p>
                <div class="message_details_popup">
                  <small class="font-medium-xs small_details"><?php esc_html_e( 'to me', 'contact' ) ?> <i class="fa fa-caret-down" aria-hidden="true"></i></small>
                  <ul class="small_detail_hide sent_details">
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
                  </ul>
                  </div>
                  <hr>
                  <?php echo $messageById['message']; ?>
              </div>
            </div>
              <div class="panel-body">
                <div class="_buttons">
                   <a href="javascript:void(0)" data-id="<?php echo $messageById['msg_id']; ?>" data-nonce="<?php echo wp_create_nonce('delete_contact_nonce') ?>" class="btn btn-danger mright5 test pull-left display-block message_delete_single"><i class="fa fa-trash"></i> <?php echo esc_html_e( 'Delete','contact' ); ?></a>
                    <a href="admin.php?page=rscf-reply&id=<?php echo $messageById['msg_id']; ?>" class="btn btn-info mright5 test pull-right display-block"><i class="fa fa-reply"></i> <?php echo esc_html_e( 'Reply','contact' ); ?></a>
                </div>
              </div>
            </div>