<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="content" class="narrowcolumn">

	<!--  BEGIN THE Temporary Banner Function! -->
	<?php gg_display_banner();  ?>
	<!-- END OF THE Temporary Banner Function! -->
	
		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>

		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>

		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>

		<?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle">Search Results</h2>

		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle">Author Archive</h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">Blog Archives</h2>

		<?php } ?>


		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

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
			<p class="postmetadata">Posted in <?php the_category(', ') ?><?php the_tags(' | ', ', ', ''); ?><?php edit_post_link('Edit', ' | ', ''); ?></p>
			<div class="post_divider"></div>
		</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
	</div>


<?php get_footer(); ?>