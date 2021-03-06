<?php if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<?php if ( IS_TOP ) : ?>
			<?php if ( is_active_sidebar('front_top') ) : // トップページ上部ウィジェット ?>
				<div class="w-frontTop">
					<?php dynamic_sidebar( 'front_top' ); ?>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<?php // 「投稿ページ」の時
				$post_data = get_queried_object();
				$post_id   = $post_data->ID;

				SWELL_FUNC::get_parts( 'parts/page_head', $post_id );

				if ( !empty( $post_data->post_content ) ) {
					echo '<div class="post_content">',
						apply_filters( 'the_content', $post_data->post_content ),
					'</div>';
				}
			?>
		<?php endif; ?>

		<?php // 投稿リスト
			$cache_key = '';
			$paged = (int) get_query_var( 'paged' );
			if ( $paged === 0 && SWELL_FUNC::get_setting('cache_top') ) {
				$cache_key = ( IS_MOBILE ) ? 'home_posts_sp' : 'home_posts';
			}
			SWELL_FUNC::get_parts( 'parts/home_content', '', $cache_key, 24 * HOUR_IN_SECONDS );
		?>
		<?php if ( IS_TOP ) : ?>
			<?php if ( is_active_sidebar('front_bottom') ) : // トップページ下部ウィジェット ?>
				<div class="w-frontBottom">
					<?php dynamic_sidebar( 'front_bottom' ); ?>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<?php // ウィジェット（「投稿ページ」の時）
				$meta = get_post_meta( $post_id, 'meta_show_widget_bottom', true );
				if ( is_active_sidebar( 'page_bottom' ) && $meta !== '1' ) :
					echo '<div class="w-pageBottom">';
						dynamic_sidebar( 'page_bottom' );
					echo '</div>';
				endif;
			?>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>