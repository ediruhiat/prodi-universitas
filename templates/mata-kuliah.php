<?php
/**
 * @package  Prodi
 */
namespace Templates;

use \Inc\Base\BaseController;
use \Inc\Classes\DatabaseHelper;
use \Inc\Classes\ListMatkul;

if( !is_object( $_db )){
    $_db = new DatabaseHelper('mata_kuliah');
    $_db->select_mk();
}
$results = json_decode(json_encode($_db->get_mk()), true);

?>
<div class="ui container one column grid">
    <div class="row">
        <div class="column">
            <div class="ui container" style="padding: 5px; margin: 10px;">
                <h2 class="ui header">
                    <i class="book icon"></i>
                    <div class="content">
                        Manajemen Data Mata Kuliah
                        <div class="sub header">Tambahkan, Edit, atau hapus data mata kuliah</div>
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
                <th>Kode</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>KBK</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php

if (!empty($results)) {
    $counter = 1;
    foreach($results as $mk){
        $data = '
        <tr>
            <td>'.$counter.'</td>
            <td>'.$mk['kode_mk'].'</td>
            <td>'.$mk['mata_kuliah'].'</td>
            <td>'.$mk['sks'].'</td>
            <td>'.$mk['semester'].'</td>
            <td>'.$mk['major'].'</td>
            <td>                       
                <form action="admin.php?page=edit_mk" method="post">
                    <input type="hidden" value="'.$mk['kode_mk'].'" name="kode-mk-'.$mk['kode_mk'].'"></input>
                    <button type="submit" name="edit-'.$mk['kode_mk'].'" class="ui blue button" value="" aria-hidden="true" /><i class="fa fa-pencil-square-o"></i></button>
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
                        <a href="admin.php?page=add_new_mk">
                            <div class="ui right floated small primary labeled icon button">
                                <i class="book icon"></i> Tambah Mata Kuliah
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
<?php
$_db->del_data();
?>