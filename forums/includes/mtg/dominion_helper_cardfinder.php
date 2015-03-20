<?php
	
//find card (executet from the generated posting via link)
if( isset($_GET['find']) )
{
	$card_url = dominion_get_source_from_name($_GET['find']);
    if( isset($_GET['address']) )
    {
        echo $card_url;
    }
    else
    {
        echo "<img src=\"$card_url\" />";
    }
	//do not execute the rest of the code
	die();
}

//for secure cardname parsing 
function dominion_get_source_from_name($name)
{
    $name = dominion_card_tags($name, "runeboggle");
    
	$name = htmlspecialchars(urldecode($name));
	$name = preg_replace("/[ ]+/", " ", $name);
    
	return $name;
}

// Filter definition
function dominion_card_tags($card_name_original, $display_name)
{
    $output = $display_name;

    // If it's not empty
    if ( $card_name_original != '' )
    {
        // Make a copy of the original
        $card_name_corrected = $card_name_original;
        
        // Replace the bad characters in the card name
        $card_name_corrected = preg_replace("/[\x{00E8}\x{00E9}]/u", "e", $card_name_corrected);     // `e
        $card_name_corrected = preg_replace("/[\x{00E6}\x{00C6}]/u", "ae", $card_name_corrected);    // AE Ligature
        $card_name_corrected = preg_replace("/[^a-zA-Z]/u", "", $card_name_corrected);              // Remove all non-alpha characters

        // Lower case
        $card_name_corrected = strtolower($card_name_corrected);

        // Format the final html output
        $output = dominion_card_tags_gatherer_img($card_name_corrected);
    }

    return $output;
}

function dominion_card_tags_gatherer_img($card_name)
{
    $gatherer_image = "http://dominion.diehrstraits.com/scans/auto/" . $card_name . ".jpg";
    return $gatherer_image;
}

?>