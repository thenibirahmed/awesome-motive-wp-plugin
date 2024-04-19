<?php  

/**
 * Plugin Name: Nibir Ahmed
 * Plugin URI: https://nibirahmed.com
 * Description: This is a plugin that does awesome things.
 * Version: 1.0
 * Author: Nibir Ahmed
 * Author URI: https://nibirahmed.com
 * text-domain: awesome-motive
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main Plugin Class
 */
final class AwesomeMotive {

    private function __construct() {
        $this->define_constants();

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ]);
    }

    /**
     * Initialize the plugin core functionalities
     *
     * @return void
     */
    public function init_plugin() {

        new AwesomeMotive\Assets();

        if( defined('DOING_AJAX') && DOING_AJAX ) {
            new AwesomeMotive\Ajax();
        }

        if( is_admin() ) {
            new AwesomeMotive\Admin();
        } else {
            new AwesomeMotive\Frontend();
        }

        if ( class_exists( 'WP_CLI' ) ) {
            new AwesomeMotive\CLI();
        }
    }

    /**
     * Initialize the plugin in singleton pattern
     *
     * @return \AwesomeMotive
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define('AWESOME_MOTIVE_VERSION', '1.0');
        define('AWESOME_MOTIVE_FILE', __FILE__);
        define('AWESOME_MOTIVE_PATH', __DIR__);
        define('AWESOME_MOTIVE_URL', plugins_url('', AWESOME_MOTIVE_FILE));
        define('AWESOME_MOTIVE_ASSETS', AWESOME_MOTIVE_URL . '/assets');
    }
}

/**
 * Initialize the plugin
 *
 * @return \AwesomeMotive
 */
function awesome_motive() {
    return AwesomeMotive::init();
}

// Kick-off the plugin
awesome_motive();
