<?php 

namespace AwesomeMotive\CLI;

class DeleteTableBlockData {
    public function __invoke( $args, $assoc_args ) {
        delete_transient('am_table_data');
        \WP_CLI::success( "Deleted" );
    }
}
