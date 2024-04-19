<?php 

namespace AwesomeMotive;

class Assets {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ]);
        add_action( 'wp_enqueue_scripts', [ $this, 'register_block_assets' ]);
        add_action( 'enqueue_block_editor_assets', [ $this, 'register_block_assets' ]);
    }

    /**
     * Register the plugin assets
     *
     * @return void
     */
    public function register_assets() {
        wp_register_style( 'awesome-motive-style', AWESOME_MOTIVE_ASSETS . '/css/style.css' );
        wp_register_script( 'awesome-motive-script', AWESOME_MOTIVE_ASSETS . '/js/index.js', [], AWESOME_MOTIVE_VERSION, true );

        wp_enqueue_style( 'awesome-motive-style' );
        // wp_enqueue_script( 'awesome-motive-script' );
    }

    /**
     * Register the block assets
     *
     * @return void
     */
    public function register_block_assets() {
        wp_register_style( 'awesome-motive-block-style', AWESOME_MOTIVE_URL . '/build/index.css' );
        wp_register_script( 'awesome-motive-block-script', AWESOME_MOTIVE_URL . '/build/index.js', ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'], AWESOME_MOTIVE_VERSION, true );

        wp_enqueue_style( 'awesome-motive-block-style' );
        wp_enqueue_script( 'awesome-motive-block-script' );

        wp_localize_script( 'awesome-motive-block-script', 'am_data', [
            'nonce' => wp_create_nonce( 'am-nonce' ),
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ]);
    }
}