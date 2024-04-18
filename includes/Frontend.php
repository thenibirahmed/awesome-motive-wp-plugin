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
        $table_data = [
            [ 'Name', 'Age', 'Country' ],
            [ 'John Doe', 30, 'USA' ],
            [ 'Jane Doe', 25, 'UK' ],
            [ 'Ahmed', 35, 'Egypt' ],
        ];

        ob_start();
        ?>
        <table class="am-table">
            <?php foreach( $table_data as $row ) : ?>
                <tr>
                    <?php foreach( $row as $cell ) : ?>
                        <td><?php echo $cell; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        return ob_get_clean();
    }
}