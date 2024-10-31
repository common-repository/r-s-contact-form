<?php
/**
 * @package  contactFormPlugin
 */

namespace Inc\Api\Callbacks;

class MessageDesignCallbacks {

	
	public function rscf_designSanitize( $input )
	{
		$output = get_option('russell_design');

		if ( isset($_POST["remove"]) ) {
			unset($output[sanitize_text_field($_POST["remove"])]);

			return $output;
		}

		if ( count($output) == 0 ) {
			$output['contact_design'] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {
			if ('contact_design' === $key) {
				$output[$key] = $input;
			} else {
				$output['contact_design'] = $input;
			}
		}
		
		return $output;
	}

	public function rscf_message_sanitize_custom_css( $input ){
		$output = esc_textarea( $input );
		return $input;
	}
	
	public function rscf_optionField( $args ) {
		switch ($args['input_type']) {
			case 'custom_css':
			$name        = esc_html($args['label_for']);
			$default        = esc_html($args['default']);
			$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$design_options  = get_option( 'russell_design' ) ?: array();
				$data = isset($design_options[1][$name]) ? $design_options[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}
				$css = ( empty($data) ? '/* Contact Form Custom CSS */' : $data );
			echo '<div class="form-group"><textarea class="regular-text" id="contact_css_code" name="' . $option_name . '[' . sanitize_text_field($name) . ']"  placeholder="' . sanitize_text_field($args['placeholder']) . '">'.sanitize_text_field($css).'</textarea></div>';
			break;
			case 'custom_js':
			$name        = esc_html($args['label_for']);
			$default        = esc_html($args['default']);
			$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$design_options  = get_option( 'russell_design' ) ?: array();
				$data = isset($design_options[1][$name]) ? $design_options[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}
				$js = ( empty($data) ? '/* Contact Form Custom JS */' : $data );
			echo '<div class="form-group"><textarea class="regular-text" id="contact_js_code" name="' . $option_name . '[' . sanitize_text_field($name) . ']"  placeholder="' . sanitize_text_field($args['placeholder']) . '">'.sanitize_text_field($js).'</textarea></div>';
			break;
			default:
				$name        = esc_html($args['label_for']);
				$default        = esc_html($args['default']);
				$default_val = ( empty($default) ? '' : $default );
				$option_name = esc_html($args['option_name']);
				$value       = '';
				$design_options  = get_option( 'russell_design' ) ?: array();
				$data = isset($design_options[1][$name]) ? $design_options[1][$name]: "";
				if (isset($data) && !empty($data)) {
					$value = $data;
				}else{
					$value       = $default_val;
				}

				echo '<div class="form-group"><input type="' . $args['input_type'] . '" class="regular-text form-control" id="' . sanitize_title($name) . '" name="' . $option_name . '[' . sanitize_text_field($name) . ']" value="' . $value . '" placeholder="' . sanitize_text_field($args['placeholder']) . '"></div>';
				break;
		}
	}
}