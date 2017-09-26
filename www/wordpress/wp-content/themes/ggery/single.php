<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="content" class="widecolumn">

	<!--  BEGIN THE Temporary Banner Function! -->
	<?php gg_display_banner();  ?>
	<!-- END OF THE Temporary Banner Function! -->

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $custom_fields = gg_get_custom_fields(); ?>
		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>

		<div class="post" id="post-<?php the_ID(); ?>">
			<h2 class="post_heading"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>

			<div class="entry">
                <div class="author">
					Posted on <?php the_time('l, F jS, Y') ?>
					<?php echo $custom_fields['author'] ?>
					<?php the_tags('<br /> More articles by ', ', ', ''); ?>
					<br />Posted in <?php the_category(', ') ?>
					<?php edit_post_link('Edit this entry.','<br />',''); ?>
				</div>
                <br>
                <?php if ($custom_fields['pmo'] != '') : 
                    gg_pmo_post(true); 
                else : 
                    the_content('<p class="serif">Read the rest of this entry &raquo;</p>');
                    gg_thread_link();
                endif; ?>
                
				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>

			</div>
		</div>

        <?php //comments_template(); ?>
        
	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div>


<?php get_footer(); ?>
