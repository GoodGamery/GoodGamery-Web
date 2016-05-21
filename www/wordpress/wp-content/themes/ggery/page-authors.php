<?php
/*
Template Name: List of Authors
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="content" class="narrowcolumn">

	<!--  BEGIN THE Temporary Banner Function! -->
	<?php gg_display_banner();  ?>
	<!-- END OF THE Temporary Banner Function! -->

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php
					if ( function_exists('list_tags') ) {
					$options = array(
						'orderby' => 'count',
						'order' => 'desc',
						'style' => 'list',
						'show_count' => 1,
						'hide_empty' => 1,
						'use_desc_for_title' => 1,
						'hierarchical' => false,
						'title_li' => __(''),
						'echo' => 1,
						'depth' => 0 );
					list_tags($options);
				} ?>

				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>

			</div>
		</div>
	<?php endwhile; endif; ?>
    <br/>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>


<?php get_footer(); ?>