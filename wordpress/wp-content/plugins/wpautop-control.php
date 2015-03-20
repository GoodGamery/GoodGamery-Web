<?php
/* Plugin Name: wpautop control
 * Plugin URI: http://goodgamery.com/
 * Author: Mark Diehr
 * Author URI: http://diehrstraits.com/
 * Version: 1.0
 * Description: Disables wpautop on the_content and the_excerpt filters
 */
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
  
?>