<div id="footer">
    <a href="http://diehrstraits.com/blog/"><img src = "<?php bloginfo('stylesheet_directory'); ?>/images/title.png"></a>
    <?php if (function_exists('cfmobi_mobile_exit')) { cfmobi_mobile_exit(); } ?>
	<p>
        &copy; 2009 PaZ. Good Gamery is a web site &amp; community for mature gamers (with attitude!) seeking humorous content and discussion related to
        Magic cards, gaming in general, and culture. We'd love to have you join our crew, contribute to the funnay, and become an internet superstar.
		<br /><a href="feed:<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a>
		and <a href="feed:<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a>.
		<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
	</p>
</div>
</div>
		<?php wp_footer(); ?>
</body>
</html>
