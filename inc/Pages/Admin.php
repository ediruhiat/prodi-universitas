<?php 
/**
 * @package  Prodi
 */
namespace Inc\Pages;

use \Inc\Base\BaseController;

/**
* 
*/
class Admin extends BaseController
{
	public function register() {
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
		add_action( 'admin_menu', array( $this, 'add_submenu_items' ) );
	}

	public function add_admin_pages() {
		add_menu_page( 
			'Prodi Informatika', //Page title
			'Prodi Informatika', //Menu title
			'manage_options', //Capability
			'prodi_plugin', //Menu slug
			array( $this, 'admin_index' ), //Callback function
			'dashicons-feedback', //Icon
			2  //Position (int)
		);
	}

	public function add_submenu_items() {
		//Sub menu mata kuliah
		add_submenu_page( 
			'prodi_plugin', //Parent menu slug
			'Mata Kuliah', //Page title
			'Mata Kuliah', //Sub menu title
			'manage_options', //Capability
			'mata_kuliah', //Sub menu slug
			array( $this, 'mata_kuliah' ), //Callback function
		);

		//Sub menu tambah mata kuliah
		add_submenu_page( 
			'mata_kuliah', //Parent menu slug
			'Tambah Mata Kuliah', //Page title
			'Tambah Mata Kuliah Baru', //Sub menu title
			'manage_options', //Capability
			'add_new_mk', //Sub menu slug
			array( $this, 'add_mk_form'), //Callback function
		);

		//Sub menu edit mata kuliah (hidden)
		add_submenu_page( 
			'mata_kuliah', //Parent menu slug
			'Edit Form', //Page title
			'Edit Form', //Sub menu title
			'manage_options', //Capability
			'edit_mk', //Sub menu slug
			array( $this, 'edit_mk'), //Callback function
		);

		//Sub menu data dosen
		add_submenu_page( 
			'prodi_plugin', //Parent menu slug
			'Data Dosen', //Page title
			'Data Dosen', //Sub menu title
			'manage_options', //Capability
			'dosen', //Sub menu slug
			array( $this, 'dosen'), //Callback function
		);

		add_submenu_page( 
			'dosen', //Parent menu slug
			'Tambah Data Dosen', //Page title
			'Tambah Data Dosen', //Sub menu title
			'manage_options', //Capability
			'add_dosen', //Sub menu slug
			array( $this, 'add_dosen'), //Callback function
		);

		add_submenu_page( 
			'dosen', //Parent menu slug
			'Edit Data Dosen', //Page title
			'Edit Data Dosen', //Sub menu title
			'manage_options', //Capability
			'edit_dosen', //Sub menu slug
			array( $this, 'edit_dosen'), //Callback function
		);

		//Sub menu data dosen
		add_submenu_page( 
			'prodi_plugin', //Parent menu slug
			'REST API Users', //Page title
			'REST API Users', //Sub menu title
			'manage_options', //Capability
			'rest_user', //Sub menu slug
			array( $this, 'rest_user'), //Callback function
		);

		add_submenu_page( 
			'rest_user', //Parent menu slug
			'Tambah Rest User', //Page title
			'Tambah Rest User', //Sub menu title
			'manage_options', //Capability
			'add_rest_user', //Sub menu slug
			array( $this, 'add_rest_user'), //Callback function
		);

		add_submenu_page( 
			'', //Parent menu slug
			'Generating Google Scholard ID...', //Page title
			'', //Sub menu title
			'manage_options', //Capability
			'generate_scholar_id', //Sub menu slug
			array( $this, 'generate_scholar_id'), //Callback function
		);
	}

	public function admin_index() {
		require_once $this->plugin_path . 'templates/admin.php';
	}

	public function mata_kuliah() {
		require_once $this->plugin_path . 'templates/mata-kuliah.php';
	}

	public function add_mk_form(){
		require_once $this->plugin_path . 'templates/add-form.php';
	}
	
	public function edit_mk(){
		require_once $this->plugin_path . 'templates/edit-form.php';
	}

	public function dosen(){
		require_once $this->plugin_path . 'templates/dosen.php';
	}

	public function add_dosen(){
		require_once $this->plugin_path . 'templates/add-form-dosen.php';
	}

	public function edit_dosen(){
		require_once $this->plugin_path . 'templates/edit-form-dosen.php';
	}

	public function rest_user(){
		require_once $this->plugin_path . 'templates/rest-user.php';
	}

	public function add_rest_user(){
		require_once $this->plugin_path . 'templates/add-rest-user.php';
	}

	public function generate_scholar_id(){
		require_once $this->plugin_path . 'templates/generate-scholar-id.php';
	}

}