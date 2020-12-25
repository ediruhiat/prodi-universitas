<?php 
/**
 * @package  Prodi
 */
namespace Inc\Classes;

class DatabaseHelper
{
    public $db_h; //Imitating $wpdp

    public $var_test; //Testing variable - nothing to do with this!

    public $table_name; //MySQL Table name

    public $table; //Some Table Name
    
    public $mk_results; //Selection variable purpose

    public $dosen_results; //Selection variable purpose

    public $keys_results; //Selection variable purpose

    public function __construct($table){
        global $wpdb;
        $this->db_h = $wpdb;
        $this->table_name = $this->db_h->prefix.$table;
        $this->var_test = "It's working now!";
    }

    public function get_mk(){
        return $this->mk_results;
    }

    public function get_dosen(){
        return $this->dosen_results;
    }

    public function get_keys(){
        return $this->keys_results;
    }

    public function select_mk(){
        $this->mk_results = $this->db_h->get_results("SELECT * FROM $this->table_name");
    }

    public function select_keys(){
        $this->keys_results = $this->db_h->get_results("SELECT * FROM $this->table_name");
    }

    public function select_dosen(){
        $this->dosen_results = $this->db_h->get_results("SELECT * FROM $this->table_name");
    }

    public function select_mk_kode($kode){
        $_temp = $this->db_h->get_results("SELECT * FROM $this->table_name WHERE kode_mk='$kode' LIMIT 1");
        return (array) $_temp[0];        
    }

    public function select_dosen_nip($nip){
        $_temp = $this->db_h->get_results("SELECT * FROM $this->table_name WHERE nip='$nip' LIMIT 1");
        return (array) $_temp[0];        
    }

    public function select_mk_id($id){
        $_temp = $this->db_h->get_results("SELECT * FROM $this->table_name WHERE id='$id' LIMIT 1");
        return (array) $_temp[0];        
    }

    public function select_dosen_id($id){
        $_temp = $this->db_h->get_results("SELECT * FROM $this->table_name WHERE id='$id' LIMIT 1");
        return (array) $_temp[0];        
    }

    //Select data berdasarkan semester
    public function select_mk_semester(int $semester){
        $_temp = $this->db_h->get_results("SELECT * FROM $this->table_name WHERE semester = $semester");
        return (array) $_temp;
    }

    //Tambah data ke dalam tabel
    public function add_data(){
        if( $this->table_name == 'wp_mata_kuliah' ){
            //Inisiasi variable menggunakan POST
            $kode = $_POST['kode-mk'];
            $nama = $_POST['nama-mk'];
            $sks = (int) $_POST['sks-mk'];
            $semester = (int) $_POST['semester-mk'];
            $major = $_POST['major-mk'];

            //Kosongkan default value
            if($major == 'None'){
                $major = '';
            }

            //INSERT query
            $this->db_h->insert(
                $this->table_name,
                array (
                    'id' => NULL,
                    'kode_mk' => $kode,
                    'mata_kuliah' => $nama,
                    'sks' => $sks,
                    'semester' => $semester,
                    'major' => $major
                )
            ) or die('mysql error');
        } else if ($this->table_name == 'wp_dosen'){
            //Inisiasi variable menggunakan POST
            $nip = $_POST['nip'];
            $nama = $_POST['nama-dosen'];
            $email = $_POST['email'];
            $jabatan = $_POST['jabatan'];
            $alamat = $_POST['alamat'];
            $gscholar_id = $_POST['scholar'];
            $pend = $_POST['pendidikan'];
            $seminar = $_POST['seminar'];
            $foto = media_handle_upload( 'foto', 0 );
            $img_path = wp_get_attachment_url( $foto );

            //INSERT query
            $this->db_h->insert(
                $this->table_name,
                array (
                    'id' => NULL,
                    'nip' => $nip,
                    'nama_dosen' => $nama,
                    'email' => $email,
                    'gscholar_id' => $gscholar_id,
                    'jabatan' => $jabatan,
                    'alamat' => $alamat,
                    'riwayat_pend' => $pend,
                    'seminar' => $seminar,
                    'img_path' => $img_path
                )
            ) or die('mysql error');
            var_dump($img_path);
            if ( is_wp_error( $foto ) ) {
                
            } else {
                // The image was uploaded successfully!
            }
        } else if ($this->table_name == 'wp_rest_keys'){
            //Inisiasi variable menggunakan POST
            $is_unique = false;
            $nip = $_POST['username'];
            $key = bin2hex(random_bytes(20));
            $temp = $this->get_keys;

            while(!$is_unique){
                if($key == $temp['the_key']){
                    $is_unique = false;
                }
                else{
                    $is_unique = true;
                }
            }

            //INSERT query
            $this->db_h->insert(
                $this->table_name,
                array (
                    'id' => NULL,
                    'username' => $nip,
                    'the_key' => $key,
                )
            ) or die('mysql error');
        }
    }

    public function del_data(){
        if( $this->table_name == 'wp_mata_kuliah' ){
            //Definisikan regex
            $regex = "/(IF|KU)[a-zA-Z0-9_]+/";
            //Gunakan preg_grep untuk array intersect antara $_POST dan $regex
            $result = array_intersect_key($_POST, array_flip(preg_grep($regex, array_keys($_POST))));

            //Loop checking untuk menghandle aksi delete
            foreach( $result as $row ){
                if( isset($_POST['delete-'.$row]) ){
                    $query = "DELETE FROM $this->table_name WHERE kode_mk = '$row'";

                    //Delete query berdasarkan id
                    $this->db_h->query( $query );
                    header("Refresh:0");
                }
            }
        } else if ($this->table_name == 'wp_dosen'){
            //Definisikan regex
            $regex = "/[0-9_]+/";
            //Gunakan preg_grep untuk array intersect antara $_POST dan $regex
            $result = array_intersect_key($_POST, array_flip(preg_grep($regex, array_keys($_POST))));

            //Loop checking untuk menghandle aksi delete
            foreach( $result as $row ){
                if( isset($_POST['delete-'.$row]) ){
                    $query = "DELETE FROM $this->table_name WHERE nip = '$row'";

                    //Delete query berdasarkan id
                    $this->db_h->query( $query );
                    header("Refresh:0");
                }
            }
        } else if ($this->table_name == 'wp_rest_keys'){
            //Definisikan regex
            $regex = "/[a-zA-Z_]+/";
            //Gunakan preg_grep untuk array intersect antara $_POST dan $regex
            $result = array_intersect_key($_POST, array_flip(preg_grep($regex, array_keys($_POST))));

            //Loop checking untuk menghandle aksi delete
            foreach( $result as $row ){
                if( isset($_POST['delete-'.$row]) ){
                    $query = "DELETE FROM $this->table_name WHERE username = '$row'";

                    //Delete query berdasarkan id
                    $this->db_h->query( $query );
                    header("Refresh:0");
                }
            }
        }
        
    }

    public function edit_data(){
        if( $this->table_name == 'wp_mata_kuliah' ){
            $id_mk = (int) $_POST['id_mk'];
            $kode = $_POST['kode-mk'];
            $nama = $_POST['nama-mk'];
            $sks = (int) $_POST['sks-mk'];
            $semester = (int) $_POST['semester-mk'];
            $major = $_POST['major-mk'];

            if($major == 'None'){
                $major = '';
            }

            $this->mk_results = $this->select_mk_kode($kode);
            //INSERT query
            $this->db_h->update(
                $this->table_name,
                array (
                    'kode_mk' => $kode,
                    'mata_kuliah' => $nama,
                    'sks' => $sks,
                    'semester' => $semester,
                    'major' => $major
                ),
                array('id' => $id_mk),
                array('%s' ,
                        '%s' , 
                        '%d' , 
                        '%d' , 
                        '%s' ),
                array('%d') 
            ) or die('mysql error');
        } else if ($this->table_name == 'wp_dosen'){
            $id_dosen = (int) $_POST['id-dosen'];
            $nip = $_POST['nip'];
            $nama = $_POST['nama-dosen'];
            $email = $_POST['email'];
            $jabatan = $_POST['jabatan'];
            $alamat = $_POST['alamat'];
            $gscholar_id = $_POST['scholar'];
            $pend = $_POST['pendidikan'];
            $seminar = $_POST['seminar'];

            $this->dosen_results = $this->select_dosen_nip($nip);
            //INSERT query
            $this->db_h->update(
                $this->table_name,
                array (
                    'nip' => $nip,
                    'nama_dosen' => $nama,
                    'email' => $email,
                    'jabatan' => $jabatan,
                    'alamat' => $alamat,
                    'gscholar_id' => $gscholar_id,
                    'riwayat_pend' => $pend,
                    'seminar' => $seminar,
                ),
                array('id' => $id_dosen),
                array('%s' ,
                        '%s' , 
                        '%s' , 
                        '%s' , 
                        '%s' , 
                        '%s' , 
                        '%s' , 
                        '%s' ),
                array('%d') 
            ) or die('mysql error');
        }        
    }
}

?>