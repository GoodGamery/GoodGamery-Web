<?php
include "functions.php";
$BANNER_URL_TEMPLATE = "samplebanner.php?title=%TITLE%";
$titleWord = getRandomWord();
$fullTitle = getFullTitle($titleWord);
$hash = generateHash($titleWord);
$bannerUrl = str_replace("%TITLE%", $titleWord, $BANNER_URL_TEMPLATE);
$banner = "<img src=\"$bannerUrl\">";
$bannerLink = "<h2>".getLink(str_replace("%HASH%", $hash, $FTV_LINK_TEMPLATE), $banner)."</h2>";
?>
<html><head><title><?php echo($fullTitle); ?></title></head><body><div align=center><?php echo($bannerLink); ?></div></body></html>