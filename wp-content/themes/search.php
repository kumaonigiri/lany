<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// リストタイプ
$list_type = apply_filters( 'swell_post_list_type_on_search', LIST_TYPE );
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<h1 class="c-pageTitle">
			<span class="c-pageTitle__inner">
				「<?php echo get_search_query(); ?>」の検索結果
			</span>
		</h1>
		<?php
			// 新着投稿一覧 ( Main loop )
			SWELL_FUNC::get_parts( 'parts/post_list/loop_main', ['type' => $list_type ] );
			SWELL_FUNC::get_parts( 'parts/post_list/item/pagination' );
		?>
	</div>
</main>
<?php get_footer(); ?>
