<?php
/**
 * @package  contactFormPlugin
 */
namespace Inc\Base;

class MessageDeactivate
{
	public static function rscf_deactivate_message() {
		flush_rewrite_rules();
	}
}