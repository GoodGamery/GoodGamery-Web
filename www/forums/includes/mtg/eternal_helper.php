<?php

//find card (executed from the generated posting via link)
if( isset($_GET['find']) )
{
    $card_url = eternal_get_source_from_name($_GET['find']);
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
function eternal_get_source_from_name($name)
{
    $name = urldecode($name);
    $name = preg_replace("/[&\"<>]/u", "", $name); // keep single quote and strip other characters
    $name = eternal_card_tags($name, "runeboggle");
    return $name;
}

// Filter definition
function eternal_card_tags($card_name_original, $display_name)
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
        $card_name_corrected = preg_replace("/[^a-zA-Z ',\-]/u", "", $card_name_corrected); // characters in card names
        $card_name_corrected = strtolower($card_name_corrected); // use title case, but not for "of" and "the"
        $card_name_corrected = ucwords($card_name_corrected);
        $card_name_corrected = str_replace("Of", "of", $card_name_corrected);
        $card_name_corrected = str_replace("The", "the", $card_name_corrected);
        $card_name_corrected = preg_replace("/[ ]+/u", "+", $card_name_corrected);    // spaces to +

        // Format the final html output
        $output = eternal_card_tags_gatherer_img($card_name_corrected);
    }

    return $output;
}

function eternal_card_tags_gatherer_img($card_name)
{
    $gatherer_image = "https://s3.amazonaws.com/eternaldecks/cards/" . $card_name . ".png";
    return $gatherer_image;
}

?>
