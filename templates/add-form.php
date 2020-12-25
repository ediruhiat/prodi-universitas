<?php
/**
 * @package  Prodi
 */

use \Inc\Classes\DatabaseHelper;

//Instansiasi class DBHelper
if( !is_object( $_db )){
    $_db = new DatabaseHelper('mata_kuliah');
}

?>


<div class="ui container">

    <form class="ui form" enctype="multipart/form-data" name="form-mk" method="post" style="margin: 30px 10px 30px 10px;">

        <h2 class="ui dividing header">Form Tambah Data Mata Kuliah</h2>

        <div class="field">
            <label>Nama Mata Kuliah</label>
            <input type="text" name="nama-mk" id="nama-mk" placeholder="Masukkan Nama Dosen" required>
        </div>

        <div class="field">
            <div class="three fields">
                <div class="field">
                    <label>Kode Mata Kuliah</label>
                    <input type="text" name="kode-mk" id="kode-mk" placeholder="Masukkan Nama Dosen" required>
                </div>

                <div class="field">
                    <label>Jumlah SKS</label>
                    <div id="dropdownsks" class="ui selection dropdown">
                        <input type="hidden" name="sks-mk" id="sks-mk">
                        <i class="dropdown icon"></i>
                        <div class="default text">SKS</div>
                        <div class="menu">
                            <div class="item" data-value="1">1</div>
                            <div class="item" data-value="2">2</div>
                            <div class="item" data-value="3">4</div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label>Semester</label>
                    <div id="dropdownsemester" class="ui selection dropdown">
                        <input type="hidden" name="semester-mk" id="semester-mk">
                        <i class="dropdown icon"></i>
                        <div class="default text">Semester</div>
                        <div class="menu">
                            <div class="item" data-value="1">1</div>
                            <div class="item" data-value="2">2</div>
                            <div class="item" data-value="3">3</div>
                            <div class="item" data-value="4">4</div>
                            <div class="item" data-value="5">5</div>
                            <div class="item" data-value="6">6</div>
                            <div class="item" data-value="7">7</div>
                            <div class="item" data-value="8">8</div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="three wide field">
            <label>KBK</label>
            <div id="dropdownmajor" class="ui selection dropdown">
                <input type="hidden" name="major-mk" id="major-mk">
                <i class="dropdown icon"></i>
                <div class="default text">KBK</div>
                <div class="menu">
                    <div class="item" data-value="AIG">AIG</div>
                    <div class="item" data-value="DSE">DSE</div>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" tabindex="0"  name="confirmation" required>
                <label>Saya menyatakan bahwa data yang saya masukkan adalah benar.</label>
            </div>
        </div>
        
        <div class="field">
            <div class="ui buttons">
                <button class="ui button" onclick="location.href='admin.php?page=mata_kuliah';">Kembali</button>
                <div class="or"></div>
                <input type="submit" class="ui linkedin button" name="tambah" id="tambah-mk">Submit</input>
                <?php if( isset( $_POST['tambah'] ) ){
                        $_db->add_data();
                    }
                ?>
            </div>
        </div>
    </form>
</div>

<script>
    jQuery("#dropdownsks")
    .dropdown()
    ;
    jQuery("#dropdownsemester")
    .dropdown()
    ;
    jQuery("#dropdownmajor")
    .dropdown()
    ;
</script>