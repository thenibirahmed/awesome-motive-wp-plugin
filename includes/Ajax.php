<?php 

namespace AwesomeMotive;

use AwesomeMotive\Admin\Tables\BlockMenuTable;

class Ajax {
    public function __construct() {
        add_action( 'wp_ajax_am-get-table-data', [ $this, 'get_table_data' ]);
        add_action( 'wp_ajax_nopriv_am-get-table-data', [ $this, 'get_table_data' ]);

        add_action( 'wp_ajax_am-refresh-table-data', array( $this, 'refresh_entire_table' ) );
    }

    /**
     * Get the table data from the API
     *
     * @return void
     */
    public function get_table_data() {
        $nonce = $_REQUEST['nonce'];

        if ( !wp_verify_nonce($nonce, 'am-nonce') ) {
            wp_send_json_error( 'Invalid nonce' );
        }

        $table_data = self::fetch_table_data_from_api();
        
        if( !$table_data ) {
            wp_send_json_error( __('Error fetching data') );
        }
        
        wp_send_json_success( $table_data );
    }

    /**
     * Fetch the table data from the API
     *
     * @return void
     */
    public static function fetch_table_data_from_api(): bool|string 
    {
        $cached_data = get_transient('am_table_data');

        if ( $cached_data === false ) {
            $api_data = wp_remote_get('https://miusage.com/v1/challenge/1/');

            if ( !is_wp_error($api_data) && wp_remote_retrieve_response_code($api_data) === 200 ) {
                $api_body = wp_remote_retrieve_body($api_data);
                
                set_transient('am_table_data', $api_body, HOUR_IN_SECONDS);

                return $api_body;
            } else {
                return false;
            }
        } 
            
        return $cached_data;
    }

    /**
     * Refresh the entire table
     *
     * @return void
     */
    public function refresh_entire_table() {
        $nonce = $_REQUEST['nonce'];

        if ( !wp_verify_nonce($nonce, 'am-nonce') ) {
            wp_send_json_error( 'Invalid nonce' );
        }
        
        ob_start();
        $my_table = new BlockMenuTable();
        $my_table->prepare_items();
        $my_table->display();
        $table_html = ob_get_clean();

        echo $table_html;
        wp_die();
    }
}