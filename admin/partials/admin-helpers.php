<?php

// delete sync-user-success-logs.txt & sync-user-error-logs.txt
function fdfp_admin_delete_log_directory() {

  $return_this = false;
  $upload_dir = wp_upload_dir()['basedir'] . '/saucy_followers_logs';
  $return_this = fdfp_admin_delete_directory( $upload_dir );

	return $return_this;

}

function fdfp_admin_delete_directory( $dirname ) {
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
     if (!$dir_handle)
          return false;
     while($file = readdir($dir_handle)) {
           if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                     unlink($dirname."/".$file);
                else
                     delete_directory($dirname.'/'.$file);
           }
     }
     closedir($dir_handle);
     rmdir($dirname);
     return true;
}

// Example: fdfp_admin_log_message( 'activity-item-import.txt', $message )
function fdfp_admin_log_message( $filename, $message ) {
      
  $upload_dir = wp_upload_dir()['basedir'] . '/saucy_followers_logs';
  if ( ! is_dir($upload_dir) ) {
     mkdir( $upload_dir, 0700 );
  }
  fopen( $filename, "w" );
  $data = "\n"; 
  $data .= "$message | " . date("Y-m-d H:i:s") . " \n";
  file_put_contents( $upload_dir . "/" . $filename, $data, FILE_APPEND );

}

/**
 * @return string
 */
function fdfp_get_notif_view_more_link($user_id) {

  // Current User 
  $user_info = get_userdata($user_id);
  return get_site_url() . "/?author=" . $user_id;

}

function fdfp_send_notif_email( $to, $to_name, $subject, $message, $view_more_link ) {

  // To Get Company Logo
  $email_template_settings = json_decode( get_option( 'email_template_settings' ) );
  // Logo
  $logo = ( ! empty($email_template_settings->logo) ) ? "<img src=" . $email_template_settings->logo . " height='100px'>" : get_blofindo("name");
  // Primary Color
  $primary_color = ( ! empty($email_template_settings->primary_color) ) ? $email_template_settings->primary_color : '#000000';

  // Get The Template 
  $body = file_get_contents( plugin_dir_path( __FILE__ ) . '../../includes/emails/notification-template.html', true );
  
  // Body And Header Of mail
  $body = str_replace('[NameGoesHere]', $to_name, $body);
  $body = str_replace('[MessageGoesHere]', $message, $body);
  $body = str_replace('[WebSiteUrl]', get_site_url(), $body);
  $body = str_replace('[CompanyLogoHere]', $logo, $body);
  $body = str_replace('[LinkGoesHere]', $view_more_link, $body);
  $body = str_replace('[PrimaryColor]', $primary_color, $body);

  // Set the value of FROM in header from admin panel
  $from_name = get_bloginfo("name");
  if( ! empty($email_template_settings->from_name) && $email_template_settings->from_name !== "" ){
    $from_name = $email_template_settings->from_name;
  }

  // set email
  $from_email = get_bloginfo("admin_email");
  if( ! empty($email_template_settings->from_email) && $email_template_settings->from_email !== "" ) {
    $from_email = $email_template_settings->from_email;
  }
  
  $headers = "From: $from_name <$from_email>" . "\r\n";

  // Mail Function
  $sent = wp_mail( $to, $subject, $body, $headers );

  $log_msg = "Subject: $subject | To: $to | ";
  if ( $sent ) {
    fdfp_admin_log_message( 'notification-email.txt', $log_msg . "Sent successfully" );
  } else {
    fdfp_admin_log_message( 'notification-email.txt', $log_msg . "Sent un-successfully"  );    
  }

  return true;

}