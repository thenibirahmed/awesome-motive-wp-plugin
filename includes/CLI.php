<?php 

namespace AwesomeMotive;

class CLI {
    public function __construct() {
        if ( class_exists( 'WP_CLI' ) ) {
            $this->register_commands();
        }
    }

    /**
     * Register the WP CLI commands
     *
     * @return void
     */
    public function register_commands() {
        \WP_CLI::add_command( 'delete-table-block-data', 'AwesomeMotive\CLI\DeleteTableBlockData' );
    }
}