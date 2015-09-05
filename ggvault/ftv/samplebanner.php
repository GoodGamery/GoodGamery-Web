<?php
include "functions.php";

$BANNER_WIDTH = 451;

$titleWord = mb_strtolower(htmlspecialchars($_GET["title"]));
$title =  mb_convert_case($titleWord, MB_CASE_TITLE, "UTF-8");
$hash = generateHash($titleWord);

$image = imagecreatefrompng("banner/ftv_banner.png");
$font = "banner/FreeSerifBold.ttf";
$font_size = 30;

$color = imagecolorallocate($image, 220,220,220);
$hilight = imagecolorallocate($image, 90,90,90);
$black = imagecolorallocate($image, 10,10,10);
imagecolortransparent($image, imagecolorallocate($image, 0,255,0));

$bounds = imagettfbbox($font_size, 0, $font, $title);
$xPos = ($BANNER_WIDTH - $bounds[2])/2;
$yPos = 74;

ImageTTFText ($image, $font_size, 0, $xPos, $yPos, $black, $font, $title);
ImageTTFText ($image, $font_size, 0, $xPos + 2, $yPos, $color, $font, $title);
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
