<html>
<?php

include 'strings.php';
include 'functions.php';

//Random generator seed
if (isset($_GET['id']))
{
	$seed = $_GET['id'];
}
else if (isset($_GET['iplock']))
{
	// ip-based seed
	$ip=str_replace('.', '', $_SERVER['REMOTE_ADDR']);
	$seed = $ip;
}
else
{
	$seed = mt_rand(1000000,9999999);
}
mt_srand($seed); 

// Generate colors
$c1 = 1;
$c2 = 2;
do {
	$c1 = mt_rand(1,5);
	$c2 = mt_rand(1,5);
}
while ($c1 == $c2);
$colors = fix(letter($c1).letter($c2));	

// Insane crazy mode
$insaneMode = false;
if( isset($_GET['insane']) )
{
	$insaneMode = true;
}

echo "<head>";

if (isset($_GET['set']))
{
	$_GET['set'] = addslashes($_GET['set']);
	echo "<title>Innistrad Spoiler</title>";
} else {
	echo "<title>Good Gamery's Dual Land Generator</title>";
}

echo "<link rel='stylesheet' href='stylesheet.css'>
	</head>
	<body style='margin: 0px;' link='7777EE' alink='7777EE' vlink='7777EE' ulink='7777EE'><center><p>";
	
echo "<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22619111-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";

echo "";

$name = $pre[$c1][mt_rand(0,count($pre[$c1])-1)]." ".$post[$c2][mt_rand(0,count($post[$c2])-1)];
$name = str_replace(' -', '-', $name);
$name = str_replace('- ', '-', $name);
$name = str_replace('--', '-', $name);

$artist = $firstname[mt_rand(0,count($firstname)-1)]." ".$lastname[mt_rand(0,count($lastname)-1)];

//Generate more realistic background image when in set mode
if (isset($_GET['set']) && $_GET['set'] == 'innistrad')
{
	echo("<table border='0' cellspacing='0' cellpadding='8' width='328' height='459' background='pics/bigframe.png'><tr><td valign='top'>");
}
else
{
	// Banner
	echo("<p style='width: 100%; padding: 1em; background-color: black;'>");
	echo("<a href='https://goodgamery.com/index.php/2011/04/14/exclusive-preview-of-dual-land-from-innistrad/'><img src='./pics/gglogo_big.png' /></a>");
	//echo("<a href='https://goodgamery.com/index.php/2011/04/14/exclusive-preview-of-dual-land-from-innistrad/'><img src='./pics/innistradbanner.jpg' /></a>");
	echo("</p>");
}

$basiclandtypes = mt_rand(0,1); // Type of land
//if ($basiclandtypes < 0) $basiclandtypes = 0;
$strangeland = 0;
if ($basiclandtypes == 0) {
	$strangeland = mt_rand(1,12);
}

echo "
<table border='0' cellspacing='0' cellpadding='0' width='312' height='443' background='pics/art/".$colors.mt_rand(1,5).".jpg'><tr><td valign='top'>\n
<table border='0' cellspacing='0' cellpadding='0' width='312' height='443' background='pics/detail/".getOverlay($c1, $seed).".png'><tr><td valign='top'>\n
<table border='0' bordercolor='#ff0000' cellspacing='0' cellpadding='0' width='312' height='443' background='pics/bg/".$colors.".png'><tr><td valign='top' width='312' height='22' colspan='3'></td></tr>\n
<tr><td width='22' height='*'></td><td width='269' height='403' valign='top'>\n
\n
<table border='0' bordercolor='#00ff00' cellspacing='0' cellpadding='0' width='269' height='403'>\n
	<tr><td valign='top' height='21'>";
	
//	<font size='4pt' face='Matrix Bold, Matrix, Helvetica, Arial'>".$name."</font>

echo(printer($name, false));

echo"</td></tr>
	<tr><td height='207'></td></tr>
	<tr><td height='20'>
	<table border='0' height='20' width='268'><tr><td width='*' valign='top'>";

//Render the type line
if ($strangeland == 1)
{
	echo("<img src='pics/font/artifact.png' alt='Artifact'><img src='pics/font/space.png' alt=' '>");
}
elseif ($strangeland == 2)
{
	echo("<img src='pics/font/enchantment.png' alt='Enchantment'><img src='pics/font/space.png' alt=' '>");
}

echo "<img src='pics/font/land.png' alt='Land'>";

if ($basiclandtypes == 1)
{
	echo("<img src='pics/font/space.png'><img src='pics/font/dash.png' alt='-'><img src='pics/font/space.png'>".basicfont(fix(letter($c1).letter($c2))));	
}

//Insert set icon
if (isset($_GET['set']))
{
	echo "</td><td width='25' valign='right'><img src='pics/set/".$_GET['set'].".png' align='right' alt=' (Rare)'></td></tr>";
	echo "<!--".mt_rand(1,13)."-->";	// Throw out this mt_rand value for the seed
} else {
	echo "</td><td width='25' valign='right'><img src='pics/set/set".mt_rand(1,13).".png' align='right' alt=' (Rare)'></td></tr>";
}
echo"</td></tr></table><tr><td height='130'><table height='110' border='0' cellspacing='0' cellpadding='1'><tr><td><font style='line-height:100%; font-size: 13px;' face='Times New Roman'>";

// Reminder paragraph
if ($basiclandtypes == 1)
{
	echo("<p class=\"ability\"><i>(<img src='pics/symbol/tap.png' alt='Tap'>: Add ".eithermana($c1,$c2)." to your mana pool.)</i></p>");
}
elseif ($strangeland < 3)
{
	echo("<p class=\"ability\"><i>(".$name." isn't a spell.)</i></p>");
}

// Set randomized color from the pair
$c = mt_rand(1, 2) == 1 ? $c1 : $c2;

// here goes the actual rules text generation
if ($basiclandtypes == 0)
{
	$isFetch = mt_rand(1,4) == 1;

	if ($strangeland == 1)
	{
		//Artifact land
		artifact_paragraph($name, $c);
		if ($isFetch)
			fetch_paragraph($name, $colors, $c1, $c2, true);
		else
			mana_paragraph($name, $c1, $c2, true);	
	}

	else if ($strangeland == 2)
	{
		//Enchantment land
		enchantment_paragraph($name, $c);
		if ($isFetch)
			fetch_paragraph($name, $colors, $c1, $c2, true);
		else
			mana_paragraph($name, $c1, $c2, true);		
	}
	else
	{
		// Regular land
		if( !$isFetch )
		{
			drawback_paragraph($name, $c);
		}
		
		if ($isFetch)
		{
			fetch_paragraph($name, $colors, $c1, $c2, false);
		}
		else
		{
			mana_paragraph($name, $c1, $c2, false);
		}
		
		random_paragraph($name, $c1, $c2);
	}
	
}
else {
	// Land with basic land types
	$randomizer = mt_rand(1,2);
	switch($randomizer) {
		case 1:
			drawback_paragraph($name, $c);
			random_paragraph($name, $c1, $c2);
			break;
		case 2:
			drawback_paragraph($name, $c);
			utility_paragraphs($c1, $c2, $name);
			break;
		default:
			drawback_paragraph($name, $c);
			random_paragraph($name, $c1, $c2);
			break;
	}
}

// Clean up the end of the rules text
echo "</font></td></tr></table></td></tr><tr><td height='20'><img src='pics/sfont/space.png' width='23' height='16'>";

// Floating logo
echo("<img style='position: absolute; margin-top: 6px; margin-left: 130px;' src='./pics/gglogo.png' />");

// Artist credits
if (isset($_GET['set']) && $_GET['set'] == 'innistrad')
{
	echo(printer($artist,true));
}
else
{
	echo(printer('Good Gamery',true));
}

// Clean up the end of the card

echo "</td></tr>

</table>
</td><td width='22' height='*'></td>
</tr><tr><td valign='top' width='312' height='' colspan='3'></td></tr></table>
</td></tr></table>
</td></tr></table>";

//iFrame-ready page without buttons and links ;D
if (isset($_GET['set']))
{
	echo("</tr></td></table></p>");
}
else
{
	// Break up the random chain with a new random seed
	mt_srand((double)(microtime() * 1000003));
	$seedNext = mt_rand(1000000,9999999);
	$sharelink = "https://goodgamery.com/cards/random/?id=".$seed.($insaneMode?"&insane":"");
	echo "</p><p><a href='index.php?id=".$seedNext."'><img src='pics/button.png' border='0' alt=''></a>&nbsp;
	<a href='index.php?id=".$seedNext."&insane'><img src='pics/button2.png' border='0' alt=''></a></p>
	<p>
		Share this card: <input id='share_link' type='text' name='link' value='$sharelink' size='55;' />
		<br /><a href='index.php?id=".$seed."&set=innistrad".($insaneMode?"&insane":"")."'>Go to Innistrad spoiler mode and fool your friends!</a>
	</p>
	<p><a href='https://goodgamery.com/'>GoodGamery.com</a></p>";
}
echo"</center>";
?>

</body>
</html>