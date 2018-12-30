<?php

/**
 * Fired during plugin activation
 *
 * @link       https://mydigitalsauce.com/
 * @since      0.1.0
 *
 * @package    Saucy_Followers
 * @subpackage Saucy_Followers/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Saucy_Followers
 * @subpackage Saucy_Followers/includes
 * @author     MyDigitalSauce <justin@mydigitalsauce.com>
 */
class Saucy_Followers_Activator {
	
	public static function activate() {

		// On Activate
		// Update options table with settings
	  $email_notif_settings = array(
	    'on_publish' => "1",
	    'on_comment' => "1",
	    'on_follow' => "1",
	    'on_unfollow' => "1",
	  );
	  update_option( '_fdfp_email_notif_settings', json_encode( $email_notif_settings ) );

	  $email_template_settings = array(
	    'from_name' => get_bloginfo('name'),
	    'from_email' => get_bloginfo('admin_email'),
	    'logo' => '',
	    'primary_color' => '',
	  );
	  update_option( '_fdfp_email_template_settings', json_encode( $email_template_settings ) );

	}

}
