<?php
/**
 * @package  Prodi
 */

use \Inc\Classes\DatabaseHelper;

//Instansiasi class DBHelper
if( !is_object( $_db )){
    $_db = new DatabaseHelper('dosen');
}