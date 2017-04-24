<?php

//find card (executed from the generated posting via link)
if( isset($_GET['find']) )
{
    $card_url = eternal_get_source_from_name($_GET['find']);
    if( isset($_GET['address']) )
    {
        echo $card_url;
    }
    else if( isset($_GET['img']))
    {
        $fp = fopen($card_url, 'rb');
        header('Content-Type: image/png');
        header('Cache-Control: max-age=864000, public');
        fpassthru($fp);
        fclose($fp);
        exit;
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
        $card_name_corrected = preg_replace("/[^a-zA-Z ',\-]/u", "", $card_name_corrected); // drops any characters not in card names
        $card_name_corrected = strtolower($card_name_corrected);
        $card_name_corrected = implode("-", array_map(ucwords, explode("-", $card_name_corrected))); // use title case for words and after -
        $card_name_corrected = preg_replace("/\bTo\b/", "to", $card_name_corrected); // these words by themselves are lowercase
        $card_name_corrected = preg_replace("/\bOf\b/", "of", $card_name_corrected);
        $card_name_corrected = preg_replace("/\bThe\b/", "the", $card_name_corrected);
        $card_name_corrected = preg_replace("/\bAt\b/", "at", $card_name_corrected);
        $card_name_corrected = preg_replace("/\bIn\b/", "in", $card_name_corrected);
        $card_name_corrected = ucfirst($card_name_corrected); // "The" is still capitalized at the start of the filename
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
