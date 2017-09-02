<?php
/*
* Template name: Страница Оптовикам
*/
$posts = get_posts(array('post_type'=>'kremlev_faq'));
get_header();
?><section class="section opt">
	<div class="wr">
		<h1 class="title"><?php the_title();?></h1>
		<div class="content"><?php the_content();?></div><?php
		if(ot_get_option( 'main_phone' )):?><div class="collaborate">
			<a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="a-d">По вопросам сотрудничества звоните:<br><?php echo ot_get_option( 'main_phone' );?></a>
		</div><?php
		endif;
	?></div>
</section><?php
get_footer();