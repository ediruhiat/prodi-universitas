<?php
/**
 * @package  Prodi
 */
namespace Templates;

use \Inc\Base\BaseController;
use \Inc\Classes\DatabaseHelper;
use \Inc\Classes\ListDosen;

if( !is_object( $_db )){
    $_db = new DatabaseHelper('dosen');
    $_db->select_dosen();
}
$results = json_decode(json_encode($_db->get_dosen()), true);

?>
<div class="ui container one column grid">
    <div class="row">
        <div class="column">
            <div class="ui container" style="padding: 5px; margin: 10px;">
                <h2 class="ui header">
                    <i class="users icon"></i>
                    <div class="content">
                        Manajemen Data Dosen
                        <div class="sub header">Tambahkan, Edit, atau hapus data dosen</div>
                    </div>
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="column">
    <table id="tabelpage" class="ui celled table responsive nowrap unstackable" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Alamat</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php

if (!empty($results)) {
    $counter = 1;
    foreach($results as $dosen){
        $data = '
        <tr>
            <td>'.$counter.'</td>
            <td>'.$dosen['nip'].'</td>
            <td>'.$dosen['nama_dosen'].'</td>
            <td>'.$dosen['email'].'</td>
            <td>'.$dosen['jabatan'].'</td>
            <td>'.$dosen['alamat'].'</td>
            <td>                       
                <form action="admin.php?page=edit_dosen" method="post">
                    <input type="hidden" value="'.$dosen['nip'].'" name="nip-'.$dosen['nip'].'"></input>
                    <button type="submit" name="edit-'.$dosen['nip'].'" class="ui blue button" value="" aria-hidden="true" /><i class="fa fa-pencil-square-o"></i></button>
                </form>
            </td>
            <td>
                <form action="" method="post">
                    <input type="hidden" value="'.$dosen['nip'].'" name="nip-'.$dosen['nip'].'"></input>
                    <button type="submit" name="delete-'.$dosen['nip'].'" class="ui red button" value="" aria-hidden="true" /><i class="fa fa-times"></i></button>                        
                </form>
            </td>
        </tr>
        ';
        $counter++;
        echo $data;
    }
    unset($counter);
}

?>
            <tfoot class="full-width">
                <tr>                    
                    <th colspan="8">
                        <a href="admin.php?page=add_dosen">
                            <div class="ui right floated small primary labeled icon button">
                                <i class="user icon"></i> Tambah Dosen
                            </div>
                        </a>
                    </th>
                </tr>
            </tfoot>
        </tbody>
    </table>
    </div>    
    </div>
</div>
';
<?php
$_db->del_data();
?>