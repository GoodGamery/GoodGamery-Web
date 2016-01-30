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
    <table class="post_block">
        <tr>
            <td>
                <a href="<?php echo $pmo_addr; ?>"><img class="icon" src="https://goodgamery.com/icons/pmoguy_icon.jpg"></a>
            </td>
            <td>
                <h2>
                    <a href="<?php echo $pmo_addr; ?>" rel="bookmark" title="Permanent Link to <?php echo the_title(); ?>">
                        <?php echo the_title(); ?>
                    </a>
                </h2>
                <span class="author">by anonymous</span>
                <small><?php the_time('Y-m-d') ?></small>
                <span class="postmetadata"><?php the_category(', ') ?><?php the_tags(' | ', ', ', ''); ?><?php edit_post_link('Edit', ' | ', ''); ?> </span>
            </td>
        </tr>
    </table>
<?php 
}
?>
<?php 
function gg_post_enhanced()
{
    $custom_fields = gg_get_custom_fields();
?>
    <!-- Custom Enhanced Post - uses the_excerpt, and the custom fields icon and author -->
    <table class="post_block">
        <tr>
            <td>
                <a href="<?php the_permalink() ?>">
                    <?php if( $custom_fields['card'] != '') : ?>
                        <div class="blank_icon"><div class="icon_card"><img alt="Card Icon" src="<?php echo $custom_fields['card']; ?>" /></div></div>
                    <?php elseif( $custom_fields['icon'] == '') : ?>
                        <img class="icon" alt="Missing Article Icon" src="http://www.goodgamery.com/icons/error_icon.jpg" />
                    <?php else : ?>
                        <img class="icon" alt="Article Icon" src="<?php echo $custom_fields['icon']; ?>" />
                    <?php endif; ?>
                </a>
            </td>
            <td>
                <h2>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title() ?>"><?php the_title() ?></a>
				</h2>
                <span class="author"><?php echo $custom_fields['author']; ?></span>
                <small><?php the_time('Y-m-d') ?></small>
                <span class="postmetadata"><?php the_category(', ') ?><?php the_tags(' | ', ', ', ''); ?><?php edit_post_link('Edit', ' | ', ''); ?> </span>
            </td>
        </tr>
    </table>
<?php 
}
?>
<?php 
function gg_thread_link()
{
    $custom_fields = gg_get_custom_fields();
    if( $custom_fields['thread'] != '' ) :
?>
    <br/><br/>
    (<a href="<?php echo $custom_fields['thread'] ?>">Discuss this item in the forums!</a>)
<?php 
    endif;
}
?>