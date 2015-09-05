<?php

// This file is part of the Carrington Mobile Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2009 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

load_theme_textdomain('carrington-mobile');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('CFCT_HOME_LIST_LENGTH', 5);
define('CFCT_HOME_LATEST_LENGTH', 250);

$cfct_options = array(
	'cfct_about_text'
	, 'cfct_credit'
	, 'cfct_posts_per_archive_page'
	, 'cfct_wp_footer'
);

function cfct_blog_init() {
	if (cfct_get_option('cfct_ajax_load') == 'yes') {
		cfct_ajax_load();
	}
}
add_action('init', 'cfct_blog_init');

function cfct_archive_title() {
	if(is_author()) {
		$output = __('Posts by:');
	} elseif(is_category()) {
		$output = __('Category Archives:');
	} elseif(is_tag()) {
		$output = __('Tag Archives:');
	} elseif(is_archive()) {
		$output = __('Archives:');
	}
	$output .= ' ';
	echo $output;
}

function cfct_mobile_post_gallery_columns($columns) {
	return 1;
}
add_filter('cfct_post_gallery_columns', 'cfct_mobile_post_gallery_columns');

if (!is_admin()) {
	wp_enqueue_script('jquery');
	wp_enqueue_script('carrington-mobile', get_bloginfo('template_directory').'/js/mobile.js', array('jquery'), '1.0');
}

include_once(CFCT_PATH.'carrington-core/carrington.php');

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
        <a href="<?php echo $pmo_addr; ?>"><img class="icon" src="http://goodgamery.com/icons/pmoguy_icon.jpg"></a>
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