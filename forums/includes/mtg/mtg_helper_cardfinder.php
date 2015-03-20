<?php
	
//find card (executed from the generated posting via link)
if( isset($_GET['find']) )
{
	$card_url = get_source_from_name($_GET['find']);
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

function stripAccents($stripAccents)
{ return strtr($stripAccents, 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'); }

//for secure cardname parsing 
function get_source_from_name($name)
{
    $name = gg_card_tags($name, "runeboggle");
    
	$name = htmlspecialchars(urldecode($name));
	$name = preg_replace("/[ ]+/", " ", $name);
    
	return $name;
}

// Filter definition
function gg_card_tags($card_name_original, $display_name)
{
    //echo "gg_card_tags(". $card_name_original . ", " . $display_name . ")<br/>";
    $output = $display_name;

    // If it's not empty
    if ( $card_name_original != '' )
    {
        // Make a copy of the original
        $card_name_corrected = stripslashes($card_name_original);
        
        // Replace the bad characters in the card name
        $card_name_corrected = preg_replace("/[\x{00E8}\x{00E9}]/u", "e", $card_name_corrected);     // `e
        $card_name_corrected = preg_replace("/[\x{00E6}\x{00C6}]/u", "ae", $card_name_corrected);    // AE Ligature
        $card_name_corrected = preg_replace("/ ?\/\/ ?/u", "__", $card_name_corrected);              // Split cards
        $card_name_corrected = preg_replace("/ ?\/ ?/u", "_", $card_name_corrected);                 // Who/What/When/Where/Why
        $card_name_corrected = preg_replace("/[ -]/u", "_", $card_name_corrected);                   // Spaces and dashes
        $card_name_corrected = preg_replace("/&amp;/u", "", $card_name_corrected);                   // '"
        $card_name_corrected = preg_replace("/ \(foil\)/u", "", $card_name_corrected);               // Foils
        $card_name_corrected = preg_replace("/#8217;|#8220;|#8221;/u", "", $card_name_corrected);    // '"
        $card_name_corrected = preg_replace("/[:`'’,!&;\"]/u", "", $card_name_corrected);              // Punctuation
        $card_name_corrected = preg_replace("/\#038/u", "", $card_name_corrected);              // HACKS
        $card_name_corrected = preg_replace("/\#8221/u", "", $card_name_corrected);              // HACKS
        $card_name_corrected = stripAccents($card_name_corrected);

        // Lower case
        $card_name_corrected = strtolower($card_name_corrected);

        // Format the wizards urls with the corrected card name
        $gatherer_address = gg_card_tags_gatherer_address($card_name_corrected);
        $gatherer_image = gg_card_tags_gatherer_img($card_name_corrected);
        
        // Format the final html output
        $output = $gatherer_image;
    }

    return $output;
}

function gg_card_tags_gatherer_img($card_name)
{
    if( $card_name == "super_secret_tech" )
    {
        $gatherer_image = "http://www.wizards.com/magic/images/SST_withborder.jpg"; // Super secret cards!
    }
    else
    {
        $gatherer_image = "http://www.wizards.com/global/images/magic/general/" . $card_name . ".jpg";
    }
    return $gatherer_image;
}

function gg_card_tags_gatherer_address($card_name)
{
    if( $card_name == "super_secret_tech" )
    {
        $gatherer_address = "http://www.wizards.com/magic/SST.asp"; // Super secret cards!
    }
    else
    {
        $gatherer_address = 'http://ww2.wizards.com/gatherer/CardDetails.aspx?name=' . $card_name;
    }
    return $gatherer_address;
}

?>