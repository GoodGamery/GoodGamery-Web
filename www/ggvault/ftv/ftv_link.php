<?php
include "functions.php";

$BANNER_URL_TEMPLATE = "samplebanner.php?title=%TITLE%";

$titleWord = getRandomWord();
$fullTitle = getFullTitle($titleWord);
$hash = generateHash($titleWord);

$bannerUrl = str_replace("%TITLE%", $titleWord, $BANNER_URL_TEMPLATE);

$banner = "<img src=\"$bannerUrl\">";
$bannerLink = "<h2>".getLink(str_replace("%HASH%", $hash, $FTV_LINK_TEMPLATE), $banner)."</h2>";

$smallBanner = "<img src=\"$bannerUrl\" width=\"226\" height=\"45\">";
$smallBannerLink = "<h2>".getLink(str_replace("%HASH%", $hash, $FTV_LINK_TEMPLATE), $smallBanner)."</h2>";
?>

<html>
<head>
<title>
<?php echo($fullTitle); ?>
</title>
<body bgcolor=black>
<div align=center>
<h2 style="color: white; font-family: sans-serif;">Introducing</h2>
<?php echo($bannerLink); ?>
<?php echo($smallBannerLink); ?>
</div>
</body></html>
