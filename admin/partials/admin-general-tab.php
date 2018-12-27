<?php
/*
 * This file creates the page:
 * /options-general.php?page=saucy-followers&tab=general
 *
*/

$success_msg = "";

if ( isset( $_POST['action'] ) && $_POST['action'] === 'update_email_notif_settings' ) {
  $email_notif_settings = array(
    'on_publish' => ( isset($_POST['email_notif_on_publish'])  ) ? $_POST['email_notif_on_publish'] :  null,
    'on_comment' => ( isset($_POST['email_notif_on_comment']) ) ? $_POST['email_notif_on_comment'] : null,
    'on_follow' => ( isset($_POST['email_notif_on_follow']) ) ? $_POST['email_notif_on_follow'] : null,
    'on_unfollow' => ( isset($_POST['email_notif_on_unfollow']) ) ? $_POST['email_notif_on_unfollow'] : null,
  );
  update_option( 'email_notif_settings', json_encode( $email_notif_settings ) );
  $success_msg = __( 'Email Notification Settings Updated.' );
}

if ( isset( $_POST['action'] ) && $_POST['action'] === 'update_email_template_settings' ) {
  $email_template_settings = array(
    'logo' => $_POST['email_template_logo'],
    'from_name' => $_POST['email_template_from_name'],
    'from_email' => $_POST['email_template_from_email'],
    'primary_color' => $_POST['email_template_primary_color'],
  );
  update_option( 'email_template_settings', json_encode( $email_template_settings ) );

  $success_msg = __( 'Email Template Settings Updated.' );
}

if ( ! empty( $success_msg ) ) { ?>
  <div class="notice notice-success is-dismissible">
      <p><?php echo $success_msg; ?></p>
  </div>
<?php } ?>


<h3>General Settings</h3>
<p>General settings go here</p>

<h3>Email Notification Settings</h3>

<form method="post" action="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=saucy-followers&tab=general" >
	
  <?php $email_notif_settings = json_decode( get_option( 'email_notif_settings' ) ); ?>

	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="email_notif_on_publish" >Enable</label></th>
				<td>
					<input type="checkbox" id="email_notif_on_publish" name="email_notif_on_publish" value="1" <?php echo ( $email_notif_settings->on_publish ) ? 'checked': ''; ?> /> On publish post notify author's followers.
				</td>
			</tr>
			<!-- <tr>
				<th><label for="email_notif_on_comment" >Enable</label></th>
				<td>
			    <input type="checkbox" id="email_notif_on_comment" name="email_notif_on_comment" value="1" <?php echo ( $email_notif_settings->on_comment ) ? 'checked': ''; ?> /> On comment notify author's followers.
			  </td>
			</tr> -->
			<tr>
				<th><label for="email_notif_on_follow" >Enable</label></th>
				<td>
			    <input type="checkbox" id="email_notif_on_follow" name="email_notif_on_follow" value="1" <?php echo ( $email_notif_settings->on_follow ) ? 'checked': ''; ?> /> On follow notify user being followed.
			  </td>
			</tr>
			<tr>
				<th><label for="email_notif_on_unfollow" >Enable</label></th>
				<td>
			    <input type="checkbox" id="email_notif_on_unfollow" name="email_notif_on_unfollow" value="1" <?php echo ( $email_notif_settings->on_unfollow ) ? 'checked': ''; ?> /> On unfollow notify user being unfollowed.
			  </td>
			</tr>
		</tbody>
	</table>

	<button type="submit" name="action" value="update_email_notif_settings" class="button button-primary" >Save Changes</button>
	
</form>

<br/>
<hr/>

<h3>Email Template Settings</h3>

<form method="post" action="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=saucy-followers&tab=general" > 
  <?php
  $email_template_settings = json_decode( get_option( 'email_template_settings' ) );
  ?>

	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="email_template_from_name" >From Name:</label></th>
				<td>
					<input type="text" id="email_template_from_name" name="email_template_from_name" value="<?php echo $email_template_settings->from_name; ?>" />
				</td>
			</tr>
			<tr>
				<th><label for="email_template_from_email" >From Email:</label></th>
				<td>
			    <input type="email" id="email_template_from_email" name="email_template_from_email" value="<?php echo $email_template_settings->from_email; ?>" />     
			  </td>
			</tr>
			<tr>
				<th><label for="email_template_logo" >Logo:</label></th>
				<td>
					<input type="text" id="email_template_logo" name="email_template_logo" value="<?php echo $email_template_settings->logo; ?>" />
				</td>
			</tr>
			<tr>
				<th><label>Primary Color:</label></th>
				<td>
					<input class="color-field" type="text" name="email_template_primary_color" value="<?php echo $email_template_settings->primary_color; ?>" />
				</td>
			</tr>
		</tbody>
	</table>

	<button type="submit" name="action" value="update_email_template_settings" class="button button-primary" >Save Changes</button>
	
</form>

<h3>Email Template</h3>
	
<a href="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=saucy-followers&tab=email-template" class="button button-default" id="showEmailTemplateButton">View Email Template</a>



