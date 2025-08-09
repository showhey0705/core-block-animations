<?php
/**
 * Plugin Name: Core Block Animations
 * Plugin URI: https://github.com/showhey0705/core-block-animations
 * Description: Add smooth entrance animations to WordPress core blocks. Choose from fade, slide, zoom, and rotate effects with customizable timing and easing options.
 * Version: 1.0.0
 * Author: PhotoshopVIP Team
 * Author URI: https://photoshopvip.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: core-block-animations
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Requires PHP: 7.4
 */
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

// Define constants
define( 'CBA_VERSION', '1.0.0' );
define( 'CBA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CBA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CBA_BUILD_DIR', CBA_PLUGIN_DIR . 'build/' );
define( 'CBA_BUILD_URL', CBA_PLUGIN_URL . 'build/' );
define( 'CBA_ASSETS_DIR', CBA_PLUGIN_DIR . 'assets/' );
define( 'CBA_ASSETS_URL', CBA_PLUGIN_URL . 'assets/' );

/**
 * Main plugin class
 */
class CoreBlockAnimations {
	
	/**
	 * Plugin instance
	 *
	 * @var CoreBlockAnimations|null
	 */
	private static $instance = null;

	/**
	 * Get plugin instance
	 *
	 * @return CoreBlockAnimations
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Initialize plugin
	 */
	public function init() {
		// Plugin initialization code can be added here
	}

	/**
	 * Enqueue editor assets
	 */
	public function enqueue_editor_assets() {
		if ( ! is_admin() ) {
			return;
		}

		// Enqueue editor JavaScript
		if ( file_exists( CBA_BUILD_DIR . 'index.js' ) ) {
			wp_enqueue_script(
				'core-block-animations-editor',
				CBA_BUILD_URL . 'index.js',
				array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-hooks', 'wp-data', 'wp-compose' ),
				CBA_VERSION,
				true
			);
			wp_set_script_translations( 'core-block-animations-editor', 'core-block-animations', CBA_PLUGIN_DIR . 'languages' );
		}

		// Enqueue editor CSS
		if ( file_exists( CBA_ASSETS_DIR . 'editor.css' ) ) {
			wp_enqueue_style(
				'core-block-animations-editor',
				CBA_ASSETS_URL . 'editor.css',
				array(),
				CBA_VERSION
			);
		}
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_frontend_assets() {
		if ( is_admin() ) {
			return;
		}

		// Enqueue frontend JavaScript
		if ( file_exists( CBA_BUILD_DIR . 'frontend.js' ) ) {
			wp_enqueue_script(
				'core-block-animations-frontend',
				CBA_BUILD_URL . 'frontend.js',
				array(),
				CBA_VERSION,
				true
			);
		}

		// Enqueue frontend CSS
		if ( file_exists( CBA_ASSETS_DIR . 'style.css' ) ) {
			wp_enqueue_style(
				'core-block-animations-frontend',
				CBA_ASSETS_URL . 'style.css',
				array(),
				CBA_VERSION
			);
		}
	}
}

// Initialize plugin
CoreBlockAnimations::get_instance();