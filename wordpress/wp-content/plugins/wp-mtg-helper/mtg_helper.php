<?php
/*
Plugin Name: GG WP MtG-Helper
Plugin URI:  http://www.goodgamery.com/
Description: Mtg Helper supports you writing "Magic:the Gathering"-articles
Version: 2.0
Author: Sebastian Sebald with Heavy Modifications by Mark Diehr
Author URI: http://www.goodgamery.com
*/

/*  Copyright 2008  Sebastian Sebald  (email : sebastian (dot) sebald (at) gmail (dot) com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include 'mtg_helper_card.php';
include 'mtg_helper_cardfinder.php';
include 'mtg_helper_options.php';
include 'mtg_helper_parser.php';

// Pre-2.6 compatibility
if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('url') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
define( 'WP_CONTENT_FOLDER', str_replace(ABSPATH, '/', WP_CONTENT_DIR) );
// plugin directory
define('MTGH_DIR', WP_CONTENT_FOLDER.'/plugins/wp-mtg-helper');

//de-/install hooks
if ( function_exists('register_activation_hook') )
	register_activation_hook(__FILE__, 'mtgh_install');
if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__, 'mtgh_uninstall');

//mtgh actions and filter
if ( is_admin() ) {
	add_action('admin_menu', 'add_mtgh_admin_page');
}
if( !is_admin() ){
	add_action('init', 'mtgh_init');
	add_shortcode('cardlist','mtgh_list');
	add_filter('the_content', 'mtgh_list');
	add_filter('the_content', 'mtgh_card');
	if(get_option(mtghComment))
		add_filter('comment_text','mtgh_card');
}

//hook in the options page function
if ( !function_exists("add_mtgh_admin_page") ) {
	function add_mtgh_admin_page() {
		global $wp_version;
		if ( function_exists('add_options_page') && current_user_can('manage_options') ) {
			
			$menutitle = '';
			if ( version_compare( $wp_version, '2.6.999', '>' ) ) {
				$menutitle = '<img src="' . mtgh_get_resource_url('mtgh.png') . '" alt="" />' . ' ';
			}
			$menutitle .= ' MtG Helper';			
			
			add_options_page('MtG Helper', $menutitle , 9, basename(__FILE__), 'mtgh_admin_page');
			
			if ( version_compare( $wp_version, '2.7', '<' ) ) {
				add_filter('plugin_action_links', 'mtgh_filter_plugin_actions', 10, 2);
			} else {
				$plugin = plugin_basename(__FILE__);
				add_filter( 'plugin_action_links_' . $plugin, 'mtgh_filter_plugin_actions_new' );
			}			
		}
	}
}


/*
* pluing mini image by http://bueltge.de/wordpress-plugins-bereichern/811/ (Frank Buelgte)
*/


/*
 * Images/ Icons in base64-encoding
 * @use function mtgh_get_resource_url() for display
 */
if( isset($_GET['resource']) && !empty($_GET['resource'])) {
	# base64 encoding performed by http://www.motobit.com/util/base64-decoder-encoder.asp
	$resources = array(
		'mtgh.png' =>
		'iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAYAAAB24g05AAAAAXNSR0IArs4c6QAAAARnQU1BAACx
jwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABh0RVh0
U29mdHdhcmUAUGFpbnQuTkVUIHYzLjM2qefiJQAAAmlJREFUKFNjZICC86fPCN3YuT3n79+/rJcu
X/3oGha5wzUs6Mq6xYttnu/ZWsIpJv38+6tXfGJW9pNC01NOwvTB6TVt/dl9elL/b7SZ/7/RbPJ/
lqfz5WOXrrJPz6tMmGOr9vP1LMf/ZzO0/+9tnZyNoRkmMDUmZsWDbuv//9cH/D9XqP9/RXFtHUhu
rn/QoafN1v9vd1r9n5qRNRWrAafPnhdabmf8YY2H6v91npr//6/z+78m1Or1RD3Xo1uc1P8/n+z8
/+s8r/+rvQx/7dm2RxnDkMUNTQUrzGX/L4vLmL+ivKH9UpnZ/7cz3P4fLTH632/n8GKup+2HP+s9
/9+ut/zfHx0/A8WAJavXMi4Ncr12NEvz/7GlawOuXL3HvizQ4t3/HX7/LxQb/d/YPS1576JV0ceL
DP7/3+z1f0WE07tnj16Iww1ZOGu++YZYnT8rkt3u7Tt5ig8ksTC3qPNBu9X/e+2W/5dUVk5++eYz
+7Igh5e/V3v+P51t8H9jz+R8RAykZS253qD1f3lq4iqY4NYJc3xPJBr9/7/V5/+6SPvPL19/5FlY
WLj4VY/N/89THP/P8XQ/efPmXQmGOekF7St9lP4faTb/360r+3/zouV2IENOnDonvTHF+vOjmdb/
5zlYPZiVVjxzuZPK/xOlZv/3lpj/35Wm8X+OjfUjhkW5BXM6gkJmrVm4UvvcsZPSly5eZAMZcPvx
Y75pjhafZnh6nXvx5gPP0e1b7afEJ8zZtHyt5d6Nu1XntvcEzaquTWPYu3e38oSpU0XQo+Xl969M
8xOzajZ0Tw4Fyd26f4vxwJHDAujqAOXAMvp256iBAAAAAElFTkSuQmCC');
	
	if(array_key_exists($_GET['resource'], $resources)) {

		$content = base64_decode($resources[ $_GET['resource'] ]);

		$lastMod = filemtime(__FILE__);
		$client = ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false );
		// Checking if the client is validating his cache and if it is current.
		if (isset($client) && (strtotime($client) == $lastMod)) {
			// Client's cache IS current, so we just respond '304 Not Modified'.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 304);
			exit;
		} else {
			// Image not cached or cache outdated, we respond '200 OK' and output the image.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 200);
			header('Content-Length: '.strlen($content));
			header('Content-Type: image/' . substr(strrchr($_GET['resource'], '.'), 1) );
			echo $content;
			exit;
		}
	}
}

/*
 * Display Images/ Icons in base64-encoding
 * @return $resourceID
 */
function mtgh_get_resource_url($resourceID) {
	
	return trailingslashit( get_bloginfo('url') ) . '?resource=' . $resourceID;
}

/*
 * Add action link(s) to plugins page
 * Thanks Dion Hulse -- http://dd32.id.au/wordpress-plugins/?configure-link
 */
function mtgh_filter_plugin_actions($links, $file){
	static $this_plugin;

	if( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=mtg_helper.php">Settings</a>';
		$links = array_merge( array($settings_link), $links); // before other links
	}
	return $links;
}


/*
 * @version WP 2.7
 * Add action link(s) to plugins page
 */
function mtgh_filter_plugin_actions_new($links) {
 
	$settings_link = '<a href="options-general.php?page=mtg_helper.php">Settings</a>';
	array_unshift( $links, $settings_link );
 
	return $links;
}

//initialize the plugin, register js and css
function mtgh_init() {
	if (function_exists('wp_enqueue_script')) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('mtgh', get_bloginfo('wpurl') . MTGH_DIR . '/js/mtgh.js', array('jquery'), '2.13a.4' );
		wp_enqueue_script('dimnesions', get_bloginfo('wpurl') . MTGH_DIR . '/js/jquery.dimensions.min.js', array('jquery'), '1.0' );
		add_action('wp_head', 'init_css');
	} else {
		add_action('wp_head', 'init_header');
	}
}

//use if the enqueue function doesnt work (hard coded)
function init_header(){
	$tooltip_url = get_bloginfo('wpurl') . MTGH_DIR .'/js/mtgh.js';
	$dimension_url = get_bloginfo('wpurl') . MTGH_DIR .'/js/jquery.dimensions.min.js.js';
	$jquery_url = get_bloginfo('wpurl') . '/wp-includes/js/jquery/jquery.js';
	?>
		<script type="text/javascript" src="<?php echo $tooltip_url ?>"></script>
		<script type="text/javascript" src="<?php echo $jquery_url ?>"></script>
		<script type="text/javascript" src="<?php echo $dimension_url ?>"></script>
	<?php
	init_css();
}

//load the css
function init_css(){
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . MTGH_DIR . '/css/mtgh.css" media="screen" />' . "\n";
}

//from http://bueltge.de/wp-addquicktags-de-plugin/120/
// only for post.php, page.php, post-new.php, page-new.php, comment.php
if (strpos($_SERVER['REQUEST_URI'], 'post.php') || strpos($_SERVER['REQUEST_URI'], 'post-new.php') || strpos($_SERVER['REQUEST_URI'], 'page-new.php') || strpos($_SERVER['REQUEST_URI'], 'page.php') || strpos($_SERVER['REQUEST_URI'], 'comment.php')) {
	add_action('admin_footer', 'mtg_add_buttons');


function mtg_add_buttons() {
	
	//get buttons
	$buttons = array();
	$tags = get_option(mtghCustomTags);
	foreach( $tags as $i => $tag ){
		if( $tag['button'] ){
			$buttons[$i]['txt'] = $tag['name'];
			$buttons[$i]['start'] = '['.$tag['name'].']';
			$buttons[$i]['end'] = '[/'.$tag['name'].']';
		}
	}
	$buttons[$i+1]['txt'] = 'card';
	$buttons[$i+1]['start'] = '[card]';
	$buttons[$i+1]['end'] = '[/card]';	
	$cardlist = get_option(mtghCardlistSettings);
	if( $cardlist['button'] ){
		$buttons[$i+2]['txt'] = 'cardlist';
		$buttons[$i+2]['start'] = '[cardlist]';
		$buttons[$i+2]['end'] = '[/cardlist]';
	}
	
	//let the editor know that i have some new buttons for him with java script
	echo '
		<script type="text/javascript">
		<!--
		if (mtghToolbar = document.getElementById("ed_toolbar")) {
			var mtghNr, mtghBut, mtghStart, mtghEnd;
	';
	
	//here they come
	foreach($buttons as $i=>$b){
		$txt = html_entity_decode(stripslashes($b['txt']), ENT_COMPAT, get_option('blog_charset'));
		$text = stripslashes($b['text']);
		$b['text'] = stripslashes($b['text']);
		$start = preg_replace('![\n\r]+!', "\\n", $b['start']);
		$start = str_replace("'", "\'", $start);
		$end = preg_replace('![\n\r]+!', "\\n", $b['end']);
		$end = str_replace("'", "\'", $end);
		
		//java script for adding buttons (called before body closes)
		echo '
			mtghStart = \'' . $start . '\';
			mtghEnd = \'' . $end . '\';
			mtghNr = edButtons.length;
			edButtons[mtghNr] = new edButton(\'ed_mtgh' . $i . '\', \'' . $b['txt'] . '\', mtghStart, mtghEnd,\'\');
			var mtghBut = mtghToolbar.lastChild;
			while (mtghBut.nodeType != 1) {
				mtghBut = mtghBut.previousSibling;
			}
			mtghBut = mtghBut.cloneNode(true);
			mtghToolbar.appendChild(mtghBut);
			mtghBut.value = \'' . $b['txt'] . '\';
			mtghBut.title = mtghNr;
			mtghBut.onclick = function () {edInsertTag(edCanvas, parseInt(this.title));}
			mtghBut.id = "ed_mtgh' . $i .'";
		';
	}

	//close java script
	echo '
		}
		//-->
		</script>
	';
	}
}

//formating from string into arrays
function mtgh_make_style($style){
	$a = explode(" ",$style);
	$style = array();
	switch( $a[0] ){
		case 'cardbox' :
			@list($style['typ'],$style['col'],$style['side']) = $a;
			break;
		case 'tooltip' :
			@list($style['typ'],$style['col']) = $a;
			break;
		case 'thumbnail' :
			@list($style['typ'],$style['rowcount'],$style['action']) = $a;
			break;
		case 'headline' :
			if( $a[1] == "true" ){
				$a[1] = true;
			}else{
				$a[1] = false;
			}			
			@list($style['typ'],$style['count']) = $a;
			break;
		case 'tabbed' :
			@list($style['typ'],$style['rowcount']) = $a;
			break;
		default:
			switch ( $a[0] ){
				case 'true':
					$a[0] = true;
					break;
				case 'false':
					$a[0] = false;
					break;
				case 'initial':
					$a[0] = 'initial';
					break;					
			}
			switch ( $a[1] ){
				case 'true':
					$a[1] = true;
					break;
				case 'false':
					$a[1] = false;
					break;
				case 'toggle':
					$a[1] = 'toggle';
					break;					
			}			
			@list($style['mini'],$style['pick']) = $a;
	}
	
	return $style;
}

//preloading the cards for a better look
function cache_cards($names){
	$images = array();
	if(is_string($names)){
		$images[] = "<img src='".get_source_from_name($names)."' style='display:none;width:1px;height:1px;' />";
	}
	else{
		foreach ($names as $cardname){
			$images[] = "<img src='".get_source_from_name($cardname)."' style='display:none;width:1px;height:1px;' />";
		}
	}
	return implode("",$images);
}

//mighty print function (only for debugging and programming)
function print_a(){ 
	if(func_num_args()==1 ){ 
		echo "<pre style='font-size:11px;border:1px solid#000;background-color:#FC3;'>";print_r(func_get_arg(0));echo "</pre>"; 
	}else{ 
		echo "<pre style='font-size:11px;border:1px solid#000;background-color:#BBB;'>"; 
		$v = array(	'id'.substr(md5(microtime().rand()),0,10),
			'Output',
			'<img style="border:0px;"  src="data:image/gif;base64,R0lGODlhCAAHALMKAGOPRY/NU5LNXpDNVJbUWJDEaZnXWpPNX4vFWXyuWv///wAAAAAAAAAAAAAAAAAAACH5BAHoAwoALAAAAAAIAAcAAAQXUClAgZQgCHvB2BhFFNUkGAfCmckaXhEAOw%3D%3D" />',
			'Output',
			'<img style="border:0px;" src="data:image/gif;base64,R0lGODlhCQAKALMKAGOPRZLNXo/NU5DNVJbUWJnXWpDEaZPNX3yuWovFWf///wAAAAAAAAAAAAAAAAAAACH5BAHoAwoALAAAAAAJAAoAAAQcUMlJJ6j2ZgCCVoAwEIUndYFxIBrHJV+GgTMWAQA7" />');
		$c = sprintf("%s %s",$v[2],$v[1]);
		$e = sprintf("%s %s",$v[4],$v[3]);		
		echo "<a href='#' style='color:#000;' onclick=\"
			d = document.getElementById('".$v[0]."').style;
			this.innerHTML = (d.display=='block')?'".htmlentities($e)."':'".htmlentities($c)."';
			d.display = (d.display=='block')?'none':'block';
			return false;\">".$c."</a>\n";
		echo "<div id='".$v[0]."' style='display:block;'>";
		foreach(func_get_args() as $item){ 
			echo "<div style='font-size:11px;border:1px solid #000;margin:3px; background-color:#FC3;'>"; 
				print_r($item); 
			echo "</div>"; 
		} 
		echo "</div>";
		echo "</pre>"; 
	}
}

?>