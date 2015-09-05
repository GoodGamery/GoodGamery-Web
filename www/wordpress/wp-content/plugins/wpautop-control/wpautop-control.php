<?php
/*
Plugin Name: wpautop-control
Plugin URI: http://blog.bigsmoke.us/tag/wpautop-control/
Description: This plugin allows you fine control of when and when not to enable the wpautop filter on posts.
Author: Rowan Rodrik van der Molen, Jesse Jacobsen <jmatjac@gmail.com>.
Author URI: http://blog.bigsmoke.us
Version: 1.6
*/

if ( is_admin() ) {
  add_action('admin_menu', 'wpautop_control_menu');
  add_action('admin_init', 'wpautop_control_settings');
  register_activation_hook(__FILE__, 'wpautop_control_update');

  function wpautop_control_menu() {
    add_submenu_page('options-general.php', 'wpautop-control', 'wpautop control', 'manage_options', 'wpautop-control-menu', 'wpautop_control_options');
  }

  function wpautop_control_options() {
    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

  ?>
  <div class="wrap">
    <h2>wpautop control options</h2>

    <form method="post" action="options.php">
      <?php settings_fields('wpautop-control') ?>

      <p>Normally, WordPress filters your posts' content using the wpautop filter. What this filter does is that it replaces single newlines with <tt>&lt;br /&gt;</tt> and empty lines with <tt>&lt;p&gt;</tt>. The setting below lets you turn this filter on or off. (You can later override it on a post-by-post basis by setting the wpautop custom field to ‘default’, ‘-breaks’, or ‘off’.)</p>

      <table class="form-table">
        <tr valign="top">
          <th scope="row">wpautop filter on by default?</th>
          <td>
            <label><input type="radio" name="wpautop_by_default" value="default" <?php if ( get_option('wpautop_by_default') == 'default' ) echo 'checked="1"' ?>> default <small>(WordPress' default behaviour)</small></label><br />
            <label><input type="radio" name="wpautop_by_default" value="-breaks" <?php if ( get_option('wpautop_by_default') == '-breaks' ) echo 'checked="1"' ?>> -breaks <small>(turn off WordPress' line breaks)</small></label><br />
            <label><input type="radio" name="wpautop_by_default" value="off" <?php if ( get_option('wpautop_by_default') == 'off' ) echo 'checked="1"' ?>> off <small>(turn off WordPress' auto-formatting)</small></label>
          </td>
      </table>

      <p class="submit">
      <input type="submit" class="button-primary" value="Save Changes" />
      </p>
    </form>
  </div>
  <?php
  }

  function wpautop_control_settings() {
    register_setting('wpautop-control', 'wpautop_by_default');
  }

  function wpautop_control_update() {
    wpautop_control_settings();

    // Upgrade from pre-Jesse boolean option
    $default_on = intval( get_option('wpautop_on_by_default', '1') );
    if ( ! $default_on ) {
      update_option('wpautop_by_default', 'off');
    }
    delete_option('wpautop_on_by_default');
  }
}
else { // ! is_admin()
  add_filter('the_content', 'wpautop_control_filter', 9);

  function wpautop_control_filter($content) {
    global $post;

    // Get the keys and values of the custom fields:
    $post_wpautop_value = get_post_meta($post->ID, 'wpautop', true);

    $filter_type = get_option('wpautop_by_default', 'default');

    if ( !empty($post_wpautop_value) ) {
      if ( in_array($post_wpautop_value, array('true', 'on', 'yes')) ) {
        $filter_type = 'default';
      }
      elseif ( in_array($post_wpautop_value, array('false', 'off', 'no')) ) {
        $filter_type = 'off';
      }
      elseif ( $post_wpautop_value == '-breaks' ) {
        $filter_type = '-breaks';
      }
    }

    if ( $filter_type == "default" ) {
        // Leave WordPress wpautop behavior in place
    } elseif ( $filter_type == "-breaks" ) {
        // Remove the wpautop filter and install our own
      remove_filter('the_content', 'wpautop');
      remove_filter('the_excerpt', 'wpautop');
      add_filter('the_content', function ($pee) { return wpautop($pee, false); } );
      add_filter('the_excerpt', function ($pee) { return wpautop($pee, false); } );
    } elseif ( $filter_type == "off" ) {
        // Remove the wpautop filter completely
      remove_filter('the_content', 'wpautop');
      remove_filter('the_excerpt', 'wpautop');
    }

    return $content;
  }
}

?>
