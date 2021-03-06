<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<aside id="sidebar" class="l-sidebar">
<?php 
	$cache_key = '';
	if ( SWELL_FUNC::get_setting('cache_sidebar') ) { // && !IS_LOGIN (非公開記事をキャッシュさせない？)
		if ( IS_TOP ) {
			$cache_key = 'sidebar_top';
		} elseif( IS_SINGLE ) {
			$cache_key = 'sidebar_single';
		} elseif( IS_PAGE || IS_HOME ) {
			$cache_key = 'sidebar_page';
		} elseif( IS_ARCHIVE ) {
			$cache_key = 'sidebar_archive';
		}
		if ( $cache_key !== '' && IS_MOBILE ) {
			$cache_key .= '_sp';
		}
	}
	SWELL_FUNC::get_parts( 'parts/sidebar_content', '', $cache_key, 24 * HOUR_IN_SECONDS ); //キャッシュは24時間だけ
 ?>
</aside>
