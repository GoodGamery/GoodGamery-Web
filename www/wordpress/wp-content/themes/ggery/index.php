<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="content" class="narrowcolumn">

	<!--  BEGIN THE Temporary Banner Function! -->
	<?php echo(gg_display_banner());  ?>
	<!-- END OF THE Temporary Banner Function! -->

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
        <?php $custom_fields = gg_get_custom_fields(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="entry" class="postcolor">
				<!-- Post starts here -->
				<?php if ($custom_fields['pmo'] != '' ) :
					 gg_pmo_post();
				elseif ($custom_fields['icon'] != '' && $custom_fields['author'] != '') :
                    gg_post_enhanced();
				else :
                    gg_post_enhanced();
                endif; ?>
				<!-- Post ends here -->
			</div>
            <p class="postmetadata">Posted in <?php the_category(', ') ?><?php the_tags(' | ', ', ', ''); ?><?php edit_post_link('Edit', ' | ', ''); ?> </p>
            <div class="post_divider"></div>
		</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

        <img class="foot_img" src="<?php bloginfo('stylesheet_directory'); ?>/images/oac.jpg">
	</div>


<?php get_footer(); ?>
