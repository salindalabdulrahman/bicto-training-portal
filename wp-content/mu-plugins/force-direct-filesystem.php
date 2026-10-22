<?php
/**
 * Plugin Name: Force Direct Filesystem
 * Description: Use direct disk writes so theme font caching never falls back to FTP.
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'filesystem_method',
	static function () {
		return 'direct';
	},
	99
);
