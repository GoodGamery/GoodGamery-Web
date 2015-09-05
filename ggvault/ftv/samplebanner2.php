<?php
include "functions.php";

$BANNER_WIDTH = 451;
$BANNER_HEIGHT = 90;

$titleWord = mb_strtolower(htmlspecialchars($_GET["title"]));
$title =  mb_convert_case($titleWord, MB_CASE_TITLE, "UTF-8");
$hash = generateHash($titleWord);

//$image = imagecreatefrompng("banner/ftv_banner.png");

$image=imagecreatetruecolor($BANNER_WIDTH,$BANNER_HEIGHT);
$srcimage=imagecreatefrompng("banner/ftv_banner.png");
imagecopyresampled($image,$srcimage,0,0,0,0, $BANNER_WIDTH,$BANNER_HEIGHT,$BANNER_WIDTH,$BANNER_HEIGHT);

$color = imagecolorallocate($image, 220,220,220);
$hilight = imagecolorallocate($image, 90,90,90);
$black = imagecolorallocate($image, 10,10,10);
$bg = imagecolorallocate($image, 0,0,0);

//imagecolortransparent($image, $bg);

$font = "banner/FreeSerifBold.ttf";
$font_size = 30;

$bounds = imagettfbbox($font_size, 0, $font, $title);
$xPos = ($BANNER_WIDTH - $bounds[2])/2;
$yPos = 74;

ImageTTFText ($image, $font_size, 0, $xPos, $yPos, $black, $font, $title);
ImageTTFText ($image, $font_size, 0, $xPos + 2, $yPos, $color, $font, $title);
header("Content-type: image/png");

imagealphablending($image, true); // setting alpha blending on
imagesavealpha($image, true); // save alphablending setting (important)
imagepng($image);
imagedestroy($image);
?>
