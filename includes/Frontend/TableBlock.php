<?php 

namespace AwesomeMotive\Frontend;

use AwesomeMotive\Ajax;

class TableBlock {
    public function __construct() {
        add_action( 'init', [ $this, 'register_block' ]);
    }

    public function register_block() {
        register_block_type( 'awesome-motive/table-block', [
            'editor_script' => 'awesome-motive-block-script',
            'editor_style'  => 'awesome-motive-block-style',
            'render_callback' => [ $this, 'render_am_table_block' ]
        ]);
    }

    public function render_am_table_block( $attributes ) {
        $api_data = Ajax::fetch_table_data_from_api();

        if ( ! $api_data ) {
            return __('Error fetching data', 'awesome-motive');
        }
        
        $table_data = json_decode( $api_data );

        $title = $table_data->title ?? __('Table', 'awesome-motive');
        $headers = $table_data->data->headers ?? [];
        $rows = $table_data->data->rows ?? [];
        
        $hidden_columns = $attributes['hiddenColumns'] ?? [];

        ob_start();

        require_once AWESOME_MOTIVE_PATH . '/includes/views/table-block-frontend.php';
        
        return ob_get_clean();
    }
}