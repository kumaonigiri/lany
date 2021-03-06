<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if ( IS_TERM ) :
	SWELL_FUNC::get_parts( 'archive-term' );
else :
	$archive_data     = SWELL_FUNC::get_archive_data();
	$archive_title    = $archive_data['title'];
	$archive_subtitle = str_replace( 'pt_archive', 'archive', $archive_data['type'] );

	// リストタイプ
	$list_type = apply_filters( 'swell_post_list_type_on_archive', LIST_TYPE, $archive_data );
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<h1 class="c-pageTitle">
			<span class="c-pageTitle__inner">
				<?=esc_html( $archive_title )?><span class="c-pageTitle__subTitle u-fz-14">– <?=esc_html( $archive_subtitle )?> –</span>
			</span>
		</h1>
		<?php
			// 新着投稿一覧 ( Main loop )
			SWELL_FUNC::get_parts( 'parts/post_list/loop_main', ['type' => $list_type ] );
			SWELL_FUNC::get_parts( 'parts/post_list/item/pagination' );
		?>
	</div>
</main>
<?php endif;
get_footer(); ?>
