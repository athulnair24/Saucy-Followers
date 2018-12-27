<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mydigitalsauce.com/
 * @since      0.1.0
 *
 * @package    Saucy_Followers
 * @subpackage Saucy_Followers/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Saucy_Followers
 * @subpackage Saucy_Followers/admin
 * @author     MyDigitalSauce <justin@mydigitalsauce.com>
 */
class Saucy_Followers_Admin {

	private $plugin_name;
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->admin_helpers();
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts') );
		add_action( 'admin_menu', array($this, 'create_admin_menu') );

	}

	public function admin_helpers() {
		require plugin_dir_path( __FILE__ ) . 'partials/admin-helpers.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		// wp_enqueue_media();
		// wp_enqueue_style( 'wp-color-picker');
		// wp_enqueue_script( 'wp-color-picker');

	}

	public function create_admin_menu() {
    $hook = add_submenu_page(
      'options-general.php',
      'Saucy Followers - Settings',
      'Saucy Followers',
      'manage_options',
      'saucy-followers',
      array($this, 'create_admin_page')
    );
	}

	public function create_admin_page() {
		require plugin_dir_path( __FILE__ ) . 'partials/admin-settings-page.php';
	}

}














