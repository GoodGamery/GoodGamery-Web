<?php
include "functions.php";

$SECONDS_PER_DAY = 24 * 60 * 60;
$CARDS_PER_SET = 15;
$CARDS_PER_LINE = 2;

$invalidHash = false;
//Get the set name:
// 1) from the hash param, else 2) from the name param, else 3) randomly.
$setName = "";
$hexedParam = "";
if (isset($_GET["id"]))
  $hexedParam = mb_strtolower(htmlspecialchars($_GET["id"]));

if (strlen($hexedParam) > 0) {
   $unhexedParam = hex2bin($hexedParam);
   $decryptedParam =  decryptHash($unhexedParam);   
   $setName = $decryptedParam;
 
   if (!(scanDirectoryForString($WORDS_PATH, $setName))) {
      $invalidHash = TRUE;
   }
} else {
  $setName = "";
  if (isset($_GET["name"]))
    $setName = mb_strtolower(htmlspecialchars($_GET["name"]));
  if (strlen($setName) == 0) {     
    $setName = getRandomWord();
  }
  $newUrlHash = generateHash($setName);
header('Location: https://goodgamery.com/ggvault/ftv/?id=' . $newUrlHash);
}

if ($invalidHash) {
   $setTitle = $invalidHashTitle;
   $cardIds = $invalidHashCards;
} else {
   $setTitle = getFullTitle($setName);
   //get all possible card ids from file
   function strip_spaces(&$element) { $element = trim($element); }
   $all_card_ids = file($CARD_ID_FILE);
   array_walk($all_card_ids, 'strip_spaces');

   $hash = hashWord($setName);

   //generate list of card ids from the hash
   mt_srand($hash);
   for ($i = 1; $i <= $CARDS_PER_SET; $i++) {
      $cardIds[] =  $all_card_ids[mt_rand(0, sizeof($all_card_ids) - 1)];
   }
}

//select a random article template
$AUTHOR_DATA = array(array("Herman Bushneck", "article_files/article/bushneck.png", "./article_files/article/bushneck.txt"), 
                    array("Ethan Orange", "article_files/article/orange.png", "./article_files/article/orange.txt"), 
                    array("Brian David-Marshall", "article_files/article/marshall.png", "./article_files/article/marshall.txt"));
$authorIndex = mt_rand(0, count($AUTHOR_DATA) - 1);
$authorName = $AUTHOR_DATA[$authorIndex][0];
$authorPic = $AUTHOR_DATA[$authorIndex][1];
$textFile = $AUTHOR_DATA[$authorIndex][2];

$articleDate = date("F j, Y", (time() - mt_rand(0, 7) * $SECONDS_PER_DAY));
$releaseDate = date("F j", time() + (mt_rand(9, 25) * $SECONDS_PER_DAY));

//link to the next article
$titleWord = getRandomWord();
$randomHash = generateHash($titleWord);
$randomLink = str_replace("%HASH%", $randomHash, $FTV_LINK_TEMPLATE);
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
<link href="./article_files/css/site.css" type="text/css" rel="stylesheet">
<link href="./article_files/css/article.css" type="text/css" rel="stylesheet">
<link href="./article_files/css/styles.css" type="text/css" rel="stylesheet">
<?php
echo("<title>$setTitle</title>");
?>

<link href="http://www.wizards.com/Magic/Assets/favicon.ico" rel="shortcut icon">
</head>
<body>

<div id="container">
    <div id="glow">
        <div id="glowStatic">
	        <div id="wrap">

		        <div id="">


			        <h1 id="WizardsLogo">
				        <?php echo("<a href=\"$randomLink\" title=\"Click this link and you might get a treat.\">"); ?>
				            <img src="article_files/images/wotc_logo.png" alt="Wizards of the Coast">
				        </a>
			        </h1>

		        </div>
		        <div id="MasterMainContent">

	<div id="bannerGraphic">
	    <h2 id="MagicLogo">
         <?php echo("<a href=\"$randomLink\" title=\"Click to see more exciting products. Just keep clicking.\">"); ?>
	            <img src="article_files/images/magic_logo.gif" alt="Magic: The Gathering">
	        </a>
	    </h2>
	</div>

	<div id="wrapper">

		<div id="centerColumn">


    <div id="content">
        <div id="" class="article-top"><h3><img src="article_files/images/article_Arcana.gif" alt="Arcana"></h3></div>
<div class="center-content">
    <div id="">

        <div class="heading">
            <div class="description">
                <h4><?php echo($setTitle); ?></h4>
                <h5 class="byline"><?php echo($authorName) ?><br>
                <?php echo($articleDate) ?>
            </h5>
            </div>
            <div class="links">
                <ul  class="heading-links">

                    <li><img src="./article_files/images/icon_email.gif" alt="Email"></li>
                    <li><img src="./article_files/images/icon_boards.gif" alt="Boards"></li>
                    <li><img src="./article_files/images/icon_print.gif" alt="Print"></li>
                </ul>
                <div id="ctl00_ctl00_ContentPlaceHolder1_mainContent_Article_AuthorImageContainer" class="author-image">
                    <?php echo("<img src=\"" . $authorPic . "\" alt=\"Author Image\"/>"); ?>
                </div>
                <div id="ctl00_ctl00_ContentPlaceHolder1_mainContent_Article_archiveSection">
					<ul id="archive-links">
					    <li><a href="http://www.goodgamery.com/">Arcana Archive</a></li>
					    <li><a href="http://www.magiclampoon.com"><?php echo($authorName) ?> Archive</a></li>
					</ul>
                </div>
            </div>
	    </div>
	    <div class="article-content">
            <p>
  <img border="0" align="left" src="./article_files/images/dropcap_H.jpg" alt="The letter H!"/>
<?php
$articleText = trim(file_get_contents($textFile));
$articleText = str_replace("%SET_TITLE%", $setTitle, $articleText);
$articleText = str_replace("%RELEASE_DATE%", $releaseDate, $articleText);
$articleText = str_replace("%AUTHOR_NAME%", $authorName, $articleText);
echo($articleText);
?>
<div id="spoiler" align="center">
<?php
//print the card tags
$i = 0;
foreach ($cardIds as $id) {
   $card = getCardTag($id);
   echo(getCardLink($id, $card));
	if (++$i % $CARDS_PER_LINE == 0) {
		echo ("<br/>");
	}
}
?>
</div>

<br/>
<div align="center">
<?php echo("<a href='" . $randomLink . "'>Next Article >></a>"); ?>
</div><br/>
<div style="font-size:.9em;">
<table align="center" width=0><tr><td valign="bottom" align="center">&copy; 2011 <a href="http://www.goodgamery.com">goodgamery.com</a></td></tr>
<tr><td align="center">This is a joke. All intellectual claim to Magic: the Gathering belongs to Wizards of the Coast, as do all related web assets and designs. Thanks also to <a href="http://www.flickr.com/photos/mybluevan/">My Blue Van</a> and <a href="http://www.flickr.com/photos/jdurchen/">jdurchen</a> for the handsome photographs.</td></tr>
</table>


</div>
        </div>
</div>
</div>
	</div>
</div></div></div></div></div></div></form></body></html>
