<?php 

namespace AwesomeMotive;

class Assets {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ]);
    }

    public function register_assets() {
        wp_register_style( 'awesome-motive-style', AWESOME_MOTIVE_ASSETS . '/css/style.css' );
        wp_register_script( 'awesome-motive-script', AWESOME_MOTIVE_URL . '/build/index.js', [], AWESOME_MOTIVE_VERSION, true );

        wp_enqueue_style( 'awesome-motive-style' );
        wp_enqueue_script( 'awesome-motive-script' );
    }
}