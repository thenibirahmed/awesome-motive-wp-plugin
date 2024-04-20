<?php 

namespace AwesomeMotive\Admin\Tables;

use AwesomeMotive\Ajax;

if( !class_exists('WP_List_Table') ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class BlockMenuTable extends \WP_List_Table{
    public function __construct() {
        parent::__construct( array(
            'singular' => 'person',
            'plural'   => 'persons',
            'ajax'     => true
        ) );
    }

    public function get_columns() {
        return array(
            'cb' => '<input type="checkbox"/>',
            'id' => __('ID'),
            'fname' => __('First Name', 'awesome-motive'),
            'lname' => __('Last Name', 'awesome-motive'),
            'email' => __('Email', 'awesome-motive'),
            'date'  => __('Date', 'awesome-motive'),
        );
    }

    protected function column_default( $item, $column_name ) {
        return $item[$column_name] ?? '';
    }

    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s"/>', $item['id']
        );
    }

    public function column_fname( $item ) {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&person=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&person=%s">Delete</a>', $_REQUEST['page'], 'delete',  $item['id']),
        );

        return sprintf('%1$s %2$s', $item['fname'], $this->row_actions($actions) );
    }

    public function get_sortable_columns() {
        return array(
            'fname' => ['fname', true],
        );
    }

    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable );

        $this->items = $this->get_table_data();
    }

    public function get_table_data() {

        $table_data = Ajax::fetch_table_data_from_api();

        if( !$table_data ) {
            return [];
        }

        return json_decode($table_data, true)['data']['rows'];
    }
}