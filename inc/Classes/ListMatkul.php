<?php 
/**
 * @package  Prodi
 */
namespace Inc\Classes;

use Inc\Classes\DatabaseHelper;

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class ListMatkul extends \WP_List_Table
{
    var $_db;

    var $list_mk = array();

    function _construct(){
        add_action( 'admin_head', array( &$this, 'admin_header' ) );
    }

    function no_items() {
        _e( 'Tidak ada mata kuliah terdaftar.' );
      }

    function register(){        
        $this->_db = new DatabaseHelper('mata_kuliah');
        $this->_db->select_mk();
        $_list_temp = $this->_db->get_mk();
        $count = 1;

        foreach( (array) $_list_temp as $mk ){
            $this->list_mk[$count] = array(
                'ID' => (int) $mk->id,
                'no' => $count,
                'kode' => $mk->kode_mk, 
                'matakuliah' => $mk->mata_kuliah,
                'sks' => $mk->sks,
                'semester' => $mk->semester,
                'major' => $mk->major
            );
            $count++;
        }        
    }
    
    function get_columns(){
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'no' => 'No',
            'kode' => 'Kode',
            'matakuliah' => 'Mata Kuliah',
            'sks' => 'SKS',
            'semester' => 'Semester',
            'major' => 'Major',
            'actions' => 'Action'
        );
        return $columns;
    }

    function column_actions($item) {
        $actions = array(
                  'edit'      => sprintf('<div style="display: inline-flex;">
                  <form action="admin.php?page=edit_mk" method="post">
                  <input type="hidden" value="%s" name="kode-mk-%s"></input>
                  <input class="wp-list-table column-actions edit-link" type="submit" value="Edit" name="edit-%s" style="
                  border: none; 
                  background: none;
                  color: #0073aa;
                  cursor: pointer;">
                  </input></form>',
                  $item['kode'], $item['kode'], $item['kode']),

                  'delete'    => sprintf('<form method="post">
                  <input type="hidden" value="%s" name="kode-mk-%s"></input>
                  <input type="submit" value="Delete" name="delete-%s" style="
                  border: none; 
                  background: none;
                  color: #a00;
                  cursor: pointer;"></input>
                  </form></div>',$item['kode'], $item['kode'], $item['kode']),
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
            '<input type="checkbox" name="matkul[]" value="%s" />', $item['ID']
        );    
    }

    function prepare_items() {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->list_mk;
        $this->process_bulk_action();
    }

    function column_default( $item, $column_name ) {
        switch( $column_name ) { 
            case 'no':
            case 'kode':
            case 'matakuliah':
            case 'sks':
            case 'semester':
            case 'major':
            case 'action':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
            }
    }

    function my_render_list_page(){
        $myListTable = new ListMatkul();
        $myListTable->register();
        $myListTable->prepare_items();        
        $myListTable->display();
    }
}

?>