<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package kremlev
 */


 /*?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'kremlev' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'kremlev' ); ?></p>

					<?php
						get_search_form();

						the_widget( 'WP_Widget_Recent_Posts' );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'kremlev' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->

					<?php

						*//* translators: %1$s: smiley *//*
						$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'kremlev' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

						the_widget( 'WP_Widget_Tag_Cloud' );
					?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
*/
get_header();
	?><style>
		.block-404{height:261px;position:relative; }
		.description-404{text-align: center;}
		.description-404 span{color: #2F2F2F;text-align: center;letter-spacing: 1px;font-size: 32px;line-height: 38px;font-weight: 600;display:block}
		.text-404{color: #2F2F2F;text-align: center;letter-spacing: 1px;font-size: 162px;line-height: 194px;font-weight: 700;}
		.info-404{width:400px;position:absolute;top: 0;bottom: 0;left:0;right:0;height:258px;margin:auto;}
	</style>
<section class="section">
	<div class="wr">
		<div id="wrap">
			<div class="block-404">
				<div class="info-404">
					<div class="text-404">
						404
					</div>
					<div class="description-404">
						<span>ПОТЕРЯЛИСЬ?</span>
						Начните с <a href="/">главной страницы</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
	<?php
get_footer();
