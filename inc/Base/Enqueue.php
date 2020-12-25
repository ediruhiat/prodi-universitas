<?php 
/**
 * @package  Prodi
 */
namespace Inc\Base;

/**
* 
*/
class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}
	
	function enqueue() {
		// Load only on ?page=mypluginname
		if(
			($_GET['page'] == 'prodi_plugin') or
			($_GET['page'] == 'mata_kuliah') or
			($_GET['page'] == 'add_new_mk') or
			($_GET['page'] == 'edit_mk') or
			($_GET['page'] == 'dosen') or
			($_GET['page'] == 'add_dosen') or
			($_GET['page'] == 'rest_user') or
			($_GET['page'] == 'add_rest_user') or
			($_GET['page'] == 'edit_dosen')
		) {
			
			// enqueue style (css)
			wp_enqueue_style( 'font-awesome', $this->plugin_url . 'assets/css/fontawesome.css' );
			wp_enqueue_style( 'semantic', $this->plugin_url . 'assets/semantic/semantic.css' );
			wp_enqueue_style( 'prodi-style', $this->plugin_url . 'assets/css/prodi-style.css' );
			wp_enqueue_style( 'dataTablesSemantic', $this->plugin_url . 'assets/semantic/dataTables.semanticui.min.css' );
			wp_enqueue_style( 'dataTablesSemanticResponsive', $this->plugin_url . 'assets/semantic/responsive.semanticui.min.css' );

			// enqueue script (js)
			wp_deregister_script( 'jquery' ); // Remove WP jQuery version
			wp_enqueue_script( 'semanticjs', $this->plugin_url . 'assets/semantic/semantic.js' );
			wp_enqueue_script( 'jquery', $this->plugin_url . 'assets/js/jquery-3.5.1.min.js' );
			wp_enqueue_script( 'dataTablesjs', $this->plugin_url . 'assets/semantic/jquery.dataTables.min.js' );
			wp_enqueue_script( 'dataTablesSemanticjs', $this->plugin_url . 'assets/semantic/dataTables.semanticui.min.js' );
			wp_enqueue_script( 'dataTablesResponseivejs', $this->plugin_url . 'assets/semantic/dataTables.responsive.min.js' );
			wp_enqueue_script( 'dataTablesSemanticResponseivejs', $this->plugin_url . 'assets/semantic/responsive.semanticui.min.js' );
			wp_enqueue_script( 'font-awesome', $this->plugin_url . 'assets/js/fontawesome.js' );
			wp_enqueue_script( 'script', $this->plugin_url . 'assets/js/script.js' );
		}		
	}
}