<?php
/*
* Template name: --Архив записей
*/
?><section class="section blog">
	<div class="wr"><?php
		the_archive_title( '<h1 class="title">', '</h1>' );
		?><div class="wr-blog row"><?php
		while( have_posts() ) : the_post();
			get_template_part( 'template/blog', 'item' );
		endwhile;
		?></div>
		<div class="more-bl"></div><?php
		switch(get_post_type()){
			case 'kremlev_news':
				?><a href="/news/" class="a-d btn btni more-blog">Показать другие новости</a><?php
				break;
			case 'kremlev_recipes':
				?><a href="/recipes/" class="a-d btn btni more-blog">Показать другие рецепты</a><?php
				break;
			default:
				?><a href="/blog/" class="a-d btn btni more-blog">Показать другие записи</a><?php
				break;
		}
	?></div>
</section>