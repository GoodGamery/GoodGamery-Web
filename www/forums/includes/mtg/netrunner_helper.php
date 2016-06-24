<?php

/*
BBCODE:
[nr]{TEXT}[/nr]
<a href="/includes/mtg/netrunner_helper.php?find={TEXT}&width=225&height=314" class="jTip" name="Netrunner"  onclick='window.open("http://netrunnerdb.com/find/?q={TEXT}")' >{TEXT}</a>

[nr={SIMPLETEXT}]{TEXT}[/nr]
<a href="/includes/mtg/netrunner_helper.php?find={SIMPLETEXT}&width=225&height=314" class="jTip" name="Netrunner"  onclick='window.open("http://netrunnerdb.com/find/?q={SIMPLETEXT}")' >{TEXT}</a>
*/

require('./config.php');

//find card (executed from the generated posting via link)
if( isset($_GET['find']) )
{
	$card_url = get_netrunner_card_from_name($_GET['find']);
    if( isset($_GET['address']) )
    {
        echo $card_url;
    }
    else
    {
        echo "<img width='225px' src=\"$card_url\" />";
    }
	//do not execute the rest of the code
	die();
}


function get_netrunner_card_from_name(&$cardName)
{
    $imgUrl = "";

    // Connect to DB
    $hostname = DB_HOST_MTG;
    $username = DB_USER_MTG;
    $dbname = DB_NAME_MTG;
    $password = DB_PASSWORD_MTG;

    $mysqli = null;

    // Connecting to your database
    if (USE_NETRUNNER_CACHE) {
        $mysqli = new mysqli($hostname, $username, $password, $dbname);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        } else {
            $imgUrl = get_netrunner_card_from_db($mysqli, $cardName);
        }
    }

    // Failed
    if ($imgUrl == "") {
        $imgUrl = NETRUNNER_DEFAULT_IMAGE;
    }

    if (USE_NETRUNNER_CACHE && $mysqli)
        $mysqli->close();

    return $imgUrl;
}

function adjustName($input)
{
    $input = strtolower($input);
    $input = preg_replace("/['\"&]/u", "", $input);
    return $input;
}

function get_netrunner_card_from_db(&$mysqli, &$cardName)
{
    // if ($debug || true) { echo "<b>cardName: <pre>$cardName</pre></b>"; }
    $cardName = adjustName($cardName);
    // if ($debug || true) { echo "<b>adjusted cardName: <pre>$cardName</pre></b>"; }


    //Prepare statement to find cached card image
    $stmt = $mysqli->prepare('SELECT url FROM `'.DB_TABLE_NETRUNNER.'` WHERE name=(?)');
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

?>