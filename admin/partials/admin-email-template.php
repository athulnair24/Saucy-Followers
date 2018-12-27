<?php

$email_template_settings = json_decode( get_option( 'email_template_settings' ) );

$email_template_html = file_get_contents(plugin_dir_path( __FILE__ ) . '../../includes/emails/notification-template.html',true);

$user = wp_get_current_user();
$user_name = $user->display_name;
$message = 'This is an example message for Saucy Followers WP Plugin email template.';
$site_url = get_site_url();

// Logo
if ( ! empty($email_template_settings->logo) ){
	$logo = '<img src="' . $email_template_settings->logo . '" height="100px" />';
} else {
	$logo = get_bloginfo( 'name' );
}

// Primary Color
$primary_color = ( ! empty($email_template_settings->primary_color) ) ? $email_template_settings->primary_color : '#000000';

$permalink = $site_url;

$email_template_html = str_replace('[NameGoesHere]', $user_name, $email_template_html);
$email_template_html = str_replace('[MessageGoesHere]', $message, $email_template_html);
$email_template_html = str_replace('[WebSiteUrl]', $site_url, $email_template_html);
$email_template_html = str_replace('[CompanyLogoHere]', $logo, $email_template_html);
$email_template_html = str_replace('[LinkGoesHere]', $permalink, $email_template_html);
$email_template_html = str_replace('[PrimaryColor]', $primary_color, $email_template_html);

echo $email_template_html;

?>

<div style="margin-top:20px">
	<a href="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=saucy-followers&tab=general" class="button button-primary">Back</a>
</div>