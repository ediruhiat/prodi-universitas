<?php
/**
 * @package  Prodi
 */
namespace Templates;

use \Inc\Base\BaseController;
use \Inc\Classes\DatabaseHelper;

if( !is_object( $_db )){
    $_db = new DatabaseHelper('rest_keys');
    $_db->select_keys();
}
$results = json_decode(json_encode($_db->get_keys()), true);

?>
<div class="ui container one column grid">
    <div class="row">
        <div class="column">
            <div class="ui container" style="padding: 5px; margin: 10px;">
                <h2 class="ui header">
                    <i class="code icon"></i>
                    <div class="content">
                        Manajemen REST User
                        <div class="sub header">Tambahkan, Edit, atau hapus data pengguna rest</div>
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
                <th>Username</th>
                <th>Key</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php

if (!empty($results)) {
    $counter = 1;
    foreach($results as $user){
        $data = '
        <tr>
            <td>'.$counter.'</td>
            <td>'.$user['username'].'</td>
            <td>'.$user['the_key'].'</td>
            <td>
                <form action="" method="post">
                    <input type="hidden" value="'.$user['username'].'" name="username-'.$user['username'].'"></input>
                    <button type="submit" name="delete-'.$user['username'].'" class="ui red button" value="" aria-hidden="true" /><i class="fa fa-times"></i></button>                        
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
                        <a href="admin.php?page=add_rest_user">
                            <div class="ui right floated small primary labeled icon button">
                                <i class="user icon"></i> Tambah User
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