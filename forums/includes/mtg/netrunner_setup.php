<?php

require('./config.php');

//find card (executed from the generated posting via link)
if( isset($_GET['code']) )
{
    $code = $_GET['code'];
    if ($code == 'grakthis') {
        echo 'OK!';
        netrunner_setup();
    } else {
        echo 'Wrong code.';
    }
	//do not execute the rest of the code
	die();
}

/*
    CREATE TABLE IF NOT EXISTS `netrunner_cache` (
      `name` varchar(64) NOT NULL,
      `url` varchar(256) NOT NULL,
      PRIMARY KEY  (`name`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Netrunner Cards';
*/


function netrunner_setup()
{
    echo '<br>Setting up netrunner cards...';

    // Connect to DB
    $hostname = DB_HOST_MTG;
    $username = DB_USER_MTG;
    $dbname = DB_NAME_MTG;
    $password = DB_PASSWORD_MTG;

    $mysqli = null;
    $cardsJson = null;

    // Connecting to your database
    if (USE_NETRUNNER_CACHE) {
       echo '<br>Connecting to MySQL Database...';
        $mysqli = new mysqli($hostname, $username, $password, $dbname);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        } else {
            $cardsJson = get_netrunner_cards();
        }
    }

    if (USE_NETRUNNER_CACHE && $cardsJson) {
       echo '<br>Reading cards...';
        foreach ($cardsJson as &$card) {
            $imageUrl = 'http://netrunnerdb.com'.$card->imagesrc;
            store_netrunner_card_in_db($mysqli, $card->title, $imageUrl);
        }
    }

    echo '<br>Done!';

    if (USE_NETRUNNER_CACHE && $mysqli)
        $mysqli->close();
}


function store_netrunner_card_in_db(&$mysqli, &$cardName, &$imgUrl)
{
    if ($mysqli->connect_errno)
        return;

    $cardName = strtolower($cardName);

    $stmt = $mysqli->prepare('INSERT INTO `'.DB_TABLE_NETRUNNER.'` (`name`, `url`) VALUES ((?), (?))');
    if (!$stmt->bind_param("ss", $cardName, $imgUrl)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->execute();
    $stmt->close();
    echo "<br>Stored card $cardName $imgUrl";
}

function get_netrunner_cards()
{
    $url = NETRUNNER_API_ENDPOINT;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $resultJSON = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($resultJSON);
    return $result;
}

?>