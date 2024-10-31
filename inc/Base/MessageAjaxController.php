<?php 

/**
 * @package  contactFormPlugin
 */
namespace Inc\Base;

class MessageAjaxController
{

    public function rscf_register() {
	
			add_action( 'wp_ajax_rscf_message_action', array( $this, 'rscf_message_handler' ) );
			add_action( 'wp_ajax_of_ajax_post_action', array( $this, 'rscf_message_of_ajax_callback' ) );
			add_action( 'wp_ajax_of_ajax_bulk_action', array( $this, 'rscf_message_bulk_of_ajax_callback' ) );
	
	}
	
	function rscf_message_handler() {
		global $wpdb;
		$getParam = isset( $_REQUEST['param'] ) ? $_REQUEST['param'] : '';
		if(!empty( sanitize_text_field($getParam) )){
			if ( sanitize_text_field($_REQUEST['param']) == "view_message" ) {
					$view_message  = $wpdb->update( rscf_message_posts_table(), array(
						"post_excerpt"        => 'view_message'
					), array(
						"ID" => intval($_REQUEST['id']),
					) );
					
				}elseif(sanitize_text_field($_REQUEST['param']) == "reply_view"){
					$view_message  = $wpdb->update( rscf_message_posts_table(), array(
						"post_excerpt"        => 'view_message'
					), array(
						"ID" => intval($_REQUEST['id']),
					) );
				}elseif(sanitize_text_field($_REQUEST['param']) == "spam_msg"){
					 $permission = check_ajax_referer( 'spam_contact_nonce', 'nonce', false );
					if( $permission == false ) {
					        echo json_encode( array( "status" => -1, "msg" => "Something wrong, try again!" ) );
					    }else{
					$view_message  = $wpdb->update( rscf_message_posts_table(), array(
						"post_status"        => 'inbox_spam'
					), array(
						"ID" => intval($_REQUEST['id']),
					) );
					echo json_encode( array( "status" => 1, "msg" => "Conversation marked as spam." ) );
				}
				}elseif(sanitize_text_field(sanitize_text_field($_REQUEST['param'])) == "trash_msg"){
					 $permission = check_ajax_referer( 'trash_contact_nonce', 'nonce', false );
					if( $permission == false ) {
					        echo json_encode( array( "status" => -1, "msg" => "Something wrong, try again!" ) );
					    }else{
					$view_message  = $wpdb->update( rscf_message_posts_table(), array(
						"post_status"        => 'inbox_trash'
					), array(
						"ID" => intval($_REQUEST['id']),
					) );
					echo json_encode( array( "status" => 1, "msg" => "Conversation moved to Trash." ) );
				}
				}elseif(sanitize_text_field($_REQUEST['param']) == "move_inbox_msg"){
					 $permission = check_ajax_referer( 'inbox_contact_nonce', 'nonce', false );
					if( $permission == false ) {
					        echo json_encode( array( "status" => -1, "msg" => "Something wrong, try again!" ) );
					    }else{
					$view_message  = $wpdb->update( rscf_message_posts_table(), array(
						"post_status"        => 'inbox'
					), array(
						"ID" => intval($_REQUEST['id']),
					) );
					echo json_encode( array( "status" => 1, "msg" => "Conversation move to inbox." ) );
				}
				}elseif(sanitize_text_field($_REQUEST['param']) == "delete_msg"){
					 $permission = check_ajax_referer( 'delete_contact_nonce', 'nonce', false );
					if( $permission == false ) {
					        echo json_encode( array( "status" => -1, "msg" => "Something wrong, try again!" ) );
					    }else{
							$delete = $wpdb->delete( rscf_message_posts_table(), array(
								"ID" => intval($_REQUEST['id']),
							) );
							if ( $delete ) {
								$wpdb->delete( rscf_message_meta_table(), array(
									"post_id" => intval($_REQUEST['id']),
								) );
							}
						echo json_encode( array( "status" => 1, "msg" => "Conversation deleted forever." ) );
					}
					die();
				}elseif(sanitize_text_field($_POST['param']) == "message_reply"){	
					$smtp_secure = rscf_message_smtp_data('smtp_secure');
					$smtp_host = rscf_message_smtp_data('smtp_host');
					$smtp_port = rscf_message_smtp_data('smtp_port');
					$smtp_email = rscf_message_smtp_data('smtp_email');
					$smtp_fromname = rscf_message_smtp_data('smtp_fromname');
					$smtp_auth = rscf_message_smtp_data('smtp_auth');
					$smtp_username = rscf_message_smtp_data('smtp_username');
					$smtp_password = rscf_message_smtp_data('smtp_password');
					$smtp_charset = rscf_message_smtp_data('smtp_charset');
					$smtp_predefined_header = rscf_message_smtp_data('smtp_predefined_header');
					$smtp_predefined_footer = rscf_message_smtp_data('smtp_predefined_footer');
					if ($smtp_host == '' || $smtp_secure == '' || $smtp_port == '' || $smtp_email == '' || $smtp_fromname == '' || $smtp_auth == '' || $smtp_username == '' || $smtp_password == '' || $smtp_charset == '' || $smtp_predefined_header == '' || $smtp_predefined_footer == '' ) {
						echo json_encode( array( "status" => 3, "error" => "Please Configure SMTP settings!" ) );
					}else{
					$reply_name         = sanitize_text_field( $_POST['reply_name'] );
					$reply_email        = sanitize_email( $_POST['reply_email'] );
					$reply_sebject      = sanitize_text_field( $_POST['reply_sebject'] );
					$reply_message      = sanitize_text_field( $_POST['reply_message'] );

					$args = array(
				      'post_title' => $reply_name,
				      'post_content' => $reply_message,
				      'post_author' => 1,
				      'post_excerpt' => $reply_sebject,
				      'post_status' => 'rscf-sent',
				      'post_type' => 'russell-contact',
				      'meta_input' => array(
				        '_contact_email_value_key' => $reply_email,
				        '_contact_subject_value_key' => $reply_sebject,
				      ),
				    );
					$body = '<p>Thank you for registering.</p>';
				    $postID = wp_insert_post($args);
				   
					if ( $postID !== 0 ) {
						echo json_encode( array( "status" => 1, "msg" => "Message Sent." ) );
						
						$to =  $reply_email;
                        $subject = $reply_sebject;
                
                        $headers[] = 'From: ' . ucfirst(get_bloginfo('name')) . ' <' . rscf_message_smtp_data('smtp_email') . '>'; // 'From: R S RUSSELL <abusayedrussell@gmail.com>'
                        $headers[] = 'Reply-To: ' . $reply_name . ' <' . $reply_email . '>';
                        $headers[] = 'Content-Type: text/html: charset=UTF-8';
                
                        wp_mail($to, $subject, $reply_message, $headers);
					} else {
						echo json_encode( array( "status" => 2, "error" => "Something wrong, try again!" ) );
					}
				}
				}elseif(sanitize_text_field($_POST['param']) == "compose_send"){
					$smtp_secure = rscf_message_smtp_data('smtp_secure');
					$smtp_host = rscf_message_smtp_data('smtp_host');
					$smtp_port = rscf_message_smtp_data('smtp_port');
					$smtp_email = rscf_message_smtp_data('smtp_email');
					$smtp_fromname = rscf_message_smtp_data('smtp_fromname');
					$smtp_auth = rscf_message_smtp_data('smtp_auth');
					$smtp_username = rscf_message_smtp_data('smtp_username');
					$smtp_password = rscf_message_smtp_data('smtp_password');
					$smtp_charset = rscf_message_smtp_data('smtp_charset');
					$smtp_predefined_header = rscf_message_smtp_data('smtp_predefined_header');
					$smtp_predefined_footer = rscf_message_smtp_data('smtp_predefined_footer');
					if ($smtp_host == '' || $smtp_secure == '' || $smtp_port == '' || $smtp_email == '' || $smtp_fromname == '' || $smtp_auth == '' || $smtp_username == '' || $smtp_password == '' || $smtp_charset == '' || $smtp_predefined_header == '' || $smtp_predefined_footer == '' ) {
						echo json_encode( array( "status" => 3, "error" => "Please Configure SMTP settings!" ) );
					}else{
					$compose_recipient    = sanitize_email( $_POST['compose_recipient'] );
					$compose_subject      = sanitize_text_field( $_POST['compose_subject'] );
					$compose_message      = sanitize_text_field( $_POST['compose_message'] );

					$args = array(
				      'post_title' => 'Sent',
				      'post_content' => $compose_message,
				      'post_author' => get_current_user_id(),
				      'post_status' => 'rscf-sent',
				      'post_type' => 'russell-contact',
				      'meta_input' => array(
				        '_contact_email_value_key' => $compose_recipient,
				        '_contact_subject_value_key' => $compose_subject,
				      ), 
				    );
				    $postID = wp_insert_post($args);
				   
					if ( $postID !== 0 ) {
						echo json_encode( array( "status" => 1, "msg" => "Message Sent." ) );
						
						$to =  $compose_recipient;
                        $subject = $compose_subject;
                        $charset = rscf_message_smtp_data('smtp_charset');
                        $smtp_predefined_header = rscf_message_smtp_data('smtp_predefined_header');
                        $smtp_predefined_footer = rscf_message_smtp_data('smtp_predefined_footer');

						$body = $smtp_predefined_header.$compose_message.$smtp_predefined_footer;
                        $headers[] = 'From: ' . ucfirst(get_bloginfo('name')) . ' <' . rscf_message_smtp_data('smtp_email') . '>'; // 'From: R S RUSSELL <abusayedrussell@gmail.com>'
                        $headers[] = 'Reply-To: ' . rscf_message_smtp_data('smtp_email') . ' <' . $reply_email . '>';
                        $headers[] = 'Content-Type: text/html: charset='.$charset.'';
                        $headers[] = 'Bcc: '.rscf_message_smtp_data('smtp_bcc_email') ;
                
                        wp_mail($to, $subject, $body, $headers);
					} else {
						echo json_encode( array( "status" => 2, "error" => "Something wrong, try again!" ) );
					}
					
				}
			}
		}

		wp_die();
	}
	

private function rscf_message_smtp_option($data, $key = null) {
	global $contact_data;
	if (empty($data))
	return;

	if ($key != null) { 
		update_option('russell_smtp',array($key, $data));
	} else { 
		foreach ( $data as $k=>$v ) {
			if (!isset($contact_data[$k]) || $contact_data[$k] != $v) {
				update_option('russell_smtp',array($k, $v));
			} else if (is_array($v)) {
				foreach ($v as $key=>$val) {
					if ($key != $k && $v[$key] == $val) {
					update_option('russell_smtp',array($k, $v));
					break;
					}
				}
			}
		}
	}
}
private function rscf_message_process_option($data, $key = null) {
	global $contact_data;
	if (empty($data))
	return;

	if ($key != null) { 
		update_option('russell_process',array($key, $data));
	} else { 
		foreach ( $data as $k=>$v ) {
			if (!isset($contact_data[$k]) || $contact_data[$k] != $v) {
				update_option('russell_process',array($k, $v));
			} else if (is_array($v)) {
				foreach ($v as $key=>$val) {
					if ($key != $k && $v[$key] == $val) {
					update_option('russell_process',array($k, $v));
					break;
					}
				}
			}
		}
	}
}
private function rscf_message_design_option($data, $key = null) {
	global $contact_data;
	if (empty($data))
	return;

	if ($key != null) { 
		update_option('russell_design',array($key, $data));
	} else { 
		foreach ( $data as $k=>$v ) {
			if (!isset($contact_data[$k]) || $contact_data[$k] != $v) {
				update_option('russell_design',array($k, $v));
			} else if (is_array($v)) {
				foreach ($v as $key=>$val) {
					if ($key != $k && $v[$key] == $val) {
					update_option('russell_design',array($k, $v));
					break;
					}
				}
			}
		}
	}
}
	public function rscf_message_of_ajax_callback()
	{
	
		$nonce= sanitize_text_field($_POST['security']);
		if (! wp_verify_nonce($nonce, 'of_ajax_nonce') ) die('-1');
		$save_type = $_POST['type'];

		if ($save_type == 'save_admin_mail')
		{
			wp_parse_str($_POST['data'], $contact_data);
			unset($contact_data['security']);
			self::rscf_message_smtp_option($contact_data);
			die('1');
		}elseif ($save_type == 'save_admin_process')
		{
			wp_parse_str($_POST['data'], $contact_data);
			unset($contact_data['security']);
			self::rscf_message_process_option($contact_data);
			die('1');
		}elseif ($save_type == 'save_admin_front_style')
		{
			wp_parse_str($_POST['data'], $contact_data);
			unset($contact_data['security']);
			self::rscf_message_design_option($contact_data);
			die('1');
		}

		die();
	}
	public function rscf_message_bulk_of_ajax_callback()
	{
	
		$nonce= sanitize_text_field($_POST['security']);
		if (! wp_verify_nonce($nonce, 'bulk_move') ) die('-1');
		$save_type = $_POST['type'];
		if ($save_type == 'bulk_inbox_action')
		{
			global $wpdb;
			$dataArray = stripslashes_deep($_POST['data']);
			foreach($dataArray as $valArray){
				foreach ($valArray as $id) {
					$wpdb->update( 
					rscf_message_posts_table(), 
					array('post_status' => 'inbox'), 
					array( 'ID' => esc_attr($id) ), 
					array('%s'), 
					array('%d') 
				);
				}
			}
			die('1');
		}elseif ($save_type == 'bulk_spam_action')
		{
			global $wpdb;
			$dataArray = stripslashes_deep($_POST['data']);
			foreach($dataArray as $valArray){
				foreach ($valArray as $id) {
					$wpdb->update( 
					rscf_message_posts_table(), 
					array('post_status' => 'inbox_spam'), 
					array( 'ID' => $id ), 
					array('%s'), 
					array('%d') 
				);
				}
			}
			die('1');
		}elseif ($save_type == 'bulk_trash_action')
		{
			global $wpdb;
			$dataArray = stripslashes_deep($_POST['data']);
			foreach($dataArray as $valArray){
				foreach ($valArray as $id) {
					$wpdb->update( 
					rscf_message_posts_table(), 
					array('post_status' => 'inbox_trash'), 
					array( 'ID' => esc_attr($id) ), 
					array('%s'), 
					array('%d') 
				);
				}
			}
			die('1');
		}elseif ($save_type == 'bulk_permanent_del_action')
		{
			global $wpdb;
			$dataArray = stripslashes_deep($_POST['data']);
			foreach($dataArray as $valArray){
				foreach ($valArray as $id) {
				$delete = $wpdb->delete( rscf_message_posts_table(), array(
					"ID" => esc_attr($id),
				) );
				if ( $delete ) {
					$wpdb->delete( rscf_message_meta_table(), array(
						"post_id" => esc_attr($id),
					) );
				}

				}
			}
			die('1');
		}

		die();
	}
}