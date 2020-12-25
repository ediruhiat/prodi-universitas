<?php
/**
 * @package  Prodi
 */

use \Inc\Classes\DatabaseHelper;

//Instansiasi class DBHelper
if( !is_object( $_db )){
    $_db = new DatabaseHelper('dosen');
}

?>


<div class="ui container">

    <form class="ui form" enctype="multipart/form-data" name="form-dosen" method="post" style="margin: 30px 10px 30px 10px;">

        <h2>Form Tambah Data Dosen</h2>
        <h4 class="ui dividing header">Informasi Umum</h4>

        <div class="field">
            <div class="two fields">
                <div class="eight wide field">
                    <label>Google Scholar ID</label>
                    <input type="text" name="scholar" id="scholar" placeholder="ID Google Scholar" value="<?= $_POST['scholar-id'] ?>" required>
                </div>
                <div class="eight wide field">
                    <label>Cari Google Scholar ID</label>
                    <div class="ui action input">
                        <input type="text" name="searchid" id="searchid" placeholder="Masukkan nama dosen yang akan dicari">
                        <button class="ui button"><a name="serp" id="serp" href="admin.php?page=generate_scholar_id&gsid=" target="_blank">Generate ID</a></button>
                    </div>
                </div>
            </div>
        </div>
        <p class="nb"><i>*Silahkan Generate Google Scholar ID terlebih dahulu sebelum mengisi form lainnya.</i></p>

        <div class="field">
            <label>Cek Profile Scholar Dosen</label>
            <div class="ui labeled action input">
                <div class="ui label">
                    http://
                </div>
                <input type="text" name="dosen-profile" id="dosen-profile" placeholder="Form akan terisi otomatis" value="<?= "scholar.google.com/citations?hl=en&user=".$_POST['scholar-id'] ?>">
                <button class="ui button"><a name="cek-sch" id="cek-sch" href="<?= "https://scholar.google.com/citations?hl=en&user=".$_POST['scholar-id'] ?>" target="_blank">Cek! </a></button>
            </div>            
        </div>
        <p class="nb"><i>*Silahkan cek terlebih dahulu profile Google Scholar dari dosen bersangkutan.</i></p>

        <div class="field">
            <label>Nama</label>
            <input type="text" name="nama-dosen" id="nama-dosen" placeholder="Masukkan Nama Dosen" required>
        </div>

        <div class="field">
            <div class="two fields">
                <div class="three wide field">
                    <label>NIP</label>
                    <input type="text" name="nip" id="nip" placeholder="Masukkan NIP Dosen" required>
                </div>
                <div class="thirteen wide field">
                    <label>E-mail</label>
                    <input type="email" name="email" id="email" placeholder="contoh@domain.com" required>
                </div>
            </div>
        </div>

        <div class="field">
                <label>Jabatan Fungsional</label>
                <input type="text" name="jabatan" id="jabatan" placeholder="Jabatan Fungsional" required>
        </div>

        <div class="field">
                <label>Alamat</label>
                <input type="text" name="alamat" id="alamat" placeholder="Alamat" required>
        </div>
        
        <div class="field">
            <div class="two fields">
                <div class="field">
                    <label>Riwayat Pendidikan</label>
                    <textarea name="pendidikan" id="pendidikan" placeholder="Masukkan daftar pendidikan dipisahkan dengan tanda titik koma [;]. Contoh: SDN Cimanggu; SMPN 1 Ngamprah; SMAN 2 Padalarang; dst."></textarea>
                </div>
                <div class="field">
                    <label>Seminar</label>
                    <textarea name="seminar" id="seminar" placeholder="Masukkan daftar seminar dipisahkan dengan tanda titik koma [;]. Contoh: SNIA 2017; SNIA 2019; dst."></textarea>
                </div>              
            </div>
        </div>

        <div class="field">
                <label>Foto</label>
                <input type="file" id="foto" name="foto" aria-required="true" required multiple="false"></input>
        </div>

        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" tabindex="0"  name="confirmation" required>
                <label>Saya menyatakan bahwa data yang saya masukkan adalah benar.</label>
            </div>
        </div>
        
        <div class="field">
            <div class="ui buttons">
                <button class="ui button" onclick="location.href='admin.php?page=dosen';">Kembali</button>
                <div class="or"></div>
                <input type="submit" class="ui linkedin button" name="tambah" id="tambah-dosen">Submit</input>
                <?php if( isset( $_POST['tambah'] ) ){
                        $_db->add_data();
                    }
                ?>
            </div>
        </div>
    </form>
</div>

<!-- Modal -->

<!-- <div class="ui longer modal test">
    <i class="close icon"></i>
    <div class="header">
        Cari ID Google Scholar
    </div>
    <div class="scrolling content">
        <p id="rawdata"></p>
    </div>
    <div class="actions">
        <div class="ui black deny button">
            Nope
        </div>
        <div class="ui positive right labeled icon button">
            Yep, that's me
            <i class="checkmark icon"></i>
        </div>
    </div>
</div> -->