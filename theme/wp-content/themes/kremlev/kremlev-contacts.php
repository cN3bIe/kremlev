<?php
/*
* Template name: Страница контакты
*/
get_header();
?><section class="section contacts">
<div class="wr">
	<h1 class="title">Контакты</h1>
	<div class="wr-cont row">
		<div class="col s12 m4">
			<div class="img" style="background-image: url('<?php echo get_template_directory_uri().'/img/design/phone.svg';?>')"></div>
			<div class="name">Звоните</div>
			<?php if(ot_get_option( 'main_phone' )):?><a href="tel:<?php echo preg_replace('/\W/','',ot_get_option( 'main_phone' ));?>" class="a-d text"><?php echo ot_get_option( 'main_phone' );?></a><?php endif;?>
		</div><?php
		if(ot_get_option( 'main_email' )):
		?><div class="col s12 m4">
			<div class="img" style="background-image: url('<?php echo get_template_directory_uri().'/img/design/email.svg';?>')"></div>
			<div class="name">Пишите</div>
			<a href="mail:<?php echo ot_get_option( 'main_email' );?>" class="a-d text"><?php echo ot_get_option( 'main_email' );?></a>
		</div><?php
		endif;
		if(ot_get_option( 'main_address' )):
		?><div class="col s12 m4">
			<div class="img" style="background-image: url('<?php echo get_template_directory_uri().'/img/design/marker.svg';?>')"></div>
			<div class="name">Приезжайте</div>
			<div class="text"><?php echo ot_get_option( 'main_address' );?></div>
		</div><?php
		endif;
		?></div><?php
	?></div>
</section><?php
if( have_posts() ):
	while ( have_posts() ) : the_post();
		?><section <?php post_class('section bl-text'); ?> id="post-<?php the_ID(); ?>">
			<div class="wr">
				<div class="text"><?php
					the_content();
				?></div>
			</div>
		</section><?php
	endwhile;
endif;
get_footer();