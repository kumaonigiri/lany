<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$SETTING = SWELL_FUNC::get_setting();

$author_id          = get_queried_object_id();
$author_data        = SWELL_FUNC::get_author_data( $author_id );
$author_name        = $author_data['name'];
$author_description = $author_data['description'];
$author_position    = $author_data['position'];
$author_sns_list    = $author_data['sns_list'];

// リストタイプ
$list_type = apply_filters( 'swell_post_list_type_on_author', LIST_TYPE, $author_id );

// タブ分けするかどうか
$is_show_tab = $SETTING['show_tab_on_author'];
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<h1 class="c-pageTitle">
			<span class="c-pageTitle__inner">
				<?=esc_html( $author_name )?>
				<span class="c-pageTitle__subTitle u-fz-14"> - Author - </span>
			</span>
		</h1>
		<div class="p-authorBox u-mb-40">
			<div class="p-authorBox__l">
				<?php echo get_avatar( $author_id, 100, '', $author_name . 'のアバター' ); ?>
				<span class="p-authorBox__name u-fz-m">
					<?=esc_html( $author_name )?>
				</span>
				<?php if ( $author_position ) : ?>
					<span class="p-authorBox__position u-fz-s u-thin">
						<?=esc_html( $author_position )?>
					</span>
				<?php endif; ?>
			</div>
			<div class="p-authorBox__r">
				<?php if ( $author_description ) : ?>
					<p class="p-authorBox__desc u-thin">
						<?php echo wp_kses_post( nl2br( $author_description ) ); ?>
					</p>
				<?php endif; ?>
				<?php
					// SNS情報があればアイコン表示
					if ( ! empty( $author_sns_list ) ) :
					$list_data = [
						'list_data' => $author_sns_list,
						'ul_class'  => 'is-style-circle p-authorBox__iconList',
						'hov_class' => 'hov-flash-up',
					];
					SWELL_FUNC::get_parts( 'parts/icon_list', $list_data );
					endif;
				?>
			</div>
		</div>

		<?php
			// タブ切り替えリスト
			if ( $is_show_tab ) :
			$tab_list = [
				$SETTING['new_tab_title'], // 新着記事一覧のタイトル
				$SETTING['ranking_tab_title'], // 人気記事一覧のタイトル
			];
			// @codingStandardsIgnoreStart
			echo SWELL_PARTS::tab_list(
				$tab_list,
				$SETTING['top_tab_style'],
				'post_list_tab_'
			);
			// @codingStandardsIgnoreEnd
			endif;
		?>
		<div class="c-tabBody p-postListTabBody">
			<div id="post_list_tab_1" class="c-tabBody__item" aria-hidden="false">
				<?php
					// 新着投稿一覧 ( Main loop )
					SWELL_FUNC::get_parts( 'parts/post_list/loop_main', ['type' => $list_type ] );
					SWELL_FUNC::get_parts( 'parts/post_list/item/pagination' );
				?>
			</div>
			<?php if ( $is_show_tab ) : // 人気記事一覧タブ ?>
				<div id="post_list_tab_2" class="c-tabBody__item" aria-hidden="true">
					<?php
						$q_args = [
							'post_type'           => 'post',
							'no_found_rows'       => true,
							'ignore_sticky_posts' => 1,
							'meta_key'            => SWELL_CT_KEY,
							'orderby'             => 'meta_value_num',
							'order'               => 'DESC',
							'author'              => $author_id,
						];

						// 新着投稿一覧 ( Sub loop )
						$parts_args = [
							'query_args' => $q_args,
							'list_args'  => ['type' => $list_type ],
						];
						SWELL_FUNC::get_parts( 'parts/post_list/loop_sub', $parts_args );
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
