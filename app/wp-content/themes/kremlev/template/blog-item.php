<?php
/*
* Template name: Шаблон карточки блога
*/
?><div class="transfer wr-item col s12 m6 l4 p0">
	<div class="item-blog">
		<div class="img bg-cover" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>');"></div>
		<div class="bl-info">
			<a href="<?php the_permalink();?>" class="title-blog a-d"><?php the_title();?></a>
			<div class="desc"><?php the_excerpt(); ?></div>
		</div>
	</div>
</div>