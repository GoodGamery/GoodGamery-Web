<?php

$use_hs_cache = false;

//find card (executed from the generated posting via link)
if( isset($_GET['find']) )
{
	$card_url = get_hearthsone_card_from_name($_GET['find']);
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


function get_hearthsone_card_from_name($cardName)
{
    $imgUrl = "";

    // Connect to DB
    $hostname = DB_HOST_MTG;
    $username = DB_USER_MTG;
    $dbname = DB_NAME_HS;
    $password = DB_PASSWORD_MTG;

    // Connecting to your database
    if ($use_hs_cache) {
        $mysqli = new mysqli($hostname, $username, $password, $dbname);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        } else {
            $cardUrl = get_hearthstone_card_from_db($mysqli, $cardName);
        }
    }

    // Failed
    if ($imgUrl == "") {
        $imgUrl = get_hearthstone_card_from_api($cardName);
        if ($use_hs_cache)
            store_hearthstone_card_in_db($mysqli, $cardName, $cardUrl);
    }

    if ($use_hs_cache)
        $mysqli->close();

    return $imgUrl;
}

function get_hearthstone_card_from_db($mysqli, $cardName)
{
    // Hearthstone-ize-it
    $cardName = strtolower($cardName);

    //Prepare statement to find cached card image
    $stmt = $mysqli->prepare("SELECT url FROM `hs_cache` WHERE name=(?)");
    if (!$stmt->bind_param("s", $cardName)) {
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
    if( $cached_exists ) {
        return $cached_url;
    }

    return "";
}

function store_hearthstone_card_in_db($mysqli, $cardName, $cardUrl)
{
    if ($mysqli->connect_errno)
        return;

    $cardName = strtolower($cardName);

    $stmt = $mysqli->prepare("INSERT INTO `hs_cache` (`name`, `url`) VALUES ((?), (?))");
    if (!$stmt->bind_param("ss", $cardName, $imgurl)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->execute();
    $stmt->close();
}

function get_hearthstone_card_from_api($cardName)
{
    $url = 'https://omgvamp-hearthstone-v1.p.mashape.com/cards/'.rawurlencode($cardName).'?collectible=1';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Mashape-Key: ZJCXImZlmomshm7KaKlcCOSn87ppp1yOu2djsnbHHw3vETav9O',
        'Accept: application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $resultJSON = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($resultJSON);
    if (is_array($result) && count($result) >= 1) {
        $imgURL = $result[0]->img;
    } else {
        $imgURL = 'http://media-hearth.cursecdn.com/avatars/128/199/7834.png';
    }
    return $imgURL;
}

?>