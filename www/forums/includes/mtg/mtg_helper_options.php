<?php

//install options in wpdb
function mtgh_install(){
	global $wpdb;
	
	//default option array for resetting and stuff
	if(get_option(mtghDefaultValues) == ''){
		$name = 'mtghDefaultValues';
		$value = 'a:12:{s:5:"width";s:3:"550";s:5:"title";a:2:{s:6:"weight";s:4:"bold";s:4:"size";s:4:"150%";}s:8:"fontsize";s:4:"12px";s:6:"layout";s:7:"tooltip";s:7:"cardbox";a:2:{s:3:"col";i:2;s:4:"side";s:5:"right";}s:7:"tooltip";a:1:{s:3:"col";i:3;}s:9:"thumbnail";a:2:{s:8:"rowcount";i:5;s:6:"action";s:4:"zoom";}s:9:"categeory";s:8:"headline";s:8:"headline";a:3:{s:6:"weight";s:4:"bold";s:4:"size";s:4:"100%";s:5:"count";b:1;}s:6:"tabbed";a:6:{s:8:"rowcount";i:8;s:4:"size";s:4:"12px";s:6:"weight";s:4:"bold";s:6:"height";s:4:"20px";s:5:"color";s:7:"#CCCCCC";s:8:"selected";s:7:"#3D3D3D";}s:7:"options";a:2:{s:4:"mini";b:0;s:4:"pick";b:0;}s:8:"comments";b:1;}';
		$autoload = 'yes';
		$wpdb->query("INSERT INTO $wpdb->options (option_name, option_value, autoload) VALUES ('$name', '$value', '$autoload')");
	}
	
	//add options
	add_option(mtghWidth, 550 , 'Max width of the cardlist');
	add_option(mtghTitle, array('weight' => 'bold', 'size' => '150%') , 'Settings for the cardlist title');
	add_option(mtghFontSize, '12px', 'Fontsize of the card names');
	add_option(mtghFontColor, '', 'Fontcolor of the card names');
	add_option(mtghComment, true , 'Toggle using card-tag in comments');
	add_option(mtghAlign, 'center' , 'Document align of the cardlists and custom tags');
	
	add_option(mtghCategoryHeadline, array( 'weight' => 'bold' , 'size' => '100%') , 'Category headline');
	add_option(mtghCategoryTabbed, array(
										'size' => '12px',
										'weight' => 'bold',
										'height' => '20px',
										'color' => '#CCCCCC',
										'selected' => '#3D3D3D'
									) , 'Category tabbed');

	//cardlist
	if(get_option(mtghCardlistSettings) == ''){
		$name = 'mtghCardlistSettings';
		$value ='a:5:{s:4:"name";s:8:"cardlist";s:6:"layout";a:4:{s:3:"typ";s:7:"tooltip";s:7:"cardbox";a:2:{s:4:"side";s:5:"right";s:3:"col";i:2;}s:7:"tooltip";a:1:{s:3:"col";i:3;}s:9:"thumbnail";a:2:{s:8:"rowcount";i:5;s:6:"action";s:4:"zoom";}}s:8:"category";a:3:{s:3:"typ";s:8:"headline";s:8:"headline";a:1:{s:5:"count";b:1;}s:6:"tabbed";a:1:{s:8:"rowcount";i:8;}}s:7:"options";a:2:{s:4:"pick";b:0;s:4:"mini";b:0;}s:6:"button";b:1;}';
		$autoload = 'yes';
		$wpdb->query("INSERT INTO $wpdb->options (option_name, option_value, autoload) VALUES ('$name', '$value', '$autoload')");
	}		
	
	//custom tags
	if(get_option(mtghCustomTags) == ''){
		$name = 'mtghCustomTags';
		$value = 'a:2:{i:0;a:5:{s:4:"name";s:4:"deck";s:6:"layout";a:3:{s:4:"side";s:5:"right";s:3:"col";i:2;s:3:"typ";s:7:"cardbox";}s:8:"category";a:2:{s:5:"count";b:1;s:3:"typ";s:8:"headline";}s:7:"options";a:2:{s:4:"pick";b:0;s:4:"mini";b:0;}s:6:"button";b:1;}i:1;a:5:{s:4:"name";s:5:"draft";s:6:"layout";a:3:{s:8:"rowcount";i:5;s:6:"action";s:4:"zoom";s:3:"typ";s:9:"thumbnail";}s:8:"category";a:2:{s:3:"typ";s:6:"tabbed";s:8:"rowcount";i:8;}s:7:"options";a:2:{s:4:"pick";b:1;s:4:"mini";b:0;}s:6:"button";b:1;}}';
		$autoload = 'yes';
		$wpdb->query("INSERT INTO $wpdb->options (option_name, option_value, autoload) VALUES ('$name', '$value', '$autoload')");
	}
}

//uninstlal mthg options
function mtgh_uninstall(){
	delete_option(mtghDefaultValues);	
	delete_option(mtghWidth);
	delete_option(mtghTitle);
	delete_option(mtghFontSize);
	delete_option(mtghFontColor);
	delete_option(mtghAlign);
	delete_option(mtghComment);
	delete_option(mtghCategoryHeadline);
	delete_option(mtghCategoryTabbed);
	delete_option(mtghCardlistSettings);	
	delete_option(mtghCustomTags);	
}

// wp_nonce (for security)
function mtgh_nonce_field(){
	echo "<input type='hidden' name='mtgh-nonce-key' value='" . wp_create_nonce('wp-mtg-helper') . "' />";
}

//prints out the admin page
function mtgh_admin_page() {
	global $wpdb, $wp_version;
	
	//load default values
	$d = get_option(mtghDefaultValues);

	//update db
	if( $_POST['mtgh_update_db'] ){
		mtgh_update_db();
		$mtgh_update = "<div class='updated fade'><p><strong>Database successfully updated.</strong></p></div>";
	}
	if( $_POST['mtgh_no_update_db'] ){
		mtgh_update_db(true);
		$mtgh_update = "<div class='updated fade'><p><strong>Database successfully cleaned.</strong></p></div>";
	}
	
	//save general settings
	if ( $_POST['mtgh_gs_update'] ){
		if ( function_exists('current_user_can') && current_user_can('edit_plugins') && wp_verify_nonce($_POST['mtgh-nonce-key'], 'wp-mtg-helper')) {
			
			//update width
			$mtgh_width = $d['width'];
			if( is_numeric($_POST['mtgh_width']) )
				$mtgh_width = $_POST['mtgh_width'];
			update_option(mtghWidth,$mtgh_width);
		
			//update title
			$mtgh_title = $d['title'];
			$mtgh_title['weight'] = $_POST['mtgh_title_fontweight'];
			if( preg_match('([0-9]+(px|%))',$_POST['mtgh_title_fontsize']) )	
				$mtgh_title['size'] = $_POST['mtgh_title_fontsize'];
			update_option(mtghTitle,$mtgh_title);

			//fontsize
			$mtgh_fontsize = $d['fontsize'];
			if( preg_match('([0-9]+(px|%))',$_POST['mtgh_fontsize']) )	
				$mtgh_fontsize = $_POST['mtgh_fontsize'];			
			update_option(mtghFontSize, $mtgh_fontsize);

			//font color
			$mtgh_fontcolor = '';
			if( preg_match('!^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$!',$_POST['mtgh_fontcolor']) || ($_POST['mtgh_fontcolor']=="") )	
				$mtgh_fontcolor = $_POST['mtgh_fontcolor'];			
			update_option(mtghFontColor, $mtgh_fontcolor);	
			
			//comments cardlinks
			$mtgh_comment = false;
			if ( $_POST['mtgh_comment'] == "true" )
				$mtgh_comment = true;
			update_option(mtghComment, $mtgh_comment);			

			//update headline settings
			$mtgh_headline['size'] = $d['headline']['size'];
			$mtgh_headline['weight'] = $_POST['mtgh_headline_fontweight'];
			if( preg_match('([0-9]+(px|%))',$_POST['mtgh_headline_fontsize']) )
				$mtgh_headline['size'] = $_POST['mtgh_headline_fontsize'];
			update_option(mtghCategoryHeadline, $mtgh_headline);
			
			//update tabebd settings
			$mtgh_tabbed['height'] = $d['tabbed']['height'];
			if( preg_match('([0-9]+(px))',$_POST['mtgh_tabbed_height']) )	
				$mtgh_tabbed['height'] = $_POST['mtgh_tabbed_height'];
			$mtgh_tabbed['rowcount'] = $d['tabbed']['rowcount'];
		
			if( is_numeric($_POST['mtgh_tabbed_rowcount']) )
				$mtgh_tabbed['rowcount'] = $_POST['mtgh_tabbed_rowcount'];
			
			$mtgh_tabbed['size'] = $d['tabbed']['size'];
			if( preg_match('([0-9]+(px|%))',$_POST['mtgh_tabbed_fontsize']) )	
				$mtgh_tabbed['size'] = $_POST['mtgh_tabbed_fontsize'];
			$mtgh_tabbed['weight'] = $_POST['mtgh_tabbed_fontweight'];
			$mtgh_tabbed['color'] = $d['tabbed']['color'];
			if( preg_match('!^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$!',$_POST['mtgh_tab_color']) )
				$mtgh_tabbed['color'] = $_POST['mtgh_tab_color'];
			$mtgh_tabbed['selected'] = $d['tabbed']['selected'];
			if( preg_match('!^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$!',$_POST['mtgh_tab_selected']) )
				$mtgh_tabbed['selected'] = $_POST['mtgh_tab_selected'];				
			update_option(mtghCategoryTabbed, $mtgh_tabbed);
			
			//update center settings
			update_option(mtghAlign, $_POST['mtgh_align']);
			
			$mtgh_update = "<div class='updated fade'><p><strong>General Settings saved.</strong></p></div>";
		}else{
			$mtgh_update = "<div class='updated fade'><p><strong>Sorry. You do not have permission to do that.</strong></p></div>";
		}
	}
	
	//save cardlist settings
	if ( $_POST['mtgh_cl_update'] ) {
		if ( function_exists('current_user_can') && current_user_can('edit_plugins') && wp_verify_nonce($_POST['mtgh-nonce-key'], 'wp-mtg-helper')) {
			
			$cardlist = array();
			//update default layout
			$cardlist['layout']['typ'] = $_POST['cardlist_layout'];
			
			//update cardbox settings
			$cardlist['layout']['cardbox'] = $d['cardbox'];
			if( is_numeric($_POST['cardlist_cardbox_count']) )
				$cardlist['layout']['cardbox']['col'] = $_POST['cardlist_cardbox_count'];
			$cardlist['layout']['cardbox']['side'] = $_POST['cardlist_cardbox_side'];
			
			//update tooltip settings
			$cardlist['layout']['tooltip']['col'] = $d['tooltip'];
			if( is_numeric($_POST['cardlist_tooltip_count']) )
				$cardlist['layout']['tooltip']['col'] = $_POST['cardlist_tooltip_count'];

			//update thumbnail
			$cardlist['layout']['thumbnail'] = $d['thumbnail'];
			if( is_numeric($_POST['cardlist_thumbnail_rowcount']) )
				$cardlist['layout']['thumbnail']['rowcount'] = $_POST['cardlist_thumbnail_rowcount'];
			$cardlist['layout']['thumbnail']['action'] = $_POST['cardlist_thumbnail_action'];
			
			//update default category layout
			$cardlist['category']['typ'] =  $_POST['cardlist_category_layout'];
			
			//update headline settings
			$cardlist['category']['headline']['count'] = false;
			if( $_POST['cardlist_headline_count'] == "true" )
				$cardlist['category']['headline']['count'] = true;

			//update tabbed settings
			$cardlist['category']['tabbed']['rowcount'] = $d['tabbed']['rowcount'];
			if( is_numeric($_POST['cardlist_tabbed_rowcount']) )
				$cardlist['category']['tabbed']['rowcount'] = $_POST['cardlist_tabbed_rowcount'];
			
			//update option minimize
			$cardlist['options']['mini'] = false;
			if( $_POST['cardlist_minimize'] == "true" )
				$cardlist['options']['mini'] = true;
			if( $_POST['cardlist_minimize'] == "initial" )
				$cardlist['options']['mini'] = $_POST['cardlist_minimize'];
		
			$cardlist['options']['pick'] = false;
			if( $_POST['cardlist_pick'] == "true" )
				$cardlist['options']['pick'] = true;
			if( $_POST['cardlist_pick'] == "toggle" )
				$cardlist['options']['pick'] = $_POST['cardlist_pick'];			

			$cardlist['button'] = false;
			if( $_POST['cardlist_button'] == "true" )
				$cardlist['button'] = true;			
			
			update_option(mtghCardlistSettings,$cardlist);
			
			$mtgh_update = "<div class='updated fade'><p><strong>Cardlist Settings saved.</strong></p></div>";
		}else{
			$mtgh_update = "<div class='updated fade'><p><strong>Sorry. You do not have permission to do that.</strong></p></div>";
		}
	}	
	
	//delete all custom tags
	if ( $_POST['mtgh_delete_all_tags'] ) {
		if( $_POST['mtgh_delete_check'] ){
			if ( function_exists('current_user_can') && current_user_can('edit_plugins') && wp_verify_nonce($_POST['mtgh-nonce-key'], 'wp-mtg-helper')) {	
				$val = array();
				update_option(mtghCustomTags, $val);
				
				$mtgh_update = "<div class='updated fade'><p><strong>Custom Tags deleted.</strong></p></div>";
			}else{
				$mtgh_update = "<div class='updated fade'><p><strong>Sorry. You do not have permission to do that.</strong></p></div>";
			}
		}else{
			$mtgh_update = "<div class='error'><p><strong>Data not deleted! You have to check the box next to the delete button in order to really delete data.</strong></p></div>";
		}
	}
	
	//save custom tags
	if ( $_POST['mtgh_save_tags'] ) {
		if ( function_exists('current_user_can') && current_user_can('edit_plugins') && wp_verify_nonce($_POST['mtgh-nonce-key'], 'wp-mtg-helper')) {	

			//validation
			$tags = array();
			foreach( $_POST['mtgh'] as $tag ){
				$tag['name'] = preg_replace("![^A-Za-z0-9]!", "", $tag['name'] );
				
				//layout
				$tag['layout'] = mtgh_make_style($tag['layout']);
				if( isset($tag['layout']['col']) ){
					if( !is_numeric($tag['layout']['col']) )
					$tag['layout']['col'] = $d['cardbox']['col'];
				}
				if( isset($tag['layout']['rowcount']) ){
					if( !is_numeric($tag['layout']['rowcount']) )
					$tag['layout']['rowcount'] = $d['thumbnail']['rowcount'];
				}				
				
				//category
				$tag['category'] = mtgh_make_style($tag['category']);
				if( isset($tag['category']['size']) ){
					if( !is_numeric($tag['category']['size']) )
					$tag['category']['size'] = $d['headline']['size'];
				}
				if( isset($tag['category']['rowcount']) ){
					if( !is_numeric($tag['category']['rowcount']) )
					$tag['category']['rowcount'] = $d['tabbed']['rowcount'];
				}				
				
				//options
				$tag['options'] = mtgh_make_style($tag['options']);

				//button must be bool
				if( isset($tag['button']) ){
					$tag['button'] = true;
				}else{
					$tag['button'] = false;
				}
				if( $tag['name'] != '' )
					$tags[] = $tag;
			}
			update_option(mtghCustomTags, $tags);
			
			$mtgh_update = "<div class='updated fade'><p><strong>Custom Tags saved.</strong></p></div>";
		}else{
			$mtgh_update = "<div class='updated fade'><p><strong>Sorry. You do not have permission to do that.</strong></p></div>";
		}
	}
	
	//delete custom tag
	if( $_POST['mtgh_del_tag'] ){
		if ( function_exists('current_user_can') && current_user_can('edit_plugins') && wp_verify_nonce($_POST['mtgh-nonce-key'], 'wp-mtg-helper')) {
			$custom_tag = get_option(mtghCustomTags);
			foreach( $custom_tag as $i => $tag ){
				if( $tag['name'] == $_POST['mtgh_del_name'] )
					unset($custom_tag[$i]);
			}
			update_option(mtghCustomTags,$custom_tag);

			if( $_POST['mtgh_del_name'] == '' ){
				$mtgh_update = "<div class='error'><p><strong>An error ocurred. You did not enter a tag name.</strong></p></div>";
			}else{
			$mtgh_update = "<div class='updated fade'><p><strong>Custom Tags &#91;".$_POST['mtgh_del_name']."&#93; deleted.</strong></p></div>";
			}
		}else{
			$mtgh_update = "<div class='updated fade'><p><strong>Sorry. You do not have permission to do that.</strong></p></div>";
		}
	}
	
	//restore
	if( $_POST['mtgh_restore'] ){
		if ( function_exists('current_user_can') && current_user_can('edit_plugins') && wp_verify_nonce($_POST['mtgh-nonce-key'], 'wp-mtg-helper')) {
			if( $_POST['mtgh_restore_check'] ){
				mtgh_uninstall();
				mtgh_install();
				echo '<div class="wrap"><h2>MtG Helper Settings</h2>';
				echo '<div class="updated fade"><p><strong>Data successfully restored.</strong></p></div>';
				echo '<form action="'.$_SERVER["REQUEST_URI"].'" method="post"><input type="submit" value="Return to MtG-Helper Settings" class="button"/></form>';
				echo '</div>';
				wp_die('');
			}else{
				$mtgh_update = "<div class='error'><p><strong>Data not restored! You have to check the box next to the restore button in order to really restore data.</strong></p></div>";;
			}
		}else{
			$mtgh_update = "<div class='updated fade'><p><strong>Sorry. You do not have permission to do that.</strong></p></div>";
		}
	}
	
	//rease all
	if( $_POST['mtgh_deletion'] ){
		if ( function_exists('current_user_can') && current_user_can('edit_plugins') && wp_verify_nonce($_POST['mtgh-nonce-key'], 'wp-mtg-helper')) {
			if( $_POST['mtgh_deletion_check'] ){
				mtgh_uninstall();
				$mtgh_update = "<div class='updated fade'><p><strong>Data successfully erased.</strong></p></div>";
			}else{
				$mtgh_update = "<div class='error'><p><strong>Data not erased! You have to check the box next to the restore button in order to really erase all data.</strong></p></div>";;
			}
		}else{
			$mtgh_update = "<div class='updated fade'><p><strong>Sorry. You do not have permission to do that.</strong></p></div>";
		}
	}	
	
	$mtgh_title = get_option(mtghTitle);
	$mtgh_category_headline = get_option(mtghCategoryHeadline);
	$mtgh_category_tabbed = get_option(mtghCategoryTabbed);
	$mtgh_cardlist = get_option(mtghCardlistSettings);


//layout option settings
?>
<style>
	select.medium{width:75px;}
	select.big{width:100px;}
	input.medium{width:75px;}
	input.big{width:100px;}
</style>

<div class="wrap">
	<h2>MtG Helper Settings</h2>
	<br/>
	<?php
	//update from from older versions to 1.0
		if( get_option(comment_card) ){
			echo '<div class="error">';
			echo '<p><strong>';
			echo 'There are settings from an older version of the plugin. Do you like to use these settings for this version? Otherwise the plugin&#39;s default values are used.';
			echo '</strong></p>';
			echo '<form name="update_db" method="post" action"'.$_SERVER["REQUEST_URI"].'" >';
			echo '<input type="submit" value="Use old settings" name="mtgh_update_db" class="button" />';
			echo '<input type="submit" value="Use plugin&#39;s default" name="mtgh_no_update_db" class="button" />';
			echo '</form>';
			echo '</div>';
			echo '<br/>';
	//update to 1.0.1
		}elseif( !get_option(mtghAlign) ){
			echo '<div class="error">';
			echo '<p><strong>';
			echo 'Your database needs an update for this plugin version. Please update.';
			echo '</strong></p>';
			echo '<form name="update_db" method="post" action"'.$_SERVER["REQUEST_URI"].'" >';
			echo '<input type="submit" value="Update" name="mtgh_update_db" class="button" />';
			echo '</form>';
			echo '</div>';
			echo '<br/>';
		}
	?>
	
	<?php
	if ( $mtgh_update ){
		echo $mtgh_update;
		echo '<br/>';
	}
	?>
	
	<div id="poststuff" class="ui-sortable">
		<div class="postbox <?php if( !$_POST['mtgh_gs_update'] ) echo 'closed';?>">
			<h3 style="font-size:14px;">General Settings</h3>
			<div class="inside">
				<form name="mtgh_gs" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<?php mtgh_nonce_field() ?>
				<table class="form-table" style="margin:0px;"><tbody>
				<tr>
					<th class="scope" style="font-size:13px;">Maximum width:</th>
					<td>
					<?php
					echo "<input type='text' size='3' ";
					echo "name='mtgh_width' ";
					echo "value='".get_option(mtghWidth)."' />";
					?> px
					</td>
				</tr>
				<tr>
					<th class="scope" style="font-size:13px;">Font Settings:</th>
					<td>
						<label style="float:left;width:90px;" >Fontcolor:</label>
						<?php
						echo "<input type='text' size='7' ";
						echo "name='mtgh_fontcolor' ";
						echo "onkeyup=\"jQuery('#fontcolor').css('backgroundColor',this.value); \"";
						echo "value='".get_option(mtghFontColor)."' />";
						?>
						<span id="fontcolor" style="border:1px solid #000;background-color:<?php echo get_option(mtghFontColor); ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="margin-left:20px;" class="setting-description">(Must be a hexadecimal color value or leave blank for blogs default link color)</span><br/>						
						<div><strong>Cards:</strong></div>
						<label style="float:left;width:90px;">Fontsize:</label>
						<?php
						echo "<input type='text' size='4' ";
						echo "name='mtgh_fontsize' ";
						echo "value='".get_option(mtghFontSize)."' />";
						?><span style="margin-left:30px;" class="setting-description">(Must be a valid unit, e.g. px or &#37;)</span><br/>
						
						<div style="margin-top:15px"><strong>Title:</strong></div>
						<label style="float:left;width:90px;">Fontsize:</label>
						<?php
						echo "<input type='text' size='4' ";
						echo "name='mtgh_title_fontsize' ";
						echo "value='".$mtgh_title['size']."' />";
						?><span style="margin-left:30px;" class="setting-description">(Must be a valid unit, e.g. px or &#37;)</span><br/>
						<label style="float:left;width:90px;">Fontweight:</label>
						<?php
							echo "<select class='medium' name='mtgh_title_fontweight'>\n";
							echo "<option value='normal'";
							if( $mtgh_title['weight'] == "normal" )
								echo " selected='selected'";
							echo ">normal</option>\n";
							echo "<option value='bold'";
							if( $mtgh_title['weight'] == "bold" )
								echo" selected='selected'";
							echo ">bold</option>\n";
							echo "</select>\n";
						?>						
					</td>
				</tr>
				<tr>
					<th class="scope" style="font-size:13px;">Category Layout:</th>
					<td>
						<div><strong>Headline:</strong></div>
						<label style="float:left;width:90px;" >Fontsize:</label>
						<?php
						echo "<input type='text' size='4' ";
						echo "name='mtgh_headline_fontsize' ";
						echo "value='".$mtgh_category_headline['size']."' />";
						?>
						<span style="margin-left:50px;" class="setting-description">(Must be a valid unit, e.g. px or &#37;)</span><br/>
						<label style="float:left;width:90px;" >Fontweight:</label>
						<?php
							echo "<select class='big' name='mtgh_headline_fontweight'>\n";
							echo "<option value='normal'";
							if( $mtgh_category_headline['weight'] == "normal" )
								echo " selected='selected'";
							echo ">normal</option>\n";
							echo "<option value='bold'";
							if( $mtgh_category_headline['weight'] == "bold" )
								echo" selected='selected'";
							echo ">bold</option>\n";
							echo "</select>\n";
						?>
						<div style="margin-top:15px;"><strong>Tabbed:</strong></div>
						<label style="float:left;width:90px;" >Fontsize:</label>
						<?php
						echo "<input type='text' size='4' ";
						echo "name='mtgh_tabbed_fontsize' ";
						echo "value='".$mtgh_category_tabbed['size']."' />";
						?>
						<span style="margin-left:50px;" class="setting-description">(Must be a valid unit, e.g. px or &#37;)</span><br/>
						<label style="float:left;width:90px;" >Fontweight:</label>
						<?php
							echo "<select class='big' name='mtgh_tabbed_fontweight'>\n";
							echo "<option value='normal'";
							if( $mtgh_category_tabbed['weight'] == "normal" )
								echo " selected='selected'";
							echo ">normal</option>\n";
							echo "<option value='bold'";
							if( $mtgh_category_tabbed['weight'] == "bold" )
								echo" selected='selected'";
							echo ">bold</option>\n";
							echo "</select>\n";
						?><br/>
<label style="float:left;width:90px;" >Tab Color:</label>
						<?php
						echo "<input class='medium' type='text' size='7' ";
						echo "name='mtgh_tab_color' ";
						echo "onkeyup=\"jQuery('#tab_color_box').css('backgroundColor',this.value); \"";
						echo "value='".$mtgh_category_tabbed['color']."' />";
						?>
						<span id="tab_color_box" style="cursor:hand;border:1px solid #000;background-color:<?php echo $mtgh_category_tabbed['color']; ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="margin-left:20px;" class="setting-description">(Must be a hexadecimal color value)</span><br/>
						<label style="float:left;width:90px;" >Selected Color:</label>
						<?php
						echo "<input class='medium' type='text' size='7' ";
						echo "name='mtgh_tab_selected' ";
						echo "onkeyup=\"jQuery('#tab_selected_box').css('backgroundColor',this.value); \"";
						echo "value='".$mtgh_category_tabbed['selected']."' />";
						?>
						<span id="tab_selected_box" style="border:1px solid #000;background-color:<?php echo $mtgh_category_tabbed['selected']; ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="margin-left:20px;" class="setting-description">(Must be a hexadecimal color value)</span>
						<br/><br/>
						<label style="float:left;width:90px;" >Height:</label>
						<?php
						echo "<input type='text' size='4' ";
						echo "name='mtgh_tabbed_height' ";
						echo "value='".$mtgh_category_tabbed['height']."' />";
						?>
						<span style="margin-left:50px;" class="setting-description">(Must be px)</span><br/>
						<span>(<strong>Note:</strong> Be careful changing the height. This could mess things up.)</span>
					</td>
				</tr>
				<tr>
					<th class="scope" style="font-size:13px;">Aligment card lists:</th>
					<td>
					<?php
						echo "<select class='big' name='mtgh_align'>\n";
						echo "<option value='left'";
						if( get_option(mtghAlign) == "left" )
							echo " selected='selected'";
						echo ">left</option>\n";
						echo "<option value='center'";
						if( get_option(mtghAlign) == "center" )
							echo" selected='selected'";
						echo ">center</option>\n";
						echo "<option value='right'";
						if( get_option(mtghAlign) == "right" )
							echo" selected='selected'";
						echo ">right</option>\n";						
						echo "</select>\n";
					?>
					</td>
				</tr>				
				<tr>
					<th class="scope" style="font-size:13px;">Allow &#91;card&#93;-tag in comments:</th>
					<td>
					<?php
						echo "<select class='big' name='mtgh_comment'>\n";
						echo "<option value='true'";
						if(get_option(mtghComment))
							echo " selected='selected'";
						echo ">Enabled</option>\n";
						echo "<option value='false'";
						if(!get_option(mtghComment))
							echo" selected='selected'";
						echo ">Disabled</option>\n";
						echo "</select>\n";
					?>
					</td>
				</tr>				
				</tbody></table>
				<p class="submit"><input class="button" type='submit' name='mtgh_gs_update' value='Save Changes' /></p>
				</form>
			</div>
		</div>				
	</div>

	<div id="poststuff" class="ui-sortable">
		<div class="postbox <?php if(!$_POST['mtgh_cl_update']) echo 'closed';?>">
			<h3 style="font-size:14px;">Cardlist Settings</h3>
			<div class="inside">
				<form name="mtgh_ls" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<?php mtgh_nonce_field() ?>
				<p>Choose a default layout for the &#91;cardlist&#93;-tag and set attributes for each layout.</p>
				<table class="widefat">
					<thead>
						<tr>
							<th><input type="radio" name="cardlist_layout" value="cardbox" style="margin:0px 5px 0px 0px;" 
							<?php if($mtgh_cardlist['layout']['typ'] == "cardbox" ) echo "checked=\"checked\"";?>>Cardbox</th>
							<th><input type="radio" name="cardlist_layout" value="tooltip" style="margin:0px 5px 0px 0px;" 
							<?php if($mtgh_cardlist['layout']['typ'] == "tooltip" ) echo "checked=\"checked\"";?>>Tooltip</th>
							<th><input type="radio" name="cardlist_layout" value="thumbnail" style="margin:0px 5px 0px 0px;" 
							<?php if($mtgh_cardlist['layout']['typ'] == "thumbnail" ) echo "checked=\"checked\"";?>>Thumbnail</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<label style="float:left;width:125px;" >Number of columns:</label>
								<?php
								echo "<input type='text' size='2' ";
								echo "name='cardlist_cardbox_count' ";
								echo "value='".$mtgh_cardlist['layout']['cardbox']['col']."' />";
								?>
								<br/>
								<label style="float:left;width:125px;" >Side of the cardbox:</label>
								<?php
									echo "<select class='medium' name='cardlist_cardbox_side'>\n";
									echo "<option value='right'";
									if( $mtgh_cardlist['layout']['cardbox']['side'] == "right")
										echo " selected='selected'";
									echo ">right</option>\n";
									echo "<option value='left'";
									if( $mtgh_cardlist['layout']['cardbox']['side'] == "left")
										echo" selected='selected'";
									echo ">left</option>\n";
									echo "</select>\n";
								?>
							</td>
							<td style="border-left:1px solid #DFDFDF;">
								<label style="float:left;width:125px;" >Number of columns:</label>
								<?php
								echo "<input type='text' size='2' ";
								echo "name='cardlist_tooltip_count' ";
								echo "value='".$mtgh_cardlist['layout']['tooltip']['col']."' />";
								?>
							</td>
							<td style="border-left:1px solid #DFDFDF;">
								<label style="float:left;width:150px;" >Number of cards per row:</label>
								<?php
								echo "<input type='text' size='2' ";
								echo "name='cardlist_thumbnail_rowcount' ";
								echo "value='".$mtgh_cardlist['layout']['thumbnail']['rowcount']."' />";
								?><br/>
								<label style="float:left;width:150px;" >Mousover action:</label>
								<?php
									echo "<select class='medium' name='cardlist_thumbnail_action'>\n";
									echo "<option value='none'";
									if( $mtgh_cardlist['layout']['thumbnail']['action'] == "none")
										echo" selected='selected'";
									echo ">none</option>\n";									
									echo "<option value='zoom'";
									if( $mtgh_cardlist['layout']['thumbnail']['action'] == "zoom")
										echo " selected='selected'";
									echo ">zoom</option>\n";
									echo "<option value='fade'";
									if( $mtgh_cardlist['layout']['thumbnail']['action'] == "fade")
										echo" selected='selected'";
									echo ">fade</option>\n";
									echo "</select>\n";
								?>								
							</td>
						</tr>
					</tbody>
				</table>
				<p style="margin-top:15px">Choose a default category layout and set attributes for each layout.</p>
				<table class="widefat">
					<thead>
						<tr>
							<th><input type="radio" name="cardlist_category_layout" value="headline" style="margin:0px 5px 0px 0px;" 
							<?php if($mtgh_cardlist['category']['typ'] == "headline" ) echo "checked=\"checked\"";?>>Headline</th>
							<th><input type="radio" name="cardlist_category_layout" value="tabbed" style="margin:0px 5px 0px 0px;" 
							<?php if($mtgh_cardlist['category']['typ'] == "tabbed" ) echo "checked=\"checked\"";?>>Tabbed</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="width:50%;">
								<label style="float:left;width:80px;" >Count cards:</label>
								<?php
									echo "<select class='big' name='cardlist_headline_count'>\n";
									echo "<option value='true'";
									if( $mtgh_cardlist['category']['headline']['count'] == true)
										echo " selected='selected'";
									echo ">Enabled</option>\n";
									echo "<option value='false'";
									if( $mtgh_cardlist['category']['headline']['count'] == false)
										echo" selected='selected'";
									echo ">Disabled</option>\n";
									echo "</select>\n";
								?>
							</td>
							<td style="border-left:1px solid #DFDFDF;width:50%;">
								<label style="float:left;width:170px;" >Number of categories per row:</label>
								<?php
								echo "<input type='text' size='2' ";
								echo "name='cardlist_tabbed_rowcount' ";
								echo "value='".$mtgh_cardlist['category']['tabbed']['rowcount']."' />";
								?>
							</td>
						</tr>					
					</tbody>
				</table>
				
				<p style="margin-top:15px">Choose options for the cardlist. They will appear above the cardlist.</p>
				<table class="form-table" style="margin:0px;"><tbody>
				<tr>
					<th class="scope" style="font-size:13px;">Minimize Button:</th>
					<td>
					<?php
						echo "<select class='big' name='cardlist_minimize'>\n";
						echo "<option value='true'";
						if( $mtgh_cardlist['options']['mini'] == true )
							echo " selected='selected'";
						echo ">Enabled</option>\n";
						echo "<option value='false'";
						if( $mtgh_cardlist['options']['mini'] == false )
							echo" selected='selected'";
						echo ">Disabled</option>\n";
						echo "<option value='initial'";
						if( !is_bool($mtgh_cardlist['options']['mini']) )
							echo" selected='selected'";
						echo ">Initial</option>\n";						
						echo "</select>\n";
					?>
					<span style="margin-left:10px;" class="setting-description">(Initial &#61; minimized right from the start)</span>
					</td>
				</tr>
				<tr>
					<th class="scope" style="font-size:13px;">Pick Setting:</th>
					<td>
					<?php
						echo "<select class='big' name='cardlist_pick'>\n";
						echo "<option value='true'";
						if( $mtgh_cardlist['options']['pick'] == true )
							echo " selected='selected'";
						echo ">Show</option>\n";
						echo "<option value='false'";
						if( $mtgh_cardlist['options']['pick'] == false )
							echo" selected='selected'";
						echo ">Never</option>\n";
						echo "<option value='toggle'";
						if( !is_bool($mtgh_cardlist['options']['pick']) )
							echo" selected='selected'";
						echo ">Toggle</option>\n";						
						echo "</select>\n";
					?>
					<span style="margin-left:10px;" class="setting-description">(Toggle &#61; hidden right from the start but the reader can toggle the pick)</span>
					</td>					
				</tr>
				<tr>
					<th class="scope" style="font-size:13px;">Button:</th>
					<td>
					<?php
						echo "<select class='big' name='cardlist_button'>\n";
						echo "<option value='true'";
						if( $mtgh_cardlist['button'] == true )
							echo " selected='selected'";
						echo ">Enabled</option>\n";
						echo "<option value='false'";
						if( $mtgh_cardlist['button'] == false )
							echo" selected='selected'";
						echo ">Disabled</option>\n";
						echo "</select>\n";
					?>
					</td>					
				</tr>				
				</tbody></table>
				<p class="submit"><input class="button" type="submit" name="mtgh_cl_update" value="Save Changes" /></p>
				</form>
			</div>
		</div>				
	</div>

	
	
	<div id="poststuff" class="ui-sortable">
		<div class="postbox <?php if( !$_POST['mtgh_add_tag'] && !$_POST['mtgh_save_tags'] && !$_POST['mtgh_del_tag'] ) echo "closed";?>">
			<h3 style="font-size:14px;">Custom Tags (Advanced)</h3>
			<div class="inside">
				<form name="mtgh_ct" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<?php mtgh_nonce_field() ?>			
				<p>You can add new tags or edit existing tags to simplify work. No longer typing attributes!</p>
				<p>
					In order to make your own tag(s) create a new form with the "Add Tag"-button and fill it out. Be sure every field is filled out.<br/>
					The name of your tag will also be the name for the call. E.g. when the name is "deck" the tag in the Wordpress editor is &#91;deck&#93;.
				</p>
				<p><a onclick="jQuery('#tag_help').slideToggle('slow');return false;" href="#" >Need some help to insert the right value in each field?</a></p>
				<div id="tag_help" style="display:none;margin-left:20px;">
					<ul style="list-style-type: disc;font-size:11px;margin-left:15px;">
						<li>Cardbox - <em>&#60;number of columns&#62;&#60;side of the cardbox&#62;</em></li>
						<li>Tooltip - <em>&#60;number of columns&#62;</em></li>
						<li>Thumbnail - <em>&#60;number of cards per row&#62;&#60;mouseover action&#62;</em></li>
						<li>Headline - <em>&#60;count cards&#62;</em>(<strong>Note:</strong> Not supported with thumbnail layout. Looks to uggly.)</li>
						<li>Tabbed - <em>&#60;number of categories per row&#62;</em></li>
						<li>Options - <em>&#60;minimize&#62;&#60;pick&#62;</em></li>
					</ul>
				</div>
				<table id="custom_tags" class="widefat">
					<thead>
						<tr>
							<th scope="col" style="width:80px;">Tag Name</th>
							<th scope="col">Attributes</th>
							<th scope="col" style="width:50px;">Button</th>
						</tr>
					</thead>
					<tbody>
<?php
/********** ADD EXISTING TAGS **********/
	$a = get_option(mtghCustomTags);

	//if options are empty write one empty field
	if( empty($a) ){
		$a =	array(
							0 => 	array(
										"tag" => "",
										"layout" => array( "typ" => "cardbox"),
										"category" => array( "typ" => "headline"),
										"options" => array( "mini" => false, "pick" => false),
										"button" => false
									)								
					);	
	}
	foreach( $a as $i => $t){
		echo '
			<tr valign="top">
				<td>
					<input type="text" style="width:80px;" value="'.$t['name'].'" name="mtgh['.$i.'][name]" />
				</td>
				<td style="border-left:1px solid #DFDFDF;">
					<label style="float:left;width:70px;" >Layout:</label>
					<select class="big" onclick="mtgh_report('.$i.');" onchange="get_la('.$i.');" id="l_'.$i.'">
							<option value="cardbox" ';
							if( $t['layout']['typ'] == "cardbox" )
								echo 'selected="selected"';
		echo				'>cardbox</option>
							<option value="tooltip" ';
							if( $t['layout']['typ'] == "tooltip" )
								echo 'selected="selected"';							
		echo				'>tooltip</option>
							<option value="thumbnail" ';
							if( $t['layout']['typ'] == "thumbnail" )
								echo 'selected="selected"';								
		echo				'>thumbnail</option>
					</select>
					<span ';
					//div cardbox
					if( $t['layout']['typ'] != "cardbox" )
						echo 'style="display:none;"';
		echo		'id="cardbox_attr_'.$i.'" >
						<input class="big" onkeyup="mtgh_report('.$i.');" type="text" value="'.$t['layout']['col'].'" id="cb_col_'.$i.'"/>
						<select class="big" onclick="mtgh_report('.$i.');" id="cb_s_'.$i.'"/>
							<option value="right" ';
							if( $t['layout']['side'] == "right" )
								echo 'selected="selected"';								
		echo				'>right</option>
							<option value="left" ';
							if( $t['layout']['side'] == "left" )
								echo 'selected="selected"';							
		echo				'>left</option>
						</select>
					</span>
					<span ';
					//div tooltip
					if( $t['layout']['typ'] != "tooltip" )
						echo 'style="display:none;"';					
		echo		'id="tooltip_attr_'.$i.'" >
						<input class="big" onkeyup="mtgh_report('.$i.');" type="text" value="'.$t['layout']['col'].'" id="tt_col_'.$i.'"/>
					</span>
					<span ';
					//div thumbnail
					if( $t['layout']['typ'] != "thumbnail" )
						echo 'style="display:none;"';					
		echo		'id="thumbnail_attr_'.$i.'" >
						<input class="big" onkeyup="mtgh_report('.$i.');" type="text" value="'.$t['layout']['rowcount'].'" id="tn_row_'.$i.'"/>
						<select class="medium" onclick="mtgh_report('.$i.');" id="tn_mo_'.$i.'"/>
							<option value="none" ';
							if( $t['layout']['action'] == "none" )
								echo 'selected="selected"';								
		echo				'>none</option>						
							<option value="zoom" ';
							if( $t['layout']['action'] == "zoom" )
								echo 'selected="selected"';								
		echo				'>zoom</option>
							<option value="fade" ';
							if( $t['layout']['action'] == "fade" )
								echo 'selected="selected"';								
		echo				'>fade</option>
						</select>									
					</span>
					<br/>
					<label style="float:left;width:70px;" >Categories:</label>
					<select class="big" onclick="mtgh_report('.$i.');" onchange="get_ca('.$i.');" id="cl_'.$i.'">
						<option value="headline" ';
							if( $t['category']['typ'] == "headline" )
								echo 'selected="selected"';							
		echo			'>headline</option>
						<option value="tabbed" ';
							if( $t['category']['typ'] == "tabbed" )
								echo 'selected="selected"';							
		echo			'>tabbed</option>
					</select>
					<span id="headline_attr_'.$i.'" ';
					//div headline
					if( $t['category']['typ'] != "headline" )
						echo 'style="display:none;"';					
		echo		'>
						<select class="big" onclick="mtgh_report('.$i.');" id="hl_cc_'.$i.'"/>
							<option value="true" ';
							if( $t['category']['count'] == true )
								echo 'selected="selected"';								
		echo				'>Enabled</option>
							<option value="false" ';
							if( $t['category']['count'] == false )
								echo 'selected="selected"';							
		echo				'>Disabled</option>
						</select>	
					</span>
					<span id="tabbed_attr_'.$i.'" ';
					//div tabbed
					if( $t['category']['typ'] != "tabbed" )
						echo 'style="display:none;"';					
		echo		'>
						<input class="big" onkeyup="mtgh_report('.$i.');" type="text" value="'.$t['category']['rowcount'].'" id="tb_row_'.$i.'"/>
					</span>
					<br/>
					<label style="float:left;width:70px;" >Options:</label>
					<select class="big" onclick="mtgh_report('.$i.');" id="op_mini_'.$i.'">
						<option value="true" ';
						if( $t['options']['mini'] == true )
							echo 'selected="selected"';							
		echo			'>Enabled</option>
						<option value="false" ';
						if( $t['options']['mini'] == false )
							echo 'selected="selected"';							
		echo			'>Disabled</option>
						<option value="initial" ';
						if( is_string($t['options']['mini']) )
							echo 'selected="selected"';							
		echo			'>Initial</option>						
					</select>
					<select class="big" onclick="mtgh_report('.$i.');" id="op_pick_'.$i.'">
						<option value="true" ';
						if( $t['options']['pick'] == true )
							echo 'selected="selected"';							
		echo			'>Show</option>
						<option value="false" ';
						if( $t['options']['pick'] == false )
							echo 'selected="selected"';							
		echo			'>Never</option>
						<option value="toggle" ';
						if( is_string($t['options']['pick']) )
							echo 'selected="selected"';						
		echo			'>Toggle</option>						
					</select>								
					<input type="hidden" id="custom_l_'.$i.'" name="mtgh['.$i.'][layout]" value="';
					switch ( $t['layout']['typ'] ){
						case 'cardbox':
							echo $t['layout']['typ']." ".$t['layout']['col']." ".$t['layout']['side'];
							break;
						case 'tooltip':
							echo $t['layout']['typ']." ".$t['layout']['col'];
							break;
						case 'thumbnail':
							echo $t['layout']['typ']." ".$t['layout']['rowcount']." ".$t['layout']['action'];
							break;							
					}
		echo		'"/>
					<input type="hidden" id="custom_cl_'.$i.'" name="mtgh['.$i.'][category]" value="';
					switch ( $t['category']['typ'] ){
						case 'headline':
							$count = "false";
							if( $t['category']['count'] )
								$count = "true";							
							echo $t['category']['typ']." ".$count;
							break;
						case 'tabbed':
							echo $t['category']['typ']." ".$t['category']['rowcount'];
							break;						
					}									
		echo		'"/>
					<input type="hidden" id="custom_o_'.$i.'" name="mtgh['.$i.'][options]" value="';
					$mini = "false";
					if( $t['options']['mini'] )
						$mini = "true";
					if( is_string($t['options']['mini']) )
						$mini = "initial";
					
					$pick = "false";
					if( $t['options']['pick'] )
						$pick = "true";
					if( is_string($t['options']['pick']) )
						$pick = "toggle";
					echo $mini." ".$pick;					
		echo		'"/>
				</td>
				<td style="border-left:1px solid #DFDFDF;text-align: center;">
					<input type="checkbox" style="margin:0px auto;padding:0;" name="mtgh['.$i.'][button]" ';
					if($t['button']) echo 'checked="checked"';
		echo		' />								
				</td>
			</tr>
		';
	}
?>
					</tbody>
				</table>
				<p style="margin-top:10px;">
				<div style="float:right">
					<input type="submit" value="Delete Tag" onclick="if(confirm('Do you really want to delete this tag?')){}else{return false;}" name="mtgh_del_tag" class="button"/>
					<select type="text" style="margin-left:10px;" name="mtgh_del_name"/>
					<option></option>
						<?php
						foreach( $a as $t){
						echo '<option>'.$t['name'].'</option>';
						}
						?>
					</select>				
				</div>
					<input type="submit" value="Add Tag" name="mtgh_add_tag" class="button" onclick="add_row();return false;"/>
					<input type="submit" value="Save Tags" name="mtgh_save_tags" class="button"/>
				</p>
				</form>
			</div>
		</div>
	</div>
	
	<?php echo '<input type="hidden" id="tag_rows" value="'.count($a).'" />'; ?>

	<div id="poststuff" class="ui-sortable">
		<div class="postbox <?php if( !$_POST['mtgh_del_res'] ) echo 'closed';?>">
			<h3 style="font-size:14px;">Restoring and Deletion</h3>
			<div class="inside">
				<form name="mtgh_del_res" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<?php mtgh_nonce_field() ?>
				<table class="form-table" style="margin:0px;"><tbody>
				<tr>
					<th class="scope" style="font-size:13px;">Restore all settings:</th>
					<td>
						<input type="submit" value="Restore" name="mtgh_restore" class="button"/>
						<input type="checkbox" name="mtgh_restore_check" style="margin-left:45px;"/> <label>Check me if you really wanna restore the data!</label>			
					</td>
				</tr>
				<tr>
					<th class="scope" style="font-size:13px;">Erase all settings:</th>
					<td>
						<input type="submit" value="Erase all Data" name="mtgh_deletion" class="button"/>
						<input type="checkbox" name="mtgh_deletion_check" style="margin-left:16px;"/> <label>Check me if you really wanna erase all data!</label>
					</td>
				</tr>
				<tr>
					<th class="scope" style="font-size:13px;">Delete all custom tags:</th>
					<td>
						<input type="submit" value="Delete all Tags" name="mtgh_delete_all_tags" class="button"/>
						<input type="checkbox" name="mtgh_delete_check" style="margin-left:16px;"/> <label>Check me if you really wanna erase all tags!</label>
					</td>
				</tr>				
				</table>
				</form>
			</div>
		</div>
	</div>

	<div id="poststuff" class="ui-sortable">
		<div class="postbox closed">
			<h3 style="font-size:14px;">Help</h3>
			<div class="inside">
				<p>Some instructions and specification, which hopefully help to use the plugin. If your questions could not be answered with the following feel free to contact me.</p>
				<ul style="list-style-type: disc;font-size:11px;margin-left:20px;">
					<li>
						<strong>How do I link single cards?</strong><br/>
						Just wrap [card][/card] around the card name.
					</li>
					<li>
						<strong>How does the cardlist and custom tags work?</strong><br/>
						It&#39;s like using <a href="http://de.wikipedia.org/wiki/BBcode">BBCode</a>. Just put the tag around the card names. To seperate cards from each other you can use three different posibilities:<br/>
						- simple linke breaks (one row for each card)<br/>
						- semicolon<br/>
						- &#42;<em>&#60;quantity&#62;  &#60;cardname&#62;</em>
					</li>					
					<li>
						<strong>Why doe&#39;s the backside of the magic card appear instead of a card picture?</strong><br/>
						Most of the time the card wasnt spelled correct. Make sure you dont use inverted comma in the card name. Just ignore it.
					</li>
					<li>
						<strong>How do I combine cards into a category?</strong><br/>
						To combine cards into a category you have to put them inside another "tag", which lies inside your used tag (E.g. &#91;cardlist&#93;). Besides special character you can name your category like you want. Just be sure you do not forget to close the tag.<br/>
						A sample category could look like these: &#91White&#93;&#60;cardname&#62;...&#60;cardname&#62;&#91White&#93;
					</li>				
					<li>
						<strong>Additional Attributes in the editor:</strong><br/>
						What you can&#39;t set on this page are the title of your cardlists and the picked card for draft walkthroughs. If you want a title for your deck you have to declare it while writing your post by putting another argument inside the tag. E. g. &#91;cardlist title=&#60;your title&#62;&#93; (without the &#60;&#62;!). The pick is declared similar but instead of the argument "title" you have to use the argument "pick". E. g. &#91;cardlist pick=&#60;cardname&#62;&#93;.<br/>
						Certainly the cardname must be a card inside your list otherwise there will be no card highlited.<br/>
						Sometimes even the custom tag may not fit your need. If you only need some attributes once you don&#39;t have to create a new custom tag. Just use the argument "style" inside the tag like you can set your title and pick.<br/>
						As a matter of course all three arguments can be used simultaneously.
					</li>
					<li>
						<strong>About the layouts:</strong><br/>
						There are three different layout you can choose: cardbox, tooltip and thumbnail. These layout affect how the cards are linked. When you choose <em>cardbox</em> as layout the cards will be displayed in text list. The card images will appear in a box right next to the list. <em>Tooltip</em> is similar but instead of a box a tooltip will appear when you mouseover a card inside the text list.<br/>
						The <em>thumbnail</em> layout differs from the other styles. The cards will placed as smaller a version side by side. When you mousover them the choosen action will enlarge them (or not if your choosen action is none).
					</li>
					<li>
						<strong>About Categories:</strong><br/>
						A category combines several cards visually. There are two different layouts for the categories.<br/>
						The first is headline. By choosing this possibility the given category name ist put before each set of cards, which belong to the category. The second possibility is tabbed, which means that tabs are generate and placed at the top of the cardlist.
					</li>
					<li>
						<strong>What does the button option do?</strong><br/>
						When you enable these option for the cardlist or a custom tag a button in the Wordpress editor is created so you don&#39;t have to always write the tag down.
					</li>
					<li>
						<strong>What does the pick setting do?</strong><br/>
						These attribute is first of all inteded for draft walkthroughs. When you enable this attribute and you declare a pick (=card name, see "Additional Attributes in the editor" for further information) the selected card is highlited. You also can choose toggle so your readers can manually show or hide the picked card.
					</li>					
				</ul>			
			</div>
		</div>
	</div>

	<div>
		<hr/>
		<p style="font-size:11px;">
			<strong>About the Plugin</strong><br/>
			For further information visit the <a href="http://www.backseatsurfer.de/wp-mtg-helper/">plugin homepage</a>. If you have any suggestions or ideas to improve the plugin (bug reports are also welcome) feel free to send me some <a href="http://www.backseatsurfer.de/feedback/">feedback</a>.
		<br/>
			If you like the plugin and want to support it, help spreading it by putting a link to the plugin page on your page or <a href="https://www.paypal.com/cgi-bin/webscr?country_code=DE&cmd=_s-xclick&hosted_button_id=635826">donate me a coffee</a>.
		</p>
		<p style="font-size:11px;">
			&copy; Copyright 2008 <?php if( date("Y") != 2008 ) echo '- '.date("Y"); ?> by <a href="http://www.backseatsurfer.de/">Sebastian Sebald.</a>
		</p>
	</div>
	
</div>
	
		<script type="text/javascript">
		<!--
		<?php if ( version_compare( substr($wp_version, 0, 3), '2.7', '<' ) ) { ?>
		jQuery('.postbox h3').prepend('<a class="togbox">+</a> ');
		<?php } ?>
		jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
		jQuery('.postbox.close-me').each(function(){
			jQuery(this).addClass("closed");
		});
		function add_row(){
			var id = jQuery('#tag_rows').val();
			var row = 	'<tr valign="top">\n'+
						'<td>\n'+
						'<input type="text" style="width:80px;" value="" name="mtgh['+id+'][name]"/>\n'+
						'</td>\n'+
						'<td style="border-left:1px solid #DFDFDF;">\n'+
						'<label style="float:left;width:70px;" >Layout:</label>\n'+
						'<select class="big" onclick="mtgh_report('+id+');" onchange="get_la('+id+');" id="l_'+id+'">\n'+
						'<option value="cardbox">cardbox</option>\n'+
						'<option value="tooltip">tooltip</option>\n'+
						'<option value="thumbnail">thumbnail</option>\n'+
						'</select>\n'+
						'<span id="cardbox_attr_'+id+'" >\n'+
						'<input class="big" onkeyup="mtgh_report('+id+');" type="text" value="" id="cb_col_'+id+'"/>\n'+
						'<select class="big" onclick="mtgh_report('+id+');" id="cb_s_'+id+'">\n'+
						'<option value="right">right</option>\n'+
						'<option value="left">left</option>\n'+
						'</select>\n'+
						'</span>\n'+
						'<span id="tooltip_attr_'+id+'" style="display:none;">\n'+
						'<input class="big" onkeyup="mtgh_report('+id+');" type="text" value="" id="tt_col_'+id+'"/>\n'+
						'</span>\n'+
						'<span id="thumbnail_attr_'+id+'" style="display:none;">\n'+
						'<input class="big" onkeyup="mtgh_report('+id+');" type="text" value="" id="tn_row_'+id+'"/>\n'+
						'<select class="medium" onclick="mtgh_report('+id+');" id="tn_mo_'+id+'">\n'+
						'<option value="none">none</option>\n'+						
						'<option value="zoom">zoom</option>\n'+
						'<option value="fade">fade</option>\n'+
						'</select>\n'+
						'</span>\n'+
						'<br/>\n'+
						'<label style="float:left;width:70px;" >Categories:</label>\n'+
						'<select class="big" onclick="mtgh_report('+id+');" onchange="get_ca('+id+');" id="cl_'+id+'">\n'+
						'<option value="headline">headline</option>\n'+
						'<option value="tabbed">tabbed</option>\n'+
						'</select>\n'+
						'<span id="headline_attr_'+id+'">\n'+
						'<select class="big" onclick="mtgh_report('+id+');" id="hl_cc_'+id+'">\n'+
						'<option value="true">Enabled</option>\n'+
						'<option value="false">Disabled</option>\n'+
						'</select>\n'+
						'</span>\n'+
						'<span id="tabbed_attr_'+id+'" style="display:none;">\n'+
						'<input class="big" onkeyup="mtgh_report('+id+');" type="text" value="" id="tb_row_'+id+'"/>'+
						'</span>'+
						'<br/>\n'+
						'<label style="float:left;width:70px;" >Options:</label>\n'+
						'<select class="big" onclick="mtgh_report('+id+');" id="op_mini_'+id+'">\n'+
						'<option value="true">Enabled</option>\n'+
						'<option value="false">Disabled</option>\n'+
						'<option value="initial">Initial</option>\n'+
						'</select>\n'+
						'<select class="big" onclick="mtgh_report('+id+');" id="op_pick_'+id+'">\n'+
						'<option value="true">Show</option>\n'+
						'<option value="false">Never</option>\n'+
						'<option value="toggle">Toggle</option>\n'+				
						'</select>\n'+
						'<input type="hidden" id="custom_l_'+id+'" value="" name="mtgh['+id+'][layout]" />\n'+
						'<input type="hidden" id="custom_cl_'+id+'" value="" name="mtgh['+id+'][category]" />\n'+
						'<input type="hidden" id="custom_o_'+id+'" value="" name="mtgh['+id+'][options]" />\n'+
						'</td>\n'+
						'<td style="border-left:1px solid #DFDFDF;text-align: center;">\n'+
						'<input type="checkbox" style="margin:0px auto;padding:0;" name="mtgh['+id+'][button]" />\n'+
						'</td>\n'+					
						'</tr>';
			jQuery('#custom_tags tr:last').after(row);
			jQuery('#tag_rows').val( parseInt(jQuery('#tag_rows').val())+1 );
		}
		function get_la(id){
			( jQuery('#l_'+id).val() == "cardbox" )? jQuery('#cardbox_attr_'+id).show() : jQuery('#cardbox_attr_'+id).hide();
			( jQuery('#l_'+id).val() == "tooltip" )? jQuery('#tooltip_attr_'+id).show() : jQuery('#tooltip_attr_'+id).hide();
			( jQuery('#l_'+id).val() == "thumbnail" )? jQuery('#thumbnail_attr_'+id).show() : jQuery('#thumbnail_attr_'+id).hide();			
		}
		function get_ca(id){
			( jQuery('#cl_'+id).val() == "headline" )? jQuery('#headline_attr_'+id).show() : jQuery('#headline_attr_'+id).hide();
			( jQuery('#cl_'+id).val() == "tabbed" )? jQuery('#tabbed_attr_'+id).show() : jQuery('#tabbed_attr_'+id).hide();			
		}
		function mtgh_report(id){
			var layout = jQuery('#l_'+id).val();
			if( layout == "cardbox" ){
				var col = jQuery('#cb_col_'+id).val();
				var side = jQuery('#cb_s_'+id).val();
				jQuery('#custom_l_'+id).val(layout + " " + col + " " + side);
			}
			if( layout == "tooltip" ){
				var col = jQuery('#tt_col_'+id).val();
				jQuery('#custom_l_'+id).val(layout + " " + col);
			}
			if( layout == "thumbnail" ){
				var row = jQuery('#tn_row_'+id).val();
				var mouse = jQuery('#tn_mo_'+id).val();
				jQuery('#custom_l_'+id).val(layout + " " + row + " " + mouse);
			}
			var cat = jQuery('#cl_'+id).val();
			if( cat == "headline" ){
				var cc = jQuery('#hl_cc_'+id).val();
				jQuery('#custom_cl_'+id).val(cat + " " + cc);
			}
			if( cat == "tabbed" ){
				var rc = jQuery('#tb_row_'+id).val();
				jQuery('#custom_cl_'+id).val(cat + " " + rc);	
			}
			jQuery('#custom_o_'+id).val(jQuery('#op_mini_'+id).val() + " " + jQuery('#op_pick_'+id).val());
		}
		//-->
		</script>
<?php
}

function mtgh_update_db($delete_old_settings=null){
	global $wpdb;
	
	//update db from old verions to 1.0
	if ( get_option(comment_card) ){
		//general options
		if( get_option(deck_width) ){
			update_option(mtghWidth, get_option(deck_width));
			delete_option(deck_width);
		}
		if( get_option(deck_titlesize) && get_option(deck_titleweight) ){
			update_option(mtghTitle, array( 'weight' => get_option(deck_titlesize), 'size' => get_option(deck_titleweight)));
			delete_option(deck_titlesize);
			delete_option(deck_titleweight);
		}
		if( get_option(comment_card) ){
			update_option(mtghComment, get_option(comment_card));
			delete_option(comment_card);
		}
		if( get_option(deck_fontsize) ){
			update_option(mtghFontSize, get_option(deck_fontsize));
			delete_option(deck_fontsize);
		}		
		//adding old deck and draft tag attributes to custom tags
		$ct = get_option(mtghCustomTags);
		foreach( $ct as $i ){
			if( $i['name'] == 'deck' ){
				$i['layout'] = array(
									'typ' => 'cardbox',
									'col' => get_option(deck_colbrake),
									'side' => get_option(deck_preview)
									);
				delete_option(deck_colbrake);
				delete_option(deck_preview);
				if( get_option(deck_cardcount) ){
					$i['category']['count'] = get_option(deck_cardcount);
					$i['category']['typ'] = 'headline';						
					delete_option(deck_cardcount);
				}				
			}
			if( $i['name'] == 'draft' ){
				$i['layout'] = array(
									'typ' => 'thumbnail',
									'rowcount' => get_option(draft_rowcount)		
									);
				delete_option(draft_rowcount);
				if( get_option(draft_pickshow) || get_option(draft_picktoggle) ){
					if( get_option(draft_picktoggle) ){
						$pick = 'toggle';
					}elseif( get_option(draft_pickshow) ){
						$pick = true;
					}else{
						$pick = false;
					}
					delete_option(draft_pickshow);
					delete_option(draft_picktoggle);
				}else{
					$pick = $d['options']['pick'];
				}
				$i['options']['pick'] = $pick;
			}
			$tags[] = $i;
		}
		update_option(mtghCustomTags,$tags);

		delete_option(deck_colwidth);
		delete_option(draft_width);
		delete_option(deck_threshold);
		delete_option(comment_deck);		
	}
	
	//dont use old data but clean the option table in wpdb (to 1.0)
	if( $delete_old_settings ){
		delete_option(deck_colwidth);
		delete_option(deck_fontsize);
		delete_option(draft_width);
		delete_option(comment_deck);
		delete_option(draft_pickshow);
		delete_option(draft_picktoggle);
		delete_option(draft_rowcount);
		delete_option(deck_preview);
		delete_option(deck_threshold);					
		delete_option(deck_colbrake);					
		delete_option(deck_cardcount);					
		delete_option(comment_card);					
		delete_option(deck_titlesize);
		delete_option(deck_titleweight);					
		delete_option(deck_width);	
	}	
	
	//update to 1.0.1
	if( get_option(mtghAlign) == '' ){
		//new setting: alginment
		add_option(mtghAlign, 'center' , 'Document align of the cardlists and custom tags');
		
		//update tabbed settings (added size, weight, height)
		$old = get_option(mtghCategoryTabbed);
		$value = array(
						'size' => '12px',
						'weight' => 'bold',
						'height' => '20px',
						'color' => $old['color'],
						'selected' => $old['selected']
					);
		update_option(mtghCategoryTabbed, $value );
	
		//update default values (added: alot)
		$name = 'mtghDefaultValues';
		$value = 'a:12:{s:5:"width";s:3:"550";s:5:"title";a:2:{s:6:"weight";s:4:"bold";s:4:"size";s:4:"150%";}s:8:"fontsize";s:4:"12px";s:6:"layout";s:7:"tooltip";s:7:"cardbox";a:2:{s:3:"col";i:2;s:4:"side";s:5:"right";}s:7:"tooltip";a:1:{s:3:"col";i:3;}s:9:"thumbnail";a:2:{s:8:"rowcount";i:5;s:6:"action";s:4:"zoom";}s:9:"categeory";s:8:"headline";s:8:"headline";a:3:{s:6:"weight";s:4:"bold";s:4:"size";s:4:"100%";s:5:"count";b:1;}s:6:"tabbed";a:6:{s:8:"rowcount";i:8;s:4:"size";s:4:"12px";s:6:"weight";s:4:"bold";s:6:"height";s:4:"20px";s:5:"color";s:7:"#CCCCCC";s:8:"selected";s:7:"#3D3D3D";}s:7:"options";a:2:{s:4:"mini";b:0;s:4:"pick";b:0;}s:8:"comments";b:1;}';
		$autoload = 'yes';
		$wpdb->query("INSERT INTO $wpdb->options (option_name, option_value, autoload) VALUES ('$name', '$value', '$autoload')");
		
		//add rowcount to cardlist settings
		$cardlist = get_option(mtghCardlistSettings);
		$cardlist['category']['tabbed']['rowcount'] = 8;
		update_option(mtghCardlistSettings, $cardlist);
		
		//add rowcount to custom decks with category layout tabbed
		$ct = get_option(mtghCustomTags);
		foreach( $ct as $tag ){
			
			if( ($tag['category']['typ']=="tabbed") && !isset($tag['category']['rowcount']) )
				$tag['category']['rowcount'] = 8;
			
			$tags[] = $tag;
		}
		update_option(mtghCustomTags, $tags);			
	}
	
}

?>