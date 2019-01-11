<?php
/**
 * Ajax Actions
 *
 * @package     French Dip Following Plugin
 * @subpackage  Ajax Actions
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/
/**
 * Processes the ajax request to follow a user
 *
 * @access      private
 * @since       1.0
 * @return      void
 */
function fdfp_process_new_follow() {
	if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
		if( fdfp_follow_user( absint( $_POST['user_id'] ), absint( $_POST['follow_id'] ) ) ) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
	die();
}
add_action('wp_ajax_follow', 'fdfp_process_new_follow');
/**
 * Processes the ajax request to unfollow a user
 *
 * @access      private
 * @since       1.0
 * @return      void
 */
function fdfp_process_unfollow() {
	if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
		if( fdfp_unfollow_user( absint( $_POST['user_id'] ), absint( $_POST['follow_id'] ) ) ) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
	die();
}
add_action('wp_ajax_unfollow', 'fdfp_process_unfollow');

/**
 * On publish post email notification to author's (user's) followers.
 *
 * @access      private
 * @since       1.0
 * @return      void
 */
function fdfp_post_published_notification( $post_id, $post ) {
								
	$email_notif_settings = json_decode( get_option( '_fdfp_email_notif_settings' ) );
	if ( ! $email_notif_settings->on_publish ) {
		return false;
	}
	/* Post author ID. */
	$author = $post->post_author; 
	
	/* Post author Follower List. */
	$followers_list = get_user_meta( $author, '_fdfp_followers', true );
	
	/* Post author Name. */
	$name = get_the_author_meta( 'display_name', $author );
	
	/* Post Title. */
	$title = $post->post_title;
	// Mail Information
	$subject = sprintf( 'New Post: %s', $title );	
	// Message To print In Template
	$message = "Author $name has been published a new $post->post_type titled $title.";
	
	// Post Link
	$permalink = get_permalink( $post_id );				
	foreach( $followers_list as $follower ) {
		// Get Information of follower
		$to_user_info = get_userdata($follower);
		
		// Mail Function
		fdfp_send_notif_email( $to_user_info->user_email, $to_user_info->display_name, $subject, $message, $permalink );
	}
}
add_action( 'publish_post', 'fdfp_post_published_notification', 10, 2 );
/**
 * Email notification to author on post comment approved
 *
 * @access      private
 * @since       1.0
 * @return      void
 */
//Check Comment Approve 
add_action('transition_comment_status', 'fdfp_my_approve_comment_callback', 10, 3);
function fdfp_my_approve_comment_callback($new_status, $old_status, $comment) {
    if($old_status != $new_status) {
        if($new_status == 'approved') {
            
            // Site Url 	
    		$site_url = get_site_url();	
    		
            //Comment ID
            $comment_id = $comment->comment_ID;
    
    		// Get the Post
    		$post = get_post($comment_id);
    
    		// To Get Company Logo
		    $email_template_settings = json_decode( get_option( '_fdfp_email_template_settings' ) );
    		// Logo
		    $logo = ( ! empty($email_template_settings->logo) ) ? '<img src="' . $email_template_settings->logo . '" height="100px" />' : get_bloginfo( 'name' );
      		// Get The Template 
            $body = file_get_contents(plugin_dir_path( __FILE__ ) . '../emails/notification-template.html',true);
            // Message To print In Template
            $message = "Your friend " . get_comment_author($comment_id) . " commented on a " . $post->post_type . " titled " . $post->post_title . ".";
            // Post Link
            $permalink = get_comment_link( $comment_id );
             // Primary Color
            $primary_color = ( ! empty($email_template_settings->primary_color) ) ? $email_template_settings->primary_color : '#000000';
    		
    		
    		 // Set the value of FROM in header from admin panel
    		 $from_name = "";
    		 // set name 
    		 if(!empty($email_notif_settings->from_name)){
    			 $from_name .= $email_notif_settings->from_name;
    		 }
     
    		 // set email
    		 if(!empty($email_notif_settings->from_email)){
    			 $from_name .= " <".$email_notif_settings->from_email.">";
    		 }
     
    		 // If both the value of admin panel is empty
    		 if(empty($from_name)){
    			 $from_name = "My Digital Sauce <example@example.com>";
    		 }
     
    	    $message_headers = 'Content-Type: text/html; charset=UTF-8;From: '.$from_name;
                
                
            // Get Comment Author
            $author = get_comment($comment->comment_ID);
            
            /* Post author Follower List. */
            $followers_list = get_user_meta( $author->user_id, '_fdfp_followers', true );
            
            $subject = "Your friend ".get_comment_author($comment_id)." left comment on ".$post->post_type.".";
    
            foreach($followers_list as $follower){
                // Get Information of follower
            	$to_user = get_userdata($follower);
            	
            	// Get Information 
    		    $to_name = $to_user->first_name.' '.$to_user->last_name;
            	
            	// Body And Header Of mail
        		$body = str_replace('[NameGoesHere]', $to_name, $body);
                $body = str_replace('[MessageGoesHere]', $message, $body);
                $body = str_replace('[WebSiteUrl]', get_site_url(), $body);
                $body = str_replace('[CompanyLogoHere]', $logo, $body);
                $body = str_replace('[LinkGoesHere]', $view_more_link, $body);
                $body = str_replace('[PrimaryColor]', $primary_color, $body);
            	
                	
                // Get user Email
            	$to = $to_user->user_email;
            	
            	wp_mail($to,$subject,$body,$message_headers);
            }
            
        }
    }
}
