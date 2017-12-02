<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kremlev
 */

?>
<section <?php post_class('section bl-text'); ?> id="post-<?php the_ID(); ?>">
	<div class="wr">
		<?php the_title( '<h1 class="title">', '</h1>' ); ?>
		<div class="text"><?php
			the_content();
		?></div>
	</div>
</section><!-- #post-<?php the_ID(); ?> -->
<?php /*/ ?>
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kremlev' ),
				'after'  => '</div>',
			) );
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						wp_kses(
							__( 'Edit <span class="screen-reader-text">%s</span>', 'kremlev' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article>
<?php /*/ ?>
