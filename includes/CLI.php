<?php 

namespace AwesomeMotive;

use AwesomeMotive\CLI\DeleteTableBlockData;

class CLI {
    public function __construct() {
        if ( class_exists( 'WP_CLI' ) ) {
            $this->register_commands();
        }
    }

    public function register_commands() {
        \WP_CLI::add_command( 'delete-table-block-data', 'AwesomeMotive\CLI\DeleteTableBlockData' );
    }
}