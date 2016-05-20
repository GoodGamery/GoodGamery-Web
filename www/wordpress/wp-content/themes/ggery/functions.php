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
    $pmo_addr = "https://goodgamery.com/pmo/c" . $custom_fields['pmo'] . ".htm";
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
            <a href="https://goodgamery.com/pmo/c<?php echo $custom_fields['pmo']; ?>.htm">
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
}
?>
