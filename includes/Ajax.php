<?php 

namespace AwesomeMotive;

class Ajax {
    public function __construct() {
        add_action( 'wp_ajax_am_get_table_data', [ $this, 'get_table_data' ]);
        add_action( 'wp_ajax_nopriv_am_get_table_data', [ $this, 'get_table_data' ]);
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

        $api_data = wp_remote_get('https://miusage.com/v1/challenge/1/');
        wp_send_json_success( self::fetch_table_data_from_api() );

        // $cached_data = get_transient('am_table_data');

        // if ( $cached_data === false ) {
        //     $api_data = wp_remote_get('https://miusage.com/v1/challenge/1/');

        //     if ( !is_wp_error($api_data) && wp_remote_retrieve_response_code($api_data) === 200 ) {
        //         $api_body = wp_remote_retrieve_body($api_data);
                
        //         set_transient('am_table_data', $api_body, HOUR_IN_SECONDS);

        //         wp_send_json_success( $api_body );
        //     } else {
        //         wp_send_json_error( __('Failed to fetch data from the API', 'awesome-motive') );
        //     }
        // } 
            
        // wp_send_json_success($cached_data);
    }

    /**
     * Fetch the table data from the API
     *
     * @return void
     */
    public static function fetch_table_data_from_api(): bool|string 
    {
        $api_data = wp_remote_get('https://miusage.com/v1/challenge/1/');

        if ( is_wp_error( $api_data ) || wp_remote_retrieve_response_code($api_data) !== 200 ) {
            return false;
        }

        return wp_remote_retrieve_body($api_data);
    }
}