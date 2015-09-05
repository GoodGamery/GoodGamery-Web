<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

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

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
    
        <img class="foot_img" src="http://www.goodgamery.com/bottoms/oac.jpg">

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>