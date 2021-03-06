<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 先に定義すべき定数
 */
// if ( ! defined( 'SWELL_DOMAIN' ) ) define( 'SWELL_DOMAIN', 'swell' );

// サイト情報
define( 'HOME', home_url( '/' ) );
define( 'TITLE', get_option( 'blogname' ) );

// 状態
define( 'IS_ADMIN', is_admin() );
define( 'IS_LOGIN', is_user_logged_in() );
define( 'IS_CUSTOMIZER', is_customize_preview() );

// テーマディレクトリパス
define( 'T_DIRE', get_template_directory() );
define( 'S_DIRE', get_stylesheet_directory() );
define( 'T_DIRE_URI', get_template_directory_uri() );
define( 'S_DIRE_URI', get_stylesheet_directory_uri() );

// テキストドメイン
load_theme_textdomain( 'swell', T_DIRE . '/languages' );

// ※
define( 'SWELL_NOTE', __( 'Note : ', 'swell' ) );


/**
 * WP_Filesystem 読み込み
 */
// require_once( ABSPATH.'wp-admin/includes/file.php' );


/**
 * Puc_v4 読み込み
 */
if ( ! class_exists( '\Puc_v4_Factory' ) ) {
	require_once T_DIRE . '/lib/update/plugin-update-checker.php';
}

/**
 * CLASSのオートロード
 */
spl_autoload_register(
	function( $classname ) {
		// SWELL_もLOOS_もなければオートロードしない。
		if ( strpos( $classname, 'SWELL_' ) === false && strpos( $classname, 'LOOS_' ) === false) return;

		$classname = str_replace( '\\', '/', $classname );
		$file      = T_DIRE . '/classes/' . $classname . '.php';

		if ( file_exists( $file ) ) require $file;
	}
);


/**
 * Init
 */
\SWELL_THEME\Init::init();
