<?php

//replace the tags with cardlinks
function mtgh_list($content){

	//get all tags
	$tags = array( 0 => 'cardlist');
	if( get_option(mtghCustomTags) != '' ){
		$ct = get_option(mtghCustomTags);
		foreach( $ct as $item ){
			array_push($tags, $item['name']);
		}
	}

	//replace known tags with the cardlists
	foreach( $tags as $tag ){
		$content = preg_replace_callback(
		'/(\['.$tag.'(| title=(.*)| style=(.*)| pick=(.*))*\])(.*)(\[\/'.$tag.'\])/isU',
		'mtgh_parser',
		$content);
		$time_end = microtime(true);
	}

	return $content;
}

//callback function for replacing tags
function mtgh_parser($matches)
{
	
	/********** MATCHES **********/
	/*	
	*	0 = everything
	*	1 = start tag
	*	2 = style-attribute with attribute name
	*	3 = title
	*	4 = style
	*	5 = pick
	*	6 = content
	*	7 = end tag
	*/
	
	/********** OPTIONS **********/
	
	$style = mtgh_get_style(strtolower(str_replace( array('[',']','/') , '' , $matches[7])),$matches[4]);
	$title = htmlspecialchars($matches[3]);

	//thumbnail and headline doesnt work
	if( ($style['category']['typ'] == "headline") && $style['layout']['typ'] == "thumbnail"  ){
		$style['category']['typ'] = "tabbed";
	}

	//set pick
	$pick = null;
	if( isset($style['pick']) ){
		$pick = $style['pick'];
		unset($style['pick']);
	}
	if( $matches[5] != "" ){
		$pick = $matches[5];
		if( substr($pick,-1) == ";")
			$pick = substr($pick,0,-1);
	}

	/********** SEARCH FOR CATEGORIES **********/
	
	//check for categories
	preg_match_all(
	'/(\[(.*)\])(.*)(\[\/(.*)\])/isU',
	$matches[6],
	$result);
	
	//search categories
	if( isset($result[0][0]) )
    {
	//found categories
		foreach( $result[3] as $i => $card ){
			$stack[$i] = parse_card_string($card, $cardnames_for_caching);
			$card_sum[$i] = count($stack[$i])+1;
			$card_sum['sum'] +=  $card_sum[$i];		
		}
		$categories = $result[2];
	}
    else
    {
	//no categories
		$stack[0] = parse_card_string($matches[6], $cardnames_for_caching);
		$card_sum['sum'] = count($stack[0]);
		$categories = array(null);
	}	
	/********** SIZE ADJUSTMENTS **********/

	//fit the width to the tab width
	if( $style['category']['typ'] == "tabbed" ){
		//fit the size to the tabs
		$single_tab_width = floor($style['width']/count($categories)). "px";
		$style['width'] = floor($single_tab_width*count($categories)). "px";
		if($style['category']['rowcount'] < count($categories) ){
			$single_tab_width = floor($style['width']/$style['category']['rowcount']). "px";
			$style['width'] = floor($single_tab_width*$style['category']['rowcount']). "px";
		}
	}
	
	/********** DISPLAY STUFF **********/
	
	//distinct ID!!!
	$id = "mtgh_" . substr( md5( rand(0,100).microtime() ),0,5 );
	
	//open surrounding div
	$content = "<div class='mtgh' id='$id' style='width:{$style['width']};margin:{$style['align']};'>"; //open cardlist
	
	/********** DISPLAY HEADER **********/
	
	//header div with title, toggle minimize
	if( $style['options']['mini'] || is_string($style['options']['pick']) || ($title != null) ){
		$content .= "<div class='mtgh_header'>"; //open header		
		//options
		if( $style['options']['deckeditor'] || $style['options']['mini'] || $style['options']['pick'] ){
			$content .= "<div class='header_options'>"; //open option div
			//deckeditor
			if( $style['options']['deckeditor'] ){
				$content .= "<a href='#'>deck editor</a>";
				if( $style['options']['mini'] || is_string($style['options']['pick']) )
					$content .= " | ";
			}
			//pick toggle
			if( is_string($style['options']['pick']) && ($pick != "") ){
				$content .= "<a href='#' onclick=\" toggle_pick(this); return false; \">show pick</a>";
				if( $style['options']['mini'] )
					$content .= " | ";				
			}
			//minimize (collapse)
			if( $style['options']['mini'] ){
			$content .=	"<script type='text/javascript'>
							jQuery(document).ready(function(){
								jQuery('#{$id}_mini').click(function () {
									jQuery('#{$id}_content').slideToggle('slow');
									jQuery('#{$id}_tabs').slideToggle('slow');
									return false;
								});
							});
						</script>";
				$content .= "<a id='{$id}_mini' href='#'>toggle</a>";
			}
			$content .= "</div>"; //close options		
		}		
		//title
		if( $title != null ){
			$title_font = get_option(mtghTitle);
			$header_style = "font-size:{$title_font['size']};font-weight:{$title_font['weight']};";
			if ( $style['options']['mini'] || is_string($style['options']['pick']) ){
				$header_style .= "margin-left:3px;";
			}else{
				$header_style .= "text-align:center;";
			}
			$content .= "<div><h4 style='{$header_style}'>" . $title;
			if( ($style['category']['typ'] == "headline") || is_null($categories[0]) )
				$content .= "<hr/>";
			$content .= "</h4></div>";
		}
		if( ($title == null) && ($style['options']['mini'] || is_string($style['options']['pick'])) )
			$content .= "<div>&nbsp;</div>";
		$content .= "</div>"; //end header
	}

	/********** DISPLAY TABS **********/
	
	//generating tabs (by category) if there are categories
	if( ($style['category']['typ'] == "tabbed") && !is_null($categories[0]) ){
		$tab = get_option(mtghCategoryTabbed);
		$div_height = (ceil(count($categories)/$style['category']['rowcount'])*$tab['height'])."px";
		$content .= "<div id='{$id}_tabs' class='tab' style='clear:left;font-size:{$tab['size']};font-weight:{$tab['weight']};height:{$div_height};";
		if( is_string($style['options']['mini']) ){
			$content .= "display:none;";
		}
		$content .= "' ><ul style='height:{$tab['height']};'>";
		foreach( $categories as $i => $category){
			
			//row brakes
			if( ($i)/$style['category']['rowcount'] == 1 ){
				$content .= "</ul>";
				$content .= "<ul style='height:{$tab['height']};'>";
			}
			
			
			$content .= 	"<li style='width:{$single_tab_width};height:{$tab['height']};'><a href='#' 
						onclick=\"mtgh_tab('$id',$i," . count($categories) . ",'".$tab['color']."','".$tab['selected']."');";
						if( $style['layout']['typ'] == "cardbox" )
							$content .= "jQuery('#{$id}_box').hide();";
			$content .=	"return false;\" id='" . $id . "_mtghtab_cat_". $i ."' style='background:";
			if($i == 0){
				$content .= $tab['selected'].";color:#FFFFFF;";			
			}else{
				$content .= $tab['color'].";";
			}
			$content .=	"height:{$tab['height']};'>" . $category. "</a></li>";
		}
		$content .= "</ul></div>"; //end of tabs
	}

	/********** DISPLAY CONTENT **********/
	
	//display content (card list and card display)
	$table_content_width = ($style['width'] -6) . "px";
	$content .= "<div id='{$id}_content' class='content'";
	if( is_string($style['options']['mini']) )
		$content .= "style='display:none;'";
	$content .= ">"; //open slide div
		
	/********** CARDLIST == THUMBNAIL **********/	
	if( $style['layout']['typ'] == "thumbnail" )
    {
		$img_tab_width = ($style['width'] - 6) . "px";
		foreach( $categories as $i => $category){
			//begin cardlist tab
			$content .= "<div id='" . $id . "_mtghtab_" . $i . "' style='width:{$img_tab_width};";
			//only display the first category
			if( $i != 0 )
				$content .= "display:none;";
			$content .= "'>";
			
			//make cute little card images
			$content .= carddisplay_thumbnail($stack[$i],$pick,$style);
		
			$content .= "</div>"; //end cardlist tab
		}		
	/********** CARDLIST == TEXT **********/
	}
    else
    {	
		$content .= "<table cellspacing='0' cellpadding='0' style='width:{$table_content_width}'><tr>"; //open content table

		//display preview card left (display normal + left)
		if( ($style['layout']['typ'] == "cardbox") && ($style['layout']['side'] == "left") ){
			$margin = "margin-right:10px;";
			$content .= display_cardbox($id,$margin);
		}	
		
		$content .= "<td>"; //open cardslist cell
		
		/********** APPEARANCE == TABBED **********/	
		if( $style['category']['typ'] == "tabbed" )
        {
			//generating divs for each categorie
			foreach( $categories as $i => $category)
            {
				//open category tab div
				$content .= "<div id='" . $id . "_mtghtab_" . $i . "'";
				//only display the first category
				if( $i != 0 )
					$content .= " style='display:none;'";
				$content .= ">";			

				//card display via jtip tooltip
				if( $style['layout']['typ'] == "tooltip" )
                {
					$content .= carddisplay_tooltip($stack[$i],$pick,$style['options']['pick'],$style['layout']['col']);
				//card display via preview card
				}else
                {
					$content .= carddisplay_box($stack[$i],$id,$pick,$style);
				}
				
				$content .= "</div>";
			}
		/********** APPEARANCE == HEADLINES **********/
		}
        else
        {
			//no categories
			if( is_null($categories[0]) ){
				//card display via jtip tooltip
				if( $style['layout']['typ'] == "tooltip" ){
					$content .= carddisplay_tooltip($stack[0],$pick,$style['options']['pick'],$style['layout']['col']);
				//card display via preview card
				}else{
					$content .= carddisplay_box($stack[0],$id,$pick,$style);
				}
			//categories
			}
            else
            {
				//dont create unnecessary columns
				if( $style['layout']['col'] > count($categories) )
					$style['layout']['col'] = count($categories);
				//gets an array of arrays with category number
				$list_colbrakes = get_colbrakes($style['layout']['col'],$stack);
				//write down alle categories
				$content .= "<table cellspacing='0' cellpadding='0' width='100%'><tr>";
				foreach( $list_colbrakes as $i => $column)
                {
					$content .= "<td>";
					for( $j=0;$j<count($column);$j++ )
                    {
						//count the cards inside a category
						if( $style['category']['count'] )
                        {
							$card_count = 0;
							foreach ( $stack[$column[$j]] as $card )
                            {
								if( $card['count'] == "" )
									$card_count++;
								$card_count += $card['count'];
							}
						}
						//display headline
						$headline_style = get_option(mtghCategoryHeadline);
						$content .= "<div style='font-size:".$headline_style['size'].";font-weight:".$headline_style['weight'].";'>" . $categories[$column[$j]];
						if( $style['category']['count'] )
							$content .= " ($card_count)";
						$content .= "</div>";
						//card display via jtip tooltip
						if( $style['layout']['typ'] == "tooltip" )
                        {
							$content .= carddisplay_tooltip($stack[$column[$j]],$pick,$style['options']['pick']);
						//card display via preview card
						}
                        else
                        {
							$content .= carddisplay_box($stack[$column[$j]],$id,$pick,$style);
						}
					}
					$content .= "</td>";
				}
				$content .= "</tr></table>";			
				
			}
		}
		$content .= "</td>"; //end cardslist cell
		
		//display preview card left (display normal + right)
		if( ($style['layout']['typ'] == "cardbox") && ($style['layout']['side'] == "right") ){
			$margin = "margin-left:10px;";
			$content .= display_cardbox($id,$margin);
		}	
		
		$content .= "</tr></table>"; //end of category		
	}		
	$content .= "</div>"; //end of slide div
	
	$content .= "</div>"; //end surrounding div

	$content .= cache_cards($cardnames_for_caching);
	
	return $content;
}	

//display card borders and background or image
function display_cardbox($id,$margin){
	$content = "<td class='card_box'><div class='display_preview'><img id='{$id}_box' src='' style='display:none;' /></div></table></td>";
	return $content;
}

//carddisplay option => card box
function carddisplay_box(&$cards,$id,$pick,&$style,$colcount=1)
{
	//dont create unnecessary columns
	if( $colcount > count($cards) )
		$colcount = count($cards);
	
	//make sure columns have almost same length
	
	if( $colcount > 1 )
    {
		//init some vars
		$list_colbrakes = get_colbrakes($colcount,count($cards));
		$start_col = 0;
		$end_col = $list_colbrakes[0];		
		
		//cardlisting
		$content = "<table cellspacing='0' cellpadding='0' width='100%'><tr>"; //open table for colums
		//for each colum
		for( $i=0;$i<$colcount;$i++ )
        {			
			$content .= "<td style='padding-right:5px;'><ul>";
			//insert cards until colum end is reached
			for($j=$start_col;$j<$end_col;$j++){
				//open list item
				$content .= "<li>";
				//check if card count is given (dont bother displaying if not)
				if( $cards[$j]["count"] )
					$content .= "<span class='count'>" . $cards[$j]["count"] . "</span> ";
					
				//reset class
				$add_class="";
				
				//show pick
				if( trim($cards[$j]["cardname"]) == trim($pick) ){
					if( $style['options']['pick'] && is_bool($style['options']['pick']) ){
						$add_class = "cardpick_border cardpick";
					}else{
						$add_class = "cardpick";
					}
				}

                // Clickthrough to magiccards.info				
                $card_name = $cards[$j]["cardname"];
                $card_name_corrected = preg_replace("/[^a-zA-Z][^a-zA-Z]?/u", " ", $card_name);
                $onclick = " onclick=window.open('https://scryfall.com/search?q=!" . urlencode($card_name_corrected) . "') ";

				//cardname and link to the cardbox
				$content .= "<span class='cardname'><a style='font-size:".get_option(mtghFontSize).";";
                
				if( $add_class == "" )
					$content .= "color:".get_option(mtghFontColor).";";
                    
				$content .= "' class='$add_class' href='#'
				onmouseover=\"jQuery('#{$id}_box').show().attr('src','" . get_source_from_name($cards[$j]["cardname"])."'); \""
				.$onclick
                .">"
				. $card_name
				."</a></span></li>";
			}
			$content .= "</ul></td>";
			//calc next colums stard-/endpoint
			$start_col = $end_col;
			if( isset($list_colbrakes[$i+1]) )
				$end_col += $list_colbrakes[$i+1];			
		}		
		$content .= "</tr></table>"; //close table
	}else{
		$content = "<ul>";
		//stack = array with cards (count,cardname);
		foreach ( $cards as $card ){
			//open list item
			$content .= "<li>";
			//check if card count is given (dont bother displaying if not)
			if( $card["count"] )
				$content .= "<span class='count'>" . $card["count"] . "</span> ";

			//reset class
			$add_class="";
			
			//show pick
			if( trim($card["cardname"]) == trim($pick) ){
				if( $style['options']['pick'] && is_bool($style['options']['pick']) ){
					$add_class = "cardpick_border cardpick";
				}else{
					$add_class = "cardpick";
				}
			}				
            
            // Clickthrough to magiccards.info				
            $card_name = $card["cardname"];
            $card_name_corrected = preg_replace("/[^a-zA-Z\-!_][^a-zA-Z\-!_]?/u", " ", $card_name);
            $onclick = " onclick=window.open('https://scryfall.com/search?q=!" . urlencode($card_name_corrected) . "') ";
            
			//cardname and link to the cardbox
			$content .= "<span class='cardname'><a style='font-size:".get_option(mtghFontSize).";";
			if( $add_class == "" )
				$content .= "color:".get_option(mtghFontColor).";";
			$content .= "' class='$add_class' href='#'
			onmouseover=\"jQuery('#{$id}_box').show().attr('src','" . get_source_from_name($card["cardname"])."'); \""
			.$onclick
            .">"
			.$card["cardname"]
			."</a></span></li>";
		}
		$content .= "</ul>";
	}
	
	return $content;
}

//carddisplay option => tooltip
function carddisplay_tooltip(&$cards,$pick,$pick_opt,$colcount=1){
	
	//dont create unnecessary columns
	if( $colcount > count($cards) )
		$colcount = count($cards);
	
	//make sure columns have almost same length 
	if( $colcount > 1 ){
		//init some vars
		$list_colbrakes = get_colbrakes($colcount,count($cards));
		$start_col = 0;
		$end_col = $list_colbrakes[0];
		
		//cardlisting
		$content = "<table cellspacing='0' cellpadding='0' width='100%'><tr>"; //open table for colums
		//for each colum
		for( $i=0;$i<$colcount;$i++ ){			
			$content .= "<td";
			//space between the table cells
			if( isset($list_colbrakes[$i-1]) )
				$content .= " style='padding-left:5px;'";
			$content .= "><ul>";
			//insert cards until colum end is reached
			for($j=$start_col;$j<$end_col;$j++){
				//open list item
				$content .= "<li>";
				//check if card count is given (dont bother displaying if not)
				if( $cards[$j]["count"] )
					$content .= "<span class='count'>" . $cards[$j]["count"] . "</span> ";
					
				//reset class
				$add_class="";
				
				//show pick
				if( trim($cards[$j]["cardname"]) == trim($pick) ){
					
					if( $pick_opt && is_bool($pick_opt) ){
						$add_class = "cardpick_border cardpick";
					}else{
						$add_class = "cardpick";
					}
				}				
				
				//cardname and js for tooltip
				$content .= "<span class='cardname'><a style='font-size:".get_option(mtghFontSize).";";
				if( $add_class == "" )
					$content .= "color:".get_option(mtghFontColor).";";
				$content .= "' class='jTip {$add_class}' href='https://goodgamery.com/api/mtg/card/html?card="
					.urlencode($cards[$j]["cardname"])
					."&width=200&height=285'"
					."name='" . get_source_from_name($cards[$j]["cardname"]). "'>"
					.$cards[$j]["cardname"]
					."</a></span></li>";
			}
			$content .= "</ul></td>";
			//calc next colums stard-/endpoint
			$start_col = $end_col;
			if( isset($list_colbrakes[$i+1]) )
				$end_col += $list_colbrakes[$i+1];			
		}	
		$content .= "</tr></table>"; //close table
	}else{
	//no linesbreaks
		$content = "<ul>";
		//stack = array with cards (count,cardname);
		foreach ( $cards as $card ){
			//open list item
			$content .= "<li>";
			//check if card count is given (dont bother displaying if not)
			if( $card["count"] )
			$content .= "<span class='count'>" . $card["count"] . "</span> ";
			
			//reset class
			$add_class="";

			//show pick
			if( trim($card["cardname"]) == trim($pick) ){
				if( $pick_opt && is_bool($pick_opt) ){
					$add_class = "cardpick_border cardpick";
				}else{
					$add_class = "cardpick";
				}
			}			
			
			//cardname and js for tooltip
			$content .= "<span class='cardname'><a style='font-size:".get_option(mtghFontSize).";";
			if( $add_class == "" )
				$content .= "color:".get_option(mtghFontColor).";";
			$content .= "' class='jTip {$add_class}' href='https://goodgamery.com/api/mtg/card/html?card="
				.urlencode($card["cardname"])
				."&width=200&height=285'"
				."name='" . get_source_from_name($card["cardname"]). "'>"
				.$card["cardname"]
				."</a></span></li>";
		}
		$content .= "</ul>";
	}
	return $content;
}

//carddisplay option => img
function carddisplay_thumbnail(&$stack, $pick, &$style){
	$content = "";
	
	/********** PARSE THE CARD STACK **********/
	/*
	* converts the stack into an array of cards
	* cards which occur more than once are listed as many times as they occur	
	*/	
	$cards = array();
	foreach( $stack as $item ){
		if( !is_numeric($item['count']) )
			$item['count'] = 1;
		for( $i=1; $i <=$item['count'];$i++){
			$cards[] = trim($item['cardname']);
		}
	}
	
	/********** DIMENSIONS CALC **********/
		
	//calc card width + height
	$count_cards = count($cards);
	if ( $count_cards > $style['layout']['rowcount'] ){
		$card_limit = $style['layout']['rowcount'];
	} else{
		$card_limit = $count_cards;
	}
	$card_width = floor(($style['width']-6)/$card_limit);
	$card_height = floor(285*($card_width/200));
	
	//hardcoded values => cards shouldnt be bigger than this values
	if ( $card_height > 175 ){
		$card_height = 175;
		$card_width = 123;
	}
	$class = "";
	if( $style['layout']['action'] == "fade" )
		$class = "cardfader";
	if( $style['layout']['action'] == "zoom" )
		$class = "cardzoomer";	
	
	//div width and numer of rows
	$div_width = $card_limit*$card_width;
	$number_of_rows = ceil($count_cards/$style['layout']['rowcount']);
	
	//start displaying cards (i == current row number)
	for($i = 0; $i<$number_of_rows;$i++){
		
		//calc start + end of line
		$start_row = $i*$card_limit;
		$end_row = ($i+1)*$card_limit;

		//open div for a card row
		$content .= "<div style='height:{$card_height}px;width:{$div_width}px;'>";
		
		//insert card pics into div (j == current card in the array)
		for($j = $start_row; $j < $end_row; $j++){
			//brake
			if( $j >= $count_cards )
				break;

			//reset card
			$add_class="";
			$display_height = $card_height;
			$display_width = $card_width;

			//check for pic and options
			if( trim($cards[$j]) == trim($pick) ){
				//highlight the pick
				if( $style['options']['pick'] && is_bool($style['options']['pick']) ){
					$add_class = "cardpick_border cardpick";
					$display_height -= 4;
					$display_width -= 4;
				}else{
					$add_class = "cardpick";
				}

			}
			
			$content .= 	'<a href="https://goodgamery.com/api/mtg/card/html?card='
						.urlencode($cards[$j]).'&width=200&height=285" name="'
						.htmlspecialchars($cards[$j],ENT_QUOTES). '">'
						."<img class='thumbnail ".$class." ".$add_class."' style='height:{$display_height}px;width:{$display_width}px;' src='"
						. get_source_from_name(trim($cards[$j]))
						. "' alt='" .htmlspecialchars($cards[$j],ENT_QUOTES). "' />"
						."</a>";
		}	
		$content .= "</div>"; //close div for a card row
	}
	
	return $content;
}

//calc colbrakes (dividable parts => list of lines, non-dividable parts => list of categories)
function get_colbrakes($colcount,&$lines){
	//init some needed vars
	$list_colbrakes = array();
	$count = 0;
	
	//with parts which could not be divided
	if( is_array($lines) ){
		//calc total height and heigt of each category
		foreach($lines as $i => $category){
			$height[$i] = count($category)+1;
			$total_height += $height[$i];
		}
		//do the magic
		for($i = 0; $i < $colcount;$i++){
			if($i == 0){
				$cat_nr = 0;
				$start = 0; 
			}
			//calc the range of the column
			$end = floor($total_height/$colcount)*($i+1);
			while( ($start < $end) && ($cat_nr<count($height)) ){
				$list_colbrakes[$i][] = $cat_nr;
				$start +=$height[$cat_nr];
				$cat_nr++;
			}
		}
	//with no parts, divide as you want 		
	}else{
		for($i=0; $i < $colcount;$i++){
			$list_colbrakes[$i] = 0;
		}
		while( $count <= $lines ){
			if( ($lines-$count) >= $colcount ){
				for($i=0; $i < $colcount;$i++){
					$list_colbrakes[$i]++;
				}
			}else{
				for($i=0; $i < ($lines-$count);$i++){
					$list_colbrakes[$i]++;
				}				
			}
			$count += $colcount;
		}	
	}
	//returned value is always an array
	return $list_colbrakes;
}

function parse_card_string( $card_matches, &$cardnames_for_caching )
{
    // Remove things we don't want from card_matches
    //$card_matches = preg_replace("/<br\/>/u", "", $card_matches); // Waaaugh

    //echo "Card_Matches is '" . $card_matches . "'<br>";
	if( strpos($card_matches, '*') )
    {
        //find all cards from deck with * sperator
		preg_match_all('!\*[0-9]*[A-Za-z_\-,\x{00E8}\x{00E9}\x{00E6}\x{00C6}#8217;#8220;#8221;#38;\.\'\!\(\)\/&amp;;: ]{1,}!isu', $card_matches, $cards);
	}
    else
    {
        //find all cards from deck with ; sperator
		preg_match_all(  '![0-9]*[A-Za-z_\-,\x{00E8}\x{00E9}\x{00E6}\x{00C6}#8217;#8220;#8221;#38;\.\'\!\(\)\/&amp;;: ]{1,}(|;|\n)!isu', $card_matches, $cards);
	}
	
	$i = 0;
	foreach( $cards[0] as $card )
    {
		//i hate tinymce. this if statement catches some weird parse errors
		if ( $card != "br " && $card != "br /" && $card != "\n" && strlen($card) > 3 )
        {
            //echo "Card is '" . $card . "'<br/>";
            $card = preg_replace("/\n/u", "", $card); // Waaaugh
			if( substr(trim($card),0,1) == "*")
				$card = substr(trim($card),1);
			if( substr(trim($card),-1) == ";")
				$card = substr(trim($card),0,-1);
			$k = 0;
			$number = "";
			while(is_numeric($card[$k])){
				$number .= $card[$k];
				$k++;
			}
			$cardname =  substr($card,strlen($number));
			$stack[$i]["cardname"] = ucfirst(trim($cardname));
			$stack[$i]["count"] = $number;
			$cardnames_for_caching[] = ucfirst(trim($cardname));
			$i++;
		}
	}
	
	return $stack;
}

//styling options for the lists
function mtgh_get_style($name,$options){
	
	$style = array();
	
	//formating the options
	if( !empty($options) ){
		//catch posibile error if user forgot the last semicolon
		if( substr($options,-1) == ";" )
			$options = substr($options,0,-1);
		$options = explode(';', $options);

		//make an array with all options
		foreach( $options as $option ){
			$option = explode(':',$option);
			if( $option[0] != '' )
				$style[$option[0]] = $option[1];
		}
		//formating
		if( isset($style['layout']) )
			$style['layout'] = mtgh_make_style($style['layout']);
		if( isset($style['category']) )
			$style['category'] = mtgh_make_style($style['category']);
		if( isset($style['options']) )
			$style['options'] = mtgh_make_style($style['options']);		
	}

	//width
	if( !isset($style['width']) )
		$style['width'] = "570px";
	
	//alignment
	if( !isset($style['align']) ){
		$style['align'] = "0px auto";
		if( get_option(mtghAlign) == "left" )
			$style['align'] = "0px";
		if( get_option(mtghAlign) == "right" )
			$style['align'] = "0px 0px 0px auto";		
	}else{
		$style['align'] = "0px auto";
		if( $style['align'] == "left" )
			$style['align'] = "0px";
		if( $style['align'] == "right" )
			$style['align'] = "0px 0px 0px auto";	
	}
	
	//cardlist settings
	if( $name == 'cardlist' ){
		$default = get_option(mtghCardlistSettings);
		//layout
		if( !isset($style['layout']) ){
			switch( $default['layout']['typ'] ){
				case 'cardbox':
					$style['layout'] = $default['layout']['cardbox'];
					$style['layout']['typ'] = 'cardbox';
					break;
				case 'tooltip':
					$style['layout'] = $default['layout']['tooltip'];
					$style['layout']['typ'] = 'tooltip';
					break;
				case 'thumbnail':
					$style['layout'] = $default['layout']['thumbnail'];
					$style['layout']['typ'] = 'thumbnail';
					break;			
			}
		}
		//category
		if( !isset($style['category']) ){
			switch( $default['category']['typ'] ){
			case 'headline':
				$style['category'] = $default['category']['headline'];
				$style['category']['typ'] = 'headline';
				break;
			case 'tabbed':
				$style['category'] = $default['category']['tabbed'];
				$style['category']['typ'] = 'tabbed';				
				break;
			}
		}
		//options
		$options = get_option(mtghOptions);
		if( !isset($style['options']) ){
			$style['options'] = $options;
		}
	//custom tags
	}else{
		$ct = get_option(mtghCustomTags);
		foreach( $ct as $i => $tag ){
			//generate styles for existing tags
			if( $tag['name'] == $name){
				if( !isset($style['layout']) ){
					$style['layout'] = $ct[$i]['layout'];					
				}
				if( !isset($style['category']) ){
					$style['category'] = $ct[$i]['category'];					
				}
				if( !isset($style['options']) ){
					$style['options'] = $ct[$i]['options'];					
				}				
			}
		}
	}
	
	return $style;
}

?>