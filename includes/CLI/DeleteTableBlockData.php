<?php 

namespace AwesomeMotive\CLI;

class DeleteTableBlockData {

    /**
     * Delete the transient data
     *
     * @param array $args
     * @param array $assoc_args
     * @return void
     */
    public function __invoke( $args, $assoc_args ) {
        delete_transient('am_table_data');
        \WP_CLI::success( "Deleted" );
    }
}
