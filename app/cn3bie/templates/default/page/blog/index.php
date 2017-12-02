<?php
get_header();
get_template_part( 'template/breadcrumbs');
?><section class="section blog">
	<div class="wr">
		<h1 class="title">Новости</h1>
		<div class="wr-blog row"><?php
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
			get_template_part( 'template/blog-preview-item');
		?></div>
		<div class="more-bl"></div>
		<a href="/news/" class="a-d btn btni more-blog">Показать другие новости</a>
	</div>
</section><?php
get_footer();