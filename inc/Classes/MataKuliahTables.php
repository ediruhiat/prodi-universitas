<?php 
/**
 * @package  Prodi
 */
namespace Inc\Classes;

use \Inc\Base\BaseController;


class MataKuliahTables extends BaseController
{
    public function register() {        
        add_shortcode( 'mktable', 'make_mk_table' ); 
    }

    // Add Shortcode
    function make_mk_table( $atts ) {

        // Attributes
        $atts = shortcode_atts(
            array(
                'smt' => '1',
            ),
            $atts
        );
        $smt = $atts['smt'];
        
        return $smt;

    } 
}