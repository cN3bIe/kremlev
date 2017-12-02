<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package kremlev
 */
// if( isset($_GET['ajax']) ):
if( have_posts() ):
	?><div class="title-fetch">Для вас мы нашли</div>
		<div class="wr-card">
			<div class="row"><?php
				while ( have_posts() ) : the_post();
					get_template_part( 'template/catalog', 'item-fetch' );
				endwhile;
			?></div>
		</div><?php
	else:
		?><div class="title-fetch none">По Вашему запросу ничего не найдено, попробуйте что-то другое</div><?php
endif;
die();
// endif;

/*
get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php
					printf( esc_html__( 'Search Results for: %s', 'kremlev' ), '<span>' . get_search_query() . '</span>' );
				?></h1>
			</header><!-- .page-header -->

			<?php
			the_posts_navigation();
		else :
			get_template_part( 'template/content', 'none' );
		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
*/