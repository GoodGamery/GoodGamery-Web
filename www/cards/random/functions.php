<?php

// Insane crazy mode
function insane()
{
	return isset($_GET['insane']);
}

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

function fontshrink()
{
	return "<style>.ability {font-size:12px;}</style>";
}

function manasymbol($l)
{
	return "<img src='pics/symbol/mana".$l.".png' alt='".strtoupper($l)."'>";
}

function letterize($c1, $c2)
{
	return fix(letter($c1).letter($c2));
}

function mcsymbol($c)
{
	return manasymbol(letter($c));
}

function tapsymbol()
{
	return "<img src='pics/symbol/tap.png' alt='Tap'>";
}

function bothmana($c1, $c2)
{
	$input = letterize($c1, $c2);
	switch($input) {
		case 'wu': $output = manasymbol('w').manasymbol('u'); break;
		case 'ub': $output = manasymbol('u').manasymbol('b'); break;
		case 'br': $output = manasymbol('b').manasymbol('r'); break;
		case 'rg': $output = manasymbol('r').manasymbol('g'); break;
		case 'gw': $output = manasymbol('g').manasymbol('w'); break;
		case 'wb': $output = manasymbol('w').manasymbol('b'); break;
		case 'bg': $output = manasymbol('b').manasymbol('g'); break;
		case 'gu': $output = manasymbol('g').manasymbol('u'); break;
		case 'ur': $output = manasymbol('u').manasymbol('r'); break;
		case 'rw': $output = manasymbol('r').manasymbol('w'); break;
		default: $output = $input;
	}
	return $output;
}

function eithermana($c1, $c2)
{
	$input = letterize($c1, $c2);
	switch($input) {
		case 'wu': $output = manasymbol('w')." or ".manasymbol('u'); break;
		case 'ub': $output = manasymbol('u')." or ".manasymbol('b'); break;
		case 'br': $output = manasymbol('b')." or ".manasymbol('r'); break;
		case 'rg': $output = manasymbol('r')." or ".manasymbol('g'); break;
		case 'gw': $output = manasymbol('g')." or ".manasymbol('w'); break;
		case 'wb': $output = manasymbol('w')." or ".manasymbol('b'); break;
		case 'bg': $output = manasymbol('b')." or ".manasymbol('g'); break;
		case 'gu': $output = manasymbol('g')." or ".manasymbol('u'); break;
		case 'ur': $output = manasymbol('u')." or ".manasymbol('r'); break;
		case 'rw': $output = manasymbol('r')." or ".manasymbol('w'); break;
		default: $output = $input;
	}
	return $output;
}

function printer($title,$small) {
	$result = '';
	if ($small == true) $small = 's';
	else $small = '';
	for ($i = 0; $i < strlen($title); $i++) {
		$k = substr($title,$i,1);
		if (ctype_upper($k)) $result = $result."<img src='pics/".$small."font/c/".$k.".png' alt='".$k."'>";
		else if ($k == ' ') $result = $result."<img src='pics/".$small."font/space.png' alt=' '>";		
		else if ($k == '-') $result = $result."<img src='pics/font/shortdash.png' alt='-'>";		
		else if ($k == '.') $result = $result."<img src='pics/sfont/dot.png' alt='-'>";		
		else $result = $result."<img src='pics/".$small."font/s/".$k.".png' alt='".$k."'>";	
	}
	return $result;
}

function arandomcreaturebycolor($c, $a, $plural)
{
	$WCreatures;
	$UCreatures;
	$BCreatures;
	$RCreatures;
	$GCreatures;
	$XCreatures;
	$ins = insane();
	if( $plural )
	{
		$WCreatures = array('Soldiers', 'Clerics', 'Birds', 'Citizens', 'Knights', 'Kor', 'Angels', 'Spirits');
		$UCreatures = array('Wizards', 'Merfolk', 'Faeries', 'Fish', 'Crabs', 'Cephalids', 'Shapeshifters', 'Illusions');
		$BCreatures = array('Zombies', 'Skeletons', 'Horrors', 'Rogues', 'Specters', 'Rats', 'Wizards', 'Clerics');
		$RCreatures = array('Goblins', 'Dwarves', 'Beasts', 'Apes', 'Shamans', 'Giants', 'Elementals', 'Trolls', 'Ogres', 'Orcs');
		$GCreatures = array('Elves', 'Treefolk', 'Squirrels', 'Leeches', 'Stags', 'Beasts', 'Snakes', 'Bears');
		$XCreatures = array('Golems', 'Constructs', 'Myr');
		
		if( insane() )
		{
			$WCreatures[] = 'Cats';
			$UCreatures[] = 'Moonfolk';
			$BCreatures[] = 'Gremlins';
			$RCreatures[] = 'Ponies';
			$GCreatures[] = 'Ouphes';
		}
	}
	else
	{
		$WCreatures = array('Soldier', 'Cleric', 'Bird', 'Citizen', 'Knight', 'Kor', 'Angel', 'Spirit');
		$UCreatures = array('Wizard', 'Merfolk', 'Faerie', 'Fish', 'Crab', 'Cephalid', 'Shapeshifter', 'Illusion');
		$BCreatures = array('Zombie', 'Skeleton', 'Horror', 'Rogue', 'Specter', 'Rat', 'Wizard', 'Cleric');
		$RCreatures = array('Goblin', 'Dwarf', 'Beast', 'Ape', 'Shaman', 'Giant', 'Elemental', 'Troll', 'Ogre', 'Orc');
		$GCreatures = array('Elf', 'Treefolk', 'Squirrel', 'Leech', 'Stag', 'Beast', 'Snake', 'Bear');
		$XCreatures = array('Golem', 'Construct', 'Myr');
		
		if( insane() )
		{
			$WCreatures[] = 'Cat';
			$UCreatures[] = 'Moonfolk';
			$BCreatures[] = 'Gremlin';
			$RCreatures[] = 'Pony';
			$GCreatures[] = 'Ouphe';
		}
	}

	$creature = "FAILURE: " . $c . $a;
	
	switch($c)
	{
		case 1: $creature = $WCreatures[mt_rand(0,count($WCreatures)-1)]; break;
		case 2: $creature = $UCreatures[mt_rand(0,count($UCreatures)-1)]; break;
		case 3: $creature = $BCreatures[mt_rand(0,count($BCreatures)-1)]; break;
		case 4: $creature = $RCreatures[mt_rand(0,count($RCreatures)-1)]; break;
		case 5: $creature = $GCreatures[mt_rand(0,count($GCreatures)-1)]; break;
		default: $creature = $XCreatures[mt_rand(0,count($XCreatures)-1)]; break;
	}
	
	$creature2 = "FAILURE: " . $c . $a;
	if( mt_rand(1,5) == 1 )
	{
		switch($c)
		{
			case 1: $creature2 = $WCreatures[mt_rand(0,count($WCreatures)-1)]; break;
			case 2: $creature2 = $UCreatures[mt_rand(0,count($UCreatures)-1)]; break;
			case 3: $creature2 = $BCreatures[mt_rand(0,count($BCreatures)-1)]; break;
			case 4: $creature2 = $RCreatures[mt_rand(0,count($RCreatures)-1)]; break;
			case 5: $creature2 = $GCreatures[mt_rand(0,count($GCreatures)-1)]; break;
			default: $creature2 = $XCreatures[mt_rand(0,count($XCreatures)-1)]; break;
		}
		
		if( $creature2 != $creature )
		{
			$creature = $creature . " " . $creature2;
		}
	}
	
	if( $a == true )
	{
		if($creature[0] == 'E' || $creature[0] == 'A' || $creature[0] == 'O' || $creature[0] == 'U' || $creature[0] == 'I')
		{
			$creature = "an ".$creature;
		}
		else
		{
			$creature = "a ".$creature;
		}
	}
	
	return $creature;
}

function arandompermanent($c)
{
	$randomthing[] = arandomcreaturebycolor($c, true, false);
	$randomthing[] = arandomcreaturebycolor($c, true, false);
	$randomthing[] = arandomcreaturebycolor($c, true, false);
	$randomthing[] = arandomcreaturebycolor($c, true, false);
	$randomthing[] = 'a creature';
	$randomthing[] = 'a creature';
	$randomthing[] = 'an artifact';
	$randomthing[] = 'an enchantment';
	$randomthing[] = 'a planeswalker';
	$randomthing[] = 'a land';
	$randomthing[] = 'a basic land';
	$randomthing[] = 'a nonbasic land';
	$randomthing[] = 'an artifact creature';
	$randomthing[] = 'an artifact land';
	$randomthing[] = 'a '.colorword($c, false).' permanent';
	$randomthing[] = 'a '.colorword($c, false).' permanent';
	$randomthing[] = 'a multicolored permanent';
	$randomthing[] = 'a multicolored permanent';
	$randomthing[] = 'a monocolored permanent';
	$randomthing[] = 'a colorless permanent';
	return $randomthing[mt_rand(0,count($randomthing)-1)];	
}

function randompermanent($c)
{
	$randomthing[] = arandomcreaturebycolor($c, false, false);
	$randomthing[] = arandomcreaturebycolor($c, false, false);
	$randomthing[] = arandomcreaturebycolor($c, false, false);
	$randomthing[] = arandomcreaturebycolor($c, false, false);
	$randomthing[] = 'creature';
	$randomthing[] = 'artifact';
	$randomthing[] = 'enchantment';
	$randomthing[] = 'planeswalker';
	$randomthing[] = 'land';
	$randomthing[] = 'basic land';
	$randomthing[] = 'nonbasic land';
	$randomthing[] = 'artifact creature';
	$randomthing[] = 'artifact land';
	$randomthing[] = colorword($c, false).' permanent';
	$randomthing[] = colorword($c, false).' permanent';
	$randomthing[] = 'multicolored permanent';
	$randomthing[] = 'monocolored permanent';
	$randomthing[] = 'colorless permanent';
	return $randomthing[mt_rand(0,count($randomthing)-1)];	
}

function randompermanents($c)
{
	$randomthing[] = 'creatures';
	$randomthing[] = 'artifacts';
	$randomthing[] = 'enchantments';
	$randomthing[] = 'planeswalkers';
	$randomthing[] = arandomcreaturebycolor($c, false, true);
	$randomthing[] = arandomcreaturebycolor($c, false, true);
	$randomthing[] = arandomcreaturebycolor($c, false, true);
	$randomthing[] = arandomcreaturebycolor($c, false, true);
	$randomthing[] = 'creatures';
	$randomthing[] = 'creatures';
	$randomthing[] = 'lands';
	$randomthing[] = 'creatures';
	$randomthing[] = 'creatures';
	$randomthing[] = 'basic lands';
	$randomthing[] = 'nonbasic lands';
	$randomthing[] = 'artifact creatures';
	$randomthing[] = 'artifact lands';
	$randomthing[] = colorword($c, false).' permanents';
	$randomthing[] = colorword($c, false).' permanents';
	$randomthing[] = 'multicolored permanents';
	$randomthing[] = 'multicolored permanents';
	$randomthing[] = 'monocolored permanents';
	$randomthing[] = 'colorless permanents';
	return $randomthing[mt_rand(0,count($randomthing)-1)];	
}


function randomcard($c)
{
	$randomthing[] = arandomcreaturebycolor($c, true, false).' card';
	$randomthing[] = arandomcreaturebycolor($c, true, false).' card';
	$randomthing[] = arandomcreaturebycolor($c, true, false).' card';
	$randomthing[] = arandomcreaturebycolor($c, true, false).' card';
	$randomthing[] = 'a creature card';
	$randomthing[] = 'an artifact card';
	$randomthing[] = 'an enchantment card';
	$randomthing[] = 'a planeswalker card';
	$randomthing[] = 'a land card';
	$randomthing[] = 'a basic land card';
	$randomthing[] = 'a nonbasic land card';
	$randomthing[] = 'an artifact creature card';
	$randomthing[] = 'an artifact land card';
	$randomthing[] = 'a '.colorword($c, false).' card';
	$randomthing[] = 'a '.colorword($c, false).' card';
	$randomthing[] = 'a multicolored card';
	$randomthing[] = 'a multicolored card';
	$randomthing[] = 'a monocolored card';
	$randomthing[] = 'a colorless card';
	return $randomthing[mt_rand(0,count($randomthing)-1)];	
}

function randomcards($c)
{
	$randomthing[] = arandomcreaturebycolor($c, false, false).' cards';
	$randomthing[] = arandomcreaturebycolor($c, false, false).' cards';
	$randomthing[] = arandomcreaturebycolor($c, false, false).' cards';
	$randomthing[] = arandomcreaturebycolor($c, false, false).' cards';
	$randomthing[] = 'creature cards';
	$randomthing[] = 'artifact cards';
	$randomthing[] = 'enchantment cards';
	$randomthing[] = 'planeswalker cards';
	$randomthing[] = 'land cards';
	$randomthing[] = 'basic land cards';
	$randomthing[] = 'nonbasic land cards';
	$randomthing[] = 'artifact creature cards';
	$randomthing[] = 'artifact land cards';
	$randomthing[] = colorword($c, false).' cards';
	$randomthing[] = colorword($c, false).' cards';
	$randomthing[] = 'multicolored cards';
	$randomthing[] = 'monocolored cards';
	$randomthing[] = 'colorless cards';
	return $randomthing[mt_rand(0,count($randomthing)-1)];	
}

function word($number)
{
	if ($number == 0) return 'no';
	elseif ($number == 10) return 'ten';
	elseif ($number == 11) return 'eleven';
	elseif ($number == 12) return 'twelve';
	elseif ($number == 13) return 'thirteen';
	elseif ($number == 14) return 'fourteen';
	elseif ($number == 15) return 'fifteen';
	elseif ($number == 16) return 'sixteen';
	elseif ($number == 17) return 'eighteen';
	elseif ($number == 18) return 'nineteen';
	else {
		if ($number > 40) {
			$output = 'forty-';
			$number = $number - 40;
		}
		elseif ($number == 40) return 'forty';
		elseif ($number > 30) {
			$output = 'thirty-'; 
		}
		elseif ($number == 30) return 'thirty';
		elseif ($number > 20) {
			$number = $number - 20;
			$output = 'twenty-'; 
		}
		elseif ($number == 20) return 'twenty';
		else $output = '';
	}
	if ($number == 1) return $output."one";
	elseif ($number == 2) return $output."two";
	elseif ($number == 3) return $output."three";
	elseif ($number == 4) return $output."four";
	elseif ($number == 5) return $output."five";
	elseif ($number == 6) return $output."six";
	elseif ($number == 7) return $output."seven";
	elseif ($number == 8) return $output."eight";
	elseif ($number == 9) return $output."nine";
}

function randomability()
{
	$randomthing[] = 'haste';
	$randomthing[] = 'flying';
	$randomthing[] = 'shadow';
	$randomthing[] = 'first strike';
	$randomthing[] = 'double strike';
	$randomthing[] = 'trample';
	$randomthing[] = "'".tapsymbol().": Add&nbsp;".manasymbol(1)." to your mana pool.'";
	return $randomthing[mt_rand(0,count($randomthing)-1)];	
}

function colorability($c)
{
	if ($c == 1) return 'first strike';
	else if ($c == 2) return 'flying';
	else if ($c == 3) return 'shadow';
	else if ($c == 4) return 'haste';
	else if ($c == 5) return "trample and get +".mt_rand(1,3)."/+".mt_rand(1,2);
}

function colorability2($c, $name)
{
	if(insane())
	{
		if ($c == 1) {
			// White abilities
			$randomthing[] = manasymbol('w').", ".tapsymbol().": Tap target creature with power ".mt_rand(1,5)." or less.";
			$randomthing[] = manasymbol('w').manasymbol('w').", ".tapsymbol().": Prevent all damage that would be dealt this turn.";
			$randomthing[] = "At the beginning of your upkeep, if you control five or more Plains, you may return target creature card from your graveyard to your hand.";
			$randomthing[] = tapsymbol().": Search your library for a Healing Salve and put it in your hand, then shuffle your library.";
		}	
		else if ($c == 2) {
			// Blue abilities
			$randomthing[] = manasymbol('u').manasymbol('u').", ".tapsymbol().": Return target tapped ".randompermanent($c)." to its owner's hand.";
			$randomthing[] = manasymbol('u').", ".tapsymbol().": Tap target red or black creature.";
			$randomthing[] = tapsymbol().", Reveal ".randomcard($c)." from your hand: Tap target ".randompermanent($c).".";
			$randomthing[] = manasymbol('u').manasymbol('u').", ".tapsymbol().", Sacrifice $name: Counter target spell.";
		}
		else if ($c == 3) {
			// Black abilities
			$randomthing[] = manasymbol(2).manasymbol('b').", ".tapsymbol().": Target player sacrifices ".arandompermanent($c).".";
			$randomthing[] = manasymbol(1).manasymbol('b').", ".tapsymbol().": Target player discards a card.";
			$randomthing[] = manasymbol(2).manasymbol('b').", ".tapsymbol().": Destroy target tapped creature.";
			$randomthing[] = manasymbol('b').", ".tapsymbol().", Reveal ".randomcard($c)." from your hand: Destroy target ".randompermanent($c).".";
			$randomthing[] = tapsymbol().", Sacrifice a Swamp: Add&nbsp;".manasymbol('b').manasymbol('b').manasymbol('b').manasymbol('b')." to your mana pool.";
			
		}
		else if ($c == 4) {
			// Red abilities
			$randomthing[] = manasymbol(2).manasymbol('r').", ".tapsymbol().": Target creature deals damage another target creature equal to its power.";
			$randomthing[] = manasymbol(2).manasymbol('r').", ".tapsymbol().": Destroy ".arandompermanent($c)." at random.";
			$randomthing[] = manasymbol('r').manasymbol('r').", ".tapsymbol().": Put ".word(mt_rand(2,4))." 1/1 red Goblin creature tokens onto the battlefield.";
			$randomthing[] = "Sacrifice $name: Destroy target planeswalker.";
		}
		else {
			// Green abilities
			$randomthing[] = manasymbol(1).manasymbol('g').", ".tapsymbol().": You gain ".mt_rand(1,10)." life.";
			$randomthing[] = manasymbol('g').", ".tapsymbol().": Target green creature gets +2/+2 until end of turn.";
			$randomthing[] = manasymbol('g').", ".tapsymbol().": Target green creature gets +3/+0 until end of turn.";
			$randomthing[] = manasymbol('g').manasymbol('g').", ".tapsymbol().", Put ".word(mt_rand(2,5))." 1/1 green Elf creature tokens onto the battlefield.";
		}
	}
	
	if ($c == 1) {
		// White abilities
		$randomthing[] = manasymbol(2).manasymbol('w').", ".tapsymbol().": Put a 1/1 ".arandomcreaturebycolor($c, false, false)." creature token onto the battlefield.";
		$randomthing[] = manasymbol('w').manasymbol('w').": Prevent the next ".mt_rand(1,2)." damage that would be dealt to target creature or player this turn.";
		$randomthing[] = manasymbol(1).manasymbol('w').", ".tapsymbol().": Target creature gains vigilance until end of turn.";
		$randomthing[] = manasymbol(1).manasymbol('w').", ".tapsymbol().": You gain ".mt_rand(1,2)." life.";
		$randomthing[] = manasymbol('w').", ".tapsymbol().": Target blocking creature gets +0/+".mt_rand(1,2)." until end of turn.";
		$randomthing[] = fontshrink().manasymbol('w').", ".tapsymbol().", Sacrifice $name: Prevent all combat damage that would be dealt this turn.";
	}	
	else if ($c == 2) {
		// Blue abilities
		$randomthing[] = manasymbol(2).manasymbol('u').", ".tapsymbol().": Put a 1/1 blue ".arandomcreaturebycolor($c, false, false)." creature token with flying onto the battlefield.";
		$randomthing[] = manasymbol(1).manasymbol('u').manasymbol('u').", ".tapsymbol().": Counter target spell unless its controller pays ".manasymbol(1).".";
		$randomthing[] = manasymbol('u').", ".tapsymbol().", Sacrifice $name: Return target creature you control to its owner's hand.";
		$randomthing[] = manasymbol(2).manasymbol('u').", ".tapsymbol().": Draw a card, then discard a card.";
		$randomthing[] = manasymbol('u').", ".tapsymbol().": Scry 1.";
		$randomthing[] = manasymbol(1).manasymbol('u').", ".tapsymbol().": Scry 2.";
	}
	else if ($c == 3) {
		// Black abilities
		$randomthing[] = manasymbol('b').", ".tapsymbol().", Pay 1 life: Put a 1/1 black ".arandomcreaturebycolor($c, false, false)." creature token onto the battlefield.";
		$randomthing[] = manasymbol(2).manasymbol('b').", ".tapsymbol().": Target player loses 1 life.";
		$randomthing[] = manasymbol(1).manasymbol('b').manasymbol('b').", ".tapsymbol().", Sacrifice $name: Target player discards a card.";
		$randomthing[] = manasymbol('b').manasymbol('b').", ".tapsymbol().", Sacrifice $name: Put a -1/-1 counter on target creature.";
		$randomthing[] = tapsymbol().", Sacrifice a Swamp: Add&nbsp;".manasymbol('b').manasymbol('b')." to your mana pool.";
	}
	else if ($c == 4) {
		// Red abilities
		$randomthing[] = manasymbol('r').manasymbol('r').": Put a 1/1 red ".arandomcreaturebycolor($c, false, false)." creature token onto the battlefield.";
		$randomthing[] = manasymbol('r').", ".tapsymbol().": Target red creature gets +1/+0 until end of turn.";
		$randomthing[] = manasymbol('r').manasymbol('r').", ".tapsymbol().": Target red creature gets +1/+1 until end of turn.";
		$randomthing[] = manasymbol('r').manasymbol('r').", ".tapsymbol().": Target creature gains haste until end of turn.";
		$randomthing[] = manasymbol(1).manasymbol('r').", ".tapsymbol().": Target red creature gains haste until end of turn.";
		$randomthing[] = manasymbol(2).manasymbol('r').manasymbol('r').", ".tapsymbol().": $name deals 1 damage to target creature.";
	}
	else {
		// Green abilities
		$randomthing[] = manasymbol(2).manasymbol('g').manasymbol('g').", ".tapsymbol().": Put a 2/2 green ".arandomcreaturebycolor($c, false, false)." creature token onto the battlefield.";
		$randomthing[] = manasymbol(2).manasymbol('g').", ".tapsymbol().": Regenerate target ".randompermanent($c).".";
		$randomthing[] = manasymbol(1).manasymbol('g').", ".tapsymbol().": You gain 1 life.";
		$randomthing[] = manasymbol(2).manasymbol('g').", ".tapsymbol().": Target green creature gains trample until end of turn.";
		$randomthing[] = manasymbol(2).manasymbol('g').", ".tapsymbol().": Target green creature gets +2/+2 until end of turn.";
		$randomthing[] = manasymbol(2).manasymbol('g').", ".tapsymbol().": You gain 2 life.";
		$randomthing[] = manasymbol(1).manasymbol('g').manasymbol('g').", ".tapsymbol().": Put a +1/+1 counter on target creature.";
		$randomthing[] = manasymbol('g').manasymbol('g').", ".tapsymbol().", Sacrifice $name: Destroy target artifact.";
		$randomthing[] = manasymbol('g').manasymbol('g').", ".tapsymbol().", Sacrifice $name: Destroy target enchantment.";
	}
	
	$randomthing[] = manasymbol(2).", ".tapsymbol().": Target land becomes a 3/3 ".colorword($c, true)." ".arandomcreaturebycolor($c, false, false)." creature until end of turn. It's still a land.";
	$randomthing[] = manasymbol(1).", ".tapsymbol().": Target land becomes a 2/2 ".colorword($c, true)." ".arandomcreaturebycolor($c, false, false)." creature until end of turn. It's still a land.";
	
	return $randomthing[mt_rand(0,count($randomthing)-1)];	
}

function fix($input)
{
	switch($input) {
		case 'uw': $output = 'wu'; break;
		case 'bu': $output = 'ub'; break;
		case 'rb': $output = 'br'; break;
		case 'gr': $output = 'rg'; break;
		case 'wg': $output = 'gw'; break;	
		case 'bw': $output = 'wb'; break;
		case 'gb': $output = 'bg'; break;
		case 'ug': $output = 'gu'; break;
		case 'ru': $output = 'ur'; break;
		case 'wr': $output = 'rw'; break;
		default: $output = $input;
	}
	return $output;
}

function colorword($input,$a)
{
	switch($input) {
		case 1: $output = 'white'; break;
		case 2: $output = 'blue'; break;
		case 3: $output = 'black'; break;
		case 4: $output = 'red'; break;
		case 5: $output = 'green'; break;
		case 'wu': $output = 'white and blue'; break;
		case 'ub': $output = 'blue and black'; break;
		case 'br': $output = 'black and red'; break;
		case 'rg': $output = 'red and green'; break;
		case 'gw': $output = 'green and white'; break;	
		case 'wb': $output = 'white and black'; break;
		case 'bg': $output = 'black and green'; break;
		case 'gu': $output = 'green and blue'; break;
		case 'ur': $output = 'blue and red'; break;
		case 'rw': $output = 'red and white'; break;
		default: $output = 'burple?';
	}
	return $a == true ? $output : ucfirst($output);
}

function basic($input)
{
	switch($input) {
		case 'wu': $output = 'Plains Island'; break;
		case 'ub': $output = 'Island Swamp'; break;
		case 'br': $output = 'Swamp Mountain'; break;
		case 'rg': $output = 'Mountain Forest'; break;
		case 'gw': $output = 'Forest Plains'; break;	
		case 'wb': $output = 'Plains Swamp'; break;
		case 'bg': $output = 'Swamp Forest'; break;
		case 'gu': $output = 'Forest Island'; break;
		case 'ur': $output = 'Island Mountain'; break;
		case 'rw': $output = 'Mountain Plains'; break;
		case 'w': $output = 'Plains'; break;
		case 'b': $output = 'Swamp'; break;
		case 'g': $output = 'Forest'; break;
		case 'u': $output = 'Island'; break;
		case 'r': $output = 'Mountain'; break;
		default: $output = $input;
	}
	return $output;
}

function abasic($input)
{
	switch($input) {
		case 'wu': $output = 'a Plains or an Island'; break;
		case 'ub': $output = 'an Island or a Swamp'; break;
		case 'br': $output = 'a Swamp or a Mountain'; break;
		case 'rg': $output = 'a Mountain or a Forest'; break;
		case 'gw': $output = 'a Forest or a Plains'; break;	
		case 'wb': $output = 'a Plains or a Swamp'; break;
		case 'bg': $output = 'a Swamp or a Forest'; break;
		case 'gu': $output = 'a Forest or an Island'; break;
		case 'ur': $output = 'an Island or a Mountain'; break;
		case 'rw': $output = 'a Mountain or a Plains'; break;
		case 'w': $output = 'a Plains'; break;
		case 'b': $output = 'a Swamp'; break;
		case 'g': $output = 'a Forest'; break;
		case 'u': $output = 'an Island'; break;
		case 'r': $output = 'a Mountain'; break;
		default: $output = $input;
	}
	return $output;
}

function basicfont($input)
{
	switch($input)
	{
		case 'wu':
			$output = "<img src='pics/font/plains.png' alt='Plains'><img src='pics/font/space.png' alt=' '><img src='pics/font/island.png' alt='Island'>"; break;
		case 'ub':
			$output = "<img src='pics/font/island.png' alt='Island'><img src='pics/font/space.png' alt=' '><img src='pics/font/swamp.png' alt='Swamp'>"; break;
		case 'br':
			$output = "<img src='pics/font/swamp.png' alt='Swamp'><img src='pics/font/space.png' alt=' '><img src='pics/font/mountain.png' alt='Mountain'>"; break;
		case 'rg':
			$output = "<img src='pics/font/mountain.png' alt='Mountain'><img src='pics/font/space.png' alt=' '><img src='pics/font/forest.png' alt='Forest'>"; break;
		case 'gw':
			$output = "<img src='pics/font/forest.png' alt='Forest'><img src='pics/font/space.png' alt=' '><img src='pics/font/plains.png' alt='Plains'>"; break;	
		case 'wb':
			$output = "<img src='pics/font/plains.png' alt='Plains'><img src='pics/font/space.png' alt=' '><img src='pics/font/swamp.png' alt='Swamp'>"; break;
		case 'bg':
			$output = "<img src='pics/font/swamp.png' alt='Swamp'><img src='pics/font/space.png' alt=' '><img src='pics/font/forest.png' alt='Forest'>"; break;
		case 'gu':
			$output = "<img src='pics/font/forest.png' alt='Forest'><img src='pics/font/space.png' alt=' '><img src='pics/font/island.png' alt='Island'>"; break;
		case 'ur':
			$output = "<img src='pics/font/island.png' alt='Island'><img src='pics/font/space.png' alt=' '><img src='pics/font/mountain.png' alt='Mountain'>"; break;
		case 'rw':
			$output = "<img src='pics/font/mountain.png' alt='Mountain'><img src='pics/font/space.png' alt=' '><img src='pics/font/plains.png' alt='Plains'>"; break;
		default:
		  $output = $input;
	}
	return $output;
}


function basicor($input)
{
	switch($input) {
		case 'wu': $output = 'Plains or Island'; break;
		case 'ub': $output = 'Island or Swamp'; break;
		case 'br': $output = 'Swamp or Mountain'; break;
		case 'rg': $output = 'Mountain or Forest'; break;
		case 'gw': $output = 'Forest or Plains'; break;	
		case 'wb': $output = 'Plains or Swamp'; break;
		case 'bg': $output = 'Swamp or Forest'; break;
		case 'gu': $output = 'Forest or Island'; break;
		case 'ur': $output = 'Island or Mountain'; break;
		case 'rw': $output = 'Mountain or Plains'; break;
		default: $output = $input;
	}
	return $output;
}

// Here $n = $name $c = $colors.
function fetch_paragraph($name, $colors, $c1, $c2, $isArtifactEnchantment)
{
	if( !$isArtifactEnchantment )
	{
		$randomthing[] = tapsymbol().": Search your library for a ".basicor($colors)." card and put it onto the battlefield tapped. Shuffle your library, then put $name on top of it.";
	}
	$randomthing[] = tapsymbol().", Pay 1 life, Sacrifice ".$name.": Search your library for a ".basicor($colors)." card and put it onto the battlefield, then shuffle your library.";
	$randomthing[] = manasymbol($colors).", ".tapsymbol().": Put a ".basicor($colors)." card from your hand onto the battlefield tapped.";

	if (insane())
	{
		$crand = mt_rand(1,2)==1 ? $c1 : $c2;
		$randomthing[] = mcsymbol($c1).mcsymbol($c2).", ".tapsymbol().", Sacrifice ".$name.": Search your library for a land card and put it onto the battlefield.";	
		$randomthing[] = mcsymbol($crand).", ".tapsymbol().": Put a ".basicor($colors)." card from your hand onto the battlefield.";
		$randomthing[] = tapsymbol()." Pay ".mt_rand(3,4)." life, Sacrifice ".$name.": Search your library for two ".basicor($colors)." cards and put them onto the battlefield.";
		$randomthing[] = mcsymbol($c1).mcsymbol($c2).", ".tapsymbol().", Sacrifice ".$name.": Search your library for any number of ".basicor($colors)." cards and put them onto the battlefield tapped.";	
	}
	echo(fontshrink()."<p class=\"ability\">".$randomthing[mt_rand(0,count($randomthing)-1)]."</p>");		
}

function special_drawbacks($name, $c)
{
	if (insane()) {
		$randomthing[] = "At the beginning of your upkeep, Sacrifice ".$name." unless you pay ".mcsymbol($c).".";
		$randomthing[] = "You can't cast spells from your hand.";
		$randomthing[] = "Skip your draw step.";
		$randomthing[] = colorword($c,false)." spells you cast cost ".manasymbol(mt_rand(1,2))." more to cast.";
		$randomthing[] = "You can't play lands from your hand.";
		$randomthing[] = "At the beginning of your end step, tap all lands you control.";
		$randomthing[] = "Phasing";	
	}
	else {
		$randomthing[] = $name." enters the battlefield tapped.";
		$randomthing[] = $name." enters the battlefield tapped unless you pay ".manasymbol(1).".";
		$randomthing[] = $name." enters the battlefield tapped unless you pay ".mcsymbol($c).".";
		$randomthing[] = "At the beginning of yoru upkeep, $name deals 1 damage to you.";

	}
	echo("<p class=\"ability\">".$randomthing[mt_rand(0,count($randomthing)-1)]."</p>");		
}

function artifact_paragraph($name, $c)
{
	if (insane())
	{
		special_drawbacks($name, $c);
		$randomthing[] = "At the beginning of each player's upkeep, that player sacrifices a permanent.";
		$randomthing[] = "You may play land cards from your graveyard.";
		$randomthing[] = "You may play ".randomcards($c)." from your graveyard.";
		$randomthing[] = manasymbol(1).": Look at the top three cards of your library, then put them back in any order.";
		$randomthing[] = tapsymbol().": Draw a card, then put ".$name." on top of its owner's library.";
		$randomthing[] = "Activated abilities of other artifacts can't be activated unless they're mana abilities.";
		$randomthing[] = "Noncreature spells cost ".manasymbol(1)." more to cast.";
		$randomthing[] = "Nonartifact spells cost ".manasymbol(1)." more to cast.";
		$randomthing[] = "At the beginning of each player's draw step, that player draws an additional card.";
		$randomthing[] = fontshrink()."Each creature gets +1/+1 for each other creature on the battlefield that shares at least one creature type with it.";
		$randomthing[] = "Whenever a permanent enters the battlefield tapped and under your control, untap it."; 
		$randomthing[] = tapsymbol().", Sacrifice $name: Draw 3 cards.";
	}
	else
	{
		drawback_paragraph($name, $c);
		echo(fontshrink());
	}
	$randomthing[] = tapsymbol().": Target player exiles a card from his or her graveyard.";
	$randomthing[] = "Sacrifice a land: You gain 1 life.";
	$randomthing[] = manasymbol('x').", ".tapsymbol().": Tap target artifact with converted mana cost X or less.";
	$randomthing[] = $name." is indestructible. <i>(Destroy effects and lethal damage don't destroy it.)</i>";	
	$randomthing[] = manasymbol(1).", ".tapsymbol().": Scry 2.";
	$randomthing[] = manasymbol(1).", ".tapsymbol().": You may put a land card from your hand onto the battlefield.";
	$randomthing[] = manasymbol(1).", ".tapsymbol().": Look at target player's hand.";
	echo("<p class=\"ability\">".$randomthing[mt_rand(0,count($randomthing)-1)]."</p>");		
}

function enchantment_paragraph($name, $c)
{
	if (insane())
	{
		special_drawbacks($name, $c);
		$randomthing[] = "Players skip their untap steps.";
		$randomthing[] = colorword($c,false)." creatures you control get +".mt_rand(2,5)."/-".mt_rand(1,2).".";
		$randomthing[] = colorword($c,false)." creatures you control get -".mt_rand(1,2)."/+".mt_rand(2,5).".";
		$randomthing[] = colorword($c,false)." creatures you control get +".mt_rand(1,2)."/+".mt_rand(1,2).".";
		$randomthing[] = colorword($c,false)." creatures your opponents control get -".mt_rand(1,2)."/-".mt_rand(1,2).".";
		$randomthing[] = "Players have no maximum hand size.";
		$randomthing[] = "Creatures have shroud. <i>(They can't be the target of spells or abilities.)</i>";
		$randomthing[] = "Creatures without flying can't attack.";
		$randomthing[] = "You may play an additional land on each of your turns.";
		$randomthing[] = "Whenever an opponent draws a card, he or she loses 1 life.";
		$randomthing[] = "All lands are 1/1 creatures that are still lands.";
		$randomthing[] = "All creatures lose all abilities and are 1/1.";
		$randomthing[] = "Nonbasic lands don't untap during their controllers' untap steps.";
		$randomthing[] = "Other nonbasic lands are ".basic(letter($c))."s.";
	}
	else
	{
		drawback_paragraph($name, $c);
		echo(fontshrink());
	}
	$randomthing[] = "All creatures have ".basic(letter(($c+2)%5+1))."walk.";
	$randomthing[] = "All creatures have ".basic(letter(($c+2)%5+1))."walk.";
	$randomthing[] = "All creatures have ".basic(letter(($c+2)%5+1))."walk.";
	$randomthing[] = "All creatures have ".basic(letter(($c+2)%5+1))."walk.";
	if ($c == 1) { // White
		$randomthing[] = "Untapped creatures you control get +0/+1.";
		$randomthing[] = "All creatures have protection from red.";
		$randomthing[] = "All creatures have protection from black.";
	}
	if ($c == 2) { // Blue
		$randomthing[] = "Red spells cost ".manasymbol(2)." more to play.";
		$randomthing[] = "Green spells cost ".manasymbol(2)." more to play.";
		$randomthing[] = "Creatures enters the battlefield tapped.";
	}
	if ($c == 3) { // Black
		$randomthing[] = "White and green spells cost ".manasymbol(1)." more to play.";
		$randomthing[] = "Whenever a card is put into a graveyard from anywhere, exile that card.";
		$randomthing[] = "Discard two cards: Put a 2/2 black Zombie creature token onto the battlefield.";
	}
	if ($c == 4) { // Red
		$randomthing[] = "Red creatures get +2/-1.";
		$randomthing[] = "Each creature you control can't be blocked except by two or more creatures.";
		$randomthing[] = "Attacking creatures you control get +1/+0.";
	}
	if ($c == 5) { // Green
		$randomthing[] = "Green creatures get +1/+0.";
		$randomthing[] = "Green creatures get +1/+1.";
		$randomthing[] = "Islands don't untap during their controllers' untap steps.";
	}
	echo("<p class=\"ability\">".$randomthing[mt_rand(0,count($randomthing)-1)]."</p>");	

}

function utility_paragraphs($c1, $c2, $name)
{
	echo("<p class=\"ability\">".colorability2($c1, $name)."</p><p class='ability'>".colorability2($c2, $name)."</p>");
}

// Here $n = $name
function random_paragraph($n, $c1, $c2)
{
	if(insane())
	{
		$randomthing[] = "Shroud <i>(This land can't be the target of spells or effects.)</i>";
		$randomthing[] = manasymbol(1).", ".tapsymbol().": You gain ".mt_rand(1,3)." life.";
		$randomthing[] = manasymbol('3').", ".tapsymbol().", Sacrifice $n: Destroy target ".randompermanent($c1).".";
		$randomthing[] = manasymbol(2).mcsymbol($c1).", ".tapsymbol().", Sacrifice $n: Exile target ".randompermanent($c1).".";
		$randomthing[] = mcsymbol($c1).", ".tapsymbol().": $n deals ".mt_rand(1,2)." damage to target creature or player.";
		$randomthing[] = "Sacrifice ".arandompermanent($c1).": $n deals ".mt_rand(1,5)." damage to target creature or player.";
		$randomthing[] = "Sacrifice ".arandompermanent($c1).": You gain ".mt_rand(5,10)." life.";
		$randomthing[] = tapsymbol().", Pay ".mt_rand(2,4)." life: Draw a card.";
		$randomthing[] = tapsymbol().": Destroy target Jace.";
		$randomthing[] = "Sacrifice ".arandompermanent($c1).": Destroy target planeswalker.";
		$randomthing[] = "At the beginning of your upkeep, you gain ".mt_rand(3,6)." life.";
		$randomthing[] = "As long as $n is untapped, creatures you control have ".colorability($c1).".";
		$randomthing[] = "Creatures you control have ".randomability().".";
		$randomthing[] = "Cycling ".manasymbol(1)." <i>(".manasymbol(1).", Discard this card: Draw a card.)</i>";
		$randomthing[] = "Cycling ".manasymbol('s')." <i>(".manasymbol('s').", Discard this card: Draw a card.)</i>";
		$randomthing[] = "Cycling ".mcsymbol($c1)." <i>(".mcsymbol($c1).", Discard this card: Draw a card.)</i>";
		$randomthing[] = "Multicycling ".manasymbol(1)." <i>(".manasymbol(1).", Discard X cards including this one: Draw X cards.)</i>";
		$randomthing[] = "Multicycling ".manasymbol(2)." <i>(".manasymbol(2).", Discard X cards including this one: Draw X cards.)</i>";
		$randomthing[] = "Multicycling ".mcsymbol($c1)." <i>(".mcsymbol($c1).", Discard X cards including this one: Draw X cards.)</i>";
		$randomthing[] = "<i>Spellcraft</i> - As long as you control three or more enchantments, creatures you control have ".randomability().".";
		$randomthing[] = "Sacrifice $n: Put ".word(mt_rand(1,50))." 1/1 colorless Squirrel tokens onto the battlefield.";
		$randomthing[] = "When $n leaves the battlefield, put a 4/4 colorless Elemental creature with flying onto the battlefield.";
		$randomthing[] = tapsymbol().": Put a counter of any type on target permanent.";
		$randomthing[] = manasymbol('s').", ".tapsymbol().": Tap target ".randompermanent($c2).".";
		$randomthing[] = manasymbol(1).manasymbol('s').manasymbol('s').", ".tapsymbol().": Untap target ".randompermanent($c2).".";
		$randomthing[] = tapsymbol().": Target ".randompermanent($c1)." gains <i>'".colorability2($c1, $n)."'</i> until end of turn.";
		$randomthing[] = tapsymbol().": Target ".randompermanent($c2)." gains <i>'".colorability2($c2, $n)."'</i> until end of turn.";
	}
	$colors = letterize($c1, $c2); //(Make them show up in correct order!)
	//White
	if ($c1 == 1 || $c2 == 1) {
		$randomthing[] = "When $n enters the battlefield, scry 1.";
		$randomthing[] = manasymbol('w').", ".tapsymbol().": $n deals 1 damage to target attacking creature.";		
		$randomthing[] = manasymbol('w').", ".tapsymbol().": Target ".arandomcreaturebycolor(1,false,false)." gets +1/+1 until end of turn.";
		$randomthing[] = "At the beginning of your upkeep, you may gain 1 life.";
		$randomthing[] = manasymbol(1).manasymbol('w').": $n becomes a 0/4 ".colorword($colors,true)." ".arandomcreaturebycolor($c1,false,false)." creature with defender until end of turn. It's still a land.";	
		$randomthing[] = manasymbol('w').manasymbol('w').", ".tapsymbol().": Put target card from your graveyard on the bottom of your library.";
		$randomthing[] = tapsymbol().": Prevent the next 1 damage that would be dealt to target creature this turn.";
		$randomthing[] = "Vigilance";
		$randomthing[] = "Protection from black";
	}
	//Blue
	if ($c1 == 2 || $c2 == 2) {
		$randomthing[] = manasymbol(1).mcsymbol($c1).mcsymbol($c2).", ".tapsymbol().": Exile target ".randompermanent($c1).", then return it to the battlefield under its owner's control.";		
		$randomthing[] = tapsymbol().": Remove a counter from target permanent.";
		$randomthing[] = manasymbol('u').", ".tapsymbol().", Sacrifice $n: Target player draws two cards, then discards two cards.";
		$randomthing[] = manasymbol(1).manasymbol('u').": $n becomes a 1/1 ".colorword($colors,true)." ".arandomcreaturebycolor($c1,false,false)." creature with flying until end of turn. It's still a land.";	
		$randomthing[] = manasymbol(1).manasymbol('u').", ".tapsymbol().": Target player reveals the top card of his or her library.";
		$randomthing[] = "Flying";
		$randomthing[] = "Islandwalk";
	}
	//Black
	if ($c1 == 3 || $c2 == 3) {
		$randomthing[] = manasymbol(2).manasymbol('b').manasymbol('b').", ".tapsymbol().", Sacrifice $n: Destroy target ".randompermanent($c1).".";		
		$randomthing[] = manasymbol(2).", ".tapsymbol().", Pay ".mt_rand(2,4)." life: Draw a card.";
		$randomthing[] = manasymbol('b').manasymbol('b').", ".tapsymbol().", Sacrifice $n: Target creature gets -2/-2 until end of turn.";	
		$randomthing[] = manasymbol('b').", ".tapsymbol().", Sacrifice $n: Target player gets a poison counter.";	
		$randomthing[] = manasymbol(1).manasymbol('b').": Regenerate target ".arandomcreaturebycolor(3,false,false).".";	
		$randomthing[] = "At the beginning of your upkeep, sacrifice ".arandomcreaturebycolor($c1,true,false).".";
		$randomthing[] = "Shadow";
		$randomthing[] = "Fear";
		$randomthing[] = "When $n enters the battlefield, put a -1/-1 counter on target land.";
	}
	//Red
	if ($c1 == 4 || $c2 == 4) {
		$randomthing[] = tapsymbol().": Target creature loses all landwalk abilities until end of turn.";
		$randomthing[] = "Sacrifice ".arandompermanent($c1).": $n deals 1 damage to target player.";		
		$randomthing[] = manasymbol('r').", Sacrifice $n: $n deals 1 damage to target creature or player.";
		$randomthing[] = manasymbol(1).manasymbol('r').", ".tapsymbol().": Target ".arandomcreaturebycolor(4,false,false)." gets +2/+0 until end of turn.";
		$randomthing[] = manasymbol(1).manasymbol('r').": $n becomes a 1/1 ".colorword($colors,true)." ".arandomcreaturebycolor($c1,false,false)." creature with first strike until end of turn. It's still a land.";	
		$randomthing[] = manasymbol('r').manasymbol('r').", ".tapsymbol().": Shuffle your library.";
		$randomthing[] = "First strike";
		$randomthing[] = "Intimidate";
	}
	//Green
	if ($c1 == 5 || $c2 == 5) {
		$randomthing[] = manasymbol('g').", ".tapsymbol().", You gain 1 life.";
		$randomthing[] = "Sacrifice ".arandompermanent($c1).": You gain ".mt_rand(1,3)." life.";
		$randomthing[] = manasymbol('g').", Sacrifice $n: Target creature gets +2/+2 until end of turn.";		
		$randomthing[] = tapsymbol().": Target 1/1 creature gets +1/+0 until end of turn.";		
		$randomthing[] = manasymbol(2).manasymbol('g').": $n becomes a 2/2 ".colorword($colors,true)." ".arandomcreaturebycolor($c1,false,false)." creature with trample until end of turn. It's still a land.";	
		$randomthing[] = "Trample";
		$randomthing[] = manasymbol('g').": Regenerate $n.";
	}
	// UB
	if (($c1 == 2 && $c2 == 3) || ($c1 == 3 && $c2 == 2)) {
		$randomthing[] = manasymbol('u').manasymbol('b').", ".tapsymbol().": Target player puts the top card of his or her library into his or her graveyard.";
	}

	$randomthing[] = manasymbol($colors[0]).manasymbol($colors[1]).": $n becomes a 2/1 ".strtolower(colorword($c1, true))." and ".strtolower(colorword($c2, true))." ".arandomcreaturebycolor($c1,false,false)." creature until end of turn. It's still a land.";	
	$randomthing[] = manasymbol(1).", ".tapsymbol().": Add one mana of any color to your mana pool.";
	$randomthing[] = tapsymbol().", Sacrifice $n: Add&nbsp;".manasymbol(2)." to your mana pool.";
	$randomthing[] = "Cycling ".manasymbol(2)." <i>(".manasymbol(2).", Discard this card: Draw a card.)</i>";
	$randomthing[] = "Cycling ".manasymbol('3')." <i>(".manasymbol('3').", Discard this card: Draw a card.)</i>";
	$randomthing[] = "Cycling ".mcsymbol($c1)." <i>(".mcsymbol($c1).", Discard this card: Draw a card.)</i>";
	$randomthing[] = "Cycling ".manasymbol(letterize($c1, $c2))." <i>(".manasymbol(letterize($c1, $c2)).", Discard this card: Draw a card.)</i>";
	$randomthing[] = tapsymbol().": Return $n to its owner's hand.";
	$randomthing[] = fontshrink()."Morph ".manasymbol(letterize($c1, $c2))." <i>(You may cast this face down as a 2/2 creature for ".manasymbol(3).". Turn it face up any time for its morph cost.)</i>";
	$randomthing[] = fontshrink()."Morph ".manasymbol(mt_rand(1,3))." <i>(You may cast this face down as a 2/2 creature for ".manasymbol(3).". Turn it face up any time for its morph cost.)</i>";
	$randomthing[] = manasymbol(mt_rand(1,3)).": $n becomes a 2/2 ".colorword($c1,true)." ".arandomcreaturebycolor($c1,false,false)." creature until end of turn. It's still a land.</i>";
	$randomthing[] = manasymbol(mt_rand(1,3)).": $n becomes a 2/2 ".colorword($c2,true)." ".arandomcreaturebycolor($c2,false,false)." creature until end of turn. It's still a land.</i>";

	echo("<p class=\"ability\">".$randomthing[mt_rand(0,count($randomthing)-1)]."</p>");
}

function drawback_paragraph($name, $c)
{
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped.";
	$cipt[] = $name." enters the battlefield tapped unless you pay ".mt_rand(1,3)." life.";
	$cipt[] = $name." enters the battlefield tapped unless you reveal ".randomcard($c)." from your hand. ";
	$cipt[] = "When ".$name." enters the battlefield, return a land you control to its owner's hand. ";
	$cipt[] = "When ".$name." enters the battlefield, you lose ".mt_rand(1,2)." life unless you reveal ".randomcard($c)." from your hand. ";
	$cipt[] = "When ".$name." enters the battlefield, sacrifice it unless you pay ".mt_rand(1,3)." life. ";
	$cipt[] = "When ".$name." enters the battlefield, sacrifice it unless you pay ".mcsymbol($c).".";
	$cipt[] = $name." enters the battlefield tapped unless you control ".word(mt_rand(1,2))." or more creatures.";
	$cipt[] = $name." enters the battlefield tapped unless you control an enchantment.";
	$cipt[] = $name." enters the battlefield tapped unless you control ".word(mt_rand(1,5))." or more ".randompermanents($c).". ";
	$cipt[] = $name." enters the battlefield tapped unless you sacrifice ".arandompermanent($c).". ";
	$cipt[] = $name." enters the battlefield tapped unless you pay ".manasymbol(1).".";
	$cipt[] = $name." enters the battlefield tapped unless you pay ".manasymbol(2).".";
	$cipt[] = $name." enters the battlefield tapped unless you pay ".mcsymbol($c).".";
	$cipt[] = "Whenever $name becomes tapped, it deals 1 damage to you. ";
	$cipt[] = "At the beginning of your upkeep, $name deals ".mt_rand(1,2)." damage to target creature you control. ";
	$cipt[] = "At the beginning of your end step, if you didn't cast any spells this turn, $name deals 1 damage to you.";
	//$cipt[] = "At the beginning of your upkeep, you lose ".mt_rand(1,2)." life unless you pay ".mcsymbol($c).".";
	if (insane()) {
		$cipt[] = "At the beginning of your upkeep, $name deals 1 damage to target creature or player. ";
		$cipt[] = "When $name enters the battlefield, untap all lands you control.";
		$cipt[] = "When $name enters the battlefield, you lose ".mt_rand(1,10)." life.";
		$cipt[] = "When $name enters the battlefield, destroy target ".randompermanent($c).".";
		$cipt[] = "When $name enters the battlefield, sacrifice all creatures you control.";
		$cipt[] = "When $name enters the battlefield, exile all planeswalkers.";
		$cipt[] = "At the beginning of your upkeep, you lose ".mt_rand(1,10)." life unless you pay ".mcsymbol($c).".";
		$cipt[] = "At the beginning of your end step, untap all lands you control.";
		$cipt[] = "As long as $name is untapped, prevent all damage.";

	}
	echo("<p class=\"ability\">".$cipt[mt_rand(0,count($cipt)-1)]."</p>");
}

function mana_paragraph($name, $c1, $c2, $isLongCardAlready)
{
	echo("<p class=\"ability\">");
	$manaeffect = mt_rand(1,17);
	if ($manaeffect == 0) {
		echo(manasymbol(1).", ".tapsymbol().": Add&nbsp;".eithermana($c1, $c2)." to your mana pool. Untap ".$name.".");
	}
	else if ($manaeffect == 1) {
		echo(tapsymbol().": Add&nbsp;".eithermana($c1, $c2)." to your mana pool. ".$name." deals ".mt_rand(1,2)." damage to you.");
	}
	else if ($manaeffect == 2) {	
		echo(tapsymbol().": Add&nbsp;".bothmana($c1, $c2)." to your mana pool. ".$name." doesn't untap during your next untap step.");
	}
	else if ($manaeffect == 3) {
		echo(manasymbol(letterize($c1, $c2)).", ".tapsymbol().": Add&nbsp;".mcsymbol($c1).mcsymbol($c1).", ".mcsymbol($c1).mcsymbol($c2)." or ".mcsymbol($c2).mcsymbol($c2)." to your mana pool.");
	}
	else if ($manaeffect == 4) {	
		echo(manasymbol(1).", ".tapsymbol().": Add&nbsp;".mcsymbol($c1).mcsymbol($c1).", ".mcsymbol($c1).mcsymbol($c2)." or ".mcsymbol($c2).mcsymbol($c2)." to your mana pool. ".$name." deals 1 damage to you.");
	}	
	else if ($manaeffect == 5) {		
		echo(tapsymbol().": Add&nbsp;".eithermana($c1, $c2)." to your mana pool.");
		echo("</p><p class=\"ability\">");
		echo(tapsymbol().": Add&nbsp;".manasymbol(2)." to your mana pool. Put ".$name." on top of your library.");
	}
	else if ($manaeffect == 6) {		
		echo(mcsymbol($c1).", ".tapsymbol().": Add&nbsp;".mcsymbol($c2).mcsymbol($c2)."  to your mana pool.");
		echo("</p><p class=\"ability\">");
		echo(mcsymbol($c2).", ".tapsymbol().": Add&nbsp;".mcsymbol($c1).mcsymbol($c1)."  to your mana pool.");
	}
	else if ($manaeffect == 7) {		
		echo(mcsymbol($c1).", ".tapsymbol().": Add&nbsp;".mcsymbol($c2).mcsymbol($c2)."  to your mana pool.");
		echo("</p><p class=\"ability\">");
		echo(mcsymbol($c2).", ".tapsymbol().": Add&nbsp;".mcsymbol($c1).mcsymbol($c1)."  to your mana pool.");
	}
	//Grove of the Burnwillows
	else if ($manaeffect == 8) {		
		echo(tapsymbol().": Add&nbsp;".manasymbol(1)." to your mana pool.");
		echo("</p><p class=\"ability\">");
		echo(tapsymbol().": Add&nbsp;".eithermana($c1, $c2)." to your mana pool. Each opponent gains 1 life.");
	}
		//Horizon Canopy
	else if ($manaeffect == 9) {		
		echo(tapsymbol().", Pay 1 life: Add&nbsp;".eithermana($c1, $c2)." to your mana pool.");
		echo("</p><p class=\"ability\">");
		echo(manasymbol(1).", ".tapsymbol().", Sacrifice ".$name.": Draw a card.");
	}
	//Nimbus Maze
	else if ($manaeffect == 10) {
		if( $isLongCardAlready )
		{
			echo(manasymbol(1).", ".tapsymbol().": Add&nbsp;".manasymbol(1).mcsymbol($c1)." or ".manasymbol(1).mcsymbol($c2)." to your mana pool.");
		}
		else
		{		
			echo(fontshrink().tapsymbol().": Add&nbsp;".mcsymbol($c1)." to your mana pool. Activate this ability only if you control ".abasic(letter($c1)).".");
			echo("</p><p class=\"ability\">");
			echo(tapsymbol().": Add&nbsp;".mcsymbol($c2)." to your mana pool. Activate this ability only if you control ".abasic(letter($c2)).".");
		}
	}
	//River of Tears
	else if ($manaeffect == 11) {
		echo(tapsymbol().": Add&nbsp;".mcsymbol($c1)." to your mana pool. If you played a land this turn, Add&nbsp;".mcsymbol($c2)." to your mana pool instead.");
	}

	else if ($manaeffect == 12) {		
		echo(tapsymbol().": Add&nbsp;".eithermana($c1, $c2)." to your mana pool.");
		echo("</p><p class=\"ability\">");
		echo("Sacrifice ".$name.": Add&nbsp;".eithermana($c1, $c2)." to your mana pool.");
	}
	else if ($manaeffect == 13) {		
		echo(tapsymbol().": Add&nbsp;".eithermana($c1, $c2)." to your mana pool.");
		echo("</p><p class=\"ability\">");
		echo("Put ".$name." on top of your library: Add&nbsp;".manasymbol(1)." to your mana pool. ");
	}
	else if ($manaeffect == 14) {		
		echo("When $name enters the battlefield, put a land you control on the bottom of its owner's library.");
		echo("</p><p class=\"ability\">");
		echo(tapsymbol().": Add&nbsp;".bothmana($c1,$c2)." to your mana pool.");
	}
	else if ($manaeffect == 15) {		
		echo(tapsymbol().": Add&nbsp;".bothmana($c1,$c2)." to your mana pool. Return $name to its owner's hand.");
	}
	// The simplest mana ability
	else {		
		echo(tapsymbol().": Add&nbsp;".eithermana($c1,$c2)." to your mana pool.");
	}
	echo("</p>");
}

function getOverlay($c1, $seed)
{
	if( insane() )
	{
		if( ($seed % 200) == 0 )
		{
			return "ufo";
		}
		if( ($seed % 666) == 0 )
		{
			return "hehal";
		}
	}
	$detailCap = insane() ? 10 : 7;
	return letter($c1).mt_rand(1, $detailCap);
}

?>