<?php

/**
 *
 * @link       https://taylordigital.com
 * @since      0.1.0
 *
 * @package    Saucy_Followers_Shortcodes
 */

/**
 *
 * @package    Saucy_Followers_Shortcodes
 * @author     Taylor Digital <support@taylordigital.com>
 */
class Saucy_Followers_Shortcodes {

	private $plugin_name;
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param    string    $plugin_name   The name of the plugin.
	 * @param    string    $version    		The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'saucy_follow_links', array($this, 'saucy_follow_links_shortcode') );
		add_shortcode( 'saucy_following_count', array($this, 'saucy_following_count_shortcode') );
		add_shortcode( 'saucy_followers_count', array($this, 'saucy_followers_count_shortcode') );
		add_shortcode( 'saucy_following_listing', array($this, 'saucy_following_listing_shortcode') );
		add_shortcode( 'saucy_followers_listing', array($this, 'saucy_followers_listing_shortcode') );
		add_shortcode( 'saucy_activity_feed', array($this, 'saucy_activity_feed_shortcode') );

	}

	/**
	 * Shows the links to follow/unfollow a user
	 */
	public function saucy_follow_links_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'follow_id' => get_the_author_meta( 'ID' )
			),
			$atts, 'follow_links' )
		);

		return fdfp_get_follow_unfollow_links( $follow_id );
	}

	/**
	 * Shows the amount of users the user is following
	 */
	public function saucy_following_count_shortcode( $atts, $content = null ) {
		$author = get_user_by( 'slug', get_query_var( 'author_name' ) );

		$following_count = fdfp_get_following_count( $author->ID );
		$following_str = $following_count.' Following'; 
		return $following_str;
	}

	/**
	* Shows the amount of followers a user has
	 */
	public function saucy_followers_count_shortcode( $atts, $content = null ) {
		$author = get_user_by( 'slug', get_query_var( 'author_name' ) );

		$followers_count = fdfp_get_follower_count( $author->ID );
		$followers_str = ($followers_count == 1 ? $followers_count.' Follower' : $followers_count.' Followers'); 
		return $followers_str;
	}

	/**
	 * Shows the listing of users the user is following
	 */
	public function saucy_following_listing_shortcode( $atts, $content = null ) {
		$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
		$author_id = $author->ID;

		$following_ids = fdfp_get_following( $author_id );
		$following_listing_str = '<ul id="fdfp__following-list-group" class="fdfp__list-group">';

		if ( ! empty( $following_ids ) ) {
			foreach ($following_ids as $following_id) {
				$following_email = get_the_author_meta( 'user_email', $following_id );
				$following_avatar_url = get_avatar_url( $following_email );
				$following_url = get_author_posts_url( $following_id );
				$following_name = get_the_author_meta( 'display_name', $following_id );
				$following_description = get_the_author_meta( 'description', $following_id );

				$following_listing_str .= '<li class="fdfp__list-group__item" >';
					$following_listing_str .= '<div class="list-group__item__row">';
						$following_listing_str .= '<div class="list-group__item__col-auto">';
							$following_listing_str .= '<img src="' . $following_avatar_url . '" class="list-group__item__avatar" alt="' . $following_name . '" >';
						$following_listing_str .= '</div>';
						$following_listing_str .= '<div class="list-group__item__col">';
							$following_listing_str .= '<a href="' . $following_url . '" class="list-group__item__title" title="' . $following_name . '" >' . $following_name . '</a>';
							$following_listing_str .= '<p>' . $following_description . '</p>';
						$following_listing_str .= '</div>';
					$following_listing_str .= '</div>';
				$following_listing_str .= '</li>';
			}
		}

		$following_listing_str .= "</ul>";

		return $following_listing_str;
	}

	/**
	 * Shows the listing of user's followers
	 */
	public function saucy_followers_listing_shortcode( $atts, $content = null ) {
		$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
		$author_id = $author->ID;

		$followers_ids = fdfp_get_followers( $author_id );
		$followers_listing_str = '<ul id="fdfp__followers-list-group" class="fdfp__list-group">';

		if ( ! empty( $followers_ids ) ) {
			foreach ($followers_ids as $follower_id) {
				$follower_email = get_the_author_meta( 'user_email', $follower_id );
				$follower_avatar_url = get_avatar_url( $follower_email );
				$follower_url = get_author_posts_url( $follower_id );
				$follower_name = get_the_author_meta( 'display_name', $follower_id );
				$follower_description = get_the_author_meta( 'description', $follower_id );

				$followers_listing_str .= '<li class="fdfp__list-group__item" >';
					$followers_listing_str .= '<div class="list-group__item__row">';
						$followers_listing_str .= '<div class="list-group__item__col-auto">';
							$followers_listing_str .= '<img src="' . $follower_avatar_url . '" class="list-group__item__avatar" alt="' . $follower_name . '" >';
						$followers_listing_str .= '</div>';
						$followers_listing_str .= '<div class="list-group__item__col">';
							$followers_listing_str .= '<a href="' . $follower_url . '" class="list-group__item__title" title="' . $follower_name . '" >' . $follower_name . '</a>';
							$followers_listing_str .= '<p>' . $follower_description . '</p>';
						$followers_listing_str .= '</div>';
					$followers_listing_str .= '</div>';
				$followers_listing_str .= '</li>';
				
			}
		}
		$followers_listing_str .= "</ul>";

		return $followers_listing_str;
	}

	/**
	 * Shows the posts from users that the current user saucy_follows
	 */
	public function saucy_activity_feed_shortcode( $atts, $content = null ) {
	
		if (is_author(get_current_user_id())) {

			// Make sure the current user follows someone
			$following = fdfp_get_following();

			if( empty( $following ) )
				return;

			$items = new WP_Query( array(
				'post_type'      => 'post',
				'posts_per_page' => 15,
				'author__in'     => fdfp_get_following()
			) );

			ob_start(); ?>
			<h3><?php _e('Activity Feed Of Users You Follow', 'fdfp'); ?></h3>

			<?php if( $items->have_posts() ) : ?>
				<ul id="fdfp_following-feed" class="fdfp__list-group" >
					<?php while( $items->have_posts() ) : $items->the_post(); ?>
						<li class="fdfp__list-group__item">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> by <?php the_author_posts_link(); ?>
						</li>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</ul>
				<?php else : ?>
					<p class="fdfp_no-results"><?php _e( 'None of the users you follow have posted anything yet.', 'fdfp' ); ?></p>
				<?php endif; ?>
			<?php
			return ob_get_clean();
			
		}

	}

}








