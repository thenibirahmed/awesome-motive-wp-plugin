<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('List Users', 'awesome-motive') ?></h1>

    <a href="#" id="am-refresh-table-block-data" class="page-title-action"><?php _e('Refresh Data', 'awesome-motive') ?></a>
    
    <form action="" method="POST" id="am-table">
        <?php 
            $table = new AwesomeMotive\Admin\Tables\BlockMenuTable();
            $table->prepare_items();
            $table->display();
        ?>
    </form>

</div>