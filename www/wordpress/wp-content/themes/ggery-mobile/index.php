<?php get_header(); ?>

<div id="content" class="narrowcolumn">

<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>
    <?php $custom_fields = gg_get_custom_fields(); ?>

    <div class="post" id="post-<?php the_ID(); ?>">
        <div class="entry">
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
    </div>

    <?php endwhile; ?>

    <div class="navigation">
        <?php next_posts_link('&laquo; Previous &laquo;') ?>  <?php previous_posts_link('&raquo; Next &raquo;') ?>
    </div>

<?php else : ?>

    <h2 class="center">Not Found</h2>
    <p class="center">Sorry, but you are looking for something that isn't here.</p>
    <?php include (TEMPLATEPATH . "/searchform.php"); ?>

<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
