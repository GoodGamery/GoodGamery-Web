<?php
/*
Plugin Name: List Tags
Plugin URI: http://wordpress.org/extend/plugins/list-tags
Description: Adds the list_tags() template tag.  It is essentially the same function as wp_list_tagegories, but for tags.
Version: 0.1
Author: Steve Smith
Author URI: http://www.stevesmith1983.co.uk

    Copyright 2008 Steve Smith  (contact : http://stevesmith1983.co.uk)

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

class Walker_Tag extends Walker {
	var $tree_type = 'tag';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

	function start_lvl(&$output, $depth, $args) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl(&$output, $depth, $args) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el(&$output, $tag, $depth, $args) {
		extract($args);

		$tag_name = attribute_escape( $tag->name);
		$tag_name = apply_filters( 'list_tags', $tag_name, $tag );
		$link = '<a href="' . get_tag_link( $tag->term_id ) . '" ';
		if ( $use_desc_for_title == 0 || empty($tag->description) )
			$link .= 'title="' . sprintf(__( 'View all posts filed under %s' ), $tag_name) . '"';
		else
			$link .= 'title="' . attribute_escape( apply_filters( 'tag_description', $tag->description, $tag )) . '"';
		$link .= '>';
		$link .= $tag_name . '</a>';

		if ( (! empty($feed_image)) || (! empty($feed)) ) {
			$link .= ' ';

			if ( empty($feed_image) )
				$link .= '(';

			$link .= '<a href="' . get_tag_feed_link($tag->term_id, $feed_type) . '"';

			if ( empty($feed) )
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $tag_name ) . '"';
			else {
				$title = ' title="' . $feed . '"';
				$alt = ' alt="' . $feed . '"';
				$name = $feed;
				$link .= $title;
			}

			$link .= '>';

			if ( empty($feed_image) )
				$link .= $name;
			else
				$link .= "<img src='$feed_image'$alt$title" . ' />';
			$link .= '</a>';
			if ( empty($feed_image) )
				$link .= ')';
		}

		if ( isset($show_count) && $show_count )
			$link .= ' (' . intval($tag->count) . ')';

		if ( isset($show_date) && $show_date ) {
			$link .= ' ' . gmdate('Y-m-d', $tag->last_update_timestamp);
		}

		if ( isset($current_tag) && $current_tag )
			$_current_tag = get_tag( $current_tag );

		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'tag-item tag-item-'.$tag->term_id;
			if ( isset($current_tag) && $current_tag && ($tag->term_id == $current_tag) )
				$class .=  ' current-tag';
			elseif ( isset($_current_tag) && $_current_tag && ($tag->term_id == $_current_tag->parent) )
				$class .=  ' current-tag-parent';
			$output .=  ' class="'.$class.'"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}
}

//
// Helper functions
//

function walk_tag_tree() {
	$walker = new Walker_Tag;
	$args = func_get_args();
	return call_user_func_array(array(&$walker, 'walk'), $args);
}

function list_tags($args = '') {
	$defaults = array(
		'show_option_all' => '', 'orderby' => 'name',
		'order' => 'ASC', 'show_last_update' => 0,
		'style' => 'list', 'show_count' => 0,
		'hide_empty' => 1, 'use_desc_for_title' => 1,
		'child_of' => 0, 'feed' => '', 'feed_type' => '',
		'feed_image' => '', 'exclude' => '', 'current_tag' => 0,
		'hierarchical' => true, 'title_li' => __('Tags'),
		'echo' => 1, 'depth' => 0
	);

	$r = wp_parse_args( $args, $defaults );

	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
		$r['pad_counts'] = true;
	}

	if ( isset( $r['show_date'] ) ) {
		$r['include_last_update_time'] = $r['show_date'];
	}

	extract( $r );

	$tags = get_tags($r);

	$output = '';
	if ( $title_li && 'list' == $style )
			$output = '<li class="tags">' . $r['title_li'] . '<ul>';

	if ( empty($tags) ) {
		if ( 'list' == $style )
			$output .= '<li>' . __("No tags") . '</li>';
		else
			$output .= __("No tags");
	} else {
		global $wp_query;

		if( !empty($show_option_all) )
			if ('list' == $style )
				$output .= '<li><a href="' .  get_bloginfo('url')  . '">' . $show_option_all . '</a></li>';
			else
				$output .= '<a href="' .  get_bloginfo('url')  . '">' . $show_option_all . '</a>';

		if ( empty( $r['current_tag'] ) && is_tag() )
			$r['current_tag'] = $wp_query->get_queried_object_id();

		if ( $hierarchical )
			$depth = $r['depth'];
		else
			$depth = -1; // Flat.

		$output .= walk_tag_tree($tags, $depth, $r);
	}

	if ( $title_li && 'list' == $style )
		$output .= '</ul></li>';

	$output = apply_filters('wp_list_tags', $output);

	if ( $echo )
		echo $output;
	else
		return $output;
}
?>