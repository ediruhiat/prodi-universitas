<?php
/**
 * @package  Prodi
 */
namespace Templates;

use \Inc\Classes\DatabaseHelper;
use \Inc\Classes\ListMatkul;

$myListTable = new ListMatkul;

$myListTable->my_render_list_page();