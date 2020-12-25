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
}
$myListTable = new ListMatkul;
?>

<div class="ui raised very padded text container segment" style="padding: 10px 30px 30px 30px;">
    <img class="ui middle aligned mini image" src="http://localhost/prodi-if/wp-content/uploads/2020/10/if.png" style="float: left; width: 54px; margin-top: 30px;">
    <img class="ui middle aligned mini image" src="http://localhost/prodi-if/wp-content/uploads/2020/07/unjani.png" style="float: right; width: 60px; margin-top: 33px;">
    <h1 class="ui header" style="text-align: center;">Selamat datang di Prodi Informatika UNJANI</h1>
    <p style="color: #c2c2c2; text-align: center;">Terakreditasi "B" SKEPBAN-PT Nomor : 1201/BAN-PT/Akred/S/XII/2015 12 Desember 2015</p>
</div>

<div class="ui raised very padded text container segment full width">
    <h2 class="ui header" style="text-align: center; margin-bottom: 50px;">Menu Manajemen</h2>
    <div class="ui cards">
    <div class="card">
        <div class="content">
        <div class="header">Mata Kuliah</div>
        <div class="description">
            Menu manajemen mata kuliah digunakan untuk
            mengelola data mata kuliah yang ada di dalam sistem.
        </div>
        </div>
        <div class="ui bottom attached button" onclick="location.href='admin.php?page=mata_kuliah';">
        <i class="book icon"></i>
        Kelola
        </div>
    </div>
    <div class="card">
        <div class="content">
        <div class="header">Data Dosen</div>
        <div class="description">
            Menu manajemen data dosen digunakan untuk
            mengelola data dosen yang ada di dalam sistem.
        </div>
        </div>
        <div class="ui bottom attached button" onclick="location.href='admin.php?page=dosen';">
        <i class="users icon"></i>
        Kelola
        </div>
    </div>
    <div class="card">
        <div class="content">
        <div class="header">REST API User</div>
        <div class="description">
            Menu manajemen data REST API User digunakan untuk
            mengelola data pengguna REST API (Data Mata Kuliah) yang ada di dalam sistem.
        </div>
        </div>
        <div class="ui bottom attached button" onclick="location.href='admin.php?page=rest_user';">
        <i class="terminal icon"></i>
        Kelola
        </div>
    </div>
    </div>
    <h4 class="ui horizontal divider header">
    Menu Lain
    </h4>
    <table class="ui definition table">
    <tbody style="font-size: 14px;">
        <tr>
        <td class="two wide column">Support</td>
        <td><a href="http://localhost/prodi-if/wp-admin/edit.php?post_type=ticket">Kelola Support Ticket</a></td>
        </tr>
        <tr>
        <td>Artikel</td>
        <td><a href="http://localhost/prodi-if/wp-admin/edit.php">Kelola Artikel yang sudah atau akan diterbitkan</a></td>
        </tr>
        <tr>
        <td>HM KMJ IF</td>
        <td><a href="http://localhost/prodi-if/wp-admin/edit.php?post_type=himpunan">Kelola Artikel yang diposting Himpunan Mahasiswa</a></td>
        </tr>
        <tr>
        <td>CETIF</td>
        <td><a href="http://localhost/prodi-if/wp-admin/edit.php?post_type=cet-if">Kelola Artikel yang diposting CETIF</a></td>
        </tr>
    </tbody>
    </table>
    <p style="color: #a2a2a2; padding: 15px 0px 0px 0px;">© Copyright 2020 Informatika UNJANI</p>
</div>