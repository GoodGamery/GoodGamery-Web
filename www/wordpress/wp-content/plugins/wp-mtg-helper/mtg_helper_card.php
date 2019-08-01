<?php

//cardlinking per jTip
function mtgh_card($content){

	//preload all image-files
	preg_match_all('/(\[CARD\])(.*)(\[\/CARD\])/iU',$content,$result);
	$preload = cache_cards($result[2]);
	
	// Also, card= tags
	preg_match_all('/(\[CARD=([^]]*)\])(.*)(\[\/CARD\])/iU',$content,$result);
	$preload = $preload . cache_cards($result[2]);

	//replace the [card]-tags with the referer for the card images
	$content = preg_replace_callback(
	'/(\[CARD\])(.*)(\[\/CARD\])/iU',
	'parse_card_url',
	$content);

	$content = preg_replace_callback(
	'/(\[CARD=([^]]*)\])(.*)(\[\/CARD\])/iU',
	'parse_card_url_override',
	$content);

	return $content.$preload;
	
}

function parse_card_url_override ($card_names)
{			
    $card_name = $card_names[2];
    $card_title = $card_names[3];
    // $card_name_corrected = preg_replace("/[^a-zA-Z\-!_][^a-zA-Z\-!_]?/u", " ", $card_name);
    $card_name_corrected = $card_name;
    $onclick = " onclick=window.open('https://scryfall.com/search?q=!%22" . urlencode($card_name_corrected) . "%22') ";

	return '<a href="' . get_bloginfo('wpurl') . MTGH_DIR 
	.'/mtg_helper_cardfinder.php?find=' . urlencode($card_name) . '&width=200&height=285" class="jTip" name="" '
    . $onclick
    .'>'
	. $card_title . '</a>';
}

function parse_card_url ($card_names)
{			
    $card_name = $card_names[2];
    // $card_name_corrected = preg_replace("/[^a-zA-Z\-!_][^a-zA-Z\-!_]?/u", " ", $card_name);
    $card_name_corrected = $card_name;
    $onclick = " onclick=window.open('https://scryfall.com/search?q=!%22" . urlencode($card_name_corrected) . "%22') ";

	return '<a href="' . get_bloginfo('wpurl') . MTGH_DIR 
	.'/mtg_helper_cardfinder.php?find=' . urlencode($card_name) . '&width=200&height=285" class="jTip" name="" '
    . $onclick
    .'>'
	. $card_name . '</a>';

}



?>