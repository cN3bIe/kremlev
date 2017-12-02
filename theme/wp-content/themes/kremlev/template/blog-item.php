<?php
/*
* Template name: Шаблон карточки блога
*/
?><div class="transfer wr-item col s12 m6 l4 p0" id="<?php the_ID();?>">
	<a href="<?php the_permalink();?>" class="item-blog ribe-light a-d">
		<div class="img bg-cover" style="background-image:url('<?php echo get_the_post_thumbnail_url( get_the_ID(),'medium'); ?>');"></div>
		<div class="bl-info">
			<div class="title-blog"><?php the_title();?></div>
			<div class="desc"><?php the_excerpt(); ?></div>
		</div>
	</a>
</div>