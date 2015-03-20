<?php

/*
Plugin Name: WordPress Mobile Edition 
Plugin URI: http://crowdfavorite.com/wordpress/ 
Description: Show your mobile visitors a site presentation designed just for them. Rich experience for iPhone, Android, etc. and clean simple formatting for less capable mobile browsers. Cache-friendly with a Carrington-based theme, and progressive enhancement for advanced mobile browsers.  
Version: 3.1
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/

// WordPress Mobile Edition
//
// Copyright (c) 2002-2009 Crowd Favorite, Ltd.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// *****************************************************************

// ini_set('display_errors', '1'); ini_set('error_reporting', E_ALL);

//define('CF_MOBILE_THEME', 'carrington-mobile-1.0.2');
define('CF_MOBILE_THEME', 'ggery-mobile');

if (!defined('PLUGINDIR')) {
	define('PLUGINDIR','wp-content/plugins');
}

load_plugin_textdomain('cf-mobile');

if (is_file(trailingslashit(ABSPATH.PLUGINDIR).'wp-mobile.php')) {
	define('CFMOBI_FILE', trailingslashit(ABSPATH.PLUGINDIR).'wp-mobile.php');
}
else if (is_file(trailingslashit(ABSPATH.PLUGINDIR).'wordpress-mobile-edition/wp-mobile.php')) {
	define('CFMOBI_FILE', trailingslashit(ABSPATH.PLUGINDIR).'wordpress-mobile-edition/wp-mobile.php');
}

register_activation_hook(CFMOBI_FILE, 'cfmobi_install');

function cfmobi_default_browsers($type = 'mobile') {
	$mobile = array(
		'2.0 MMP',
		'240x320',
		'400X240',
		'AvantGo',
		'BlackBerry',
		'Blazer',
		'Cellphone',
		'Danger',
		'DoCoMo',
		'Elaine/3.0',
		'EudoraWeb',
		'Googlebot-Mobile',
		'hiptop',
		'IEMobile',
		'KYOCERA/WX310K',
		'LG/U990',
		'MIDP-2.',
		'MMEF20',
		'MOT-V',
		'NetFront',
		'Newt',
		'Nintendo Wii',
		'Nitro', // Nintendo DS
		'Nokia',
		'Opera Mini',
		'Palm',
		'PlayStation Portable',
		'portalmmm',
		'Proxinet',
		'ProxiNet',
		'SHARP-TQ-GX10',
		'SHG-i900',
		'Small',
		'SonyEricsson',
		'Symbian OS',
		'SymbianOS',
		'TS21i-10',
		'UP.Browser',
		'UP.Link',
		'webOS', // Palm Pre, etc.
		'Windows CE',
		'WinWAP',
		'YahooSeeker/M1A1-R2D2',
	);
	$touch = array(
		'iPhone',
		'iPod',
		'Android',
		'BlackBerry9530',
		'LG-TU915 Obigo', // LG touch browser
		'LGE VX',
		'webOS', // Palm Pre, etc.
		'Nokia5800',
	);
	switch ($type) {
		case 'mobile':
		case 'touch':
			return $$type;
	}
}

$mobile = explode("\n", trim(get_option('cfmobi_mobile_browsers')));
$cfmobi_mobile_browsers = apply_filters('cfmobi_mobile_browsers', $mobile);
$touch = explode("\n", trim(get_option('cfmobi_touch_browsers')));
$cfmobi_touch_browsers = apply_filters('cfmobi_touch_browsers', $touch);

function cfmobi_install() {
	global $cfmobi_default_mobile_browsers;
	add_option('cfmobi_mobile_browsers', implode("\n", cfmobi_default_browsers('mobile')));
	global $cfmobi_default_touch_browsers;
	add_option('cfmobi_touch_browsers', implode("\n", cfmobi_default_browsers('touch')));
}

function cfmobi_init() {
	global $cfmobi_mobile_browsers, $cfmobi_touch_browsers;
	if (is_admin() && !cfmobi_installed()) {
		global $wp_version;
		if (isset($wp_version) && version_compare($wp_version, '2.5', '>=')) {
			add_action('admin_notices', create_function( '', "echo '<div class=\"error\"><p>WP Mobile is incorrectly installed. Please check the <a href=\"http://alexking.org/projects/wordpress/readme?project=wordpress-mobile-edition\">README</a>.</p></div>';" ) );
		}
	}
	if (isset($_COOKIE['cf_mobile']) && $_COOKIE['cf_mobile'] == 'false') {
		add_action('the_content', 'cfmobi_mobile_available');
	}
}
add_action('init', 'cfmobi_init');

function cfmobi_check_mobile() {
	global $cfmobi_mobile_browsers, $cfmobi_touch_browsers;
	$mobile = null;
	if (!isset($_SERVER["HTTP_USER_AGENT"]) || (isset($_COOKIE['cf_mobile']) && $_COOKIE['cf_mobile'] == 'false')) {
		$mobile = false;
	}
	else if (isset($_COOKIE['cf_mobile']) && $_COOKIE['cf_mobile'] == 'true') {
		$mobile = true;
	}
	$browsers = array_merge($cfmobi_mobile_browsers, $cfmobi_touch_browsers);
	if (is_null($mobile) && count($browsers)) {
		foreach ($browsers as $browser) {
			if (!empty($browser) && strpos($_SERVER["HTTP_USER_AGENT"], trim($browser)) !== false) {
				$mobile = true;
			}
		}
	}
	if (is_null($mobile)) {
		$mobile = false;
	}
	return apply_filters('cfmobi_check_mobile', $mobile);
}

if (cfmobi_check_mobile()) {
	add_filter('template', 'cfmobi_template');
	add_filter('option_template', 'cfmobi_template');
	add_filter('option_stylesheet', 'cfmobi_template');
}

function cfmobi_template($theme) {
	if (cfmobi_installed()) {
		return apply_filters('cfmobi_template', CF_MOBILE_THEME);
	}
	else {
		return $theme;
	}
}

function cfmobi_installed() {
	return is_dir(ABSPATH.'/wp-content/themes/'.CF_MOBILE_THEME);
}

function cfmobi_mobile_exit() {
	echo '<p><a href="'.trailingslashit(get_bloginfo('home')).'?cf_action=reject_mobile">Exit the Mobile Edition</a> <span class="small">(view the standard browser version)</span>.</p>';
}

function cfmobi_mobile_available($content) {
	if (!defined('WPCACHEHOME')) {
		$content = $content.'<p><a href="'.trailingslashit(get_bloginfo('home')).'?cf_action=show_mobile">Return to the Mobile Edition</a>.</p>';
	}
	return $content;
}

function cfmobi_mobile_link() {
	if (!defined('WPCACHEHOME')) {
		echo '<a href="'.trailingslashit(get_bloginfo('home')).'?cf_action=show_mobile">Mobile Edition</a>';
	}
}

// TODO - add sidebar widget for link, with some sort of graphic?

function cfmobi_request_handler() {
	if (!empty($_GET['cf_action'])) {
		$url = parse_url(get_bloginfo('home'));
		$domain = $url['host'];
		if (!empty($url['path'])) {
			$path = $url['path'];
		}
		else {
			$path = '/';
		}
		$redirect = false;
		switch ($_GET['cf_action']) {
			case 'cfmobi_admin_js':
				cfmobi_admin_js();
				break;
			case 'cfmobi_admin_css':
				cfmobi_admin_css();
				die();
				break;
			case 'reject_mobile':
				setcookie(
					'cf_mobile'
					, 'false'
					, time() + 300000
					, $path
					, $domain
				);
				$redirect = true;
				break;
			case 'show_mobile':
				setcookie(
					'cf_mobile'
					, 'true'
					, time() + 300000
					, $path
					, $domain
				);
				$redirect = true;
				break;
			case 'cfmobi_who':
				if (current_user_can('manage_options')) {
					header("Content-type: text/plain");
					echo sprintf(__('Browser: %s', 'cf-mobile'), strip_tags($_SERVER['HTTP_USER_AGENT']));
					die();
				}
				break;
		}
		if ($redirect) {
			if (!empty($_SERVER['HTTP_REFERER'])) {
				$go = $_SERVER['HTTP_REFERER'];
			}
			else {
				$go = get_bloginfo('home');
			}
			header('Location: '.$go);
			die();
		}
	}
	if (!empty($_POST['cf_action'])) {
		switch ($_POST['cf_action']) {
			case 'cfmobi_update_settings':
				cfmobi_save_settings();
				wp_redirect(trailingslashit(get_bloginfo('wpurl')).'wp-admin/options-general.php?page=wp-mobile.php&updated=true');
				die();
				break;
		}
	}
}
add_action('init', 'cfmobi_request_handler');

function cfmobi_admin_js() {
	global $cfmobi_default_mobile_browsers, $cfmobi_default_touch_browsers;
	header('Content-type: text/javascript');
	$mobile = str_replace(array("'","\r", "\n"), array("\'", '', ''), implode('\\n', cfmobi_default_browsers('mobile')));
	$touch = str_replace(array("'","\r", "\n"), array("\'", '', ''), implode('\\n', cfmobi_default_browsers('touch')));
?>
jQuery(function($) {
	$('#cfmobi_mobile_reset').click(function() {
		$('#cfmobi_mobile_browsers').val('<?php echo $mobile; ?>');
		return false;
	});
	$('#cfmobi_touch_reset').click(function() {
		$('#cfmobi_touch_browsers').val('<?php echo $touch; ?>');
		return false;
	});
});
<?php
	die();
}
if (is_admin()) {
	wp_enqueue_script('cfmobi_admin_js', trailingslashit(get_bloginfo('url')).'?cf_action=cfmobi_admin_js', array('jquery'));
}

function cfmobi_admin_css() {
	header('Content-type: text/css');
?>
fieldset.options div.option {
	background: #EAF3FA;
	margin-bottom: 8px;
	padding: 10px;
}
fieldset.options div.option label {
	display: block;
	float: left;
	font-weight: bold;
	margin-right: 10px;
	width: 150px;
}
fieldset.options div.option span.help {
	color: #666;
	font-size: 11px;
	margin-left: 8px;
}
#cfmobi_mobile_browsers, #cfmobi_touch_browsers {
	height: 200px;
	width: 300px;
}
#cfmobi_mobile_reset, #cfmobi_touch_reset {
	display: block;
	font-size: 11px;
	font-weight: normal;
}
<?php
	die();
}

function cfmobi_admin_head() {
	echo '<link rel="stylesheet" type="text/css" href="'.trailingslashit(get_bloginfo('url')).'?cf_action=cfmobi_admin_css" />';
}
add_action('admin_head', 'cfmobi_admin_head');

$cfmobi_settings = array(
	'cfmobi_mobile_browsers' => array(
		'type' => 'textarea',
		'label' => 'Mobile Browsers <a href="#" id="cfmobi_mobile_reset">Reset to Default</a>',
		'default' => cfmobi_default_browsers('mobile'),
		'help' => '',
	),
	'cfmobi_touch_browsers' => array(
		'type' => 'textarea',
		'label' => 'Touch Browsers <a href="#" id="cfmobi_touch_reset">Reset to Default</a>',
		'default' => cfmobi_default_browsers('touch'),
		'help' => '(iPhone, Android G1, BlackBerry Storm, etc.)',
	),
);

function cfmobi_setting($option) {
	$value = get_option($option);
	if (empty($value)) {
		global $cfmobi_settings;
		$value = $cfmobi_settings[$option]['default'];
	}
	return $value;
}

function cfmobi_admin_menu() {
	if (current_user_can('manage_options')) {
		add_options_page(
			__('WordPress Mobile Edition', 'cf-mobile')
			, __('Mobile', 'cf-mobile')
			, 10
			, basename(__FILE__)
			, 'cfmobi_settings_form'
		);
	}
}
add_action('admin_menu', 'cfmobi_admin_menu');

function cfmobi_plugin_action_links($links, $file) {
	$plugin_file = basename(__FILE__);
	if ($file == $plugin_file) {
		$settings_link = '<a href="options-general.php?page='.$plugin_file.'">'.__('Settings', 'cf-mobile').'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}
add_filter('plugin_action_links', 'cfmobi_plugin_action_links', 10, 2);

if (!function_exists('cf_settings_field')) {
	function cf_settings_field($key, $config) {
		$option = get_option($key);
		$label = '<label for="'.$key.'">'.$config['label'].'</label>';
		$help = '<span class="help">'.$config['help'].'</span>';
		switch ($config['type']) {
			case 'select':
				$output = $label.'<select name="'.$key.'" id="'.$key.'">';
				foreach ($config['options'] as $val => $display) {
					$option == $val ? $sel = ' selected="selected"' : $sel = '';
					$output .= '<option value="'.$val.'"'.$sel.'>'.htmlspecialchars($display).'</option>';
				}
				$output .= '</select>'.$help;
				break;
			case 'textarea':
				if (is_array($option)) {
					$option = implode("\n", $option);
				}
				$output = $label.'<textarea name="'.$key.'" id="'.$key.'">'.htmlspecialchars($option).'</textarea>'.$help;
				break;
			case 'string':
			case 'int':
			default:
				$output = $label.'<input name="'.$key.'" id="'.$key.'" value="'.htmlspecialchars($option).'" />'.$help;
				break;
		}
		return '<div class="option">'.$output.'<div class="clear"></div></div>';
	}
}

function cfmobi_settings_form() {
	global $cfmobi_settings;
	print('
<div class="wrap">
	<h2>'.__('WordPress Mobile Edition', 'cf-mobile').'</h2>
	<form id="cfmobi_settings_form" name="cfmobi_settings_form" action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php" method="post">
		<input type="hidden" name="cf_action" value="cfmobi_update_settings" />
		<p>'.__('Browsers that have a <a href="http://en.wikipedia.org/wiki/User_agent">User Agent</a> matching a key below will be shown the mobile version of your site instead of the normal theme.', 'cf-mobile').'</p>
		<fieldset class="options">
	');
	foreach ($cfmobi_settings as $key => $config) {
		echo cf_settings_field($key, $config);
	}
	print('
		</fieldset>
		<p>'.sprintf(__('To see the User Agent for your browser, <a href="%s">click here</a>.', 'cf-mobile'), trailingslashit(get_bloginfo('home')).'?cf_action=cfmobi_who').'</p>
		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="'.__('Save Settings', 'cf-mobile').'" />
		</p>
	</form>
</div>
	');
	do_action('cfmobi_settings_form');
}

function cfmobi_save_settings() {
	if (!current_user_can('manage_options')) {
		return;
	}
	global $cfmobi_settings;
	foreach ($cfmobi_settings as $key => $option) {
		$value = '';
		switch ($option['type']) {
			case 'int':
				$value = intval($_POST[$key]);
				break;
			case 'select':
				$test = stripslashes($_POST[$key]);
				if (isset($option['options'][$test])) {
					$value = $test;
				}
				break;
			case 'string':
			case 'textarea':
			default:
				$value = stripslashes($_POST[$key]);
				break;
		}
		update_option($key, $value);
	}
}

if (!function_exists('get_snoopy')) {
	function get_snoopy() {
		include_once(ABSPATH.'/wp-includes/class-snoopy.php');
		return new Snoopy;
	}
}

//a:22:{s:11:"plugin_name";s:24:"WordPress Mobile Edition";s:10:"plugin_uri";s:42:"http://crowdfavorite.com/wordpress/plugins";s:18:"plugin_description";s:277:"Show your mobile visitors a site presentation designed just for them. Rich experience for iPhone, Android, etc. and clean simple formatting for less capable mobile browsers. Cache-friendly with a Carrington-based theme, and progressive enhancement for advanced mobile browsers.";s:14:"plugin_version";s:3:"3.0";s:6:"prefix";s:6:"cfmobi";s:8:"filename";s:13:"wp-mobile.php";s:12:"localization";s:9:"cf-mobile";s:14:"settings_title";s:24:"WordPress Mobile Edition";s:13:"settings_link";s:6:"Mobile";s:4:"init";s:1:"1";s:7:"install";s:1:"1";s:9:"post_edit";b:0;s:12:"comment_edit";b:0;s:6:"jquery";b:0;s:6:"wp_css";b:0;s:5:"wp_js";b:0;s:9:"admin_css";s:1:"1";s:8:"admin_js";s:1:"1";s:15:"request_handler";s:1:"1";s:6:"snoopy";s:1:"1";s:11:"setting_cat";b:0;s:14:"setting_author";b:0;}

?>