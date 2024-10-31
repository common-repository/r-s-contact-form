<?php
/**
 * @package  contactFormPlugin
 */

namespace Inc\Api\Callbacks;

class MessageCallbacks {

	
	public function rscf_smtpSanitize( $input )
	{
		$output = get_option('russell_smtp');

		if ( isset($_POST["remove"]) ) {
			unset($output[sanitize_text_field($_POST["remove"])]);

			return $output;
		}

		if ( count($output) == 0 ) {
			$output['russell_smtp'] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ('russell_smtp' === $key) {
				$output[$key] = $input;
			} else {
				$output['russell_smtp'] = $input;
			}
		}
		
		return $output;
	}
	public function rscf_message_sanitize_custom_css( $inputs ){
		$output = esc_textarea( $inputs );
		return $inputs;
	}
	
	public function rscf_optionField( $args ) {
		switch ($args['input_type']) {
			case 'text':
				$name        = esc_html($args['label_for']);
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
		    	$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><input type="text" class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" value="' . sanitize_text_field($value) . '" placeholder="' . sanitize_text_field($args['placeholder']) . '"></div>';
				break;
				case 'number':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
		    	$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><input type="number" class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" value="' . sanitize_text_field($value) . '" placeholder="' . sanitize_text_field($args['placeholder']) . '"></div>';
				break;
				case 'email':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><input type="email" class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" value="' . sanitize_email($value) . '" placeholder="' . sanitize_text_field($args['placeholder']) . '"></div>';
				break;
			case 'password':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><input oncontextmenu="return false;" type="password" class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" value="' . sanitize_text_field($value) . '" placeholder="' . sanitize_text_field($args['placeholder']) . '"></div>';
				break;
			case 'checkbox':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				$checked = isset($value) ? ($value ? true : false) : false;
				echo '<div class="form-group">
				<div class="onoffswitch">
		            <input type="' . $args['input_type'] . '" id="' . sanitize_title($name) . '" class="onoffswitch-checkbox" value="1" name="' . $option_name . '[' . sanitize_text_field($name) . ']" style="display:none;" ' . ( $checked ? 'checked' : '') . '>
		            <label class="onoffswitch-label" for="' . $name . '" data-toggle="tooltip" title="Check this option to turn on the smtp auth."></label>
		        </div></div>';
				break;
			case 'select':
			$html = '';
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();

				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}
				$select_option        = $args['select_option'];
				
				$html .= '<div class="form-group">';
				$html .= '<select class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']">';
				foreach( $select_option as $s_key => $s_value ) {
				$selected = '';
                    if ( $value === $s_key ) {
                      $selected = 'selected';
                    } 
					$html .= '<option value="'. $s_key.'" '.$selected.'>'.$s_value.'</option>';
				}

				$html .= '</select></div>';
				echo $html;
				break;
			case 'switch':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				$checked = isset($value) ? ($value ? true : false) : false;
				echo '<div class="form-group">
				<div class="onoffswitch">
		            <input type="checkbox" id="' . sanitize_title($name) . '" class="onoffswitch-checkbox" value="1" name="' . $option_name . '[' . sanitize_text_field($name) . ']" style="display:none;" ' . ( $checked ? 'checked' : '') . '>
		            <label class="onoffswitch-label" for="' . $name . '" data-toggle="tooltip" title="Check this option to turn on the smtp auth."></label>
		        </div></div>';
				break;
			
			case 'textarea':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><textarea class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" value="' . sanitize_text_field($value) . '" placeholder="' . sanitize_text_field($args['placeholder']) . '"></textarea></div>';
				break;
			case 'textarea_header':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><textarea class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" placeholder="' . sanitize_text_field($args['placeholder']) . '">'.$value.'</textarea></div>';
				break;
			case 'textarea_footer':
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><textarea class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" placeholder="' . sanitize_text_field($args['placeholder']) . '">'.$value.'</textarea></div>';
				break;
			default:
				$name        = $args['label_for'];
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$smtps  = get_option( 'russell_smtp' ) ?: array();
				$data = isset($smtps[1][$name]) ? $smtps[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><input type="' . $args['input_type'] . '" class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" value="' . sanitize_text_field($value) . '" placeholder="' . sanitize_text_field($args['placeholder']) . '"></div>';
				break;
		}
	}
}