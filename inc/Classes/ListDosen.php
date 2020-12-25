<?php 
/**
 * @package  Prodi
 */
namespace Inc\Classes;

use Inc\Classes\DatabaseHelper;

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class ListDosen extends \WP_List_Table
{
    var $_db;

    var $list_dosen = array();

    function _construct(){
        add_action( 'admin_head', array( &$this, 'admin_header' ) );
    }

    function no_items() {
        _e( 'Tidak ada dosen terdaftar.' );
      }

    function register(){        
        $this->_db = new DatabaseHelper('dosen');
        $this->_db->select_dosen();
        $_list_temp = $this->_db->get_dosen();
        $count = 1;

        foreach( (array) $_list_temp as $dosen ){
            $this->list_dosen[$count] = array(
                'ID' => (int) $dosen->id,
                'no' => $count,
                'nip' => $dosen->nip,
                'namadosen' => $dosen->nama_dosen,
                'email' => $dosen->email, 
                'jabatan' => $dosen->jabatan,
                'alamat' => $dosen->alamat,
            );
            $count++;
        }        
    }
    
    function get_columns(){
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'no' => 'No',
            'nip' => 'NIP',
            'namadosen' => 'Nama Dosen',
            'email' => 'Email',
            'jabatan' => 'Jabatan',
            'alamat' => 'Alamat',
            'actions' => 'Action'
        );
        return $columns;
    }

    function column_actions($item) {
        $actions = array(
                  'edit'      => sprintf('<div style="display: inline-flex;">
                  <form action="admin.php?page=edit_dosen" method="post">
                  <input type="hidden" value="%s" name="nip-%s"></input>
                  <input class="wp-list-table column-actions edit-link" type="submit" value="Edit" name="edit-%s" style="
                  border: none; 
                  background: none;
                  color: #0073aa;
                  cursor: pointer;">
                  </input></form>',
                  $item['nip'], $item['nip'], $item['nip']),

                  'delete'    => sprintf('<form method="post">
                  <input type="hidden" value="%s" name="nip-%s"></input>
                  <input type="submit" value="Delete" name="delete-%s" style="
                  border: none; 
                  background: none;
                  color: #a00;
                  cursor: pointer;"></input>
                  </form></div>',$item['nip'], $item['nip'], $item['nip']),
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
                var_dump($action);
                break;

            case 'edit':
                wp_die( 'Edit something' );
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
            '<input type="checkbox" name="dosen[]" value="%s" />', $item['ID']
        );    
    }

    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->list_dosen;
        $this->process_bulk_action();
    }

    function column_default( $item, $column_name ) {
        switch( $column_name ) { 
            case 'no':
            case 'nip':
            case 'namadosen':
            case 'email':
            case 'jabatan':
            case 'alamat':
            case 'action':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
            }
    }

    function my_render_list_page(){
        $myListTable = new ListDosen();
        $myListTable->register();
        $myListTable->prepare_items();        
        $myListTable->display();
    }
}

?>