<?php

//cardlinking per jTip
function mtgh_card($content){

	//preload all image-files
	preg_match_all('/(\[CARD\])(.*)(\[\/CARD\])/iU',$content,$result);
	$preload = cache_cards($result[2]);

	//replace the [card]-tags with the referer for the card images
	$content = preg_replace_callback(
	'/(\[CARD\])(.*)(\[\/CARD\])/iU',
	'parse_card_url',
	$content);

	return $content.$preload;
	
}

function parse_card_url ($card_names)
{
    // Clickthrough to magiccards.info				
    $card_name = $card_names[2];
    $card_name_corrected = preg_replace("/[^a-zA-Z\-!_][^a-zA-Z\-!_]?/u", " ", $card_name);
    $onclick = " onclick=window.open('http://magiccards.info/query.php?cardname=" . urlencode($card_name_corrected) . "') ";

	return '<a href="' . get_bloginfo('wpurl') . MTGH_DIR 
	.'/mtg_helper_cardfinder.php?find=' . urlencode($card_name) . '&width=200&height=285" class="jTip" name="" '
    . $onclick
    .'>'
	. $card_name . '</a>';

/*
    $card_img = get_source_from_name($card_names[2]);
	return '<a href="http://magiccards.info'
	.'/query.php?cardname=' . urlencode($card_names[2]) . '&width=200&height=285" class="jTip" name="' . $card_img . '">'
	. $card_names[2] . '</a>';
/**/
/*
    return '<a href="http://magiccards.info/query.php?cardname='
        . urlencode($card_names[2])
        . '&width=200&height=285" class="jTip" name="">'
        . $card_names[2] . '</a>';
/**/
}

?>