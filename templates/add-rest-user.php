<?php
/**
 * @package  Prodi
 */

use \Inc\Classes\DatabaseHelper;

//Instansiasi class DBHelper
if( !is_object( $_db )){
    $_db = new DatabaseHelper('rest_keys');
}

?>

<h1>Tambah Pengguna Rest</h1>
<hr>

<div class="wrap">

    <form action="admin.php?page=rest_user" method="post">
        <input class="button" type="submit" value="Back" name="cancel"></input>
    </form>
    <br>

    <form method="post">

        <table>

            <tr>
            <td><label for="username">Username</label></td>
            <td><input type="text" name="username" id="username" placeholder="Username"></td>
            </tr>

            <tr>
            <td><button type="submit" class="button button-primary" name="generate">Generate</button></td>
            <?php if( isset( $_POST['generate'] ) ){
                $_db->add_data();
            }
            ?>

        </table>

    </form>

</div>

