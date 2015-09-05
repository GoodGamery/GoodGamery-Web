=== Plugin Name ===
Contributors: joetan
Tags: admin, comments, spam
Requires at least: 2.3
Tested up to: 2.6
Stable tag: 0.6.2

A plugin that does a simple sanity check to stop really obvious comment spam before it is processed.

== Description ==

A simple pre-filter to weed out the most obvious comment spam (about 90% of all spam).

Legitimate comments that get blocked (either by this plugin or by Akismet) can be presented with a captcha to confirm that the comment is legitimate. Comments that don’t pass the captcha will be immediately discarded.

Helps you identify potential spam words (you can use this to tweak the plugin’s filters).


== Installation ==

1. Upload `tantan-spam` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin in 'Comments' -> 'Spam Filter' by following the onscreen prompts.
