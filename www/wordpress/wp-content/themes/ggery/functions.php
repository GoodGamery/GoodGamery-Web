<?php
if ( function_exists('register_sidebar') )
    register_sidebar();
?>
<?php
function gg_get_custom_fields()
{
    // Magical hackery to display custom posts
    $custom_fields = array('pmo' => '', 'icon' => '', 'author' => '', 'thread' => '');
    $custom_field_keys = get_post_custom_keys();
    if($custom_field_keys)
    {
        foreach ( $custom_field_keys as $key => $field )
        {
            $fieldt = trim($field);
            if ( '_' == $fieldt{0} )
                continue;
                
            $mykey_values = get_post_custom_values($field);
            foreach ( $mykey_values as $vkey => $value )
            {
                //echo "------> $field  => $value<br />";
                $custom_fields[$field] = $value;
            }
        }
    }
    return $custom_fields;
}
?>
<?php
function gg_pmo_post()
{
    $custom_fields = gg_get_custom_fields();
    $pmo_addr = "http://www.goodgamery.com/pmo/c" . $custom_fields['pmo'] . ".htm";
?>
    <!-- PMO Post -->
    <div class="entry_heading">
    <h2>
        <a href="<?php echo $pmo_addr; ?>" rel="bookmark" title="Permanent Link to <?php echo the_title(); ?>">
            <?php echo the_title(); ?>
        </a>
    </h2>
    <small><?php echo the_time('F jS, Y'); ?></small>
    </div>
    <div class="frontpage">
        <a href="<?php echo $pmo_addr; ?>"><img class="icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/pmoguy_icon.jpg"></a>
        <div class="front_text">
            <span class="author">by anonymous</span>
            <br /><br />
            Pro MTG Online, the ultimate self-aware Magic strategy web comic, has updated itself.
            <a href="http://www.goodgamery.com/pmo/c<?php echo $custom_fields['pmo']; ?>.htm">
                Click here to read it!
            </a>
        </div>
    </div>
<?php 
}
?>
<?php 
function gg_post_enhanced()
{
    $custom_fields = gg_get_custom_fields();
?>
    <!-- Custom Enhanced Post - uses the_excerpt, and the custom fields icon and author -->
    <div class="entry_heading">
        <h2>
            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title() ?>"><?php the_title() ?></a>
        </h2>
        <small><?php the_time('F jS, Y') ?></small>
    </div>
    <div class="frontpage">
        <a href="<?php the_permalink() ?>">
            <?php if( $custom_fields['card'] != '') : ?>
                <div class="blank_icon"><div class="icon_card"><img alt="Card Icon" src="<?php echo $custom_fields['card']; ?>" /></div></div>
            <?php elseif( $custom_fields['icon'] == '') : ?>
                <img class="icon" alt="Missing Article Icon" src="<?php bloginfo('stylesheet_directory'); ?>/images/error_icon.jpg" />
            <?php else : ?>
                <img class="icon" alt="Article Icon" src="<?php echo $custom_fields['icon']; ?>" />
            <?php endif; ?>
        </a>
        <div class="front_text">
            <span class="author"><?php echo $custom_fields['author']; ?></span>
            <br /><br />
            <?php echo the_excerpt(); ?> <a href="<?php echo the_permalink(); ?>">More...</a>
        </div>
    </div>
<?php 
}
?>
<?php 
function gg_thread_link()
{
    $custom_fields = gg_get_custom_fields();
    if( $custom_fields['thread'] != '' ) :
?>
    <a href="<?php echo $custom_fields['thread'] ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/forum_discussion_icon.png"></a>
<?php 
    endif;
}
?>
<?php
function gg_get_facebook_share()
{
?>
	<a href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink() ?>&t=<?php the_title(); ?>" target="_blank" title="Share on Facebook">
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/FaceBookShare.png">
	</a>
<?php
}
?>
<?php
function gg_display_banner()
{
?>
	<!-- BEGIN THE  Temporary Jace Week Post!  
		<BR><center>
		<a href="http://goodgamery.com/index.php/2009/12/19/announcing-jace-week/"><img src="http://www.goodgamery.com/articles/jace/jace1on.jpg" border="0"/></a><a href="http://goodgamery.com/index.php/2009/12/21/jaceless-butcher/"><img src="http://www.goodgamery.com/articles/jace/jace2on.jpg" border="0"/></a><a href="http://goodgamery.com/index.php/2009/12/22/kormus-belleren-jaceful-antelope/"><img src="http://www.goodgamery.com/articles/jace/jace3on.jpg" border="0"/></a><a href="http://goodgamery.com/index.php/2009/12/23/pocket-jaces/"><img src="http://www.goodgamery.com/articles/jace/jace4on.jpg" border="0"/></a><a href="http://goodgamery.com/index.php/2009/12/24/echo-jacer/"><img src="http://www.goodgamery.com/articles/jace/jace5on.jpg" border="0"/></a><a href="http://goodgamery.com/index.php/2009/12/25/jace-cycle/"><img src="http://www.goodgamery.com/articles/jace/jace6on.jpg" border="0"/></a><a href="http://goodgamery.com/index.php/2009/12/26/from-the-vault-jace/"><img src="http://www.goodgamery.com/articles/jace/jace7on.jpg" border="0"/></a>
		</center><BR>
	END OF THE Temporary Jace Week Post! -->

	<!-- BEGIN THE  RotE Alliance Post! 
	er><a href = "http://goodgamery.com/index.php/category/mtg/rise-of-the-eldrazi-alliance/"><img src = "http://www.goodgamery.com/articles/alliance.jpg" border = "0"></A></center><BR>
	END OF THE  RotE Alliance Post! --> 

	<!-- BEGIN THE Emilevin Post!
		<center><a href = "https://forums.goodgamery.com/viewtopic.php?p=305154#p305154"><img src = "http://www.goodgamery.com/articles/emilevin_banner.jpg" border = "0"></A></center><BR>
	END OF THE  Emilevin! Post! --> 

	<!-- BEGIN THE Shirt Post!
		<center><a href = "http://www.printfection.com/goodgamery/pmoticons/_s_344077"><img src = "http://www.goodgamery.com/articles/shirt_banner.jpg" border = "0"></A></center><BR>
	END OF THE  Shirt Post! --> 

	<!-- BEGIN THE BlockRogue Post! --
		<center><a href = "http://www.blockrogue.com"><img src = "http://www.goodgamery.com/brbanner.jpg" border = "0"></A></center><BR>
	-- END OF THE BlockRogue Post! --> 
	
	<!-- BEGIN THE FROM THE VAULT Post! --
		<center>
			<iframe style="border: 0;" src="http://goodgamery.com/ggvault/ftv/banner.php" width="500" height="130" seamless="seamless" ></iframe>
		</center>
		<BR>
	-- END OF THE FROM THE VAULT Post! --> 
<?php
}
?>