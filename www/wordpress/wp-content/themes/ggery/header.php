<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?><?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen">
<?php 
// Checks to see whether it needs a sidebar or not
if ( !$withcomments && !is_single() ) { 
?>

<?php } else { // No sidebar ?>

<?php } ?>
</style>

<?php wp_head(); ?>

<!-- GGery scripts -->
<script src="http://forums.goodgamery.com/includes/java/gg/cardTags.js" type="text/javascript"></script>
<script src="http://forums.goodgamery.com/includes/java/gg/quoteUnnest.js" type="text/javascript"></script>
<script src="http://forums.goodgamery.com/includes/java/gg/Decklist.js" type="text/javascript"></script>

</head>

<body>
<div id="page">
<div id="header">
    <div id="headerimg">
        <!-- The header image goes here -->
        <table id="headercontent">
            <tr>
                <td width="266" height="100" >
                    <a href="<?php bloginfo('url'); ?>"><img src = "<?php bloginfo('stylesheet_directory'); ?>/images/invisibutton.gif" border="0"></a>
                </td>
                <td width="150" height="100" valign="middle">
                    <center><a href="http://forums.goodgamery.com/viewtopic.php?t=1428"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/decoder_little.jpg"></a></center>
                </td>
                <td width="200" height="100" valign="center">
                    
                    <a href="http://forums.goodgamery.com/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/newforumlink.jpg"></a><br>
                    <a href="http://wbe02.mibbit.com/?settings=ececfe11aee20d6298208a748d9a6abc&server=irc.umich.edu&channel=%23goodgamery&noServerNotices=true&noServerMotd=true&autoConnect=true&nick=Morph22"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/newchatlink.jpg"></a>
                </td>
                <td width="184" height="100" valign="bottom">
                    <center>
                        <?php $my_query = new WP_Query('category_name=PMO&showposts=1');
                              while ($my_query->have_posts()) : $my_query->the_post();
							  $do_not_duplicate = $post->ID;
						 ?>
							<?php
								// Set up the PMO address to use for this post
								$pmo_addr = '0';
								$mykey_values = get_post_custom_values('pmo');
								if($mykey_values):
									foreach ( $mykey_values as $key => $value )
									{
										$pmo_addr = $value; 
									}
								endif;
							 ?>
                            <div class="promtg_header">
                                <a href="http://www.goodgamery.com/pmo/c<?php echo $pmo_addr ?>.htm">
                                    <img src="http://goodgamery.com/pmo_icon.jpg">
									<br><b>PMO</b> #<?php echo $pmo_addr ?>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </center>
                </td>
            </tr>
        </table>        
    </div>
</div>
