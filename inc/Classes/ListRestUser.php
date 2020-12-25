<?php 
/**
 * @package  Prodi
 */
namespace Inc\Classes;

use Inc\Classes\DatabaseHelper;

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class ListRestUser extends \WP_List_Table
{
    var $_db;

    var $list_rest = array();

    function _construct(){
        add_action( 'admin_head', array( &$this, 'admin_header' ) );
    }

    function no_items() {
        _e( 'Tidak ada user terdaftar.' );
      }

    function register(){        
        $this->_db = new DatabaseHelper('rest_keys');
        $this->_db->select_keys();
        $_list_temp = $this->_db->get_keys();
        $count = 1;

        foreach( (array) $_list_temp as $user ){
            $this->list_rest[$count] = array(
                'ID' => (int) $user->id,
                'no' => $count,
                'username' => $user->username,
                'key' => $user->the_key,
            );
            $count++;
        }        
    }
    
    function get_columns(){
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'no' => 'No',
            'username' => 'Username',
            'key' => 'Key',
            'actions' => 'Action'
        );
        return $columns;
    }

    function column_actions($item) {
        $actions = array(
                'delete'    => sprintf('<form method="post">
                <input type="hidden" value="%s" name="username-%s"></input>
                <input type="submit" value="Delete" name="delete-%s" style="
                border: none; 
                background: none;
                color: #a00;
                cursor: pointer;"></input>
                </form></div>',$item['username'], $item['username'], $item['username']),
        );
      
        return sprintf('%1$s %2$s', $item['actions'], $this->row_actions($actions) );
    }

    function get_bulk_actions() {
        $actions = array(
          'delete'    => 'Delete'
        );
        return $actions;
    }

    public function process_bulk_action() {

        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );

        }

        $action = $this->current_action();

        switch ( $action ) {

            case 'delete':
                wp_die( 'Delete something' );
                break;

            default:
                // do nothing or something else
                return;
                break;
        }

        return;
    }

    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="user[]" value="%s" />', $item['ID']
        );    
    }

    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->list_rest;
        $this->process_bulk_action();
    }

    function column_default( $item, $column_name ) {
        switch( $column_name ) { 
            case 'no':
            case 'username':
            case 'key':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
            }
    }

    function my_render_list_page(){
        $myListTable = new ListRestUser();
        $myListTable->register();
        $myListTable->prepare_items();        
        $myListTable->display();
    }
}

?>