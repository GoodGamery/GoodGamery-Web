<?php

include 'config.php';

//find card (executed from the generated posting via link)
if( isset($_GET['find']) )
{
	$card_url = get_source_from_name_v3($_GET['find']);
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
function adjustName($input)
{ return strtr($input, '&,', '..'); }

function fixApostrophes($input)
{
	$trans = array("%26%238217%3B" => "'", "&#8217;" => "'");
	$temp = strtr($input, $trans);
	return $temp;
}

function fetch_gatherer_redirect($url, $maxredirects) 
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec($ch);
    curl_close($ch);

    $rv = null;

    // Check headers to see if we got redirected.
    // Best case scenario: We got redirected and the url contains multiverseid and we can quit.
    // Next-best: We got redirected and the url doesn't contian multiverseid and we need to follow the redirect.
    // Worst-case scenario, no redirect (or we hit our max) and we need to divine the multiverseid from the body (which could be wrong)
    $headers = explode("\n", $result);
    foreach ($headers as $key => $r) 
    {
        if (stripos($r, "Location") !== FALSE) 
        {
            list($headername, $headervalue) = explode(":", $r);
            $rv = trim($headervalue);
            if ( strpos($rv, "multiverseid=") === FALSE && $maxredirects > 0 ) // Follow further redirects.
                $rv = fetch_gatherer_redirect($url, $maxredirects - 1);
        }
    }

    if ( $rv == null )
    {
        // If we couldn't find it, just use the first multiverseid= we find in the body of the request
        $pos = strpos($result, "multiverseid=");
        if ( $pos !== FALSE )
        {
            $rv = "http://gatherer.wizards.com/Pages/Card/Details.aspx?multiverseid=" . intval(substr($result, $pos+strlen("multiverseid=")));
        }
        else
        {
            // give up
            $rv = $url;
        }
    }

    return $rv;
}

function get_source_from_name_v3($name)
{
	// Connect to DB
	$hostname = DB_HOST_MTG;
	$username = DB_USER_MTG;
	$dbname = DB_NAME_MTG;
	$password = DB_PASSWORD_MTG;

	//Connecting to your database
	$mysqli = new mysqli($hostname, $username, $password, $dbname);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$name = fixApostrophes($name);
	$name = adjustName(strtolower($name));
	$words = explode(" ", $name);
	$nameFixed = "";
	$split = false;
	if( count($words) >= 3 && $words[1] == "//" )
	{
		$split = true;
		$nameFixed = implode("]+[", $words);
	}
	else
	{
		$nameFixed = implode("\s", $words);
	}

	//Prepare statement to find cached card image
	$stmt = $mysqli->prepare("SELECT url FROM autocard_cache WHERE name=(?)");
	if (!$stmt->bind_param("s", $name)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	
	// Put the variable in and execute it
	$cached_url = "";
	$cached_exists = false;
	$stmt->execute();
	$stmt->store_result();
	
	if( $stmt->num_rows == 1 )
	{
		$cached_exists = true;
		$stmt->bind_result($cached_url);
		$stmt->fetch();
	}
	
	$stmt->close();

	// Found it!
	if( $cached_exists )
	{
		// Close and return
		$mysqli->close();
		//printf("CACHED!<br>");
		return $cached_url;
	}

	$url = "http://gatherer.wizards.com/Pages/Search/Default.aspx?name=";
	if( $split )	// Exact searches don't work for split cards
	{
		$url .= "+[" . urlencode($nameFixed) . "]";
	}
	else	// Use an exact search
	{
		$url .= "+[m/^" . urlencode($nameFixed) . "$/]";
	}

    $imgurl = "http://gatherer.wizards.com/Handlers/Image.ashx?type=card&multiverseid=";
    $gathererurl = fetch_gatherer_redirect($url, 3);
    $pos = strpos($gathererurl, "multiverseid=");
    $multiverseid = ""; // Default value
    if ( $pos > 0 )
    {
        $multiverseid = intval(substr($gathererurl, $pos+strlen("multiverseid=")));
        $imgurl .= $multiverseid;
    }
	
	if( ( $multiverseid == "73935" && strpos($name, "ach!") === FALSE ) || $multiverseid == "" ) 	// Ach hans run, it's a terrible bug
	{
		printf("url was %s<br>it's a name: %s<br>it's a nameFixed: %s<br>", $url, $name, $nameFixed);
	}
	// Cache it if the id is valid
	else if( $multiverseid != "" )
	{
		$stmt = $mysqli->prepare("INSERT INTO `autocard_cache` (`name`, `url`) VALUES ((?), (?))");
		if (!$stmt->bind_param("ss", $name, $imgurl)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->execute();
		$stmt->close();
	}
	$mysqli->close();

    return $imgurl;
}

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