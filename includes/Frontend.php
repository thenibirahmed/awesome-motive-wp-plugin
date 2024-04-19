<?php 

namespace AwesomeMotive;

class Frontend {
    public function __construct() {
        add_action( 'init', [ $this, 'register_blocks' ]);
    }

    public function register_blocks() {
        register_block_type( 'awesome-motive/table-block', [
            'editor_script' => 'awesome-motive-block-script',
            'editor_style'  => 'awesome-motive-block-style',
            'render_callback' => [ $this, 'render_am_table_block' ]
        ]);
    }

    public function render_am_table_block( $attributes ) {
        $api_data = wp_remote_get('https://miusage.com/v1/challenge/1/');

        if ( is_wp_error( $api_data ) ) {
            return 'Error fetching data';
        }
        
        $table_data = json_decode(wp_remote_retrieve_body( $api_data ));
        $title = $table_data->title ?? 'Table';
        $headers = $table_data->data->headers ?? [];
        $rows = $table_data->data->rows ?? [];

        ob_start();
        ?>
        <div class="awesome-motive-table-block">
            <h3><?php echo $title ?></h3>
            <table>
                <thead>
                    <tr>
                        <?php foreach( $headers as $header ): ?>
                            <th><?php echo $header ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $rows as $row ) : ?>
                        <tr>
                            <?php foreach( $row as $cell ) : ?>
                                <td><?php echo $cell; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        return ob_get_clean();
    }
}