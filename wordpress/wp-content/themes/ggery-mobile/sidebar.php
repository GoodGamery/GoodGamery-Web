	<div id="sidebar_div">
		<ul id="sidebar">
            <li>
                <?php include (TEMPLATEPATH . '/searchform.php'); ?>
            </li>

            <li>
                <?php /* If this is a 404 page */ if (is_404()) { ?>
                <?php /* If this is a category archive */ } elseif (is_category()) { ?>
                <p>You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>
    
                <?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
                <p>You are currently browsing the <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> weblog archives
                for the day <?php the_time('l, F jS, Y'); ?>.</p>
    
                <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                <p>You are currently browsing the <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> weblog archives
                for <?php the_time('F, Y'); ?>.</p>
    
                <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                <p>You are currently browsing the <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> weblog archives
                for the year <?php the_time('Y'); ?>.</p>
    
                <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
                <p>You have searched the <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> weblog archives
                for <strong>'<?php echo wp_specialchars($s); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>
    
                <?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                <p>You are currently browsing the <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> weblog archives.</p>
    
                <?php } ?>
            </li>

            <?php wp_list_pages('title_li=<h2>Pages</h2>' ); ?>

            <li><h2>Archives</h2>
                <ul>
                <?php wp_get_archives('type=monthly'); ?>
                </ul>
            </li>

            <li><h2>Categories</h2>
                <ul>
                <?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
                </ul>
            </li>
		</ul>
	</div>