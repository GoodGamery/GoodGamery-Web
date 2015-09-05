<?php
/*
Plugin Name: GoodGamery Best-of
Plugin URI: http://goodgamery.com
Description: Displays bestof articles in the sidebar.
Version: 0.5
Author: Mark Diehr
Author URI: http://DiehrStraits.com/blog/
*/

// Put functions into one big function we'll call at the plugins_loaded
// action. This ensures that all required plugin functions are defined.
function widget_gg_bestofs_init() {

	// Check for the required plugin functions. This will prevent fatal
	// errors occurring when you deactivate the dynamic-sidebar plugin.
	if ( !function_exists('register_sidebar_widget') )
		return;

	// This is the function that outputs our bestof images.
	function widget_gg_bestof_images($args) {
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Each widget can store its own options. We keep strings here.
		$options = get_option('widget_gg_bestof_images');
		$number = $options['number'];
        
		// These lines generate our output. Widgets can be very complex
		// but as you can see here, they can also be very, very simple.
		echo $before_widget . $before_title . $title . $after_title;
		gg_sidebar_bestofs($number);
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_gg_bestof_images_control()
    {
		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_gg_bestof_images');
		if ( !is_array($options) )
			$options = array('number'=>'3');
		if ( $_POST['ggbestofs-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['number'] = strip_tags(stripslashes($_POST['ggbestofs-number']));
			update_option('widget_gg_bestof_images', $options);
		}

		// Be sure you format your options to be valid HTML attributes.
		$title = htmlspecialchars($options['number'], ENT_QUOTES);
		
		// Here is our little form segment. Notice that we don't need a
		// complete form. This will be embedded into the existing form.
		echo '<p style="text-align:right;"><label for="ggbestofs-number">' . __('Number:') . ' <input style="width: 200px;" id="ggbestofs-number" name="ggbestofs-number" type="text" value="'.$title.'" /></label></p>';
		echo '<input type="hidden" id="ggbestofs-submit" name="ggbestofs-submit" value="1" />';
	}
	
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget(array('GG bestofs', 'widgets'), 'widget_gg_bestof_images');

	// This registers our optional widget control form. Because of this
	// our widget will have a button that reveals a 300x100 pixel form.
	register_widget_control(array('GG bestofs', 'widgets'), 'widget_gg_bestof_images_control', 300, 100);
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_gg_bestofs_init');

?>
<?php
function gg_sidebar_bestofs($number_of_bestofs)
{
?>
    <li>
		<!-- <a href="http://goodgamery.com/index.php/category/best-of/"><img src="http://goodgamery.com/wordpress/wp-content/themes/ggery/images/right_head.jpg" /></a><br /> -->
        <?php
        $category = 'best of';
        $order = 'rand';
        $my_query = new WP_Query('category_name='.$category.'&showposts='.$number_of_bestofs.'&orderby='.$order);
        while ($my_query->have_posts()) :
            $my_query->the_post();
            $do_not_duplicate = $post->ID;
        ?>
            <?php $custom_fields = gg_get_custom_fields(); ?>
                <div class="bestof_sidebar" style="clear:both; margin-left: 10px;">
					<a href="<?php the_permalink(); ?>">
						<img src="http://goodgamery.com/gg/icons/bestof.png" style="float: left; margin-right: 4px;">
						<?php the_title(); ?>
					</a>
                </div>
        <?php endwhile; ?>
    </li>
<?php
}
?>