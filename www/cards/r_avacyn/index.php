<html>
<style type="text/css">
table {
	display: inline-table;	
}
p { 
  margin-top: 2px;
  margin-bottom: 0px;
  margin-left: 3px;
  margin-right: 0px;
}
#transformpt {
	position: relative; top: 244px; left: -3px;
}
</style>
<?php

include "rules_functions.php";

function letter($input)
{
	$output = 'x';
	switch($input) {
		case 1:	$output = 'w'; break;
		case 2:	$output = 'u'; break;
		case 3:	$output = 'b'; break;
		case 4:	$output = 'r'; break;
		case 5:	$output = 'g'; break;
	}
	return $output;
}

function number2word($input)
{
	$output = 'colorless';
	switch($input) {
		case 1:	$output = 'white'; break;
		case 2:	$output = 'blue'; break;
		case 3:	$output = 'black'; break;
		case 4:	$output = 'red'; break;
		case 5:	$output = 'green'; break;
	}
//	echo "<p>Converting number ".$input." to color ".$output.".</p>";
	return $output;
}

function integer2word($input)
{
	$output = 'a';
	switch($input) {
		case 1:	$output = 'a'; break;
		case 2:	$output = 'two'; break;
		case 3:	$output = 'three'; break;
		case 4:	$output = 'four'; break;
		case 5:	$output = 'five'; break;
		case 6:	$output = 'six'; break;
		case 7:	$output = 'seven'; break;
		case 8:	$output = 'eight'; break;
		case 9:	$output = 'nine'; break;
		case 10:	$output = 'ten'; break;
		case 11:	$output = 'eleven'; break;
		case 12:	$output = 'twelve'; break;
		case 13:	$output = 'thirteen'; break;
		case 14:	$output = 'fourteen'; break;
		case 15:	$output = 'fifteen'; break;
		case 16:	$output = 'sixteen'; break;
		case 17:	$output = 'seventeen'; break;
		case 18:	$output = 'eighteen'; break;
		case 19:	$output = 'nineteen'; break;
	}
	return $output;
}

function word2number($input)
{
	$output = 0;
	switch($input) {
		case "white":	$output = 1; break;
		case "blue":	$output = 2; break;
		case "black":	$output = 3; break;
		case "red":	$output = 4; break;
		case "green":	$output = 5; break;
	}
	return $output;
}


// Prints rendered text in the Matrix font
function printer($title,$type,$inverted) {
	$result = "";
	if ($inverted) $inverted = "inverted/";
	else $inverted == "";
	if ($type == 'small') $height="height='16px'";
	else $height = "";
	if ($type == 'normal' || $type == 'small') $type = '';
	for ($i = 0; $i < strlen($title); $i++) {
		$k = substr($title,$i,1);
		if (ctype_upper($k)) $result = $result."<img src='pics/".$inverted.$type."font/c/".$k.".png' alt='".$k."' ".$height.">";
		else if ($k == ' ') $result = $result."<img src='pics/".$inverted.$type."font/space.png' alt=' '>";
		else if ($k == "'") $result = $result."<img src='pics/".$inverted.$type."font/apostrophe.png'>";
		else if ($k == '/') $result = $result."<img src='pics/".$inverted.$type."font/slash.png' alt='/' ".$height.">";	
		else if ($k == '-') $result = $result."<img src='pics/".$inverted.$type."font/shortdash.png' alt='-'>";		
		else if ($k == '.') $result = $result."<img src='pics/whitefont/dot.png' alt='-'>";		
		else $result = $result."<img src='pics/".$inverted.$type."font/s/".$k.".png' alt='".$k."' ".$height.">";	
	}
	return $result;
}

function manacost($string) {
	$string = str_replace("{x}","<img src='pics/symbol/manacostx.png'>",$string);
	$string = str_replace("{9}","<img src='pics/symbol/manacost9.png'>",$string);
	$string = str_replace("{8}","<img src='pics/symbol/manacost8.png'>",$string);
	$string = str_replace("{7}","<img src='pics/symbol/manacost7.png'>",$string);
	$string = str_replace("{6}","<img src='pics/symbol/manacost6.png'>",$string);
	$string = str_replace("{5}","<img src='pics/symbol/manacost5.png'>",$string);
	$string = str_replace("{4}","<img src='pics/symbol/manacost4.png'>",$string);
	$string = str_replace("{3}","<img src='pics/symbol/manacost3.png'>",$string);
	$string = str_replace("{2}","<img src='pics/symbol/manacost2.png'>",$string);
	$string = str_replace("{1}","<img src='pics/symbol/manacost1.png'>",$string);
	$string = str_replace("{0}","<img src='pics/symbol/manacost0.png'>",$string);
	$string = str_replace("{W}","<img src='pics/symbol/manacostw.png'>",$string);	
	$string = str_replace("{U}","<img src='pics/symbol/manacostu.png'>",$string);
	$string = str_replace("{B}","<img src='pics/symbol/manacostb.png'>",$string);
	$string = str_replace("{R}","<img src='pics/symbol/manacostr.png'>",$string);	
	$string = str_replace("{G}","<img src='pics/symbol/manacostg.png'>",$string);
	
	return $string;	
}

function parse($string,$fontsize) {
	if ($fontsize == 14) $tmp = " height='12'";
	else $tmp = ""; 
	$string = str_replace("{T}","<img src='pics/symbol/tap.png'".$tmp.">",$string);
	$string = str_replace("{t}","<img src='pics/symbol/tap.png'".$tmp.">",$string);
	$string = str_replace("{W}","<img src='pics/symbol/manaw.png'".$tmp.">",$string);
	$string = str_replace("{w}","<img src='pics/symbol/manaw.png'".$tmp.">",$string);
	$string = str_replace("{U}","<img src='pics/symbol/manau.png'".$tmp.">",$string);
	$string = str_replace("{u}","<img src='pics/symbol/manau.png'".$tmp.">",$string);
	$string = str_replace("{B}","<img src='pics/symbol/manab.png'".$tmp.">",$string);
	$string = str_replace("{b}","<img src='pics/symbol/manab.png'".$tmp.">",$string);
	$string = str_replace("{R}","<img src='pics/symbol/manar.png'".$tmp.">",$string);
	$string = str_replace("{r}","<img src='pics/symbol/manar.png'".$tmp.">",$string);
	$string = str_replace("{G}","<img src='pics/symbol/manag.png'".$tmp.">",$string);
	$string = str_replace("{g}","<img src='pics/symbol/manag.png'".$tmp.">",$string);
	$string = str_replace("{X}","<img src='pics/symbol/manax.png'".$tmp.">",$string);
	$string = str_replace("{x}","<img src='pics/symbol/manax.png'".$tmp.">",$string);
	$string = str_replace("{1}","<img src='pics/symbol/mana1.png'".$tmp.">",$string);
	$string = str_replace("{2}","<img src='pics/symbol/mana2.png'".$tmp.">",$string);
	$string = str_replace("{3}","<img src='pics/symbol/mana3.png'".$tmp.">",$string);
	$string = str_replace("{4}","<img src='pics/symbol/mana4.png'".$tmp.">",$string);
	$string = str_replace("{5}","<img src='pics/symbol/mana5.png'".$tmp.">",$string);
	$string = str_replace("{6}","<img src='pics/symbol/mana6.png'".$tmp.">",$string);
	return $string;	
}

//function cmc($manacost) {
//  return count($manacost)/3;	
//}

function one_letter_color($color) {
	if ($color == "white") return "W";
	elseif ($color == "blue") return "U";
	elseif ($color == "black") return "B";
	elseif ($color == "red") return "R";
	elseif ($color == "green") return "G";
}

function generate_manacost($color,$cmc) {
//	echo "<p>Generating CMC=".$cmc." manacost for color: ".$color."</p>";
  $tmp = "";
	if ($cmc > 1) {
		$cc = mt_rand(1,2);
	  for ($a = 0; $a < $cc; $a = $a + 1) {
 	    $tmp = $tmp."{".one_letter_color($color)."}";
	  }
  	if ($cmc > $cc) {
		  $tmp = "{".($cmc-$cc)."}".$tmp;
	  }
	}
	else {
		$tmp = "{".one_letter_color($color)."}";
	}
	return $tmp;
}

function cmc($manacost) {
 $ret = 0;
 for ($i = 0; $i < strlen($manacost); $i = $i + 3) {
 	$letter = substr($manacost,$i+1,1);
 	if ($letter == "W" || $letter == "U" || $letter == "B" || $letter == "R" || $letter == "G")
 	 $ret = $ret + 1.25;
 	else
 	 $ret = $ret + $letter;
 }
 //echo "<p>Returning weighted mana cost: ".$ret."</p>";
 return $ret;
}

function spell_name($color) {
  return "A spell in ".$color;	
}

function random_name($color,$type) {
	if ($type == "artifact") {
 		switch(mt_rand(1,19)) {				
		  case 1 : $first = "Blazing"; break;
		  case 2 : $first = "Butcher's"; break;
		  case 3 : $first = "Cellar"; break;
		  case 4 : $first = "Cobbled"; break;
		  case 5 : $first = "Creepy"; break;
		  case 6 : $first = "Demonmail"; break;			
		  case 7 : $first = "Galvanic"; break;
		  case 8 : $first = "Geistcatcher's"; break;
		  case 9 : $first = "Ghoulcaller's"; break;
		  case 10 : $first = "Graveyard"; break;			
		  case 11 : $first = "Grimoire"; break;			
		  case 12 : $first = "Inquisitor's"; break;
		  case 13 : $first = "Avacyn's"; break;
		  case 14 : $first = "Traveler's"; break;
		  case 15 : $first = "Trepanation"; break;
		  case 16 : $first = "Witchbane"; break;
		  case 17 : $first = "Grafdigger's"; break;
		  case 18 : $first = "Wooden"; break;
		  case 19 : $first = "Supersized"; break;
 		}
 		switch(mt_rand(1,19)) {				
		  case 1 : $last= "Torch"; break;
		  case 2 : $last = "Cleaver"; break;
		  case 3 : $last = "Door"; break;
		  case 4 : $last = "Wings"; break;
		  case 5 : $last = "Doll"; break;
		  case 6 : $last = "Hauberk"; break;			
		  case 7 : $last= "Bell"; break;
		  case 8 : $last = "Shovel"; break;
		  case 9 : $last = "Flail"; break;
		  case 10 : $last = "Mask"; break;
		  case 11 : $last = "Dagger"; break;
		  case 12 : $last = "Amulet"; break;			
		  case 13 : $last= "Pike"; break;
		  case 14 : $last = "Orb"; break;
		  case 15 : $last = "Blade"; break;
		  case 16 : $last = "Cage"; break;
		  case 17 : $last = "Stone"; break;
		  case 18 : $last = "Stake"; break;			
		  case 19 : $last = "Plant"; break;

 		}
	}
	elseif ($type == "land") {
 		switch(mt_rand(1,16)) {				
		  case 1 : $first = "Clifftop"; break;
		  case 2 : $first = "Gavony"; break;
		  case 3 : $first = "Ghost"; break;
		  case 4 : $first = "Hinterland"; break;
		  case 5 : $first = "Isolated"; break;
		  case 6 : $first = "Kessig"; break;			
		  case 7 : $first = "Moorland"; break;
		  case 8 : $first = "Nephalia"; break;
		  case 9 : $first = "Shimmering"; break;
		  case 10 : $first = "Stensia"; break;			
		  case 11 : $first = "Sulfur"; break;			
		  case 12 : $first = "Woodland"; break;
		  case 13 : $first = "Evolving"; break;
		  case 14 : $first = "Grim"; break;
		  case 15 : $first = "Haunted"; break;
		  case 16 : $first = "Archangel's"; break;
 		}
 		 switch(mt_rand(1,16)) {				
		  case 1 : $last= "Retreat"; break;
		  case 2 : $last = "Township"; break;
		  case 3 : $last = "Quarter"; break;
		  case 4 : $last = "Harbor"; break;
		  case 5 : $last = "Chapel"; break;
		  case 6 : $last = "Wolf Run"; break;			
		  case 7 : $last= "Haunt"; break;
		  case 8 : $last = "Drownyard"; break;
		  case 9 : $last = "Grotto"; break;
		  case 10 : $last = "Bloodhall"; break;
		  case 11 : $last = "Falls"; break;
		  case 12 : $last = "Cementary"; break;			
		  case 13 : $last= "Wilds"; break;
		  case 14 : $last = "Backwoods"; break;
		  case 15 : $last = "Fengraf"; break;
		  case 16 : $last = "Vault"; break;
 		}
	}
	if ($type != "creature") { // Spell
  	if ($color == "white") {
  		switch(mt_rand(1,21)) {				
			  case 1 : $first = "Bonds of"; break;
			  case 2 : $first = "Archangel's"; break;
			  case 3 : $first = "Bar the"; break;
			  case 4 : $first = "Break of"; break;
			  case 5 : $first = "Burden of"; break;
			  case 6 : $first = "Divinity of"; break;
			  case 7 : $first = "Faith's"; break;
			  case 8 : $first = "Feeling of"; break;
			  case 9 : $first = "Gather the"; break;
			  case 10 : $first = "Increasing"; break;
			  case 11 : $first = "Lingering"; break;
			  case 12 : $first = "Midnight of"; break;
			  case 13 : $first = "Moment of"; break;
			  case 14 : $first = "Ray of"; break;
			  case 15 : $first = "Rebuke of"; break;
			  case 16 : $first = "Seance of"; break;
			  case 17 : $first = "Skillful"; break;
			  case 18 : $first = "Smite"; break;
			  case 19 : $first = "Spare from"; break;
			  case 20 : $first = "Sudden"; break;
			  case 21 : $first = "Moonsilver"; break;
  		}
			switch(mt_rand(1,20)) {
			  case 1 : $last = "Day"; break;
			  case 2 : $last = "Devotion"; break;
			  case 3 : $last = "Disappearance"; break;
			  case 4 : $last = "Door"; break;
			  case 5 : $last = "Dread"; break;
			  case 6 : $last = "Evil"; break;
			  case 7 : $last = "Exorcism"; break; 
			  case 8 : $last = "Faith"; break;
			  case 9 : $last = "Grave"; break;
			  case 10 : $last = "Guilt"; break;
			  case 11 : $last = "Light"; break;
			  case 12 : $last = "Lunge"; break;
			  case 13 : $last = "Reckoning"; break;
			  case 14 : $last = "Revelation"; break;
			  case 15 : $last = "Seance"; break;
			  case 16 : $last = "Shield"; break;
			  case 17 : $last = "Souls"; break;
			  case 18 : $last = "Townsfolk"; break;
			  case 19 : $last = "Virtue"; break;
			  case 20 : $first = "Paladin"; break;
  		} 
  	}				
  	elseif ($color == "blue") {
  		switch(mt_rand(1,1)) {				
				case 1 : $first = "Back from the"; break; 
				case 2 : $first = "Artful"; break; 
				case 3 : $first = "Bone to"; break; 
				case 4 : $first = "Call to the"; break; 
				case 5 : $first = "Chill of"; break; 
				case 6 : $first = "Claustrophobic"; break; 
				case 7 : $first = "Curiosity of"; break; 
				case 8 : $first = "Diviniation of"; break; 
				case 9 : $first = "Dream"; break; 
				case 10 : $first = "Dungeon"; break; 
				case 11 : $first = "Forbidden"; break; 
				case 12 : $first = "Frightful"; break; 
				case 13 : $first = "Grasp of"; break; 
				case 14 : $first = "Grip of the"; break; 
				case 15 : $first = "Hysterical"; break; 
				case 16 : $first = "Increasing"; break; 
				case 17 : $first = "Lost in the"; break; 
				case 18 : $first = "Memory's"; break; 
				case 19 : $first = "Murder of"; break; 
				case 20 : $first = "Mystic"; break; 
				case 21 : $first = "Runic"; break; 
				case 22 : $first = "Saving"; break; 
				case 23 : $first = "Secrets of the"; break; 
				case 24 : $first = "Sense the"; break; 
				case 25 : $first = "Silent"; break; 
				case 26 : $first = "Thinking"; break; 
				case 27 : $first = "Though"; break;
			  case 21 : $first = "Moonsilver"; break;
  		}
  		switch(mt_rand(1,24)) {				
				case 1 : $last = "Alchemy"; break; 
				case 2 : $last = "Ash"; break; 
				case 3 : $last = "Blindness"; break; 
				case 4 : $last = "Bloody Tome"; break; 
				case 5 : $last = "Brink"; break; 
				case 6 : $last = "Confusion"; break; 
				case 7 : $last = "Curiosity"; break; 
				case 8 : $last = "Dead"; break; 
				case 9 : $last = "Deprivation"; break; 
				case 10 : $last = "Divination"; break; 
				case 11 : $last = "Dodge"; break; 
				case 12 : $last = "Echoes"; break; 
				case 13 : $last = "Foreboding"; break; 
				case 14 : $last = "Grasp"; break; 
				case 15 : $last = "Journey"; break; 
				case 16 : $last = "Kindred"; break; 
				case 17 : $last = "Mist"; break; 
				case 18 : $last = "Repetition"; break; 
				case 19 : $last = "Retrieval"; break; 
				case 20 : $last = "Scour"; break; 
				case 21 : $last = "Secrets"; break; 
				case 22 : $last = "Tide"; break; 
				case 23 : $last = "Twice"; break; 
				case 24 : $last = "Twist"; break; 
  		} 
  	}				
  	elseif ($color == "black") {
  		switch(mt_rand(1,22)) {				
				case 1 : $first = "Altar's"; break; 
				case 2 : $first = "Bump in the"; break; 
				case 3 : $first = "Dead"; break; 
				case 4 : $first = "Deadly"; break; 
				case 5 : $first = "Death's"; break; 
				case 6 : $first = "Ghoulcaller's"; break; 
				case 7 : $first = "Gruesome"; break; 
				case 8 : $first = "Gruesome"; break; 
				case 9 : $first = "Harrowing"; break; 
				case 10 : $first = "Heartless"; break; 
				case 11 : $first = "Increasing"; break; 
				case 12 : $first = "Maw of the"; break; 
				case 13 : $first = "Mire"; break; 
				case 14 : $first = "Purge the"; break; 
				case 15 : $first = "Reap the"; break; 
				case 16 : $first = "Tragic"; break; 
				case 17 : $first = "Tribute to"; break; 
				case 18 : $first = "Unburial"; break; 
				case 19 : $first = "Undying"; break; 
				case 20 : $first = "Unhallowed"; break; 
				case 21 : $first = "Victim of the"; break; 
				case 22 : $first = "Zombie"; break;
			  case 23 : $first = "Silverblade"; break;
  		}
			switch(mt_rand(1,19)) {				
				case 1 : $last = "Allure"; break; 
				case 2 : $last = "Ambition"; break; 
				case 3 : $last = "Apocalypse"; break; 
				case 4 : $last = "Caress"; break; 
				case 5 : $last = "Chant"; break; 
				case 6 : $last = "Deformity"; break; 
				case 7 : $last = "Discovery"; break; 
				case 8 : $last = "Evil"; break; 
				case 9 : $last = "Grave"; break; 
				case 10 : $last = "Hunger"; break; 
				case 11 : $last = "Journey"; break; 
				case 12 : $last = "Mire"; break; 
				case 13 : $last = "Night"; break; 
				case 14 : $last = "Reap"; break; 
				case 15 : $last = "Rites"; break; 
				case 16 : $last = "Seagraf"; break; 
				case 17 : $last = "Slip"; break; 
				case 18 : $last = "Summoning"; break;
			  case 19 : $first = "Paladin"; break; 
  		}
  	}				
  	elseif ($color == "red") {
  		switch(mt_rand(1,23)) {				
				case 1 : $first = "Ancient"; break; 
				case 2 : $first = "Alpha"; break; 
				case 3 : $first = "Blasphemous"; break; 
				case 4 : $first = "Blood"; break; 
				case 5 : $first = "Brimstone"; break; 
				case 6 : $first = "Burning"; break; 
				case 7 : $first = "Burning"; break; 
				case 8 : $first = "Desperate"; break; 
				case 9 : $first = "Devil's"; break; 
				case 10 : $first = "Faithless"; break; 
				case 11 : $first = "Fires of"; break; 
				case 12 : $first = "Furor of the"; break; 
				case 13 : $first = "Harvest"; break; 
				case 14 : $first = "Increasing"; break; 
				case 15 : $first = "Infernal"; break; 
				case 16 : $first = "Into the"; break; 
				case 17 : $first = "Past in"; break; 
				case 18 : $first = "Rolling"; break; 
				case 19 : $first = "Scorch the"; break; 
				case 20 : $first = "Shattered"; break; 
				case 21 : $first = "Traitorous"; break; 
				case 22 : $first = "Vampiric"; break; 
				case 23 : $first = "Wrack with"; break;
  		}
  		switch(mt_rand(1,24)) {				
				case 1 : $last = "Act"; break; 
				case 2 : $last = "Bitten"; break; 
				case 3 : $last = "Blood"; break; 
				case 4 : $last = "Bloodletting"; break; 
				case 5 : $last = "Brawl"; break; 
				case 6 : $last = "Clutches"; break; 
				case 7 : $last = "Feud"; break; 
				case 8 : $last = "Fields"; break; 
				case 9 : $last = "Fury"; break; 
				case 10 : $last = "Grudge"; break; 
				case 11 : $last = "Looting"; break; 
				case 12 : $last = "Madness"; break; 
				case 13 : $last = "Maw of Hell"; break; 
				case 14 : $last = "Oil"; break; 
				case 15 : $last = "Perception"; break; 
				case 16 : $last = "Play"; break; 
				case 17 : $last = "Plunge"; break; 
				case 18 : $last = "Punishment"; break; 
				case 19 : $last = "Pyre"; break; 
				case 20 : $last = "Ravings"; break; 
				case 21 : $last = "Undeath"; break; 
				case 22 : $last = "Vengeance"; break; 
				case 23 : $last = "Vengeance"; break; 
				case 24 : $last = "Volley"; break; 
  		}
  	}				
  	elseif ($color == "green") {
  		switch(mt_rand(1,20)) {				
				case 1 : $first = "Bramble"; break; 
				case 2 : $first = "Clinging"; break; 
				case 3 : $first = "Creeping"; break; 
				case 4 : $first = "Crushing"; break; 
				case 5 : $first = "Essence of the"; break; 
				case 6 : $first = "Favor of the"; break; 
				case 7 : $first = "Feed the"; break; 
				case 8 : $first = "Full Moon's"; break; 
				case 9 : $first = "Gnaw to the"; break; 
				case 10 : $first = "Hunger of the"; break; 
				case 11 : $first = "Increasing"; break; 
				case 12 : $first = "Lost in the"; break; 
				case 13 : $first = "Make a"; break; 
				case 14 : $first = "Moon's"; break; 
				case 15 : $first = "Mulch"; break; 
				case 16 : $first = "Ranger's"; break; 
				case 17 : $first = "Spidery"; break; 
				case 18 : $first = "Tracker's"; break; 
				case 19 : $first = "Wild"; break; 
				case 20 : $first = "Wreath of"; break; 
  		}
  		switch(mt_rand(1,20)) {				
				case 1 : $last = "Bone"; break; 
				case 2 : $last = "Catch"; break; 
				case 3 : $last = "Crush"; break; 
				case 4 : $last = "Geists"; break; 
				case 5 : $last = "Grasp"; break; 
				case 6 : $last = "Guile"; break; 
				case 7 : $last = "Howlpack"; break; 
				case 8 : $last = "Hunger"; break; 
				case 9 : $last = "Instincts"; break; 
				case 10 : $last = "Mist"; break; 
				case 11 : $last = "Mists"; break; 
				case 12 : $last = "Pack"; break; 
				case 13 : $last = "Preparations"; break; 
				case 14 : $last = "Rise"; break; 
				case 15 : $last = "Savagery"; break; 
				case 16 : $last = "Vines"; break; 
				case 17 : $last = "Wild"; break; 
				case 18 : $last = "Wish"; break; 
				case 19 : $last = "Woods"; break; 
				case 20 : $last = "Woods"; break; 
  		}
  	} 
  }				
	else { //Creature
	  if ($color == "white") {
	  	switch(mt_rand(1,28)) {
		  	case 1 : $first = "Abbey"; break;	
		  	case 2 : $first = "Angel"; break;	
		  	case 3 : $first = "Angelic"; break;	
		  	case 4 : $first = "Champion of the"; break;	
		  	case 5 : $first = "Chapel"; break;	
		  	case 6 : $first = "Cloistered"; break;	
		  	case 7 : $first = "Elder"; break;	
		  	case 8 : $first = "Elguad"; break;	
		  	case 9 : $first = "Elite"; break;	
		  	case 10 : $first = "Gavony"; break;	
		  	case 11 : $first = "Geist-Honored"; break;	
		  	case 12 : $first = "Hollowhenge"; break;	
		  	case 13 : $first = "Loyal"; break;	
		  	case 14 : $first = "Mausoleum"; break;	
		  	case 15 : $first = "Mentor of the"; break;	
		  	case 16 : $first = "Midnight"; break;	
		  	case 17 : $first = "Niblis of the"; break;	
		   	case 18 : $first = "Requiem"; break;	
		  	case 19 : $first = "Sanctuary"; break;	
		  	case 20 : $first = "Selfless"; break;	
		  	case 21 : $first = "Silverchase"; break;	
		  	case 22 : $first = "Silverclaw"; break;	
		  	case 23 : $first = "Thraben"; break;	
		  	case 24 : $first = "Thraben"; break;	
		  	case 25 : $first = "Thraben"; break;	
		  	case 26 : $first = "Unruly"; break;	
		  	case 27 : $first = "Village"; break;	
		  	case 28 : $first = "Voiceless"; break;	
		  }				
	  	switch(mt_rand(1,29)) {				
		  	case 1 : $last = "Angel"; break;	
	  		case 2 : $last = "Bell-Ringer"; break;	
		  	case 3 : $last = "Cat"; break;	
		  	case 4 : $last = "Cathar"; break;	
		  	case 5 : $last = "Cathar"; break;	
		  	case 6 : $last = "Doomsayer"; break;	
		  	case 7 : $last = "Geist"; break;	
		  	case 8 : $last = "Griffin"; break;	
		  	case 9 : $last = "Griffin"; break;	
		  	case 10 : $last = "Guard"; break;	
		  	case 11 : $last = "Guard"; break;	
		  	case 12 : $last = "Guardian"; break;	
		  	case 13 : $last = "Heretic"; break;	
		  	case 14 : $last = "Inquisitor"; break;	
		  	case 15 : $last = "Ironwright"; break;	
		  	case 16 : $last = "Mist"; break;	
		  	case 17 : $last = "Mob"; break;	
		  	case 18 : $last = "Monk"; break;	
		  	case 19 : $last = "of the Meek"; break;	
		  	case 20 : $last = "Peasant"; break;	
		  	case 21 : $last = "Priest"; break;	
		  	case 22 : $last = "Purebloods"; break;	
		  	case 23 : $last = "Rider"; break;	
		  	case 24 : $last = "Sentry"; break;	
		  	case 25 : $last = "Spirit"; break;	
		  	case 26 : $last = "Spirit"; break;	
		  	case 27 : $last = "Traveller"; break;	
		  	case 28 : $last = "Urn"; break;	
		  	case 29 : $last = "Youth"; break;	
	  	}				
	  }					
	  elseif ($color == "blue") {					
	  	switch(mt_rand(1,16)) {				
		  	case 1 : $first = "Battleground"; break;	
		  	case 2 : $first = "Cackling"; break;	
		  	case 3 : $first = "Civilized"; break;	
		  	case 4 : $first = "Delver of"; break;	
		  	case 5 : $first = "Deranged"; break;	
		  	case 6 : $first = "Fortress"; break;	
		  	case 7 : $first = "Frightful"; break;	
		  	case 8 : $first = "Invisible"; break;	
		  	case 9 : $first = "Laboratory"; break;	
		  	case 10 : $first = "Lantern"; break;	
		  	case 11 : $first = "Mirror-Mad"; break;	
		  	case 12 : $first = "Selhoff"; break;	
		  	case 13 : $first = "Skaab"; break;	
		  	case 14 : $first = "Snapcaster"; break;	
		  	case 15 : $first = "Stitched"; break;	
		  	case 16 : $first = "Undead"; break;	
		  }				
	  	switch(mt_rand(1,12)) {				
		  	case 1 : $last = "Geist"; break;	
		  	case 2 : $last = "Counterpart"; break;	
		  	case 3 : $last = "Scholar"; break;	
		  	case 4 : $last = "Assistant"; break;	
		  	case 5 : $last = "Delusion"; break;	
		  	case 6 : $last = "Phantom"; break;	
		  	case 7 : $last = "Stalker"; break;	
		  	case 8 : $last = "Maniac"; break;	
		  	case 9 : $last = "Spirit"; break;	
		  	case 10 : $last = "Mauler"; break;	
		  	case 11 : $last = "Mage"; break;	
		  	case 12 : $last = "Alchemist"; break;	
	  	}				
	  }					
	  elseif ($color == "black") {					
	  	switch(mt_rand(1,41)) {				
		  	case 1 : $first = "Abattoir"; break;	
		   	case 2 : $first = "Beguiler"; break;	
		  	case 3 : $first = "Bitterheart"; break;	
				case 4 : $first = "Black"; break;	
		  	case 5 : $first = "Brain"; break;	
		   	case 6 : $first = "Chosen"; break;	
		   	case 7 : $first = "Crawler"; break;	
		  	case 8 : $first = "Diregraf"; break;	
		  	case 9 : $first = "Disciple"; break;	
		  	case 10 : $first = "Falkenrath"; break;	
		   	case 11 : $first = "Falkenrath"; break;	
		   	case 12 : $first = "Farbog"; break;	
		   	case 13 : $first = "Fiend"; break;	
		   	case 14 : $first = "Geralf's"; break;	
		   	case 15 : $first = "Geralf's"; break;	
		  	case 16 : $first = "Ghoul"; break;	
		   	case 17 : $first = "Havengul"; break;	
		   	case 18 : $first = "Headless"; break;	
		   	case 19 : $first = "Highborn"; break;	
		  	case 20 : $first = "Manor"; break;	
		  	case 21 : $first = "Markov"; break;	
		  	case 22 : $first = "Mirror-Mad"; break;	
		  	case 23 : $first = "Morkrut"; break;	
		   	case 24 : $first = "Nephalia"; break;	
		   	case 25 : $first = "Niblis of the"; break;	
		   	case 26 : $first = "Ravenous"; break;	
		   	case 27 : $first = "Relentless"; break;	
		  	case 28 : $first = "Screeching"; break;	
		  	case 29 : $first = "Screeching"; break;	
		   	case 30 : $first = "Shaman"; break;	
		   	case 31 : $first = "Sightless"; break;	
		  	case 32 : $first = "Skirsdag"; break;	
		   	case 33 : $first = "Skirsdag"; break;	
		   	case 34 : $first = "Soul"; break;	
		   	case 35 : $first = "Stormbound"; break;	
		  	case 36 : $first = "Stromkirk"; break;	
		   	case 37 : $first = "Tower"; break;	
		  	case 38 : $first = "Typhold"; break;	
		   	case 39 : $first = "Vengeful"; break;	
		  	case 40 : $first = "Village"; break;	
		  	case 41 : $first = "Walking"; break;	
	  	}				
	  	switch(mt_rand(1,36)) {				
		  	case 1 : $last = "Boneflinger"; break;	
		  	case 2 : $last = "Breath"; break;	
		  	case 3 : $last = "Cannibals"; break;	
		  	case 4 : $last = "Cat"; break;	
		  	case 5 : $last = "Corpse"; break;	
		  	case 6 : $last = "Dancer"; break;	
		  	case 7 : $last = "Demon"; break;	
		  	case 8 : $last = "Demon"; break;	
		  	case 9 : $last = "Flayer"; break;	
		  	case 10 : $last = "Geist"; break;	
		  	case 11 : $last = "Ghoul"; break;	
		  	case 12 : $last = "Ghoul"; break;	
		  	case 13 : $last = "Ghoul"; break;	
		  	case 14 : $last = "High Priest"; break;	
		  	case 15 : $last = "Interloper"; break;	
		  	case 16 : $last = "Keeper"; break;	
		  	case 17 : $last = "Messenger"; break;	
		  	case 18 : $last = "Mindcrusher"; break;	
		  	case 19 : $last = "Noble"; break;	
		  	case 20 : $last = "of Griselbrand"; break;	
		  	case 21 : $last = "of Markov"; break;	
		  	case 22 : $last = "of the Grave"; break;	
		  	case 23 : $last = "of the Shadows"; break;	
		  	case 24 : $last = "of Wills"; break;	
		  	case 25 : $last = "Patrician"; break;	
		   	case 26 : $last = "Patrol"; break;	
		  	case 27 : $last = "Runebinder"; break;	
		  	case 28 : $last = "Seakite"; break;	
		  	case 29 : $last = "Seizer"; break;	
		  	case 30 : $last = "Skaab"; break;	
		  	case 31 : $last = "Skaabs"; break;	
		  	case 32 : $last = "Skeleton"; break;	
		  	case 33 : $last = "Torturer"; break;	
		  	case 34 : $last = "Vampire"; break;	
		  	case 35 : $last = "Weevil"; break;	
		  	case 36 : $last = "Witch"; break;	
	  	}				
	  }					
	  elseif ($color == "red") {					
	  	switch(mt_rand(1,32)) {				
		  	case 1 : $first = "Ashmouth"; break;	
		   	case 2 : $first = "Afflicted"; break;	
		  	case 3 : $first = "Balefire"; break;	
		  	case 4 : $first = "Bloodcrazed"; break;	
		  	case 5 : $first = "Charmbreaker"; break;	
		  	case 6 : $first = "Crossway"; break;	
		   	case 7 : $first = "Erdwal"; break;	
		  	case 8 : $first = "Falkenrath"; break;	
		  	case 9 : $first = "Feral"; break;	
		   	case 10 : $first = "Flayer"; break;	
		   	case 11 : $first = "Forge"; break;	
		  	case 12 : $first = "Hanweir"; break;	
		   	case 13 : $first = "Heckling"; break;	
		   	case 14 : $first = "Hinterland"; break;	
		  	case 15 : $first = "Instigator"; break;	
		  	case 16 : $first = "Kruin"; break;	
		   	case 17 : $first = "Markov"; break;	
		   	case 18 : $first = "Markov"; break;	
		   	case 19 : $first = "Mondronen"; break;	
		   	case 20 : $first = "Moonveil"; break;	
		   	case 21 : $first = "Nearheath"; break;	
		  	case 22 : $first = "Night"; break;	
		  	case 23 : $first = "Pitchburn"; break;	
		   	case 24 : $first = "Pyreheart"; break;	
		  	case 25 : $first = "Rage"; break;	
		  	case 26 : $first = "Rakish"; break;	
		   	case 27 : $first = "Rider"; break;	
		  	case 28 : $first = "Riot"; break;	
		   	case 29 : $first = "Russet"; break;	
		  	case 30 : $first = "Stromkirk"; break;	
		  	case 31 : $first = "Tormented"; break;	
		  	case 32 : $first = "Village"; break;	
	  	}				
		  switch(mt_rand(1,28)) {				
		   	case 1 : $last = "Blademaster"; break;	
		  	case 2 : $last = "Corpse"; break;	
		  	case 3 : $last = "Cultist"; break;	
		   	case 4 : $last = "Deserter"; break;	
		  	case 5 : $last = "Devil"; break;	
		   	case 6 : $last = "Devil"; break;	
		  	case 7 : $last = "Dragon"; break;	
		   	case 8 : $last = "Dragon"; break;	
		   	case 9 : $last = "Fiends"; break;	
		  	case 10 : $last = "Gang"; break;	
		   	case 11 : $last = "Hermit"; break;	
		  	case 12 : $last = "Hound"; break;	
		  	case 13 : $last = "Hound"; break;	
		  	case 14 : $last = "Marauders"; break;	
		   	case 15 : $last = "of Hell"; break;	
		   	case 16 : $last = "of the Hatebound"; break;	
		  	case 17 : $last = "Outlaw"; break;	
		   	case 18 : $last = "Patrol"; break;	
		  	case 19 : $last = "Ridgewolf"; break;	
		   	case 20 : $last = "Ripper"; break;	
		   	case 21 : $last = "Shaman"; break;	
		   	case 22 : $last = "Stalker"; break;	
		  	case 23 : $last = "Thrower"; break;	
		  	case 24 : $last = "Walf"; break;	
		   	case 25 : $last = "Warlord"; break;	
		  	case 26 : $last = "Wolf"; break;	
		   	case 27 : $last = "Wolf"; break;	
		   	case 28 : $last = "Wolves"; break;	
		  }				
	  }					
	  elseif ($color == "green") {					
	  	switch(mt_rand(1,36)) {				
				case 1 : $first = "Ambush"; break;
				case 2 : $first = "Avacyn's"; break;
				case 3 : $first = "Boneyard"; break;
				case 4 : $first = "Briarpack"; break;
				case 5 : $first = "Caravan"; break;
				case 6 : $first = "Darkthicket"; break;
				case 7 : $first = "Dawntreader"; break;
				case 8 : $first = "Daybreak"; break;
				case 9 : $first = "Deranged"; break;
				case 10 : $first = "Elder"; break;
				case 11 : $first = "Festerhide"; break;
				case 12 : $first = "Gatstaf"; break;
				case 13 : $first = "Ghoul"; break;
				case 14 : $first = "Grave"; break;
				case 15 : $first = "Gravetiller"; break;
				case 16 : $first = "Grizzled"; break;
				case 17 : $first = "Hamlet"; break;
				case 18 : $first = "Hollowhenge"; break;
				case 19 : $first = "Hollowhenge"; break;
				case 20 : $first = "Kessig"; break;
				case 21 : $first = "Lambholt"; break;
				case 22 : $first = "Mayor of"; break;
				case 23 : $first = "Moldgraf"; break;
				case 24 : $first = "Predator"; break;
				case 25 : $first = "Scorned"; break;
				case 26 : $first = "Somberwald"; break;
				case 27 : $first = "Somberwald"; break;
				case 28 : $first = "Spidery"; break;
				case 29 : $first = "Strangleroot"; break;
				case 30 : $first = "Ulvenwald"; break;
				case 31 : $first = "Ulvenwald"; break;
				case 32 : $first = "Village"; break;
				case 33 : $first = "Villager of"; break;
				case 34 : $first = "Wolfbitten"; break;
				case 35 : $first = "Woodland"; break;
				case 36 : $first = "Young"; break;
	  	}				
	  	switch(mt_rand(1,29)) {				
				case 1 : $last = "Alpha"; break;
				case 2 : $last = "Bear"; break;
				case 3 : $last = "Beast"; break;
				case 4 : $last = "Boar"; break;
				case 5 : $last = "Bramble"; break;
				case 6 : $last = "Captain"; break;
				case 7 : $last = "Captive"; break;
				case 8 : $last = "Dryad"; break;
				case 9 : $last = "Elder"; break;
				case 10 : $last = "Elk"; break;
				case 11 : $last = "Geist"; break;
				case 12 : $last = "Monstrosity"; break;
				case 13 : $last = "Mystics"; break;
				case 14 : $last = "of Avabruck"; break;
				case 15 : $last = "of Laurels"; break;
				case 16 : $last = "of the Tree"; break;
				case 17 : $last = "Ooze"; break;
				case 18 : $last = "Outcast"; break;
				case 19 : $last = "Outcast"; break;
				case 20 : $last = "Pilgrim"; break;
				case 21 : $last = "Ranger"; break;
				case 22 : $last = "Sheperd"; break;
				case 23 : $last = "Sleuth"; break;
				case 24 : $last = "Spawning"; break;
				case 25 : $last = "Survivors"; break;
				case 26 : $last = "Villager"; break;
				case 27 : $last = "Wolf"; break;
				case 28 : $last = "Wolf"; break;
				case 29 : $last = "Wurm"; break;
	  	}
	  }
	}
  $tmp = $first." ".$last;
  $tmp = str_replace("of of","of",$tmp);
  if (not_in_innistrad($tmp)) return $tmp;
  return random_name($color,$type);
}

function not_in_innistrad($candidate) {
	$name[] = "Abattoir Ghoul";
	$name[] = "Abbey Griffin";
	$name[] = "Altar's Reap";
	$name[] = "Ancient Grudge";
	$name[] = "Ashmouth Hound";
	$name[] = "Avacyn's Pilgrim";
	$name[] = "Avacynian Priest";
	$name[] = "Balefire Dragon";
	$name[] = "Battleground Geist";
	$name[] = "Bitterheart Witch";
	$name[] = "Blasphemous Act";
	$name[] = "Blazing Torch";
	$name[] = "Bloodcrazed Neonate";
	$name[] = "Bloodgift Demon";
	$name[] = "Bloodline Keeper";
	$name[] = "Bonds of Faith";
	$name[] = "Boneyard Wurm";
	$name[] = "Brain Weevil";
	$name[] = "Bramblecrush";
	$name[] = "Brimstone Volley";
	$name[] = "Bump in the Night";
	$name[] = "Burning Vengeance";
	$name[] = "Butcher's Cleaver";
	$name[] = "Cackling Counterpart";
	$name[] = "Caravan Vigil";
	$name[] = "Cellar Door";
	$name[] = "Champion of the Parish";
	$name[] = "Chapel Geist";
	$name[] = "Charmbreaker Devils";
	$name[] = "Civilized Scholar";
	$name[] = "Claustrophobia";
	$name[] = "Clifftop Retreat";
	$name[] = "Cloistered Youth";
	$name[] = "Cobbled Wings";
	$name[] = "Corpse Lunge";
	$name[] = "Creeping Renaissance";
	$name[] = "Creepy Doll";
	$name[] = "Crossway Vampire";
	$name[] = "Curiosity";
	$name[] = "Curse of Death's Hold";
	$name[] = "Curse of Oblivion";
	$name[] = "Curse of Stalked Prey";
	$name[] = "Curse of the Bloody Tome";
	$name[] = "Curse of the Nightly Hunt";
	$name[] = "Curse of the Pierced Heart";
	$name[] = "Darkthicket Wolf";
	$name[] = "Daybreak Ranger";
	$name[] = "Dead Weight";
	$name[] = "Dearly Departed";
	$name[] = "Delver of Secrets";
	$name[] = "Demon Token";
	$name[] = "Demonmail Hauberk";
	$name[] = "Deranged Assistant";
	$name[] = "Desperate Ravings";
	$name[] = "Devil's Play";
	$name[] = "Diregraf Ghoul";
	$name[] = "Disciple of Griselbrand";
	$name[] = "Dissipate";
	$name[] = "Divine Reckoning";
	$name[] = "Doomed Traveler";
	$name[] = "Dream Twist";
	$name[] = "Elder Cathar";
	$name[] = "Elder of Laurels";
	$name[] = "Elite Inquisitor";
	$name[] = "Endless Ranks of the Dead";
	$name[] = "Essence of the Wild";
	$name[] = "Evil Twin";
	$name[] = "Falkenrath Marauders";
	$name[] = "Falkenrath Noble";
	$name[] = "Feeling of Dread";
	$name[] = "Feral Ridgewolf";
	$name[] = "Festerhide Boar";
	$name[] = "Fiend Hunter";
	$name[] = "Forbidden Alchemy";
	$name[] = "Fortress Crab";
	$name[] = "Frightful Delusion";
	$name[] = "Full Moon's Rise";
	$name[] = "Furor of the Bitten";
	$name[] = "Gallows Warden";
	$name[] = "Galvanic Juggernaut";
	$name[] = "Garruk Relentless";
	$name[] = "Gatstaf Shepherd";
	$name[] = "Gavony Township";
	$name[] = "Geist of Saint Traft";
	$name[] = "Geist-Honored Monk";
	$name[] = "Geistcatcher's Rig";
	$name[] = "Geistflame";
	$name[] = "Ghost Quarter";
	$name[] = "Ghostly Possession";
	$name[] = "Ghoulcaller's Bell";
	$name[] = "Ghoulcaller's Chant";
	$name[] = "Ghoulraiser";
	$name[] = "Gnaw to the Bone";
	$name[] = "Grasp of Phantoms";
	$name[] = "Grave Bramble";
	$name[] = "Graveyard Shovel";
	$name[] = "Grimgrin, Corpse-Born";
	$name[] = "Grimoire of the Dead";
	$name[] = "Grizzled Outcasts";
	$name[] = "Gruesome Deformity";
	$name[] = "Gutter Grime";
	$name[] = "Hamlet Captain";
	$name[] = "Hanweir Watchkeep";
	$name[] = "Harvest Pyre";
	$name[] = "Heartless Summoning";
	$name[] = "Heretic's Punishment";
	$name[] = "Hinterland Harbor";
	$name[] = "Hollowhenge Scavenger";
	$name[] = "Homonculus Token";
	$name[] = "Hysterical Blindness";
	$name[] = "Infernal Plunge";
	$name[] = "Inquisitor's Flail";
	$name[] = "Instigator Gang";
	$name[] = "Intangible Virtue";
	$name[] = "Into the Maw of Hell";
	$name[] = "Invisible Stalker";
	$name[] = "Isolated Chapel";
	$name[] = "Kessig Cagebreakers";
	$name[] = "Kessig Wolf";
	$name[] = "Kessig Wolf Run";
	$name[] = "Kindercatch";
	$name[] = "Kruin Outlaw";
	$name[] = "Laboratory Maniac";
	$name[] = "Lantern Spirit";
	$name[] = "Liliana of the Veil";
	$name[] = "Lost in the Mist";
	$name[] = "Ludevic's Test Subject";
	$name[] = "Lumberknot";
	$name[] = "Make a Wish";
	$name[] = "Makeshift Mauler";
	$name[] = "Manor Gargoyle";
	$name[] = "Manor Skeleton";
	$name[] = "Markov Patrician";
	$name[] = "Mask of Avacyn";
	$name[] = "Mausoleum Guard";
	$name[] = "Maw of the Mire";
	$name[] = "Mayor of Avabruck";
	$name[] = "Memory's Journey";
	$name[] = "Mentor of the Meek";
	$name[] = "Midnight Haunting";
	$name[] = "Mikaeus, the Lunarch";
	$name[] = "Mindshrieker";
	$name[] = "Mirror-Mad Phantasm";
	$name[] = "Moan of the Unhallowed";
	$name[] = "Moldgraf Monstrosity";
	$name[] = "Moment of Heroism";
	$name[] = "Moon Heron";
	$name[] = "Moonmist";
	$name[] = "Moorland Haunt";
	$name[] = "Morkrut Banshee";
	$name[] = "Mulch";
	$name[] = "Murder of Crows";
	$name[] = "Naturalize";
	$name[] = "Nephalia Drownyard";
	$name[] = "Nevermore";
	$name[] = "Night Revelers";
	$name[] = "Night Terrors";
	$name[] = "Nightbird's Clutches";
	$name[] = "Olivia Voldaren";
	$name[] = "One-Eyed Scarecrow";
	$name[] = "Ooze Token";
	$name[] = "Orchard Spirit";
	$name[] = "Parallel Lives";
	$name[] = "Paraselene";
	$name[] = "Past in Flames";
	$name[] = "Pitchburn Devils";
	$name[] = "Prey Upon";
	$name[] = "Purify the Grave";
	$name[] = "Rage Thrower";
	$name[] = "Rakish Heir";
	$name[] = "Rally the Peasants";
	$name[] = "Ranger's Guile";
	$name[] = "Reaper from the Abyss";
	$name[] = "Rebuke";
	$name[] = "Reckless Waif";
	$name[] = "Riot Devils";
	$name[] = "Rolling Temblor";
	$name[] = "Rooftop Storm";
	$name[] = "Rotting Fensnake";
	$name[] = "Runechanter's Pike";
	$name[] = "Runic Repetition";
	$name[] = "Scourge of Geier Reach";
	$name[] = "Screeching Bat";
	$name[] = "Selfless Cathar";
	$name[] = "Selhoff Occultist";
	$name[] = "Sensory Deprivation";
	$name[] = "Sever the Bloodline";
	$name[] = "Sharpened Pitchfork";
	$name[] = "Shimmering Grotto";
	$name[] = "Silent Departure";
	$name[] = "Silver-Inlaid Dagger";
	$name[] = "Silverchase Fox";
	$name[] = "Skaab Goliath";
	$name[] = "Skaab Ruinator";
	$name[] = "Skeletal Grimace";
	$name[] = "Skirsdag Cultist";
	$name[] = "Skirsdag High Priest";
	$name[] = "Slayer of the Wicked";
	$name[] = "Smite the Monstrous";
	$name[] = "Snapcaster Mage";
	$name[] = "Somberwald Spider";
	$name[] = "Spare from Evil";
	$name[] = "Spectral Flight";
	$name[] = "Spectral Rider";
	$name[] = "Spider Spawning";
	$name[] = "Spider Token";
	$name[] = "Spidery Grasp";
	$name[] = "Spirit Token";
	$name[] = "Splinterfright";
	$name[] = "Stensia Bloodhall";
	$name[] = "Stitched Drake";
	$name[] = "Stitcher's Apprentice";
	$name[] = "Stony Silence";
	$name[] = "Stromkirk Noble";
	$name[] = "Stromkirk Patrol";
	$name[] = "Sturmgeist";
	$name[] = "Sulfur Falls";
	$name[] = "Think Twice";
	$name[] = "Thraben Purebloods";
	$name[] = "Thraben Sentry";
	$name[] = "Tormented Pariah";
	$name[] = "Traitorous Blood";
	$name[] = "Travel Preparations";
	$name[] = "Traveler's Amulet";
	$name[] = "Tree of Redemption";
	$name[] = "Trepanation Blade";
	$name[] = "Tribute to Hunger";
	$name[] = "Typhoid Rats";
	$name[] = "Ulvenwald Mystics";
	$name[] = "Unbreathing Horde";
	$name[] = "Unburial Rites";
	$name[] = "Undead Alchemist";
	$name[] = "Unruly Mob";
	$name[] = "Urgent Exorcism";
	$name[] = "Vampire Interloper";
	$name[] = "Vampire Token";
	$name[] = "Vampiric Fury";
	$name[] = "Victim of Night";
	$name[] = "Village Bell-Ringer";
	$name[] = "Village Cannibals";
	$name[] = "Village Ironsmith";
	$name[] = "Villagers of Estwald";
	$name[] = "Voiceless Spirit";
	$name[] = "Walking Corpse";
	$name[] = "Witchbane Orb";
	$name[] = "Wolf Token";
	$name[] = "Wolf Token";
	$name[] = "Wooden Stake";
	$name[] = "Woodland Cemetery";
	$name[] = "Woodland Sleuth";
	$name[] = "Wreath of Geists";
	$name[] = "Afflicted Deserter";
	$name[] = "Alpha Brawl";
	$name[] = "Altar of the Lost";
	$name[] = "Archangel's Light";
	$name[] = "Artful Dodge";
	$name[] = "Avacyn's Collar";
	$name[] = "Bar the Door";
	$name[] = "Beguiler of Wills";
	$name[] = "Black Cat";
	$name[] = "Blood Feud";
	$name[] = "Bone to Ash";
	$name[] = "Break of Day";
	$name[] = "Briarpack Alpha";
	$name[] = "Burden of Guilt";
	$name[] = "Burning Oil";
	$name[] = "Call to the Kindred";
	$name[] = "Chalice of Life";
	$name[] = "Chant of the Skifsang";
	$name[] = "Chill of Foreboding";
	$name[] = "Chosen of Markov";
	$name[] = "Clinging Mists";
	$name[] = "Counterlash";
	$name[] = "Crushing Vines";
	$name[] = "Curse of Bloodletting";
	$name[] = "Curse of Echoes";
	$name[] = "Curse of Exhaustion";
	$name[] = "Curse of Misfortunes";
	$name[] = "Curse of Thirst";
	$name[] = "Dawntreader Elk";
	$name[] = "Deadly Allure";
	$name[] = "Death's Caress";
	$name[] = "Deranged Outcast";
	$name[] = "Diregraf Captain";
	$name[] = "Divination";
	$name[] = "Drogskol Captain";
	$name[] = "Drogskol Reaver";
	$name[] = "Dungeon Geists";
	$name[] = "Elbrus, the Binding Blade";
	$name[] = "Elgaud Inquisitor";
	$name[] = "Emblem Sorin, Lord of Innistrad";
	$name[] = "Erdwal Ripper";
	$name[] = "Evolving Wilds";
	$name[] = "Executioner's Hood";
	$name[] = "Faith's Shield";
	$name[] = "Faithless Looting";
	$name[] = "Falkenrath Aristocrat";
	$name[] = "Falkenrath Torturer";
	$name[] = "Farbog Boneflinger";
	$name[] = "Favor of the Woods";
	$name[] = "Feed the Pack";
	$name[] = "Fiend of the Shadows";
	$name[] = "Fires of Undeath";
	$name[] = "Flayer of the Hatebound";
	$name[] = "Fling";
	$name[] = "Forge Devil";
	$name[] = "Gather the Townsfolk";
	$name[] = "Gavony Ironwright";
	$name[] = "Geralf's Messenger";
	$name[] = "Geralf's Mindcrusher";
	$name[] = "Ghoultree";
	$name[] = "Grafdigger's Cage";
	$name[] = "Gravecrawler";
	$name[] = "Gravepurge";
	$name[] = "Gravetiller Wurm";
	$name[] = "Grim Backwoods";
	$name[] = "Grim Flowering";
	$name[] = "Griptide";
	$name[] = "Gruesome Discovery";
	$name[] = "Harrowing Journey";
	$name[] = "Haunted Fengraf";
	$name[] = "Havengul Lich";
	$name[] = "Havengul Runebinder";
	$name[] = "Headless Skaab";
	$name[] = "Heavy Mattock";
	$name[] = "Heckling Fiends";
	$name[] = "Hellrider";
	$name[] = "Helvault";
	$name[] = "Highborn Ghoul";
	$name[] = "Hinterland Hermit";
	$name[] = "Hollowhenge Beast";
	$name[] = "Hollowhenge Spirit";
	$name[] = "Human Token";
	$name[] = "Hunger of the Howlpack";
	$name[] = "Huntmaster of the Fells";
	$name[] = "Immerwolf";
	$name[] = "Increasing Ambition";
	$name[] = "Increasing Confusion";
	$name[] = "Increasing Devotion";
	$name[] = "Increasing Savagery";
	$name[] = "Increasing Vengeance";
	$name[] = "Jar of Eyeballs";
	$name[] = "Kessig Recluse";
	$name[] = "Lambholt Elder";
	$name[] = "Lingering Souls";
	$name[] = "Lost in the Woods";
	$name[] = "Loyal Cathar";
	$name[] = "Markov Blademaster";
	$name[] = "Markov Warlord";
	$name[] = "Midnight Guard";
	$name[] = "Mikaeus, the Unhallowed";
	$name[] = "Mondronen Shaman";
	$name[] = "Moonveil Dragon";
	$name[] = "Mystic Retrieval";
	$name[] = "Nearheath Stalker";
	$name[] = "Nephalia Seakite";
	$name[] = "Niblis of the Breath";
	$name[] = "Niblis of the Mist";
	$name[] = "Niblis of the Urn";
	$name[] = "Predator Ooze";
	$name[] = "Pyreheart Wolf";
	$name[] = "Ravenous Demon";
	$name[] = "Ray of Revelation";
	$name[] = "Reap the Seagraf";
	$name[] = "Relentless Skaabs";
	$name[] = "Requiem Angel";
	$name[] = "Russet Wolves";
	$name[] = "Sanctuary Cat";
	$name[] = "Saving Grasp";
	$name[] = "Scorch the Fields";
	$name[] = "Scorned Villager";
	$name[] = "Screeching Skaab";
	$name[] = "Seance";
	$name[] = "Secrets of the Dead";
	$name[] = "Shattered Perception";
	$name[] = "Shriekgeist";
	$name[] = "Sightless Ghoul";
	$name[] = "Silverclaw Griffin";
	$name[] = "Skillful Lunge";
	$name[] = "Skirsdag Flayer";
	$name[] = "Somberwald Dryad";
	$name[] = "Sorin, Lord of Innistrad";
	$name[] = "Soul Seizer";
	$name[] = "Spiteful Shadows";
	$name[] = "Stormbound Geist";
	$name[] = "Strangleroot Geist";
	$name[] = "Stromkirk Captain";
	$name[] = "Sudden Disappearance";
	$name[] = "Talons of Falkenrath";
	$name[] = "Thalia, Guardian of Thraben";
	$name[] = "Thought Scour";
	$name[] = "Thraben Doomsayer";
	$name[] = "Thraben Heretic";
	$name[] = "Torch Fiend";
	$name[] = "Tower Geist";
	$name[] = "Tracker's Instincts";
	$name[] = "Tragic Slip";
	$name[] = "Ulvenwald Bear";
	$name[] = "Undying Evil";
	$name[] = "Vampire Token";
	$name[] = "Vault of the Archangel";
	$name[] = "Vengeful Vampire";
	$name[] = "Village Survivors";
	$name[] = "Vorapede";
	$name[] = "Wakedancer";
	$name[] = "Warden of the Wall";
	$name[] = "Wild Hunger";
	$name[] = "Wolfbitten Captive";
	$name[] = "Wolfhunter's Quiver";
	$name[] = "Wrack with Madness";
	$name[] = "Young Wolf";
	$name[] = "Zombie Apocalypse";
  return !in_array($candidate,$name);
}

// Creature type for typeline
function creature_type($color,$name) {
	if (strpos($name,"Wurm")) return "Wurm";
  elseif (strpos(" ".$name, "Geist")) return "Spirit";
  elseif (strpos(" ".$name,"Skaab")) return "Zombie";
  elseif (strpos(" ".$name,"Hound")) return "Hound";
  elseif (strpos(" ".$name,"Ghoul")) return "Zombie Soldier";
  elseif (strpos(" ".$name,"Demon")) return "Demon";
  elseif (strpos(" ".$name,"Devil")) return "Devil";
  elseif (strpos(" ".$name,"Dragon")) return "Dragon";
  elseif (strpos(" ".$name,"Wolf")) return "Wolf";
  elseif (strpos(" ".$name,"Wolves")) return "Wolf";
  elseif (strpos(" ".$name,"Elk")) return "Elk";
  elseif (strpos(" ".$name,"Seakite")) return "Bird";
  elseif (strpos(" ".$name,"Bear")) return "Bear";
  elseif (strpos(" ".$name,"Shaman")) return "Shaman";
  elseif (strpos(" ".$name,"Cat")) return "Cat";
  elseif (strpos(" ".$name,"Angel")) return "Angel";
  elseif (strpos(" ".$name,"Griffin")) return "Bird Soldier";
	else {
  if ($color == "white") {
  	$tmp[] = "Human Scout";
  	$tmp[] = "Human Monk";
  	$tmp[] = "Human Miltia";
  	$tmp[] = "Human Soldier";
  	$tmp[] = "Spirit";
  	$tmp[] = "Spirit";
  	$tmp[] = "Human Cleric";
  	$tmp[] = "Angel";
  	$tmp[] = "Angel";
  	$tmp[] = "Angel";
  	$tmp[] = "Angel";
  }
  elseif ($color == "blue") {
  	$tmp[] = "Zombie Warrior";
  	$tmp[] = "Spirit";
  	$tmp[] = "Human Advisor";
  	$tmp[] = "Human Wizard";
  	$tmp[] = "Illusion Spirit";
  	$tmp[] = "Human Ghost";
  	$tmp[] = "Human Rogue";
  	$tmp[] = "Horror";
  	$tmp[] = "Homunculus";
  	$tmp[] = "Angel Rogue";
  	$tmp[] = "Zombie";
  	$tmp[] = "Zombie";
  }
  elseif ($color == "black") {
  	$tmp[] = "Vampire";
  	$tmp[] = "Zombie";
  	$tmp[] = "Human Shaman";
  	$tmp[] = "Demon";
  	$tmp[] = "Demon";
  	$tmp[] = "Skeleton";
  	$tmp[] = "Skeleton";
  	$tmp[] = "Spirit";
  	$tmp[] = "Human Cleric";
  	$tmp[] = "Vampire Scout";
   	$tmp[] = "Angel Rogue";
  	$tmp[] = "Zombie";
  	$tmp[] = "Zombie";
  }
  elseif ($color == "red") {
  	$tmp[] = "Elemental Hound";
  	$tmp[] = "Hound";
  	$tmp[] = "Wolf";
  	$tmp[] = "Vampire Hound";
  	$tmp[] = "Devil";
  	$tmp[] = "Elemental";
  	$tmp[] = "Wolf Hound";
   	$tmp[] = "Angel Devil";
  }
  elseif ($color == "green") {
  	$tmp[] = "Hound Werewolf";
  	$tmp[] = "Hound";
  	$tmp[] = "Wolf";
  	$tmp[] = "Elemental";
  	$tmp[] = "Human Werewolf";
  	$tmp[] = "Werewolf";
  	$tmp[] = "Boar";
	 	$tmp[] = "Angel Werewolf";	
  }
  else return "error";
	}
  return $tmp[mt_rand(0,count($tmp)-1)];
}

function artist() {
	switch(mt_rand(1,21)) {	
		case 1 : $firstname = 'Aleksi'; break;
		case 2 : $firstname = 'Allan'; break;
		case 3 : $firstname = 'Carl'; break;
		case 4 : $firstname = 'Chippy'; break;
		case 5 : $firstname = 'Christopher'; break;
		case 6 : $firstname = 'Douglas'; break;
		case 7 : $firstname = 'Eric'; break;
		case 8 : $firstname = 'Greg'; break;
		case 9 : $firstname = 'James'; break;
		case 10 : $firstname = 'Jason'; break;
		case 11 : $firstname = 'Jesper'; break;
		case 12 : $firstname = 'John'; break;
		case 13 : $firstname = 'Justin'; break;
		case 14 : $firstname = 'Kev'; break;
		case 15 : $firstname = 'Lars'; break;
		case 16 : $firstname = 'Mark'; break;
		case 17 : $firstname = 'Rebecca'; break;
		case 18 : $firstname = 'Ron'; break;
		case 19 : $firstname = 'Steve'; break;
		case 20 : $firstname = 'Steve'; break;
		case 21 : $firstname = 'Therese'; break;
	}	
	switch(mt_rand(1,21)) {
		case 1 : $lastname = 'Argyle'; break;
		case 2 : $lastname = 'Avon'; break;
		case 3 : $lastname = 'Briclot'; break;
		case 4 : $lastname = 'Chan'; break;
		case 5 : $lastname = 'Chippy'; break;
		case 6 : $lastname = 'Critchlow'; break;
		case 7 : $lastname = 'Deschamps'; break;
		case 8 : $lastname = 'Grant West'; break;
		case 9 : $lastname = 'Guay'; break;
		case 10 : $lastname = 'Moeller'; break;
		case 11 : $lastname = 'Myrfors'; break;
		case 12 : $lastname = 'Nielsen'; break;
		case 13 : $lastname = 'Palck'; break;
		case 14 : $lastname = 'Pollack'; break;
		case 15 : $lastname = 'Prescott'; break;
		case 16 : $lastname = 'Schuler'; break;
		case 17 : $lastname = 'Spencer'; break;
		case 18 : $lastname = 'Staples'; break;
		case 19 : $lastname = 'Sweet'; break;
		case 20 : $lastname = 'Tedin'; break;
		case 21 : $lastname = 'Walker'; break;
	}
	return $firstname." ".$lastname;
}

function random_flavor($color) {

	switch(mt_rand(1,193)) {
		case 1 : $first = "Moorlanders speak in awe of the priests,"; break;
		case 2 : $first = "The darkness crawls with vampires and ghouls,"; break;
		case 3 : $first = "She endures without Avacyn but secretly asks:"; break;
		case 4 : $first = "From immortal hope, mortal power fails,"; break;
		case 5 : $first = "The spirit cares nothing"; break;
		case 6 : $first = "In life, they were a motley crew:"; break;
		case 7 : $first = "In these halls,"; break;
		case 8 : $first = "Your true test comes:"; break;
		case 9 : $first = "The path back to the world of the living"; break;
		case 10 : $first = "What cannot be destroyed,"; break;
		case 11 : $first = "I stand for every villager,"; break;
		case 12 : $first = "Death has bound it,"; break;
		case 13 : $first = "Forever it searches for atonement, "; break;
		case 14 : $first = "I heard her talking in her sleep,"; break;
		case 15 : $first = "Never forget our ancestors,"; break;
		case 16 : $first = "He vowed he would never rest,"; break;
		case 17 : $first = "My greatest hope is that you will surpass me,"; break;
		case 18 : $first = "No matter how many I kill, "; break;
		case 19 : $first = "It makes me smile,"; break;
		case 20 : $first = "Ghoulcallers trying to get in"; break;
		case 21 : $first = "By the law of Avacyn,"; break;
		case 22 : $first = "Moonlight has a way of showing all things"; break;
		case 23 : $first = "Not content to nudge vases and chill drawing rooms,"; break;
		case 24 : $first = "After seeing his life's work drip away,"; break;
		case 25 : $first = "If he doesn't stop being so rude,"; break;
		case 26 : $first = "His mind whirled with grand plans,"; break;
		case 27 : $first = "After several failed experiments,"; break;
		case 28 : $first = "Even more than carrion,"; break;
		case 29 : $first = "Let those idiot priests tremble,"; break;
		case 30 : $first = "The same magic that lets geists pass through our realm,"; break;
		case 31 : $first = "Three heads, six arms and some armor grafts are better than..."; break;
		case 32 : $first = "The best skaab are more powerful,"; break;
		case 33 : $first = "Sometimes, when death comes knocking,"; break;
		case 34 : $first = "He relishes the devotion of his Skirsdag puppets,"; break;
		case 35 : $first = "May you and all your kin waste,"; break;
		case 36 : $first = "At least this one still has arms and legs,"; break;
		case 37 : $first = "With Thraben's army recalled to its city walls,"; break;
		case 38 : $first = "They won't be winning any beauty pageants,"; break;
		case 39 : $first = "For a ghoul, every village is a buffet"; break;
		case 40 : $first = "Let go your grudges,"; break;
		case 41 : $first = "Avacyn has deserted you,"; break;
		case 42 : $first = "When I realized we all have skeletons on the inside,"; break;
		case 43 : $first = "All crave the Blessed Sleep"; break;
		case 44 : $first = "He listens to every heartbeat,"; break;
		case 45 : $first = "They have endured the horrors of Innistrad "; break;
		case 46 : $first = "If it comes for you,"; break;
		case 47 : $first = "Holy places are no longer sanctuary from death,"; break;
		case 48 : $first = "While elder vampires select their meals with care,"; break;
		case 49 : $first = "Innocent thorns can fill the air with your bloodscent,"; break;
		case 50 : $first = "He scans for wolves,"; break;
		case 51 : $first = "Technically he never left his post,"; break;
		case 52 : $first = "Hold tight,"; break;
		case 53 : $first = "Stensian villagers mourned the loss of human life,"; break;
		case 54 : $first = "Within blood is life. Within life is fire. Within fire,"; break;
		case 55 : $first = "A responsible king"; break;
		case 56 : $first = "Each night,"; break;
		case 57 : $first = "Each morning,"; break;
		case 58 : $first = "Avacyn's protection is everywhere,"; break;
		case 59 : $first = "Discovering a pit of bones,"; break;
		case 60 : $first = "Wander too far into the wild,"; break;
		case 61 : $first = "What's worse than a wolf"; break;
		case 62 : $first = "Nature abhors"; break;
		case 63 : $first = "After werewolves slaughtered the citizenry of Hollowhenge,"; break;
		case 64 : $first = "They put bars on these noble beasts,"; break;
		case 65 : $first = "He can deny his true nature,"; break;
		case 66 : $first = "Nobody's seen the Lady of Videns for years,"; break;
		case 67 : $first = "Visiting a shrine at the start of a journey "; break;
		case 68 : $first = "Whatever did this is near,"; break;
		case 69 : $first = "This is the light of Avacyn,"; break;
		case 70 : $first = "It may not look like much,"; break;
		case 71 : $first = "It's a good old door with strong wards,"; break;
		case 72 : $first = "Grab an axe and defend the gate,"; break;
		case 73 : $first = "I do believe your heresy will prove itself,"; break;
		case 74 : $first = "It will take more than steel alone,"; break;
		case 75 : $first = "In the memories of those they lost,"; break;
		case 76 : $first = "I wish my work could shelter everyone"; break;
		case 77 : $first = "Some spirits mourn,"; break;
		case 78 : $first = "The murdered inhabitants of Hollowhenge impart to the living,"; break;
		case 79 : $first = "I trust myself to do my duty,"; break;
		case 80 : $first = "It's what comes after that,"; break;
		case 81 : $first = "Your soul is protected by the hand of Avacyn,"; break;
		case 82 : $first = "When you're on watch, no noise is harmless,"; break;
		case 83 : $first = "Not even a roaring fire! No,"; break;
		case 84 : $first = "I never had the nerve to open that bottle,"; break;
		case 85 : $first = "May angels carry him into the Blessed Sleep,"; break;
		case 86 : $first = "When angels dispair,"; break;
		case 87 : $first = "It patrols the grafs for miles around Thraben"; break;
		case 88 : $first = "Valor is a currency of the living,"; break;
		case 89 : $first = "Thraben is our home,"; break;
		case 90 : $first = "Swarms of the unhallowed claw at Thraben's gates,"; break;
		case 91 : $first = "Let them decry me,"; break;
		case 92 : $first = "I'm not giving those ghoulcallers any more,"; break;
		case 93 : $first = "Those who know the alleys and sewers,"; break;
		case 94 : $first = "Come,"; break;
		case 95 : $first = "I can think of worse ways to go,"; break;
		case 96 : $first = "The skifsang craft spells like other sailors craft nets,"; break;
		case 97 : $first = "Wait,"; break;
		case 98 : $first = "Pathetic! Now,"; break;
		case 99 : $first = "Even the House of Galan,"; break;
		case 100 : $first = "Beware the seagrafs just off the shore,"; break;
		case 101 : $first = "So many corpses,"; break;
		case 102 : $first = "A head is a needless encumbrance,"; break;
		case 103 : $first = "Keep one eye on the cliff road,"; break;
		case 104 : $first = "Keep one eye on the sky,"; break;
		case 105 : $first = "Why do the dead remain among us? Why,"; break;
		case 106 : $first = "Nothing's more valuable than"; break;
		case 107 : $first = "Its screeching is the sound of"; break;
		case 108 : $first = "The veil between the living and the dead is so very thin,"; break;
		case 109 : $first = "Wounds of the flesh,"; break;
		case 110 : $first = "Wounds of the mind,"; break;
		case 111 : $first = "The body often twists and flails,"; break;
		case 112 : $first = "As you inject the viscus vitae into the brain stem,"; break;
		case 113 : $first = "It will soon become"; break;
		case 114 : $first = "Jenrik's tower is served by those,"; break;
		case 115 : $first = "Its last life is spent "; break;
		case 116 : $first = "I have been found worthy"; break;
		case 117 : $first = "May you drink until you drown,"; break;
		case 118 : $first = "What could be more irresistible than"; break;
		case 119 : $first = "The faint smell of cloves, the rustling of the wind,"; break;
		case 120 : $first = "There was a time when,"; break;
		case 121 : $first = "Here are some bones for you to choke on,"; break;
		case 122 : $first = "Innistrad's ghoulcallers are talented,"; break;
		case 123 : $first = "Wake up my lovelies! Now,"; break;
		case 124 : $first = "There are always fools who attempt to traverse Kruin Pass before sundown,"; break;
		case 125 : $first = "All the dead sleep lightly here,"; break;
		case 126 : $first = "His twisted words,"; break;
		case 127 : $first = "The price is paid,"; break;
		case 128 : $first = "The wreck hung on the jagged reef,"; break;
		case 129 : $first = "It blindly marches on Thraben's gates,"; break;
		case 130 : $first = "Certain initiates into the Skirsdag cult take a vow of blindness"; break;
		case 131 : $first = "Let us remind these human cattle why they fear,"; break;
		case 132 : $first = "Linger on death's door,"; break;
		case 133 : $first = "Is it true,"; break;
		case 134 : $first = "He wields the full power of wrath,"; break;
		case 135 : $first = "Hers is an ancient form of necromancy,"; break;
		case 136 : $first = "There will come a day so dark,"; break;
		case 137 : $first = "On that day,"; break;
		case 138 : $first = "On the rising of the first full moon,"; break;
		case 139 : $first = "Being an alpha means proving it,"; break;
		case 140 : $first = "Succession is a matter of blood,"; break;
		case 141 : $first = "Every now and then,"; break;
		case 142 : $first = "It is the demon's mark,"; break;
		case 143 : $first = "Savage vampires lurk in the Erdwal's network of passageways,"; break;
		case 144 : $first = "Avacyn has abandoned us,"; break;
		case 145 : $first = "I drink of those who are worthy of my palate,"; break;
		case 146 : $first = "Masters of the sword know the blade,"; break;
		case 147 : $first = "Devils infiltrated the lower levels of Thraben Cathedral,"; break;
		case 148 : $first = "Their language may be a cacophonous agglomeration of chittering snorts,"; break;
		case 149 : $first = "Behind every devil's mayhem,"; break;
		case 150 : $first = "He tried to live far from those he could hurt,"; break;
		case 151 : $first = "Mortals practice swordplay for a few decades at best,"; break;
		case 152 : $first = "What use is a stake or holy symbol,"; break;
		case 153 : $first = "Tovolar, my master. Gather the howlpack,"; break;
		case 154 : $first = "Their hearts beat, their lungs draw breath,"; break;
		case 155 : $first = "Do not speak of this to the elders,"; break;
		case 156 : $first = "The wolves of our valley,"; break;
		case 157 : $first = "For centuries they have kept our estates clear,"; break;
		case 158 : $first = "Your fields will turn as black as a ghoul's tongue,"; break;
		case 159 : $first = "You must shatter the fetters of the past,"; break;
		case 160 : $first = "Devils redecorate,"; break;
		case 161 : $first = "The skathul, spirits consumed by revenge"; break;
		case 162 : $first = "The wolves turned on us,"; break;
		case 163 : $first = "Your veil's curse won't stop me,"; break;
		case 164 : $first = "Silent as winter snow,"; break;
		case 165 : $first = "Cast out by his village,"; break;
		case 166 : $first = "Feeling abandoned by Avacyn,"; break;
		case 167 : $first = "It uproots entire fengrafs,"; break;
		case 168 : $first = "As the creatures of the night closed in,"; break;
		case 169 : $first = "Nothing in nature goes to waste,"; break;
		case 170 : $first = "In a world of monsters,"; break;
		case 171 : $first = "Werewolves are an unholy mix,"; break;
		case 172 : $first = "Its silk is highly prized,"; break;
		case 173 : $first = "Be wary,"; break;
		case 174 : $first = "The Somberwald is her domain,"; break;
		case 175 : $first = "Geists of the hanged often haunt"; break;
		case 176 : $first = "As their villages fell to werewolves,"; break;
		case 177 : $first = "If you think you've killed one,"; break;
		case 178 : $first = "The Ulvenwald makes no allowances for youth,"; break;
		case 179 : $first = "Though its mind has long since rotted away,"; break;
		case 180 : $first = "Dead or alive,"; break;
		case 181 : $first = "Wracked and warped with anguish,"; break;
		case 182 : $first = "Your blood is quite pleasing,"; break;
		case 183 : $first = "Fusing intelligence with the power of undeath,"; break;
		case 184 : $first = "No longer can we allow our human populations,"; break;
		case 185 : $first = "The sweet taste of this,"; break;
		case 186 : $first = "The bitter taste of this,"; break;
		case 187 : $first = "Those who grasp its hilt,"; break;
		case 188 : $first = "There are not enough lives,"; break;
		case 189 : $first = "If you wind up in one of mine"; break;
		case 190 : $first = "Our world is vast,"; break;
		case 191 : $first = "The cathedral must stand,"; break;
		case 192 : $first = "I love what they've done,"; break;
		case 193 : $first = "For centuries my creation kept this world in balance,"; break;
	}
	switch(mt_rand(1,194)) {
		case 1: $last = "die boldly or die swiftly - for die you will."; break;
		case 2: $last = "and death is no longer sanctuary from anything."; break;
		case 3: $last = " the newly sired frenzy at the first whiff."; break;
		case 4: $last = "so don't stray from the path."; break;
		case 5: $last = "knowing there's one he can never anticipate."; break;
		case 6: $last = "he looks after the wolf wherever it goes."; break;
		case 7: $last = "I've got a surprise for them."; break;
		case 8: $last = "Thraben vampire slayers mourned the loss of living wood."; break;
		case 9: $last = "is the path to our master's glory!"; break;
		case 10: $last = "walks among his subjects."; break;
		case 11: $last = "he abandons the trappings of civilization."; break;
		case 12: $last = "he repairs the front door."; break;
		case 13: $last = "all that we see is under her blessed watch."; break;
		case 14: $last = "adding to it."; break;
		case 15: $last = "and it may take you for its own."; break;
		case 16: $last = "in sheep's clothing?"; break;
		case 17: $last = "a zombie."; break;
		case 18: $last = "other creatures moved in."; break;
		case 19: $last = "and then wonder why werewolves target our towns."; break;
		case 20: $last = "for only so long."; break;
		case 21: $last = "no companions at all in that old castle."; break;
		case 22: $last = "makes the traveler more likely to finish it."; break;
		case 22: $last = "be alert!"; break;
		case 23: $last = "arriving just in time to drive off the wicked things."; break;
		case 24: $last = "but we are not without allies."; break;
		case 25: $last = "if it has seen her."; break;
		case 26: $last = "as it shelters all beneath its stormy cloak."; break;
		case 27: $last = "for the crimes or triumphs of the slain."; break;
		case 28: $last = "but in death they are united."; break;
		case 29: $last = "there is no pass or fail. "; break;
		case 30: $last = "as the full moon rises."; break;
		case 31 : $last = "is murky and bewildering."; break;
		case 32 : $last = "will be bound."; break;
		case 33 : $last = "and they stand for me."; break;
		case 34 : $last = "chains of past regrets."; break;
		case 35 : $last = "each kindness removing a single link."; break;
		case 36 : $last = "and it was not my daughter's voice."; break;
		case 37 : $last = "for they have not forgotten us."; break;
		case 38 : $last = "until he reached his destination."; break;
		case 39 : $last = "consigning my name to some forgotten corner of history."; break;
		case 40 : $last = "there are always more to hunt."; break;
		case 41 : $last = "just to think about it."; break;
		case 42 : $last = "geists trying to get out."; break;
		case 43 : $last = "the following deeds are henceforth disallowed."; break;
		case 44 : $last = "for better or for worse."; break;
		case 45 : $last = "some geists muster spectral armies."; break;
		case 46 : $last = "the mage decided it was a good time to go crazy."; break;
		case 47 : $last = "I'm quitting."; break;
		case 48 : $last = "but might happen if he were to succeed?"; break;
		case 49 : $last = "he needed to create a monster."; break;
		case 50 : $last = "they crave the last words of the dying."; break;
		case 51 : $last = "raise the lightning vane!"; break;
		case 52 : $last = "force them out of it."; break;
		case 53 : $last = "the normal numbers of those things."; break;
		case 54 : $last = "and more beautiful than the sum of their parts."; break;
		case 55 : $last = "with their belief that it will earn them immortality."; break;
		case 56 : $last = "and wither until your clan is no more."; break;
		case 57 : $last = "at least most of its legs."; break;
		case 58 : $last = "outlying villages were left to fend for themselves."; break;
		case 59 : $last = "but they'll do the trick."; break;
		case 60 : $last = "and every disaster is a reunion."; break;
		case 61 : $last = "or risk wandering the bogs forever in a murderous rage"; break;
		case 62 : $last = "I welcome your devotion in her stead."; break;
		case 63 : $last = "Thraben's pleas fell of deaf ears."; break;
		case 64 : $last = "but few receive it."; break;
		case 65 : $last = "deciding which one of hundreds he will stop."; break;
		case 66 : $last = "by becoming the worst monsters of all."; break;
		case 67 : $last = "even in her absence she offers us hope."; break;
		case 67 : $last = "but it's a good old door with strong wards."; break;
		case 68 : $last = "It'll hold."; break;
		case 69 : $last = "that we can ill afford."; break;
		case 70 : $last = "your despair is an extravagance!"; break;
		case 71 : $last = "you have more pressing concerns."; break;
		case 72 : $last = "to purge this world of evil."; break;
		case 73 : $last = "the strength needed to defend their city."; break;
		case 74 : $last = "yet I pray we are never so few that it does."; break;
		case 75 : $last = "others terrorize."; break;
		case 76 : $last = "the living the terror they felt in death."; break;
		case 77 : $last = "it's what comes after that I'm afraid of."; break;
		case 78 : $last = "and will never submit to evil."; break;
		case 79 : $last = "and no shadow can be ignored."; break;
		case 80 : $last = "thaw the chill it put in my heart."; break;
		case 81 : $last = "I'll bet you're wishing right now you hadn't been so curious yourself."; break;
		case 82 : $last = "with dreams of sunlit days and moonless nights."; break;
		case 83 : $last = "what hope can remain for mortals?"; break;
		case 84 : $last = "in search of devils or signs of their mischief."; break;
		case 85 : $last = "ensuring that the unhallowed do not wake for long."; break;
		case 86 : $last = "that serves us well."; break;
		case 87 : $last = "I will not see it fall to this unhallowed horde."; break;
		case 88 : $last = "do you still deny the end approaches?"; break;
		case 89 : $last = "more fuel for their madness."; break;
		case 90 : $last = "can disappear like smoke."; break;
		case 91 : $last = "the tyranny of thought."; break;
		case 92 : $last = "on second thought, maybe not."; break;
		case 93 : $last = "enough to snare even the deadliest catch."; break;
		case 94 : $last = "... did you fellows hear something?"; break;
		case 95 : $last = "let me show you how it's done."; break;
		case 96 : $last = "has resorted to exploring more primitive methods in Avacyn's absence."; break;
		case 97 : $last = "filled with hungry geists looking for an easy meal."; break;
		case 98 : $last = "so little time."; break;
		case 99 : $last = "when muscle is all that's required."; break;
		case 100 : $last = " or your death may fall on you."; break;
		case 101 : $last = " or you may fall to your death."; break;
		case 102 : $last = "where is Flight Alabaster to lead them home?"; break;
		case 103 : $last = "more valuable than perfect timing."; break;
		case 104 : $last = "you losing your mind."; break;
		case 105 : $last = "the whispers of the ancients can finally be heard."; break;
		case 106 : $last = "easy to heal."; break;
		case 107 : $last = "it may never be undone."; break;
		case 108 : $last = "the spirit explores its new home."; break;
		case 109 : $last = "don't let the spastic moaning bother you."; break;
		case 110 : $last = "music to your ears."; break;
		case 111 : $last = "those who once sought to enter it uninvited."; break;
		case 112 : $last = "tormenting your dreams."; break;
		case 113 : $last = "and for that I shall be eternally grateful."; break;
		case 114 : $last = "but never be sated."; break;
		case 115 : $last = "more irresistible than death?"; break;
		case 116 : $last = "an airless, fathomless tomb."; break;
		case 117 : $last = "our cages rang with wailing."; break;
		case 118 : $last = "these whimpering fools remain."; break;
		case 119 : $last = "dear brother!"; break;
		case 120 : $last = "what someone with real power can create."; break;
		case 121 : $last = "there's work to be done!"; break;
		case 122 : $last = "every time they wind up in a race for their lives."; break;
		case 123 : $last = "no matter how refined their beds may be."; break;
		case 124 : $last = "the power is mine!"; break;
		case 125 : $last = "each night disgorging more of its gruesome cargo."; break;
		case 126 : $last = "guided by its master's direful will."; break;
		case 127 : $last = "pledging obedience to none but demonkind."; break;
		case 128 : $last = "they fear the shadows of this world."; break;
		case 129 : $last = "and risk being invited in."; break;
		case 130 : $last = "is it true? Let's find out."; break;
		case 131 : $last = "by the sympathies of a soul."; break;
		case 132 : $last = "which few skaberen or ghoulcallers comprehend."; break;
		case 133 : $last = "on that day your prayers will be answered."; break;
		case 134 : $last = "doubt as to the horrible truth lurking within."; break;
		case 135 : $last = "proving it every full moon."; break;
		case 136 : $last = "and by blood it is often decided."; break;
		case 137 : $last = "a devil's prank can give you a good idea."; break;
		case 138 : $last = "an infernal claim on the flesh of the guilty."; break;
		case 139 : $last = "where prey is plentiful and easy to catch."; break;
		case 140 : $last = "except what we can take!"; break;
		case 141 : $last = "the rest will burn."; break;
		case 142 : $last = "the blade is not the only weapon at their disposal."; break;
		case 143 : $last = "making cracks in load-bearing pillars."; break;
		case 144 : $last = "setting fire to precious archives."; break;
		case 145 : $last = "but the message they send is all too clear."; break;
		case 146 : $last = "there lurks a demon's scheme."; break;
		case 147 : $last = "but the monster within was a tireless hunter."; break;
		case 148 : $last = "for a few decades at best."; break;
		case 149 : $last = "that eternity has to offer?"; break;
		case 150 : $last = "in the hands of a coward?"; break;
		case 151 : $last = "for the Hunter's Moon is nigh."; break;
		case 152 : $last = "and Thraben's walls grow weak."; break;
		case 153 : $last = "and they have one true form."; break;
		case 154 : $last = "as allies of the living."; break;
		case 155 : $last = "to the elders."; break;
		case 156 : $last = "they look unfavorably upon my indulgences."; break;
		case 157 : $last = "to detest the scent of ghouls."; break;
		case 158 : $last = "and fire shall be your only harvest."; break;
		case 159 : $last = "only then can you truly act."; break;
		case 160 : $last = "with fire."; break;
		case 161 : $last = "and a chill swept over me."; break;
		case 162 : $last = "while looking for weak minds to assault."; break;
		case 163 : $last = "and this dark plane is not big enough for you to hide."; break;
		case 164 : $last = "by the walking dead."; break;
		case 165 : $last = "in his forest."; break;
		case 166 : $last = "to the pagan rituals of their ancestors."; break;
		case 167 : $last = "to add to its twisted frame."; break;
		case 168 : $last = "as though waking to watch the slaughter."; break;
		case 169 : $last = "it's the stuff of nightmares."; break;
		case 170 : $last = "and a human's hatred."; break;
		case 171 : $last = "but then again, so is your life."; break;
		case 172 : $last = "long ago."; break;
		case 173 : $last = "of the seemingly gentle souls."; break;
		case 174 : $last = "back to my village."; break;
		case 175 : $last = "an acceptable excuse for trespassing."; break;
		case 176 : $last = "on which they died."; break;
		case 177 : $last = "out chasing bears."; break;
		case 178 : $last = "had remarkable survival instincts."; break;
		case 179 : $last = "guess again."; break;
		case 180 : $last = "with many grand ambitions."; break;
		case 181 : $last = "or tomorrow's lunch."; break;
		case 182 : $last = "it wields a sword with deadly skill."; break;
		case 183 : $last = "true leaders can inspire an entire army."; break;
		case 184 : $last = "within its eternal prison."; break;
		case 185 : $last = "not enough for both of us."; break;
		case 186 : $last = "requires inspiration of the darkest kind."; break;
		case 187 : $last = "mindlessly slaughtered by ghouls."; break;
		case 188 : $last = "life's only certainty."; break;
		case 189 : $last = "hear the demon's call."; break;
		case 190 : $last = "to satisfy his thirst for retribution."; break;
		case 191 : $last = "be sure as silver it will be your last."; break;
		case 192 : $last = "even if the hinterlands are lost."; break;
		case 193 : $last = "now only her shadow remains."; break;
		case 194 : $last = "a playground."; break;
	}
	$tmp = $first." ".$last;
	if (mt_rand(0,1)) {
		$tmp = "&ldquo;".$tmp."&rdquo;";
 		if (mt_rand(0,1)) $tmp = $tmp."<br>&mdash;".random_source($color);
 	}	
 	return $tmp;
}

function random_creature($color) {
 return random_creature_type($color,false,false);
}

function random_creatures($color) {
 return random_creature_type($color,false,true);
}

function a_random_creature($color) {
 return random_creature_type($color,true,false);
}

function random_enemy_creature($color) {
 return random_enemy_creature_type($color,false,false);
}

function random_enemy_creatures($color) {
 return random_enemy_creature_type($color,false,true);
}

function a_random_enemy_creature($color) {
 return random_enemy_creature_type($color,true,false);
}

//-------------------------------------------------------
// FUNCTION: random_enemy_creature_type
// Inputs:
//         $color   Creature color as word string ("white", ...) etc.
//         $a       True if definite form, false if indefinite form.
//                  Has no meaning if plural is true.
//         $plural  True if plural form, false if single form.
//--------------------------------------------------------
function random_enemy_creature_type($color,$a,$plural) {
 return random_creature_type(enemycolor($color),$a,$plural);
}


//-------------------------------------------------------
// FUNCTION: random_creature_type
// Inputs:
//         $color   Creature color as word string ("white", ...) etc.
//         $a       True if definite form, false if indefinite form.
//                  Has no meaning if plural is true.
//         $plural  True if plural form, false if single form.
//--------------------------------------------------------
function random_creature_type($color,$a,$plural) {
	if ($plural == false) {
	 if ($color == "white") {
 	  $type[] = "Human";
    $type[] = "Spirit";
	 }
   elseif ($color == "blue") {
    $type[] = "Zombie";
    $type[] = "Homunculus";
   }
   elseif ($color == "black") {
    $type[] = "Vampire";
    $type[] = "Zombie";
    $type[] = "Demon";
	  $type[] = "Skeleton";
   }
   elseif ($color == "red") {
    $type[] = "Elemental";
    $type[] = "Devil";
   }
   elseif ($color == "green") {
    $type[] = "Hound";
    $type[] = "Boar";
    $type[] = "Wolf";
   }
   $creature = $type[mt_rand(0,count($type)-1)]; 
   if( $a == true )	{
		if($creature[0] == 'E' || $creature[0] == 'A' || $creature[0] == 'O' || $creature[0] == 'U' || $creature[0] == 'I')	$creature = "an ".$creature;
		else $creature = "a ".$creature;
	  }
	 return $creature;
  }
  else if ($plural == true) {
   if ($color == "white") {
    $type[] = "Humans";
    $type[] = "Spirits";
	 }
   elseif ($color == "blue") {
    $type[] = "Zombies";
    $type[] = "Homunculi";
   }
   elseif ($color == "black") {
    $type[] = "Vampires";
    $type[] = "Zombies";
    $type[] = "Demons";
	  $type[] = "Skeletons";
   }
   elseif ($color == "red") {
    $type[] = "Elementals";
    $type[] = "Devils";
   }
   elseif ($color == "green") {
    $type[] = "Hounds";
    $type[] = "Boars";
    $type[] = "Wolves";
   }
   return $type[mt_rand(0,count($type)-1)];
  }
}

function random_enemy_color($color) {
	if ($color == "white") {
   $type[] = "black";
   $type[] = "red";
	}
  elseif ($color == "blue") {
   $type[] = "green";
   $type[] = "red";
  }
  elseif ($color == "black") {
   $type[] = "white";
   $type[] = "green";
  }
  elseif ($color == "red") {
   $type[] = "white";
   $type[] = "blue";
  }
  elseif ($color == "green") {
   $type[] = "black";
   $type[] = "blue";
  }
  return $type[mt_rand(0,count($type)-1)];
}

function random_source($color) {
	
	if ($color == "white") {
		switch(mt_rand(1,19)) {
	   case 1: return "Mikeus, the Lunarch";
	   case 2: return "Oath of Avacyn";
	   case 3: return "Ekatrin, Elder of Hanweir";
	   case 4: return "Zilla of Lambholt";
	   case 5: return "Master of the Elgaud Cathars";
	   case 6: return "Thalia, Knight-Cathar";
	   case 7: return "Bretta, midwife of Gatstaf";
	   case 8: return "Kolman, Elder of Gatstaf";
	   case 9: return "Hinrik of House Cecani";
	   case 10: return "Saint Trogen, the Slayer";
	   case 11: return "Cosper Lowe of the Silbern Guard";
	   case 12: return "Tomb inscription of Saint Raban";
	   case 13: return "Old Rutstein";
	   case 14: return "Vonn, geist-trapper";
	   case 15: return "Olgard of the Skiltfolk";
	   case 16: return "Constable Visil";
	   case 17: return "Bishop Argust";
	   case 18: return "Radulf, priest of Avacyn";
	   case 19: return "Olgard of the Skiltfolk";
		}
	}
  elseif ($color == "blue") {
   switch(mt_rand(1,6)) {
	   case 1: return "Stitcher Geralf";
	   case 2: return "Amalric of Midvast Hall";
	   case 3: return "Eruth of Lambholt";
	   case 4: return "Manfried Ulmach, Elgaud Master-at-Arms";
	   case 5: return "Captain Eberhart";
	   case 6: return "Ludevic, necro-alchemist";
	  }
  }
  elseif ($color == "black") {
   switch(mt_rand(1,12)) {
	   case 1: return "Enslow, ghoulcaller of Nephalia";
	   case 2: return "Hildin, priest of Avavyn";
	   case 3: return "Jadar, ghoulcaller of Nephalia";
	   case 4: return "Runo Stromkirk";
	   case 5: return "Liliana Vess";
	   case 6: return "Sorin Markov";
	   case 7: return "Minaldra, the Vizag Atum";
	   case 8: return "Aldreg, Skirsdag cultist";
	   case 9: return "Grafdigger Wulmer";
	   case 10: return "Old Rutstein";
	   case 11: return "Gisa, ghoulcaller of Gavony";
	   case 12: return "Odila, witch of Morkrut";
   }
  }
  elseif ($color == "red") {
   switch(mt_rand(1,7)) {
	   case 1: return "Thalia, Knight-Cathar";
	   case 2: return "Elmut, crossway watcher";
	   case 3: return "Runo Stromkirk";
	   case 4: return "Rem Karolus, Blade of the Inquisitors";
	   case 5: return "Minaldra, the Vizag Atum";
	   case 6: return "Olivia Voldaren";
	   case 7: return "Thalia, Knight-Cathar";
   }
  }
  elseif ($color == "green") {
   switch(mt_rand(1,9)) {
	   case 1: return "Wolfhunter's riddle";
	   case 2: return "Paulin, trapper of Somberwald";
	   case 3: return "Yonda of Gavony";
	   case 4: return "Wolfhunter's creed";
	   case 5: return "Kessig expression";
	   case 6: return "Rem Karolus, Blade of the Inquisitors";
	   case 7: return "Alena, trapper of Kessig";
	   case 8: return "Halana of Ulvenwald";
	   case 9: return "Garruk Wildspeaker";
   }
  }
}

function manasymbol($l)
{
	return "<img src='pics/symbol/mana".$l.".png' alt='".strtoupper($l)."'>";
}

function draw_cards($number) {
  if ($number > 1) $plural = "s";
  else $plural = "";
  return integer2word($number)." card".$plural;
}

function enchantment_paragraph($color,$name,$powerlevel) {
	return paragraph("enchantment",$color,$name); //TODO add powerlevel.
}

function curse_paragraph($color,$name,$powerlevel) {
	return paragraph("curse",$color,$name); //TODO add powerlevel.
}

function aura_paragraph($color,$name,$powerlevel) {
	return paragraph("aura",$color,$name); //TODO add powerlevel.
}

function instant_paragraph($color,$name,$powerlevel) {
	return paragraph("instant",$color,$name); //TODO add powerlevel.
}

function sorcery_paragraph($color,$name,$powerlevel) {
	return paragraph("sorcery",$color,$name); //TODO add powerlevel.
}

function static_ability($color,$name,$intext) {

	//TODO Replace this hardwritten ability with Markov chain

	if ($color == "white") {
		switch(mt_rand(1,4)) {
			case 1: $tmp = "protection from ".random_enemy_creatures($color); break;		
			case 2: $tmp = "vigilance"; break;
			case 3: $tmp = "flying"; break;
			case 4: $tmp = "flying, vigilance"; break;
		}
	}
	if ($color == "blue") {
		switch(mt_rand(1,3)) {
			case 1: $tmp = "protection from ".random_enemy_creatures($color); break;		
			case 2: $tmp = "flying"; break;
			case 3: $tmp = $name." is unblockable."; break;
			} 
	}
	if ($color == "black") {
		switch(mt_rand(1,5)) {
			case 1: $tmp = "protection from ".random_enemy_creatures($color); break;		
			case 2: $tmp = "intimidate"; break;		
			case 3: $tmp = "deathtouch"; break;	
			case 4: $tmp = "intimidate, deathtouch"; break;
			case 5: $tmp =$name." can&rsquo;t block."; break;		
		} 
	}
	if ($color == "red") {
		switch(mt_rand(1,4)) {
			case 1: $tmp = "protection from ".random_enemy_creatures($color); break;		
			case 2: $tmp = "haste"; break;
			case 3: $tmp = "trample"; break;				
			case 4: $tmp = "trample, haste"; break;				
		}
	}
	if ($color == "green") {
		switch(mt_rand(1,9)) {
			case 1: $tmp = "protection from ".random_enemy_creatures($color); break;		
			case 2: $tmp = "trample"; break;		
			case 3: $tmp = "deathtouch"; break;		
			case 4: $tmp = "shroud"; break;		
			case 5: $tmp = "trample, shroud"; break;		
			case 6: $tmp = "deathtouch, trample"; break;		
			case 7: $tmp = "shroud, deathtouch"; break;		
			case 8: $tmp = "trample, deathtouch"; break;
			case 9: $tmp = "defender"; break;
		}
	}	
	if ($intext) {
		if (
			strpos($tmp,"can&rsquo;t") ||
			strpos($tmp,"is") ||
			strpos($tmp,"is&rsquo;t") ||
			strpos($tmp,"can")
		)
			$tmp = "&lsquo;".$tmp."&rsquo;";
		return str_replace(","," and",str_replace(".","",$tmp));
	}
	else
		return $tmp;
}

function flashback($color) {
	return "Flashback ".generate_manacost(friendcolor($color),mt_rand(1,5))." <i>(You may cast this card from your graveyard for its flashback cost. Then exile it.)</i>";  	
}

function ability($color,$name) {
	
	//TODO replace this hardwritten ability with Markov chain
	switch(mt_rand(1,6)) {
		case 1: return keyword()." <i>(".WHENEVER("",$color,$name,true).".)</i>";
		case 2: return "<i>".keyword()."</i> &mdash; ".ucfirst(trim(EFFECT("",false,true,$color,$name,true))).".";
		case 3: return "<i>Fateful hour</i> &mdash; As long as you have 5 or less life, ".trim(EFFECT("",false,true,$color,$name,true)).".";
		case 4: return "Undying <i>(When this creature dies, if it had no +1/+1 counters on it, return it to the battlefield under its owner's control with a +1/+1 counter on it.)</i>";
	}
 switch(mt_rand(1,8)) {
 case 1: return "Resurrect ".generate_manacost(friendcolor($color),mt_rand(1,5))." <i>(You may cast this spell from your graveyard for its resurrection cost. When a resurrected creature dies, exile it instead.)</i>";
 case 2:  return "Undying <i>(When this creature dies, if it had no +1/+1 counters on it, return it to the battlefield under its owner's control with a +1/+1 counter on it.)</i>";
 case 3: return "<i>Funeral with Honors</i> &mdash; When this creature dies, players can't cast spells until end of turn.";
 case 4: return "<i>Fateful hour</i> &mdash; At the beginning of your upkeep, if you have less than 5 life, you may return ".$name." from your graveyard to the battlefield.";
 case 5: return "<i>Deathlink</i> &mdash; When ".$name." dies, you may sacrifice any number of creatures with combined power greater than ".$name.". If you do, return ".$name." to the battlefield.";
 case 6: return "Forceflash ".generate_manacost($color,mt_rand(4,6))." <i>(You may cast this spell for its forceflash cost as if it had flash.)</i>";
 case 7: return "<i>Relay race</i> &mdash; When this creature dies, you may return another target creature from your graveyard to the battlefield tapped.";
 case 8: return "Slowtrip <i>(If you cast this spell from your hand, draw an additional card at the beginning of your next draw step.)</i>";

 }
}

function mass($wording,$flavor) {
$d = 0;
if ($wording[1] != '') $d++;
if ($wording[2] != '') $d++;
if ($wording[3] != '') $d++;
if ($wording[4] != '') $d++;
if ($wording[5] != '') $d++;
if ($flavor != '') {
	$d++;
	if (strpos("<br>",$flavor)) $d++;
}
// Number of characters per row, approx. Tweak this
$t = (strlen($wording[0]) + strlen($wording[1]) + strlen($wording[2]) + strlen($wording[3])
	 + strlen($wording[4]) + strlen($flavor)) / 30;	
//	 echo "<p>Card is believed to have ".$t." lines of text and ".$d." paragraph spaces.</p>";
	 return $d*0.7 + $t*1.2;
}

echo "<head><title>GoodGamery's Avacyn Restored Exclusive Preview Card!</title><link rel='stylesheet' href='stylesheet.css'></head><body topmargin='0' bottommargin='0' link='7777EE' alink='7777EE' vlink='7777EE' ulink='7777EE'><center><br>";

// Defaults
$preview = false;
$iplock = false;
$seed = mt_rand(1000000,9999999);
//Art choice
if (isset($_GET['preview'])) {
	$preview = true;
}

//Particular card wanted?
if (isset($_GET['id']))
{
	$seed = $_GET['id'];
}
elseif (isset($_GET['iplock'])) {
	// ip-based seed
	$ip=str_replace(':','',str_replace('.', '', $_SERVER['REMOTE_ADDR']));
	$seed = $ip;
	$iplock = true;
}

// Seed generator with number
mt_srand($seed); 

$tmp = mt_rand(1,5);
if ($tmp == 1) $color = "white";
elseif ($tmp == 2) $color = "blue";
elseif ($tmp == 3) $color = "black";
elseif ($tmp == 4) $color = "red";
elseif ($tmp == 5) $color = "green";

if (isset($_POST['back'])) {
	$back = true;
	switch (mt_rand(1,15)) {
		case 1: $type = "back2.jpg"; break;
		case 2: $type = "back3.jpg"; break;
		case 2: $type = "back4.jpg"; break;
		case 3: $type = "back5.jpg"; break;
		default: $type = "back.jpg"; break;
	}
}
else {
	$back = false;

	if (isset($_POST['transform'])) {
		$transform = true;
		$cardtype = "creature";
		//throw off randomizer here
	}
	else {
		$transform = false;
		if (mt_rand(0,1)) $cardtype = "spell";
		else $cardtype = "creature";
	}
	
	
	$name = random_name($color,$cardtype);
	$cmc = mt_rand(1,5);
	if (!$transform) $manacost = generate_manacost($color, $cmc);

	
	$type = $color;
	$wr = 0; // Word Row counter
	$powerlevel = 0;
	
	// HOMELANDS ART.
	//"placeholder"; // Fix this when AVR art is spoiled
	if (!$preview) {
		switch ($color) {
			case "black": $art = "homelands/".mt_rand(1,25).".png"; break;// BLACK 
			case "blue": $art = "homelands/".mt_rand(26,50).".png"; break;// BLUE
			case "green": $art = "homelands/".mt_rand(51,75).".png"; break;// GREEN
			case "red": $art = "homelands/".mt_rand(76,100).".png"; break;// RED
			case "white":	$art = "homelands/".mt_rand(101,125).".png"; break;// WHITE
		}
	}
	else
	{
		$art = "spell".mt_rand(1,7).".jpg"; // Any spell
	}
	
	// CREATURE!!

	if ($cardtype == "creature") {
	
		if ($transform) {
			$pow = $_POST['pow'];
			$tough = $_POST['tough'];
			$werewolf_pow = $_POST['werewolf_pow'];
			$werewolf_tough = $_POST['werewolf_tough'];
			switch ($color) {
				case "white":	$typeline = "       Creature - Demon"; break;//Werewolf"; break;
				case "blue":	$typeline = "       Creature - Demon"; break;//Zombie"; break;
				case "black":	$typeline = "       Creature - Demon"; break;
				case "red":	$typeline = "       Creature - Demon"; break;//Werewolf"; break;
				case "green":	$typeline = "       Creature - Demon"; break;//Werewolf"; break;
			}
			// Fix art
			if ($preview) {
				switch(mt_rand(1,3)) {
					case 1: $art = "demon1"; break;
					case 2: $art = "skeleton"; break;
					case 3: $art = "zombie"; break;
				}
				$art = $art.".jpg";
			}
			$type = $type."night";
		}
		else {
		$typeline = "Creature - ".creature_type($color,$name);
			$pow = mt_rand(1,$cmc/2);
			$tough = max(1,mt_rand(1,$cmc/2+1-mt_rand(1,$pow/2)));
			if ($color == "white") $tough = $tough + mt_rand(0,$cmc/2);
		  elseif ($color == "blue") $pow = max(1,$pow + mt_rand(-1,0));
		  elseif ($color == "black") $pow = $pow + mt_rand(0,$cmc/2);
		  elseif ($color == "red") ;
		  elseif ($color == "green") {
		   $pow = $pow + mt_rand(0,$cmc/2);
		   $tough = $tough + mt_rand(0,$cmc/2);	
		  };
		
			// Werewolf?
			if (mt_rand(1,5) == 1) {
				$werewolf = true;
				$werewolf_pow = $pow + mt_rand(1,5);
				$werewolf_tough = $tough + mt_rand(1,5);
			}
			else $werewolf = false;
		}
		if ($werewolf) {
			$type = $type."day";
			if (strpos($typeline,"Werewolf"))	$werewolf = true;	
			elseif (($color == "white" || $color == "red" || $color == "green") && strlen($typeline) < 23	) {
				$typeline = $typeline." Werewolf";
			}
		}
		elseif (!$transform) $type = $type."pt";
	
			$flavor = random_flavor($color); 
			$pt = $pow."/".$tough; 
			//$powerlevel = ($pow*1.5+$tough)+1/(cmc($manacost)+1);
	
	
			// Add static creature ability
			if (!$transform) {
					$tmp = ability($color,$name);
					if (strpos($name, "Seakite") ||
							strpos($name, "Angel") ||
							strpos($name, "Griffin") ||
							strpos($name, "Dragon" ||
							strpos($typeline, "Angel")))
						if (!strpos(strtolower($tmp),"flying")) {	$wording[$wr] = "Flying";	$wr++; }
					$wording[$wr] = $tmp;	$wr++;
					$powerlevel++;
			}
			
			// Paragraph
			elseif (mt_rand(0,1)) {
					if ($color == "green" && mt_rand(0,1)) {
											// Add mana ability
					switch(mt_rand(1,14)) {
						case 0:
							$wording[$wr] = "{1}, {T}: Add ".mana($color)." to your mana pool. At the beginning of your next end step, untap ".$name.".";
							break;
						case 1:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. ".$name." deals ".mt_rand(1,2)." damage to you.";
							break;
						case 2:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. ".$name." doesn&rsquo;t untap during your next untap step.";
							break;
						case 3:
							$wording[$wr] = "{1}, {T}: Add ".mana($color).mana($color)." to your mana pool. ".$name." deals 1 damage to you.";
							break;
						case 4:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "{T}: Add {2} to your mana pool. Put ".$name." on top of your library.";
							break;
						case 5:
							$wording[$wr] = mana($color).", {T}: Add ".mana($color).mana($color)."  to your mana pool.";
							break;
						case 6:
							$wording[$wr] = mana($color).", {T}: Add ".mana($color).mana($color)."  to your mana pool.";
							break;
						case 7:
							$wording[$wr] = "{T}: Add {1} to your mana pool."; $wr++;
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. Each opponent gains 1 life.";
							break;
						case 8:
							$wording[$wr] = "{T}, Pay 1 life: Add ".mana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "{1}, {T}, Sacrifice ".$name.": Draw a card.";
							break;
						case 9:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. Activate this ability only if you control ".a(basic_land($color)).".";
							break;
						case 10:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. If you played a land this turn, add {2} to your mana pool instead, then return ".$name." to your hand.";
							break;
						case 11:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool.</p><p>Sacrifice ".$name.": Add ".bothmana($color)." to your mana pool.";
							break;
						case 12:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "Put ".$name." on top of your library: Add {1} to your mana pool.";
							break;
						case 13:
							$wording[$wr] = "When $name enters the battlefield, put a land you control on the bottom of its owner's library."; $wr++;
							$wording[$wr] = "{T}: Add ".bothmana($color)." to your mana pool.";
							break;
						case 14:
							$wording[$wr] = "{T}: Add ".bothmana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "Return ".$name." to its owner&rsquo;s hand";
							break;
					}
					$wr++;
					}
					else 
					$wording[$wr] = ucfirst(static_ability($color,$name,false));	$wr++;
			}
	
		// Set masslevel
		$masslevel = 7.5;
	
		if (mt_rand(0,2) && !$werewolf && $wording[$wr-1] != "Flying"&& $wording[$wr-2] != "Flying") {
				if (strpos(" ".$name, "Seakite") ||
						strpos(" ".$name, "Angel") ||
						strpos(" ".$name, "Griffin") ||
						strpos(" ".$name, "Dragon"))
						{ $wording[$wr] = "Flying";	$wr++; $powerlevel++;}
				if (mass($wording,"") < $masslevel) $wording[$wr] = paragraph("creature",$color,$name); $wr++;
				
		}
		
		// Fix art
		if ($preview) {
			if (strpos(" ".$typeline, "Dragon")) $art = "dragon".mt_rand(1,4).".jpg";
			elseif (strpos(" ".$typeline, "Angel")) $art = "angel".mt_rand(1,3).".jpg";
			elseif (strpos(" ".$typeline, "Human")) $art = "human".mt_rand(1,3).".jpg";
			elseif (strpos(" ".$typeline, "Shaman")) $art = "human3.jpg";
			elseif (strpos(" ".$typeline, "Hound")) $art = "wolf.jpg";				
			elseif (strpos(" ".$typeline, "Boar")) $art = "boar.jpg";
			elseif (strpos(" ".$typeline, "Elk")) $art = "elk.jpg";
			elseif (strpos(" ".$typeline, "Bear")) $art = "bear.jpg";				
			elseif (strpos(" ".$typeline, "Bird")) $art = "bird.jpg";	
			elseif (strpos(" ".$typeline, "Wolf")) $art = "wolf.jpg";				
			elseif (strpos(" ".$typeline, "Vampire")) $art = "human".mt_rand(1,3).".jpg";
			elseif (strpos(" ".$typeline, "Skeleton")) $art = "skeleton.jpg";				
			elseif (strpos(" ".$typeline, "Spirit")) $art = "spirit.jpg";				
			elseif (strpos(" ".$typeline, "Zombie")) $art = "skeleton.jpg";				
			elseif (strpos(" ".$typeline, "Demon")) $art = "demon1.jpg";				
			elseif (strpos(" ".$typeline, "Wurm")) $art = "wurm.jpg";				
			elseif (strpos(" ".$typeline, "Devil")) $art = "devil.jpg";				
			elseif (strpos(" ".$typeline, "Homunculus")) $art = "humonculus.jpg";			
			elseif (strpos(" ".$typeline, "Cat")) $art = "cat.jpg";			
			elseif (strpos(" ".$typeline, "Elemental")) $art = "elemental.jpg";		
		}	
		
		if ($werewolf) { 		// Add werewolf ability
					$wording[$wr] = werewolf_paragraph($color,$name);	$wr++;
		}
		elseif ($transform && mt_rand(0,1)) { 		// Add transform ability
					$wording[$wr] = transform_paragraph($color,$name);	$wr++;
		}
	
	
	}
	
	// SORCERY AND INSTANT !!
	else {
		// Power level of ability randomly determined
		$pt = "";
		switch(mt_rand(1,12)) {
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
				$typeline = "Instant";	
				$wording[$wr] = instant_paragraph($color,$name,$powerlevel); $wr++;
				if(mt_rand(-5,1) && mass($wording,$flavor) < $masslevel) {
			 		$wording[$wr] = instant_paragraph($color,$name,$powerlevel); $wr++;
				}
				elseif(mt_rand(-5,1) && mass($wording,$flavor) < $masslevel) {
			 		$wording[$wr] = flashback($color); $wr++;
				}
				break;
				
			case 6:
			case 7:
				$typeline = "Sorcery";
				$wording[$wr] = sorcery_paragraph($color,$name,$powerlevel); $wr++;
				if (mt_rand(1,1) == 1 && mass($wording,$flavor) < $masslevel) { //TODO add length checker here!!
			 		$wording[$wr] = sorcery_paragraph($color,$name,$powerlevel); $wr++;
				}
				elseif (mt_rand(1,5) == 1 && mass($wording,$flavor) < $masslevel) { //TODO add length checker here!!
			 		$wording[$wr] = flashback($color); $wr++;
				}
				break;
			case 8:
				$typeline = "Enchantment";
			 		$wording[$wr] = enchantment_paragraph($color,$name,$powerlevel); $wr++;
			case 9:	
			case 10:
				// Special case...				
				$typeline = "Artifact";
				$type = "artifact";
				$cardtype = "artifact";
				$name = random_name("",$type); 
				$manacost = "{".$cmc."}";
			 	$wording[$wr] = paragraph("artifact",$color,$name,$powerlevel); $wr++;
			 	if ($preview) $art = "artifact".mt_rand(1,6).".jpg";
			 	else $art = "homelands/".mt_rand(131,135).".png";
			 	break;
			case 11:
			case 12:
				// Special case....
				$typeline = "Land";
				$type = "land";
				$cardtype = "land";
				$name = random_name("","land"); 
				$manacost = "";
				if (mt_rand(0,1)) {
					// Add drawback
					if (mt_rand(0,1)) {
						$wording[$wr] = $name." enters the battlefield tapped.";
						$wr++;
					}
					
					// Add mana ability
					switch(mt_rand(1,14)) {
						case 0:
							$wording[$wr] = "{1}, {T}: Add ".mana($color)." to your mana pool. At the beginning of your next end step, untap ".$name.".";
							break;
						case 1:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. ".$name." deals ".mt_rand(1,2)." damage to you.";
							break;
						case 2:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. ".$name." doesn&rsquo;t untap during your next untap step.";
							break;
						case 3:
							$wording[$wr] = "{1}, {T}: Add ".mana($color).mana($color)." to your mana pool. ".$name." deals 1 damage to you.";
							break;
						case 4:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "{T}: Add {2} to your mana pool. Put ".$name." on top of your library.";
							break;
						case 5:
							$wording[$wr] = mana($color).", {T}: Add ".mana($color).mana($color)."  to your mana pool.";
							break;
						case 6:
							$wording[$wr] = mana($color).", {T}: Add ".mana($color).mana($color)."  to your mana pool.";
							break;
						case 7:
							$wording[$wr] = "{T}: Add {1} to your mana pool."; $wr++;
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. Each opponent gains 1 life.";
							break;
						case 8:
							$wording[$wr] = "{T}, Pay 1 life: Add ".mana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "{1}, {T}, Sacrifice ".$name.": Draw a card.";
							break;
						case 9:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. Activate this ability only if you control ".a(basic_land($color)).".";
							break;
						case 10:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool. If you played a land this turn, add {2} to your mana pool instead, then return ".$name." to your hand.";
							break;
						case 11:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool.</p><p>Sacrifice ".$name.": Add ".bothmana($color)." to your mana pool.";
							break;
						case 12:
							$wording[$wr] = "{T}: Add ".mana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "Put ".$name." on top of your library: Add {1} to your mana pool.";
							break;
						case 13:
							$wording[$wr] = "When $name enters the battlefield, put a land you control on the bottom of its owner's library."; $wr++;
							$wording[$wr] = "{T}: Add ".bothmana($color)." to your mana pool.";
							break;
						case 14:
							$wording[$wr] = "{T}: Add ".bothmana($color)." to your mana pool."; $wr++;
							$wording[$wr] = "Return ".$name." to its owner&rsquo;s hand";
							break;
					}
					$wr++;
				}
				else {
					// Simple land, no drawback
					$wording[$wr] = "{T}: Add {1} to your mana pool."; $wr++;
				}
			 	$wording[$wr] = paragraph("land",$color,$name,$powerlevel); $wr++;
			 	if ($preview) $art = "land".mt_rand(1,10).".jpg";
			 	else $art = "homelands/".mt_rand(136,140).".png";
			 	// Set color or colorless frame
				$colorsymbol = false;
				$tmp = $wr;
				while ($tmp--)
					if (strpos(" ".$wording[$tmp],"{".one_letter_color($color)."}"))
						$colorsymbol = true;
				if ($colorsymbol)	$type = $color."land";
		}
			
		// Check if flavor can fit
		if(!mt_rand(0,2) && mass($wording,$flavor) < $masslevel)
	 	$flavor = random_flavor($color); 
		
	}
	
	if ($transform) $rarity = $_POST['rarity'];
	else {
		$rarity = "common";
		if ($cardtype == "creature") $powerlevel = $powerlevel + ($pow+$tough+$wr)/($cmc*2);
		elseif ($cardtype == "land") $powerlevel = $wr;
		else $powerlevel = $wr*2/cmc($manacost);
		//echo "Power level: ".$powerlevel."<br>";	
		if ($powerlevel > 1) $rarity = "uncommon";
		if ($powerlevel > 2) $rarity = "rare";
		if ($powerlevel > 3) $rarity = "mythicrare";	
	}
	if (
		($rarity == "mythicrare" || $rarity == "rare") &&
		mt_rand(0,1) == 1 &&
		($cardtype == "creature" || $cardtype == "artifact" || $cardtype == "land") &&
		strlen($typeline) < 23
		) {
		$typeline = "Legendary ".$typeline;
	}
	$artist = artist();
	
	//Automatic font size!
	$mass = mass($wording,$flavor);
	//echo "<p>Approx. number of rows of text (with flavor): ".($mass)."</p>";	
	if (($mass) > 9.5) $tempfontsize = 13;
	if (($mass) > 10) {
	//	echo "<p>Mass: ".$mass."</p>";
		//echo "<p>Removing flavor because of lack of space.";// Flavor was:<br> <i>".$flavor."</i>";
	  $flavor = "";
	  $mass = mass($wording,$flavor);
	
	  	// Check if text fits card
		if(mass($wording,$flavor) > 14) { $wr--; $wording[$wr] = "";}
	
	  $mass = mass($wording,$flavor);
	  if ($mass > 9.5) $tempfontsize = 13;
	  else $tempfontsize = 14;
	}
	else {
		$tempfontsize = 14;
	}
	if ($tempfontsize == 14) {
		if (count($wording) == 1 && strlen($wording[0]) < 50 && $flavor == "") $tempcenter = 1;
		else $tempcenter = 0;	
	}
}

if (!$back) {
	echo "<table border='0' cellspacing='0' cellpadding='8' width='328' height='459' background='pics/bigframe.png'><tr><td valign='top'><table border='0' cellspacing='0' cellpadding='0' width='312' height='443' background='pics/art/".$art."'><tr><td valign='top'>\n
	<table border='0' bordercolor='#ff0000' cellspacing='0' cellpadding='0' width='312' height='443' background='pics/frames/".$type.".png'><tr><td valign='top' width='312' height='20' colspan='3'></td></tr>\n
	<tr><td width='22' height='*'></td><td width='269' height='403' valign='top'>\n
	\n
	<table border='0' bordercolor='#00ff00' cellspacing='0' cellpadding='0' width='269' height='403'>\n
		<tr><td valign='top' height='21'>
	<table border='0' cellspacing='0' cellpadding='0' height='21' width='268'><tr><td width='*'>";
	if ($werewolf || $transform) 
		echo("<table border='0' cellspacing='0' cellpadding='1'><tr><td>".printer("       ".$name, 'normal',$transform)."</td></tr></table>");
	else
		echo("<table border='0' cellspacing='0' cellpadding='1'><tr><td>".printer($name, 'normal',$transform)."</td></tr></table>");
	
	if ($transform) echo "</td></tr></table></td></tr><tr><td height='210'>";
	else echo "</td><td align='right' width='".(15*strlen($manacost))."'>".manacost($manacost)."</td></tr></table></td></tr><tr><td height='210'>";
	
	
	// Werewolf PT
	if ($werewolf) echo "<div id='transformpt' align='right'>".printer($werewolf_pow."/".$werewolf_tough, 'small',false)."</div>";
	
	
	echo "</td></tr>
		<tr><td height='18' valign='bottom'>
		<table border='0' cellspacing='0' cellpadding='0' height='0' width='268'><tr><td width='*' valign='bottom'>";
	echo("<table border='0' cellspacing='0' cellpadding='2'><tr><td>".printer($typeline, 'typeline',$transform)."</td></tr></table>");
	
	echo"</td><td width='22' valign='right'><img src='pics/set/".$rarity.".png' align='right' alt=' (Rare)'></td></tr>
	</td></tr></table><tr><td height='5'></td></tr><tr><td height='125'><table height='125' border='0' width='267' cellspacing='0' cellpadding='1'><tr><td><font style='line-height:100%; font-size: ".$tempfontsize."px;' face='Plantin,Mplantin,Georgia,Arial,Times New Roman'>";
	
	
	// Oracle text
	if ($tempcenter == 1) echo "<center>";
	if ($wording[0] != '') echo "<p style='margin-top: 2px;'>".parse($wording[0],$tempfontsize)."</p>";
	if ($tempcenter == 1) echo "</center>";
	for ($i = 1; $i < 5; $i++) {
		if ($wording[$i] != '') echo "<p style='margin-top: 6px;'>".parse($wording[$i],$tempfontsize)."</p>";
	}
	if ($flavor != '') {
		if ($wording[0] != '') echo "<p style='margin-top: 10px'><i>".$flavor."</i></p>";
		else echo "<p><i>".$flavor."</i></p>";
	}
	
	// Clean up the end of the rules text
	echo "</font></td></tr></table></td></tr><tr><td height='20'>
	<table border='0' cellspacing='0' cellpadding='0' height='20' width='268'><tr><td width='*' valign='top'>
	<img src='pics/whitefont/space.png' width='23' height='20'>";
	
	if ($type == 'black' || $type == 'blackpt' || strpos(" ".$type,"land") || $type == 'blackday' || $type == 'blacknight')	echo(printer($artist,'white',false));
	else echo(printer($artist,'black',false));
	
	echo("<img src='pics/whitefont/space.png' width='100' height='20'></td><td width='46' align='center'>".((isset($pt) && $pt != '') ?printer($pt, 'normal',$transform) : printer(' ','normal',$transform))."</td></tr></table>");
	
	echo("</td></tr></table></td><td width='22' height='*'></td></tr><tr><td valign='top' width='312' height='*' colspan='3'></td></tr></table></td></tr></table></tr></td></table></td>");
}
else { // if ($back), that is.
		echo "<table border='0' cellspacing='0' cellpadding='8' width='328' height='459' background='pics/bigframe.png'><tr><td valign='top'><img src='pics/frames/".$type."'></td></tr></table></td></tr></table></td>";
}

mt_srand((double)(microtime() * 1000003));
$seedNext = mt_rand(1000000,9999999);

// Convert flags to strings
if ($iplock) $iplock = "&iplock";
else $iplock = "";
if ($preview) $preview = "&preview";
else $preview = "";

if ($werewolf) {
	echo "<p><form method='POST' action='index.php?id=".$seed.$preview.$iplock."' name='transform'>";

	echo "<input type='hidden' name='transform'>
	<input type='hidden' name='rarity' value='".$rarity."'>
	<input type='hidden' name='pow' value='".$werewolf_pow."'>
	<input type='hidden' name='tough' value='".$werewolf_tough."'>
	<input type='hidden' name='werewolf_pow' value='".$pow."'>
	<input type='hidden' name='werewolf_tough' value='".$tough."'>
	<input type='submit' value='Flip card!'>
	</form></p>";
	}
elseif ($transform) {
	echo "<p><form method='POST' action='index.php?id=".$seed.$preview.$iplock."' name='werewolf'>";
	echo "<input type='submit' value='Flip card!'></form></p>";
}
elseif ($back && !$preview) { echo "
	<p><form method='POST' action='index.php?id=".$seed.$preview.$iplock."'>
	<input type='submit' value='Flip card!'>
	</form></p>	
";}
elseif (!$preview) { echo "
	<p><form method='POST' action='index.php?id=".$seed.$preview.$iplock."' name='back'>
	<input type='hidden' name='back'>
	<input type='submit' value='Flip card!'>
	</form></p>	
";}

if (!$preview) {
	echo ("<p><a href='index.php?id=".$seedNext."'><img src='pics/button.png' border='0' alt='Generate another'></a></p><p><a href='index.php?id=".$seed.($insaneMode?"&insane":"")."'>Share this card!</a></p>");
	
	if (!$back) {
		echo "<table width='400'><tr><td><font size=2 color='grey'><b>Oracle text</b></font></td></tr><tr><td><font size=2 color='grey'>";
		echo $name." {".strtoupper(str_replace("{","",str_replace("}","",$manacost)))."} |".$typeline."| ".$pt." ";
		$wLen = count($wording);
		for ($i = 0; $i < $wLen; $i++) {
			if ($wording[$i] != '') echo str_replace("{","",str_replace("}","",str_replace("{T}","Tap",$wording[$i])));
			if (i+1 < $wLen && $wording[$i+1] != '') echo " / ";
		}
	}
}
echo "</font></td></tr></table>";

?>


</center>
</body>
</html>