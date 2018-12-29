<h2>Saucy Followers Details</h2>

<table class="form-table">
	<tbody>
		<tr>
			<th>
				<label for="pass1-text">Following</label>
			</th>
			<td>
				<?php 
				
		$author_id = $_GET['user_id'];

		$following_ids = fdfp_get_following( $author_id );
		$following_listing_str = '<ul class="fdfp-author-list fdfp-author-following-list">';

		if ( ! empty( $following_ids ) ) {
			foreach ($following_ids as $following_id) {
				$following_email = get_the_author_meta( 'user_email', $following_id );
				$following_avatar_url = get_avatar_url( $following_email );
				$following_url = get_author_posts_url( $following_id );
				$following_name = get_the_author_meta( 'display_name', $following_id );
				$following_description = get_the_author_meta( 'description', $following_id );

				$following_listing_str .= '<li class="col-xs-12"><div class="fdfp-author-list-inner-row row">';
				$following_listing_str .= '<div class="col-xs-3 padding-left-0"><img src="' . $following_avatar_url . '" class="avatar-img"></div>';
				$following_listing_str .= '<div class="col-xs-9 padding-left-0"><a href="' . $following_url . '" class="h3 author-title">' . $following_name . '</a><p>' . $following_description . '</p></div>';
				$following_listing_str .= '</div></li>';
			}
		}

		$following_listing_str .= "</ul>";
		echo $following_listing_str;

				 ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="pass1-text">Followers</label>
			</th>
			<td>
			</td>
		</tr>
	</tbody>
</table>	