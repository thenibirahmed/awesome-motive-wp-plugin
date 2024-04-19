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
        $api_data = Ajax::fetch_table_data_from_api();

        if ( ! $api_data ) {
            return __('Error fetching data', 'awesome-motive');
        }
        
        $table_data = json_decode( $api_data );

        $title = $table_data->title ?? __('Table', 'awesome-motive');
        $headers = $table_data->data->headers ?? [];
        $rows = $table_data->data->rows ?? [];
        
        $hidden_columns = $attributes['hiddenColumns'];
        ob_start();
        ?>
        <div class="awesome-motive-table-block">
            <h4><?php echo esc_html($title) ?></h4>
            <table>
                <thead>
                    <tr>
                        <?php foreach( $headers as $header ): ?>
                            <?php echo !in_array($header, $hidden_columns) ? "<th>". esc_html($header) ."</th>" : "" ?>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $rows as $row ) : ?>
                        <tr>
                            <?php 
                            $i = 0;
                            foreach( $row as $cell ) : ?>
                                <?php 
                                    echo !in_array($headers[$i], $hidden_columns) ? "<td>". esc_html($cell) ."</td>" : "";
                                    $i++;
                                ?>
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