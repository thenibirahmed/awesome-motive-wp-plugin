<?php 

namespace AwesomeMotive\Admin;

class BlockMenu {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu' ) );
    }

    /**
     * Add the menu
     *
     * @return void
     */
    public function add_menu() {
        add_menu_page( 'Table Block', 'Table Block', 'manage_options', 'table-block', array( $this, 'menu_page' ) );
    }

    /**
     * The menu page
     *
     * @return void
     */
    public function menu_page() {
        require_once AWESOME_MOTIVE_PATH . '/includes/views/list-users.php';
    }
}
