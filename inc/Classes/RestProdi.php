<?php 
/**
 * @package  Prodi
 */
namespace Inc\Classes;

use WP_REST_Controller;
use WP_REST_Server;
use WP_Error;

class RestProdi extends WP_REST_Controller {

    /**
	 * The namespace.
	 *
	 * @var string
	 */
	protected $namespace;

	/**
	 * Rest base for the current object.
	 *
	 * @var string
	 */
	protected $rest_base;
	

	/**
	 * Category_List_Rest constructor.
	 */
	public function __construct() {
		$this->namespace = 'prodi-api/v1';
		$this->rest_base = 'mata-kuliah';
    }
    
    /**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {

		register_rest_route( $this->namespace, '/' . $this->rest_base, array(

			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_items' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'                => $this->get_collection_params(),
			),
			array(
				'methods'         => 'PUT',
				'callback'        => array( $this, 'update_item' ),
				'permission_callback' => array( $this, 'update_item_permissions_check' ),
				'args'            => $this->get_endpoint_args_for_item_schema( false ),
			),
			array(
				'methods'         => 'POST',
				'callback'        => array( $this, 'add_item' ),
				'permission_callback' => array( $this, 'add_item_permissions_check' ),
				'args'            => $this->get_endpoint_args_for_item_schema( false ),
			),
			array(
				'methods'         => 'DELETE',
				'callback'        => array( $this, 'del_item' ),
				'permission_callback' => array( $this, 'del_item_permissions_check' ),
				'args'            => $this->get_endpoint_args_for_item_schema( false ),
			),
			'schema' => null,

		) );

	}

	/**
	 * Check get collection parameters.
	 *
	 */
	public function get_collection_params() {
		return array(
			'max_results' => array(
				'description'       => 'Jumlah maksimal data yang akan ditampilkan',
				'type'              => 'integer',
				'default'           => null,
				'sanitize_callback' => 'absint',              
			),
			'kode_mk' => array(
				'description'       => 'Kode mata kuliah yang akan dicari',
				'type'              => 'string',
				'default'           => null,             
			),
			'sks' => array(
				'description'       => 'Jumlah SKS yang akan dicari',
				'type'              => 'integer',
				'default'           => null,
				'sanitize_callback' => 'absint',              
			),
			'semester' => array(
				'description'       => 'Semester yang akan dicari',
				'type'              => 'integer',
				'default'           => null,
				'sanitize_callback' => 'absint',              
			),
			'major' => array(
				'description'       => 'Peminatan yang akan dicari',
				'type'              => 'string',
				'default'           => null,              
			),
		);
	}

	/**
	 * Check permissions for the read.
	 *
	 * @param WP_REST_Request $request get data from request.
	 *
	 * @return bool|WP_Error
	 */
	public function get_items_permissions_check( $request ) {

		global $wpdb;
		
		$key_validation = false;
		$keys = json_decode(json_encode($wpdb->get_results("SELECT * FROM wp_rest_keys")), true);

		foreach($keys as $key){
			if($request['key'] == $key['the_key']){
				$key_validation = true;
			}
		}

		if($request['key'] == NULL OR $key_validation == false){
			return new WP_Error( 'rest_forbidden', esc_html__( 'The key value is wrong or empty!' ), array( 'status' => $this->authorization_status_code() ) );
		}
		return true;
	}
	/**
	 * Check permissions for the update
	 *
	 * @param WP_REST_Request $request get data from request.
	 *
	 * @return bool|WP_Error
	 */
	public function update_item_permissions_check( $request ) {
		global $wpdb;
		
		$key_validation = false;
		$keys = json_decode(json_encode($wpdb->get_results("SELECT the_key FROM wp_rest_keys")), true);
		$keys = $keys[0];

		foreach($keys as $key){
			if($request['key'] == $key){
				$key_validation = true;
			}
		}

		if($request['key'] == NULL OR $key_validation == false){
			return new WP_Error( 'rest_forbidden', esc_html__( 'The key value is wrong or empty!' ), array( 'status' => $this->authorization_status_code() ) );
		}
		return true;
	}

	/**
	 * Check permissions for the add
	 *
	 * @param WP_REST_Request $request get data from request.
	 *
	 * @return bool|WP_Error
	 */
	public function add_item_permissions_check( $request ) {
		global $wpdb;
		
		$key_validation = false;
		$keys = json_decode(json_encode($wpdb->get_results("SELECT the_key FROM wp_rest_keys")), true);
		$keys = $keys[0];

		foreach($keys as $key){
			if($request['key'] == $key){
				$key_validation = true;
			}
		}

		if($request['key'] == NULL OR $key_validation == false){
			return new WP_Error( 'rest_forbidden', esc_html__( 'The key value is wrong or empty!' ), array( 'status' => $this->authorization_status_code() ) );
		}
		return true;
	}

	public function del_item_permissions_check( $request ) {
		global $wpdb;
		
		$key_validation = false;
		$keys = json_decode(json_encode($wpdb->get_results("SELECT the_key FROM wp_rest_keys")), true);
		$keys = $keys[0];

		foreach($keys as $key){
			if($request['key'] == $key){
				$key_validation = true;
			}
		}

		if($request['key'] == NULL OR $key_validation == false){
			return new WP_Error( 'rest_forbidden', esc_html__( 'The key value is wrong or empty!' ), array( 'status' => $this->authorization_status_code() ) );
		}
		return true;
	}

	/**
	 * Grabs all the category list.
	 *
	 * @param WP_REST_Request $request get data from request.
	 *
	 * @return mixed|WP_REST_Response
	 */
	public function get_items( $request ) {

		global $wpdb;

		$params = $request->get_params();

        $max_results = (int) $_GET['max_results'];
    
        $query = "SELECT * FROM wp_mata_kuliah WHERE ";
        $keys = array(
            "kode_mk" => $params['kode_mk'],
            "mata_kuliah" => $params['mata_kuliah'],
            "semester" => $params['semester'],
            "sks" => $params['sks'],
            "major" => strtoupper($params['major'])
        );

        $clauses = 0;
        foreach ( $keys as $inc ) {
            if( $inc != null ){
                $clauses++;
            }
        }

        if ( $clauses > 0 ){
            $counter = 1;
            foreach( $keys as $key ) {
                if ( $key != null) {
                    switch ($counter) {
                        case 1:
                            $clause = "kode_mk";
                            break;
                        case 2:
                            $clause = "mata_kuliah";
                          break;
                        case 3:
                            $clause = "semester";
                            break;
                        case 4:
                            $clause = "sks";
                            break;
                        case 5:
                            $clause = "major";
                            break;
                        default:
                            break;
                    }
                    if ( ($clauses > 1 and $counter < 5) AND ($clause != 'semester' or $clause != 'sks') ){
                        $query .= $clause.' = \''.$key.'\' AND ';
                    } elseif( ($clauses > 1 and $counter < 5) AND ($clause == 'semester' or $clause == 'sks') ){
                        $query .= $clause.' = '.$key.' AND ';
                    } elseif( $clauses == 1 AND ($clause == 'semester' or $clause == 'sks') ){
                        $query .= $clause.' = '.$key;
                    }
                    else {
                        $query .= $clause.' = \''.$key.'\'';
                    }
                }
                $counter++;
            }
            unset($counter);
        } else {
            $query = "SELECT * FROM wp_mata_kuliah";
        }

        if ( $max_results == null or $max_results < 1) {
            $results = $wpdb->get_results($query);
        } else {
            $query .= " LIMIT $max_results";
            $results = $wpdb->get_results($query);
		}
		
		if( empty($results) ) {
			return rest_ensure_response( array (
				'Message' => 'Mata kuliah not found!',
				'Status' => 401
			) );
		}

		// var_dump($params);
        return rest_ensure_response( $results );

	}

	/**
	 * Adds an item to the wp_mata_kuliah tables.
	 *
	 * @param \WP_REST_Request $request Full details about the request.
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function add_item( $request ){

		global $wpdb;

		$params = $request->get_params();
		$clauses = $this->getClauses();

		if( !empty($params) ){
			$counter = 1;
			foreach( $clauses as $clause ){
				if($counter != 1 and $counter != 6){
					if( $params[$clause] == NULL ){
						return rest_ensure_response( array(
							'Message' => 'Please fill up all the parameters',
							'Status' => 403,
						) );
					}
				}
				$counter++;
			}
			unset($counter);
		} else{
			return rest_ensure_response( array(
				'Message' => 'Please fill up all the parameters',
				'Status' => 403,
			) );
		}

		//INSERT query
		$wpdb->insert(
		'wp_mata_kuliah',
			array (
				'id' => NULL,
				'kode_mk' => $params['kode_mk'],
				'mata_kuliah' => $params['mata_kuliah'],
				'semester' => (int) $params['semester'],
				'sks' => (int) $params['sks'],
				'major' => strtoupper($params['major'])
			)
		);

		return rest_ensure_response( array(
			'Message' => 'Mata kuliah added!',
			'Status' => 200,
		) );
	}

	/**
	 * Update category order
	 *
	 * @param WP_REST_Request $request get data from request.
	 *
	 * @return mixed|WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {

		global $wpdb;

		$params = $request->get_params();		

		if( empty($params) or $params['id'] == NULL){
			return rest_ensure_response( array(
				'Message' => 'Error. Please fill up paramaters!',
				'Status' => 403
			) );
		}
		$id = (int) $params['id'];
		$default = json_decode(json_encode($wpdb->get_results("SELECT * FROM wp_mata_kuliah WHERE id = $id")), true);
		$default = $default[0];
		$clauses = $this->getClauses();
			
		foreach( $clauses as $row ){
			if( is_null($params[$row]) ){
				$params[$row] = $default[$row];
			}
		}
		
		$wpdb->update(
			'wp_mata_kuliah',
			array (
				'kode_mk' => $params['kode_mk'],
				'mata_kuliah' => $params['mata_kuliah'],
				'semester' => $params['semester'],
				'sks' => $params['sks'],
				'major' => strtoupper($params['major'])
			),
			array('id' => $params['id']),
			array('%s' ,
					'%s' , 
					'%d' , 
					'%d' , 
					'%s' ),
			array('%d') 
		);

		//var_dump($default);
		return rest_ensure_response( array(
			'Message' => 'Mata kuliah updated!',
			'ID' => $params['id'],
			'Status' => 200,
		) );
	}

	/**
	 * Update category order
	 *
	 * @param WP_REST_Request $request get data from request.
	 *
	 * @return mixed|WP_Error|WP_REST_Response
	 */
	public function del_item( $request ) {
		global $wpdb;

		$params = $request->get_params();
		
		$kode_mk = $params['kode_mk'];
		
		$temp = json_decode(json_encode($wpdb->get_results("SELECT * FROM wp_mata_kuliah WHERE kode_mk = '$kode_mk'")), true);
		$temp = $temp[0];

		if( empty($params) or $params['kode_mk'] == NULL){
			return rest_ensure_response( array(
				'Message' => 'Error. Please fill up paramaters!',
				'Status' => 'Requests_Exception_HTTP_403'
			) );
		}

		if( empty($temp) ){
			return rest_ensure_response( array(
				'Message' => "Error, no mata kuliah with kode_mk $kode_mk",
				'Status' => 'Requests_Exception_HTTP_405'
			) );
		}
		$query = "DELETE FROM wp_mata_kuliah WHERE kode_mk = '$kode_mk'";

		$wpdb->query($query);
		
		return rest_ensure_response( array(
			'Message' => 'Mata kuliah deleted!',
			'Mata Kuliah' => $temp['mata_kuliah'],
			'Status' => 'HTTP_OK_200',
		) );
	}

	/**
	 * Sets up the proper HTTP status code for authorization.
	 *
	 * @return int
	 */
	public function authorization_status_code() {

		$status = 401;

		if ( is_user_logged_in() ) {
			$status = 403;
		}

		return $status;
	}

	function getClauses(){
		return $clauses = array(
			"id",
            "kode_mk",
            "mata_kuliah",
            "semester",
            "sks",
			"major"
		);
	}
}