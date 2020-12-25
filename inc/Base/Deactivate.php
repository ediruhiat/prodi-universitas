<?php
/**
 * @package  Prodi
 */
namespace Inc\Base;

class Deactivate extends BaseController
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}