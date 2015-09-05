<?php

function WHENEVER($t,$c,$n,$favorable) {
	switch(mt_rand(1,2)) {
		 // As long as requires follow up: $followup = true
		 // As long as requires a static ability: $static = true
		case 1: $t = CONDITION("As long as ",true,true,$c,$n,$favorable); break;
 		// When NAME enters the battlefield
 		case 2:
 			$t = ACTION("When ".$n." enters the battlefield, ",PLAYER(),false,false,$c,$n,$favorable,mt_rand(0,1)); break;
 		case 3:
			$t = EVENT_TRIGGER("Whenever ",$c,$n).", "; // Like AT_TIME, but on permanents!
			return AT_TIME_FOLLOWUP($t,$c,$n,$favorable);
	}
	return $t;
}

function DOES($p) {
// if ($p == "target player") return "does";
// if ($p == "an opponent") return "does";
 if ($p == "you") return "do";
 else return "does";	
}

function S($p) {
 if ($p == "you") return "";
 else return "s";	
}

function a_random_spell($c,$target) {
	if ($target) {
		switch (mt_rand(1,9)) {
			case 1: return "target creature spell";	
			case 2: return "target sorcery spell";
			case 3: return "target ".enemycolor($c)." spell";
			case 4: return "target artifact spell";
			case 5: return "target enchantment spell";
			case 6: return "target Jace, the Mind Sculptor";
			case 7: return "target ".random_creature($c)." spell";
			case 8: return "target ".random_creature(enemycolor($c))." spell";
			case 9: return "target ".random_creature(friendcolor($c))." spell";
		}
	}
	else {	
		switch (mt_rand(1,9)) {
			case 1: return "a creature spell";	
			case 2: return "a sorcery spell";
			case 3: return "a ".enemycolor($c)." spell";
			case 4: return "an artifact spell";
			case 5: return "an enchantment spell";
			case 6: return "Jace, the Mind Sculptor";
			case 7: return a_random_creature($c)." spell";
			case 8: return a_random_creature(enemycolor($c))." spell";
			case 9: return a_random_creature(friendcolor($c))." spell";
		}	
	}		
}

function reminder($text) {
	global $reminder;
	if ($reminder == "") $reminder = $reminder." ".$text;
	else $reminder = $text;
}

function EVENT_TRIGGER($t, $c, $n) {
	
	$p = PLAYER_NOTARGET();
	$s = S($p);
	//return $t." (".$p." ".DOES($p)." something)";	
	switch($c) {
		case "white":	
			switch(mt_rand(1,7)) {
				case 1: return $t." ".$p." gain".$s." life";
				case 2: return $t." ".a_random_creature(friendcolor($c))." ".is_put_into_random_zone(true);
				case 3: return $t." a counter is put on ".a_random_permanent($c);
				case 4: return $t." ".$p." cast".$s." a spell";
				default: break;
			}
		case "blue":
			switch(mt_rand(1,8)) {
				case 1: return $t." ".$p." draw".$s." a card";
				case 2: return $t." ".$p." cast".$s." ".a_random_spell($c,false);
				case 3: return $t." ".$p." cast".$s." a spell";
				case 4: return $t." ".a_random_creature(friendcolor($c))." ".is_put_into_random_zone(true);
				case 5: return $t." a player discards ".a_random_permanent(friendcolor($c));
				default: break;
			}
		case "black":
			switch(mt_rand(1,8)) {
				case 1: 
					reminder("Damage causes loss of life.");
					return $t." ".$p." lose".$s." life";
				case 2: return "a creature dies";
				case 3: return $t." "."a non".$c." creature enters the battlefield";
				case 4: return $t." ".$p." discard".$s." a card";
				default: break;
			}
		case "red":
			switch(mt_rand(1,5)) {
				case 1:
					if ($p == "you") return $t." you are dealt damage";
					return $t." ".$p." is dealt damage";
				case 2: return $t." a non".$c." creature enters the battlefield";
				default: break;
			}
		case "green":
			switch(mt_rand(1,7)) {
				case 1: return $t." a green creature enters the battlefield";
				case 2: return $t." ".$p." cast".$s." a creature spell";
				case 3: return "a non".$c." creature enters the battlefield";
				case 4: return $t." ".$p." gain".$s." life";
				default: break;
			}
	}
	// Common
	switch(mt_rand(1,9)) {
		case 1: return $t." ".a_random_creature($c)." transforms";					
		case 2: return $t." ".a_random_creature($c)." ".is_put_into_random_zone(true);
		case 3: return a_random_permanent($c)." card ".is_put_into_random_zone(false);
		case 4: return a_random_permanent($c)." enters the battlefield";
		case 5: return $t." ".a_random_permanent($c)." leaves the battlefield";
		case 6: return $t." ".a_random_permanent($c)." enters the battlefield";
		case 7: return a_random_permanent($c)." card ".is_put_into_random_zone(false)." ".from_random_zone();
		case 8: return $t." a creature ".is_put_into_random_zone(false);
		case 9: return $t." a creature you control ".is_put_into_random_zone(false);
	}
	//Never reached
}

function AT_TIME($t,$c,$n,$favorable) {
	switch(mt_rand(3,3)) {
		//TODO replace upkeep with random step/phase
		case 1: $t = "At the beginning of your next upkeep, "; break; // Like WHENEVER, but on spells!
		case 2: $t = EVENT_TRIGGER($t."The next time ",$c,$n).", "; break;
		case 3: $t = "Until end of turn, whenever ".EVENT_TRIGGER($t,$c,$n).", "; break;
	}
	return AT_TIME_FOLLOWUP($t,$c,$n,$favorable);

}

function AT_TIME_FOLLOWUP($t,$c,$n,$favorable) {

	if (mt_rand(1,3) == 1) { $may = true; }// TODO tweak this!
	else { $may = false; }	

	switch(mt_rand(1,4)) {
		//AT TIME may be followed by ACTION.
		case 1: return ACTION($t, PLAYER(),false,false,$c,$n,$favorable,$may); // don't carry follow-up	
		//AT TIME may be followed by EFFECT
		case 2: return EFFECT($t,false,false,$c,$n,$favorable); // carry follow-up
		//AT_TIME may be followed by PLAYER may ACTION
		case 3: return ACTION($t, PLAYER(),false,false,$c,$n,$favorable,$may); // carry follow-up	
		//AT_TIME may be followed by CONDITION
		case 4: return CONDITION($t." if",true,false,$c,$n,$favorable); // carry follow-up
	}
}

function UNTIL_EOT($t,$c,$n,$favorable) {
	$tmp = EFFECT($t,false,true,$c,$n,$favorable);
	if (strpos("block",$tmp) || strpos("transform",$tmp)) return $tmp." this turn";
		return $tmp." until end of turn";
}


function UNTIL_TIME($t,$c,$n,$favorable) {
	switch(mt_rand(1,5)) {
		case 1: return $t."until end of combat";
		default: return $t."until end of turn";
	}
}


function STATIC_EFFECT($t, $c, $n) {
	
	// Something happens ...
	$p = PLAYER();
		
	switch($c) {
		case "white":	
			switch(mt_rand(1,9)) {
				case 1: return "players can&rsquo;t untap ".enemycolor($c)." permanents";
				case 2: $tmp = mt_rand(1,2); return friendcolor($c)." creatures get +".$tmp."/+".$tmp;
				case 3: return random_creatures(enemycolor($c))." can&rsquo;t transform";
				case 4: return "players can&rsquo;t untap ".random_permanents($c);
				case 5:
					$tmp = random_permanent(enemycolor($c));
					return "at the beginning of each player&rsquo;s upkeep, destroy each ".$tmp." that player controls unless he or she pays {1} for that ".$tmp;
				case 6: return "each ".random_creature(friendcolor($c))." creature you control enters the battlefield with an additional +1/+1 counter on it";
				case 7: return random_creatures(friendcolor($c))." you control get +".mt_rand(0,2)."/+".mt_rand(1,2);
				case 8: return random_creatures(friendcolor($c))." you control get +".mt_rand(0,2)."/+".mt_rand(1,2)." and have ".static_ability($c,"this creature",true);
				case 9: return "activated abilities of ".random_permanents($c)." can&rsquo;t be activated";
			}
		case "blue":
			switch(mt_rand(1,8)) {
				case 1: return "players can&rsquo;t draw cards";
				case 2: return random_creatures($c)." you control have Islandwalk";
				case 3: return random_permanents(enemycolor($c))." don&rsquo;t untap";
				case 4: return random_permanents(enemycolor($c))." can&rsquo;t ".enter_random_zones()." ".from_random_zones();
				case 5: return "opponents can&rsquo;t draw cards";
				case 6: return random_creatures($c)." have Islandwalk";
				case 7: return random_creatures($c)." you control have ".random_permanent($c)."walk";
				case 8: return "creatures you control have ".random_permanent($c)."walk";
			}
		case "black":
			switch(mt_rand(1,4)) {
				case 1: return "players can&rsquo;t gain life";
				case 2: return enemycolor($c)." ".random_creatures(enemycolor($c))." get -".mt_rand(1,13)."/-".mt_rand(1,13);
				case 3: return random_creatures(friendcolor($c))." you control get +".mt_rand(0,2)."/+".mt_rand(1,2);
				case 4: return random_creatures(friendcolor($c))." you control get +".mt_rand(0,2)."/+".mt_rand(1,2)." and have ".static_ability($c,"this creature",true);
			}
		case "red":
			switch(mt_rand(1,6)) {
				case 1: return random_creatures(friendcolor($c))." can&rsquo;t block";
				case 2: return "damage dealt by ".random_creatures(friendcolor($c))." can&rsquo;t be prevented";
				case 3: return "damage can&rsquo;t be prevented";
				case 4: return "damage dealt by ".friendcolor($c)." creatures can&rsquo;t be prevented";
				case 5: return friendcolor($c)." creatures have ".static_ability($c,"this creature",true);
				case 6: return random_permanents($c)." ".are_random_permanents($c);
			}
		case "green":
			switch(mt_rand(1,2)) {
				case 1: return random_creatures(friendcolor($c))." have deathtouch";
				case 2: return random_creatures(friendcolor($c))." you control get +".mt_rand(0,2)."/+".mt_rand(1,2)." and have ".static_ability($c,"this creature",true);
			}
	}
	//Never reached
}

function NONSTATIC_EFFECT($t, $c, $n) {
	
	// Something happens ...
	$p = PLAYER();
	$s = S($p);
	switch($c) {
		case "white":	
			switch(mt_rand(1,6)) {
				case 1: return $p." gain".$s." ".mt_rand(2,4)." life";
				case 2: return "destroy target ".random_creature(enemycolor($c));
				case 5: return "destroy all ".random_creatures(enemycolor($c));
				case 6: return "destroy all tapped ".random_creatures(enemycolor($c));
				case 3: return "destroy target tapped ".enemycolor($c)." creature";
				case 4: return "target ".random_creature($c)." gets +".mt_rand(0,2)."/+".mt_rand(1,4)." until end of turn";
			}
		case "blue":
			switch(mt_rand(1,4)) {
				case 1: return the_imperative($p)." draw".$s." a card";
				case 2: return "return target ".random_creature(enemycolor($c))." to its owners hand";
				case 3: return "tap all ".random_creatures(enemycolor($c));
				case 4: return "tap all creatures";
			}
		case "black":
			switch(mt_rand(1,4)) {
				case 1: return "destroy target creature if it is ".a_random_creature(enemycolor($c));
				case 2: return "target ".random_creature(enemycolor($c))." gets -".mt_rand(1,13)."/-".mt_rand(0,3)." until end of turn";
				case 3: return "destroy target non".friendcolor($c)." ".random_permanent(friendcolor($c));
				case 4:
					if ($p == "you") $tmp = "you";
					else $tmp = "";
					return $p." draw".$s." a card and ".$tmp." lose".$s." ".mt_rand(1,4)." life";
				case 5:
					$tmp = mt_rand(1,3);
					return "target player loses ".$tmp." life and you gain ".$tmp." life";
			}
		case "red":
			switch(mt_rand(1,6)) {
				case 1: return $n." deals ".mt_rand(1,13)." damage to target creature if it is ".a_random_creature(enemycolor($c));
				case 2: return $n." deals ".mt_rand(1,2)." damage to all ".random_creatures(enemycolor($c));
				case 3: return $n." deals ".mt_rand(1,3)." damage to target ".random_creature(enemycolor($c));
				case 4: return $n." deals ".mt_rand(1,3)." damage to target opponent";
				case 5: return $n." deals ".mt_rand(1,3)." damage to target creature or player";
				case 6: return $n." deals ".mt_rand(1,3)." damage to target planeswalker";
			}
		case "green":
			switch(mt_rand(1,6)) {
				case 1: return the_imperative($p)." untap".$s." all creatures ".he_or_she($p)." control".$s;
				case 2: return random_creatures($c)." you control get +".mt_rand(1,5)."/+".mt_rand(1,5)." until end of turn";
				case 3: return $p." gain".$s." life equal to the number of ".random_permanents($c)." ".he_or_she($p)." control".$s;
				case 4: return $n." deals damage to target player equal to the number of ".random_permanents($c)." you control";
				case 5: return "destroy target ".random_permanent(friendcolor($c)); // Desert twister!
				case 6: return $p." gain".$s." ".mt_rand(1,13)." life";
			}
	}
	//Never reached
}

// ******************
//  Effect -- Something that happens in the game state (not a performed action)
// ******************
function EFFECT($t,$followup,$static,$c,$n,$favorable) {
	
	if ($followup) {
		// When something happens, something else also happens.
 		$followup = false;
 		$t = $t.", ";
	}
	
	// No follow-up effect.
	if (!$followup) {
		// Static effect
		if ($static) {
			$t = $t." ".STATIC_EFFECT($t,$c,$n);
		}
		else {
			switch(mt_rand(1,3)) {
				case 1: 
				case 2: $t = $t." ".NONSTATIC_EFFECT($t,$c,$n); break;
				// Return "static effect until end of turn" (33%)
				default: $t = UNTIL_TIME(EFFECT($t,false,true,$c,$n,$favorable)." ",$c,$n,$favorable); break; 
			}			
		}

	//Return here if text is too big
	if (strlen($t) > 150) {return $t;}
		
		//Effect may be followed by... (10% odds)
		switch(mt_rand(0,10)) {
			case 10: return EFFECT($t." and ",$followup,$static,$c,$n,$favorable); break;
		}
	}
	return $t;
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
	if ($number == 1)	return $output."one";
	elseif ($number == 2) return $output."two";
	elseif ($number == 3) return $output."three";
	elseif ($number == 4) return $output."four";
	elseif ($number == 5) return $output."five";
	elseif ($number == 6) return $output."six";
	elseif ($number == 7) return $output."seven";
	elseif ($number == 8) return $output."eight";
	elseif ($number == 9) return $output."nine";
}

//"you" is left out in the imperative form
function the_imperative($p) {
	if ($p == "you") return "";
	else return $p;
}

function your($p) {
	if ($p == "you") return "your";
	else return "his or her";	
}

function he_or_she($p) {
	if ($p == "you") return "you";
	else return "he or she";	
}

function that_player($p) {
	if ($p == "you") return "you";
	return "that player";
}

function ACTION_NOFOLLOW($p,$c,$may,$first) {	
	// Determine the proper linguistic forms for the wording
		
	if ($p == "you") {
		$the_imperative = "";
		$of_your_choice = "";
	}
	else {
		$the_imperative = $p;
		$of_your_choice = " of his or her choice";
	}
	
	$your = your($p);
	$s = S($p);
	$es = "";
	if ($s == "s") $es = "es";
	$s2 = $s;
	if ($may) {
		if ($p == "you") {
			$the_imperative = "you may";
		}
		else {
			if ($first) { $the_imperative = $p." may"; }
			else { $the_imperative = "that player may";}
		}
		$s = ""; // Exception
	}


	switch($c) {
		case "white":
		  switch(mt_rand(1,14)) {
				case 1: return $the_imperative." tap".$s." target ".random_creature(enemycolor($c)).$of_your_choice;
				case 2: return $the_imperative." sacrifice".$s." an enchantment";
				case 3:
			 		$tmp = random_creature($c);
			 		if ($tmp == "Spirit") $tmp2 = " with flying";
			 		else $tmp2 = "";
			 		return $the_imperative." put".$s." a 1/1 white ".$tmp." creature token".$tmp2." onto the battlefield";
				case 4: 
					return $the_imperative." exile".$s." ".a_random_creature(enemycolor($c))." card from ".$your." graveyard";
				case 5:
			 		$tmp = random_creature($c);
			 		if ($tmp == "Spirit") $tmp2 = " with flying";
			 		else $tmp2 = "";
					return $the_imperative." put".$s." ".word(mt_rand(2,4))." 1/1 white ".$tmp." creature tokens".$tmp2." onto the battlefield";
				case 6: return $the_imperative." tap".$s." target non-".random_creature(friendcolor($c))." creature".$of_your_choice;
				case 7: return $the_imperative." put".$s." a +1/+1 counter on target ".random_creature(friendcolor($c)).$of_your_choice;
				case 8: return $the_imperative." destroy".$s." target enchantment".$of_your_choice;
				case 9: return $the_imperative." destroy".$s." target ".random_enemy_creature(enemycolor($c)).$of_your_choice;
				case 10: return $the_imperative." tap".$s." two target creatures".$of_your_choice;
				case 11: return $the_imperative." exile".$s." target creature".$of_your_choice;
				case 12: return $the_imperative." return".$s." target exiled creature".$of_your_choice." to the battlefield under its owner&rsquo;s control";
				case 13: return $the_imperative." put".$s." a +1/+1 counter on each ".random_creature($c)." ".that_player($p)." control".$s2;
				case 14: return $the_imperative." put".$s." a +1/+1 counter on each ".random_creature($c)." ".that_player($p)." control".$s2;
				case 15: return $the_imperative." exile".$s." target attacking ".random_enemy_creature(enemycolor($c)).$of_your_choice;
				case 16: return $the_imperative." exile".$s." target blocked ".random_enemy_creature(enemycolor($c))." ".$of_your_choice;
		  }
		case "blue":
		  switch(mt_rand(1,20)) {
				case 1: return $the_imperative." draw".$s." a card";
				case 2:
					$tmp = mt_rand(1,4);
					if ($tmp == 1) return $the_imperative." put".$s." a -1/-1 counter on target ".random_creature(enemycolor($c)).$of_your_choice;
					else return $the_imperative." put".$s." ".word($tmp)." -1/-1 counters on target ".random_creature(enemycolor($c)).$of_your_choice;
				case 3: return $the_imperative." put".$s." the top ".word(mt_rand(2,5))." cards of ".your($p)." library into ".your($p)." graveyard";
				case 4: return $the_imperative." exile".$s." a creature card from ".your($p)." graveyard";
				case 5: return $the_imperative." exile".$s." ".a_random_creature(friendcolor($c))." card from ".your($p)." graveyard";
				case 6: return $the_imperative." put".$s." a token onto the battlefield that&rsquo;s a copy of target exiled ".random_permanent(friendcolor($c))." card";
				case 7: return $the_imperative." tap".$s." target ".random_permanent(friendcolor($c)).$of_your_choice;
				case 8: return $the_imperative." tap".$s." target creature".$of_your_choice;
				case 9: return $the_imperative." look".$s." at the top card of ".your($p)." library";
				case 10: return $the_imperative." reveal".$s." the top card of ".your($p)." library";
				case 11: return $the_imperative." transform".$s." target double-faced ".random_creature(friendcolor($c))." card".$of_your_choice;
				case 12: return $the_imperative." discard".$s." an instant or sorcery card or reveal".$s." a hand with no such card";
				case 13: return $the_imperative." look".$s." at the top ".word(mt_rand(2,5))." cards of ".your($p)." library, then ".put_one_card_into_your_random_zone($s,$p);
				case 14: return $the_imperative." return".$s." target ".random_permanent(friendcolor($c))."".$of_your_choice." card from ".your($p)." graveyard to ".your($p)." hand";
				case 15: return $the_imperative." put".$s." target creature".$of_your_choice." on top of its owner&rsquo;s library";
				case 16: return $the_imperative." shuffle".$s." up to ".word(mt_rand(2,5))." target ".thing_in_a_random_zone("cards ".he_or_she($p)." own".$s)."".$of_your_choice." into ".your($p)." library";
				case 17: return $the_imperative." return".$s." target exiled ".random_permanent($c)." to ".your($p)." hand";
				case 18: return $the_imperative." return".$s." target ".random_permanent(enemycolor($c))." to its owner's hand";
				case 19: return $the_imperative." put".$s." a ".mt_rand(1,3)."/".mt_rand(1,3)." blue ".random_creature($c)." creature token onto the battlefield, then sacrifice".$s." a ".random_permanent($c).$of_your_choice;
				case 20:
					$c = friendcolor($c);
					return $the_imperative." exile".$s." a ".random_permanent($c)."".$of_your_choice." and put".$s." a ".mt_rand(1,3)."/".mt_rand(1,3)." ".$c." ".random_creature($c)." creature token onto the battlefield";
		  }
		case "black":
			switch(mt_rand(1,21)) {
				case 1: return $the_imperative." sacrifice".$s." ".a_random_creature($c);
				case 2: 
				case 3: return $the_imperative." discard".$s." ".mt_rand(2,4)." cards";
				case 4: return $p." lose".$s." ".mt_rand(2,4)." life";
				case 5: return $the_imperative." exile".$s." a ".random_creature(enemycolor($s))." card from ".your($p)." graveyard";
				case 6: return $the_imperative." sacrifice".$s." a creature and gain".$s." life equal to that creature&rsquo;s toughness";
				case 7:
					$tmp = friendcolor($c);
					return $the_imperative." put".$s." X 2/2 ".friendcolor($tmp)." ".random_creature($tmp)." creature tokens onto the battlefield, where X is half the number of the ".random_creatures($tmp)." ".that_player($p)." control".$s2.", rounded down";
				case 8:
				case 9: return $the_imperative." return".$s." target ".random_creature($c)."".$of_your_choice." card from ".your($p)." graveyard to ".your($p)." hand";
				case 10: return $the_imperative." return".$s." two target ".random_creatures($c)." card".$of_your_choice." from ".your($p)." graveyard to ".your($p)." hand";
				case 11: return $the_imperative." return".$s." a ".random_creature($c)." card".$of_your_choice." at random from ".your($p)." graveyard to ".your($p)." hand";
				case 12: return "each player discards a card";
				case 13: return "each player sacrifices ".a_random_permanent(enemycolor($c));
				case 14: return $the_imperative." exile".$s." a card from ".your($p)." hand";
				case 15: return $the_imperative." destroy".$s." target non-".random_creature($c)." creature".$of_your_choice;
				case 15: return $the_imperative." destroy".$s." target nonblack creature".$of_your_choice;
				case 16: return $the_imperative." destroy".$s." target nonartifact creature".$of_your_choice;
				case 17: return $the_imperative." exile".$s." target creature".$of_your_choice." and all other creatures with the same name as that creature";
				case 18:
					$tmp = mt_rand(2,5);
					if (mt_rand(0,1)) $flying = "with flying";
					else $flying = "";
					return $the_imperative." put a ".$tmp."/".$tmp." black ".random_creature($c)." creature token ".$flying." onto the battlefield";
				case 19: return $the_imperative." return".$s." target ".random_creature($c)." card".$of_your_choice." from ".your($p)." graveyard to the battlefield";
				case 20: return $the_imperative." destroy".$s." all non-".random_creature($c)." creatures";
				case 21: return $the_imperative." put".$s." a +1/+1 counter on target ".random_creature($c).$of_your_choice;
			}
		case "red":	
		  switch(mt_rand(1,16)) {			
				case 1: return $the_imperative." untap".$s." all ".random_creatures($c)." ".he_or_she($p)." control".$s2;
				case 2:
					if (mt_rand(0,1)) return $the_imperative." draw".$s." a card, then discard".$s." a card";
					else return $the_imperative." draw".$s." two cards, then discard".$s." two cards";
				case 4: return $p." may cast".$s." target".$of_your_choice." spell ".from_random_zone();
				case 3: return $p." may cast".$s." ".a_random_spell($c,true)." ".from_random_zone();
				case 5: return $p." may cast".$s." target instant or sorcery spell".$of_your_choice." ".from_random_zone();
				case 6: return $the_imperative." put".$s." a +1/+1 counter on target creature".$of_your_choice;
				case 7: return $the_imperative." put".$s." a +1/+1 counter on target ".random_creature(friendcolor($c)).$of_your_choice;
				case 8: return $the_imperative." draw".$s." two cards, then discard".$s." a card"; 
				case 9: return $the_imperative." draw".$s." a card, then discard".$s." two cards";
				case 10: return $the_imperative." put".$s." two +1/+1 counters on target creature".$of_your_choice; 
				case 11: return $the_imperative." exile".$s." ".word(mt_rand(2,5))." cards from ".your($p)." graveyard";
				case 12: return $the_imperative." put".$s." the top ".word(mt_rand(2,5))." cards of ".your($p)." library into ".your($p)." graveyard";
				case 13:
					$tmp = ""; for ($i = 0; $i < mt_rand(1,5); $i++) $tmp = $tmp."{R}";
					return $the_imperative." add".$s." ".$tmp." to ".your($p)." mana pool";
				case 14: return $the_imperative." destroy".$s." target land".$of_your_choice;
				case 15: return $the_imperative." destroy".$s." target ".random_permanent(enemycolor($c)).$of_your_choice;
				case 16: return $the_imperative." untap".$s." and gain".$s." control of target ".random_permanent(enemycolor($c))."".$of_your_choice." until end of turn";
		  }
		case "green":
		  switch(mt_rand(1,8)) {
				case 1: return $the_imperative." put".$s." a +1/+1 counter on each ".random_creature($c)." ".that_player($p)." control".$s2;
				case 2: return $the_imperative." destroy".$s." target noncreature permanent".$of_your_choice;
				case 3: return $the_imperative." destroy".$s." target nongreen permanent".$of_your_choice;
				case 4: return $the_imperative." return".$s." all ".random_creatures($c)." from ".your($p)." graveyard to ".your($p)." hand";
				case 5: return $the_imperative." return".$s." target ".random_creature(friendcolor($c))."".$of_your_choice." from your graveyard to ".your($p)." hand";
				case 6: return $the_imperative." regenerate".$s." all ".random_creatures(friendcolor($c))." ".that_player($p)." control".$s2;
				case 7: return $the_imperative." search".$es." ".your($p)." library for a ".random_creature($c)." card, then put".$s." it into ".your($p)." hand";
				case 8: return $the_imperative." search".$es." ".your($p)." library for a ".random_creature($c)." card, reveal".$s." it, then put".$s." it into ".your($p)." hand";
		  }
	}	
}


// ******************
//  Action -- Something a player actively performs
// ($static is only passed along, an action cannot be static)
// ******************
function ACTION($t,$p,$followup,$static,$c,$n,$favorable = false,$may = false) {
	
	//Fix for "Whenever (action)", as "you" is omitted in the actual action text.
//	if (($followup || $may) && $p == "you") {
//		$t = $t." you";
//	}
	$t = $t." ".ACTION_NOFOLLOW($p,$c,$may,true); // Possibly may, first!
		
	if ($may)	$followup = true;
	
	// Follow-up is required?
	// If $followup is true, this action is a conditional action. Something else must follow it
	if ($followup) {
	//echo "ACTION: There is a follow-up requirement<br>";		
		$followup = false;
		if ($may) $tmp2 = 2;
		else $tmp2 = mt_rand(1,3);
		switch($tmp2) {
			case 1:
			  // ", target player may ACTION" follows conditional action.
					$t = $t.", ".ACTION_NOFOLLOW($p,$c,true,false); //May, not first.
					break;
			case 2:
			  // ", EFFECT" follows conditional action.
				$tmp[] = ": Unless";
				$tmp[] = ": Whenever";
				if (in_array(trim($t),$tmp) || substr(trim($t),0,4) == "when" || substr(trim($t),0,4) == "unle")
					return EFFECT($t.", ",false,$static,$c,$n,$favorable); 
				else {
					if (mt_rand(0,1)) $tmp2 = "n&rsquo;t";
					else $tmp2 = "";
					if ($p == "you") return EFFECT($t.". If you do".$tmp2.", ",false,$static,$c,$n,$favorable);
					else return EFFECT($t.". If he or she does".$tmp2.", ",false,$static,$c,$n,$favorable);
				}
				break;
			case 3:
			  // "(you) ACTION" follows conditional action.
					$t = $t.", ".ACTION_NOFOLLOW("you",$c,false,false);
					break;
		}
	} 


	
	// reset $may for the follow-up
	if (mt_rand(1,10) == 1) { $may = true; }// TODO tweak this!
	else { $may = false; }

	$tobecontinued = false;

	if (!$tobecontinued) {
		//Return here if text is too big
		if (strlen($t) > 150) { return $t; }
		switch(mt_rand(1,15)) {
			case 1:
				//ACTION may be followed by IF YOU DO, ACTION/EFFECT (20%)
				if (mt_rand(0,1)) $tmp = "n&rsquo;t";
				if (mt_rand(0,1)) {
					if ($p == "you") return ACTION($t.". If you do".$tmp.", ",PLAYER(),false,$static,$c,$n,$favorable,$may);
					else return ACTION($t.". If he or she does".$tmp.", ",PLAYER(),false,$static,$c,$n,$favorable,$may);
				}
				else {
					if ($p == "you") return EFFECT($t.". If you do".$tmp.", ",false,$static,$c,$n,$favorable,$may);
					else return EFFECT($t.". If he or she does".$tmp.", ",false,$static,$c,$n,$favorable,$may);	
				}
			case 2:
			//ACTION may be followed by AND ACTION. (20%)
				return ACTION($t." and",$p,$followup,$static,$c,$n,$favorable,$may); break;
			default:
			//ACTION may end sentence (60%)
				return $t; 
		}
	}
	// else
	switch(mt_rand(1,2)) {
		case 1: return ACTION($t." and",PLAYER(),false,$static,$c,$n,$favorable,$may); break;
		case 2: return EFFECT($t." and",false,$static,$c,$n,$favorable); break;
	}
	// Never reached
}

function COST($c,$cmc) {
  $t = generate_manacost($c,$cmc);
  if (!mt_rand(0,2)) $t = $t.", {T}";
  if ($c == "black")
  	switch(mt_rand(1,5)) {
  		case 1: $t = $t.", Pay ".mt_rand(1,$cmc)." life"; break;
  		case 2: $t = $t.", Sacrifice ".a_random_permanent($c); break;
  		case 3: $t = $t.", Sacrifice ".a_random_creature($c); break;
		}
  if ($c == "blue")
   	switch(mt_rand(1,7)) {
  		case 1: $t = $t.", Discard a blue card"; break;
  		case 2: $t = $t.", Tap an untapped ".random_permanent($c)." you control"; break;
  		case 3: $t = $t.", Untap a tapped ".random_permanent($c)." you control"; break;
  		case 4: $t = $t.", Discard a card"; break;
			case 5: $t = $t.", Return ".a_random_creature($c)." to your hand"; break;
   	}
  if ($c == "red" && mt_rand(0,1)) $t = $t.", Sacrifice ".a_random_permanent($c);
  if ($c == "green" && mt_rand(0,1)) $t = $t.", Return a Forest to your hand";
  if ($c == "white" && mt_rand(0,1)) $t = $t.", Tap an untapped ".random_creature($c)." you control";
  return $t.": "; 
}

function enter_random_zones() {
	switch(mt_rand(1,5)) {
		case 1: return "be exiled";
		case 2: return "enter the battlefield";	
		case 3: return "be put into graveyards";
		case 4: return "be put into hands";
		case 5: return "be put into libraries";		
		case 6: return "be put on top of libraries";		
		case 7: return "be put at the bottom of libraries";
	}
}

function random_zone() {
	switch(mt_rand(1,5)) {
		case 1: return "exile zone";
		case 2: return "battlefield";	
		case 3: return "graveyard";
		case 4: return "hand";
		case 5: return "library";		
	}
}

function in_a_random_zone() {
	switch(mt_rand(1,3)) {
		case 1: return "exiled";
		case 2: return "on the battlefield";	
		case 3: 
			if (mt_rand(0,1)) return "in your graveyard";
			return "in a graveyard";
	}
}

function thing_in_a_random_zone($thing) {
	switch(mt_rand(1,3)) {
		case 1: return "exiled ".$thing;
		case 2: return $thing." on the battlefield";	
		case 3: 
			if (mt_rand(0,1)) return $thing." in your graveyard";
			return $thing." in a graveyard";
	}
}


function put_one_card_into_your_random_zone($s,$p) {
	switch(mt_rand(1,5)) {
		case 1: return "exile".$s." one of them";
		case 2: return "play".$s." one of them without paying its mana cost";
		case 3: return "put".$s." one of them on the bottom of ".your($p)." library";
		case 4: return "put".$s." one of them into ".your($p)." graveyard";
		case 5: return "put".$s." one of them into ".your($p)." hand";
	}
}

function is_put_into_random_zone($creature) {

//	$creature = true; //static?
	switch(mt_rand(1,5)) {
		case 1: return "is exiled";
		case 2: return "enters the battlefield";	
		case 3: {
			if ($creature) return "dies";
			return "is put into your graveyard";
		}
		case 4: return "is returned to your hand";
		case 5: return "is put into your library";		
	}
}

function from_random_zone() {
	switch(mt_rand(1,5)) {
		case 1: return "from the exile zone";
		case 2: return "from the battlefield";	
		case 3:
			if(mt_rand(1,2)) return "from a graveyard";
			return "from your graveyard";
		case 4:
			if(mt_rand(1,2)) return "from an opponent's hand";
			return "from your hand";
		case 5:
			if(mt_rand(1,2)) return "from a library";
			return "from your library";		
	}
}

function from_random_zones() {
	switch(mt_rand(1,5)) {
		case 1: return "from the exile zone";
		case 2: return "from the battlefield";	
		case 3:	return "from graveyards";
		case 4:	return "from hands";
		case 5:	return "from libraries";		
	}
}


function friendcolor($color) {
	switch($color) {
		case "white":
			switch(mt_rand(1,3)) {
				case 1: return "green";
				case 2: return "white";
				case 3:	return "blue";
			}
		case "blue":
			switch(mt_rand(1,3)) {
				case 1: return "white";
				case 2: return "blue";
				case 3:	return "black";
			}
		case "black":
			switch(mt_rand(1,3)) {
				case 1: return "blue";
				case 2: return "black";
				case 3:	return "red";
			}
		case "red":
			switch(mt_rand(1,3)) {
				case 1: return "black";
				case 2: return "red";
				case 3:	return "green";
			}
		case "green":
			switch(mt_rand(1,3)) {
				case 1: return "red";
				case 2: return "green";
				case 3:	return "white";
			}
	}	
}

function enemycolor($color) {
	switch($color) {
		case "white":
			switch(mt_rand(1,2)) {
				case 1: return "red";
				case 2: return "black";
			}
		case "blue":
			switch(mt_rand(1,2)) {
				case 1: return "green";
				case 2: return "red";
			}
		case "black":
			switch(mt_rand(1,2)) {
				case 1: return "green";
				case 2: return "white";
			}
		case "red":
			switch(mt_rand(1,2)) {
				case 2: return "blue";
				case 3:	return "white";
			}
		case "green":
			switch(mt_rand(1,2)) {
				case 1: return "black";
				case 2: return "blue";
			}
	}	
}

function are_random_permanents($c) {
	$tmp = random_permanents($c);
	if (strpos(" ".$tmp,"creatures")) {
		$size = mt_rand(1,3);
		$tmp = $size."/".$size." ".$tmp;
	}
	$tmp = str_replace("permanents","",$tmp);
	if (strpos(" ".$tmp,"planeswalkers")) {
		$tmp = $tmp." with loyalty count ".word(mt_rand(2,6));	
	}
	if (strpos(" ".$tmp,"basic lands")) {
		$tmp = basic_lands($c);	
	}

	return "are ".$tmp;
}



function random_permanents($c) {
	$retval = random_permanent($c,false);
	if (substr($retval,strlen($retval)-2,2) == "us") return substr($retval,0,strlen($retval)-1)."i"; // Homunculus -> Homunculi, Jesus -> Jesi etc.
	elseif (substr($retval,strlen($retval)-2,2) == "ns") return $retval; // Plains
	elseif (substr($retval,strlen($retval)-1,1) == "s") return $retval."es"; // Bonus -> Bonuses, etc.
	elseif (substr($retval,strlen($retval)-1,1) == "f") return substr($retval,0,strlen($retval)-1)."ves"; // Wolf -> Wolves, etc.
	else return $retval."s"; // Default: "permanent" -> "permanents" etc.
}

function target_random_permanent($c) {
	return "target ".random_permanent($c);
}

function a_random_permanent($c) {
	$retval = random_permanent($c,false);
	if (substr($retval,0,1) == "A" || substr($retval,0,1) == "E" || substr($retval,0,1) == "I" || substr($retval,0,1) == "O" || substr($retval,0,1) == "U" || substr($retval,0,1) == "Y" || substr($retval,0,1) == "a" || substr($retval,0,1) == "e" || substr($retval,0,1) == "i" || substr($retval,0,1) == "o" || substr($retval,0,1) == "u" || substr($retval,0,1) == "y") return "an ".$retval;
	return "a ".$retval;
}

function a($retval) {
	if (substr($retval,0,1) == "A" || substr($retval,0,1) == "E" || substr($retval,0,1) == "I" || substr($retval,0,1) == "O" || substr($retval,0,1) == "U" || substr($retval,0,1) == "Y" || substr($retval,0,1) == "a" || substr($retval,0,1) == "e" || substr($retval,0,1) == "i" || substr($retval,0,1) == "o" || substr($retval,0,1) == "u" || substr($retval,0,1) == "y") return "an ".$retval;
	return "a ".$retval;
}

function random_permanent($c) {
		switch(mt_rand(1,30)) {
			case 1:
			case 2:
			case 3:
			case 4:	return $c." creature";
	    case 5: 
	    case 6: return "creature";
			case 7: return 'artifact';
			case 8: return  "enchantment";
			case 9: return  "planeswalker";
			case 10: return  "land";
			case 11: return  "basic land";
			case 12: return  "nonbasic land";
			case 13: 
			case 14: 
			case 15: return  random_creature(friendcolor($c));
			case 16: 
			case 17: return  $c." permanent";
			case 18: return  "multicolored permanent";
			case 19: return  "monocolored permanent";
			case 20: return  "colorless permanent";
			case 21:
			case 22: 
			case 23: 
			case 24: 
			case 25: basic_land($c);
			default: return random_creature($c);
		}
}

function bothmana($c) {
	return mana($c).mana($c);	
}

function mana($c) {
	switch($c) {
		case "white": return "{W}";
		case "blue": return "{U}";
		case "black": return "{B}";
		case "red": return "{R}";
		case "green": return "{G}";	
	}	
}

function basic_land($c) {
	switch($c) {
		case "white": return "Plains";
		case "blue": return "Island";
		case "black": return "Swamp";
		case "red": return "Mountain";
		case "green": return "Forest";	
	}	
}

function basic_lands($c) {
	switch($c) {
		case "white": return "Plains";
		case "blue": return "Islands";
		case "black": return "Swamps";
		case "red": return "Mountains";
		case "green": return "Forests";	
	}	
}

function CONDITION_NOFOLLOW($t,$followup,$static,$color,$n,$favorable) {
	
	$p = PLAYER_NOTARGET();
	
	switch($color) {
		case "white":
			switch(mt_rand(1,4)) {
				case 1: return $t." ".a_random_permanent($color)." is ".in_a_random_zone();
				case 2:	return $t." ".$p." control".S($p)." ".a_random_permanent($color);
				case 3: return $t." ".$p." control".S($p)." ".a_random_creature($color);
				default: break;
			}
		case "blue":
			switch(mt_rand(1,3)) {
				case 1: return $t." ".a_random_permanent($color)." is ".in_a_random_zone();
				case 2: return $t." an opponent controls an Island";
				default: break;
			}
		case "black":
			switch(mt_rand(1,3)) {
				case 1: return $t." ".a_random_permanent($color)." is ".in_a_random_zone();
				case 2: return $t. " an opponent has ".mt_rand(5,20)." or less life";
				default: break;
			}
		case "red":
			switch(mt_rand(1,3)) {
				case 1: return $t." ".a_random_permanent($color)." is ".in_a_random_zone();
				case 2: return $t."  an opponent controls ".a_random_creature(enemycolor($color));
				default: break;
			}
		case "green":
			switch(mt_rand(1,3)) {
				case 1: return $t." ".a_random_permanent($color)." is ".in_a_random_zone();
				case 2: return $t."  you have ".mt_rand(5,20)." or more life";
				default: break;
			}
	}
	// Common
	switch(mt_rand(1,1)) {
		case 1: return $t." ".$p." control".S($p)." ".word(mt_rand(2,5))." or more ".random_creatures($color);	
	}	
	//Never reached
}

function CONDITION($t,$followup,$static,$c,$n,$favorable) {
 $t = CONDITION_NOFOLLOW($t,$followup,$static,$c,$n,$favorable);
 switch(mt_rand(1,30)) {
		//CONDITION may be followed by AND CONDITION. (low odds)
		case 1: return CONDITION($t." and ",$followup,$static,$c,$n,$favorable);
		//CONDITION may be followed by OR CONDITION. (low odds)
		case 2: return CONDITION($t." or ",$followup,$static,$c,$n,$favorable);
		//CONDITION may be followed by unless CONDITION. (low odds)
		case 3: return CONDITION($t.", unless ",$followup,$static,$c,$n,$favorable);
		//CONDITION may be followed by comma EFFECT. (80%)
		default: return EFFECT($t,$followup,$static,$c,$n,$favorable);
 }
 //Condition CANNOT end the sentence.
}

function TARGET_PLAYER() {
	switch(mt_rand(1,7)) {
	 case 1: return "target opponent";
 	 case 2: return "target player";
 	 default: return "you";
	}	
}

function PLAYER_NOTARGET() {
	switch(mt_rand(1,6)) {
	 case 1: return "an opponent";
 	 case 2: return "a player";
 	 default: return "you";
	}	
}

function ENEMY_PLAYER() {
	switch(mt_rand(1,2)) {
 	 case 1: return "target opponent";
 	 case 2: return "target player";
	}		
}

function PLAYER() {
	switch(mt_rand(1,10)) {
	 case 1: return "target player";
 	 case 2: return "target opponent";
 	 case 3: return "target player";
 	 default: return "you";
	}
}

function UNLESS($t,$c,$n,$favorable) {
	//$t = " (UNLESS) ".$t;
	switch(mt_rand(1,3)) {
	 	case 1:
  		// $followup = true: Require follow up consequence
  		// $static = false;
  		// $favorable = TODO;
  		// $may = false;
  		$p = PLAYER(); 
  		if ($p == "you") $t = ACTION($t." unless you",$p,true,false,$c,$n,$favorable,false);
 			else $t = ACTION($t." unless",$p,true,false,$c,$n,$favorable,false);
	 		break;
	 
		case 2:
	  	// $followup = true: Require follow up consequence
	 		$t = "unless ".CONDITION($t,true,false,$c,$n,$favorable);
	 		break;

		case 3:
	  	// $followup = true: Require follow up consequence
	 		$t = "if ".CONDITION($t,true,false,$c,$n,$favorable);
	 		$t = $t.". Otherwise, ";
	 		$t = ACTION($t,"you",false,false,$c,$n,false,false);
	 		break;

	}
	return $t;
}

function keyword() {
	do {
		$first = mt_rand(1,16);
		$second = mt_rand(1,16);
	} while ($first == $second);
	
	switch($first) {
		case 1: $first = "Flash"; break;
		case 2: $first = "Un"; break;
		case 3: $first = "Multi"; break;
		case 4: $first = "Con"; break;
		case 5: $first = "Trans"; break;
		case 6: $first = "Sub"; break;
		case 7: $first = "Metal"; break;
		case 8: $first = "Land"; break;
		case 9: $first = "Split"; break;
		case 10: $first = "In"; break;	
		case 11: $first = "Life"; break;
		case 12: $first = "Re"; break;
		case 13: $first = "Un"; break;
		case 14: $first = "Kin"; break;
		case 15: $first = "Sun"; break;	
		case 16: $first = "Soul"; break;		
	}
	switch($second) {
		case 1: $second = "back"; break;
		case 2: $second = "dying"; break;
		case 3: $second = "kicker"; break;
		case 4: $second = "spire"; break;
		case 5: $second = "form"; break;
		case 6: $second = "stance"; break;
		case 7: $second = "craft"; break;
		case 8: $second = "fall"; break;
		case 9: $second = "second"; break;
		case 10: $second = "print"; break;	
		case 11: $second = "link"; break;
		case 12: $second = "trace"; break;
		case 13: $second = "earth"; break;
		case 14: $second = "ship"; break;
		case 15: $second = "burst"; break;
		case 16: $second = "shift"; break;	
	}	
	return $first.$second;
}

function werewolf_paragraph($c,$n) {
	$favorable = false;
	switch(mt_rand(1,4)) {
			case 1:
				return "Whenever ".EVENT_TRIGGER("",$c,$n).", transform ".$n."."; $wr++; break;
			case 2:
				return "At the beginning of each upkeep, if ".CONDITION_NOFOLLOW("",false,true,$c,$n,$favorable).", transform ".$n."."; $wr++; break;
			default:	
				return "At the beginning of each upkeep, if no spells were cast last turn, transform ".$n."."; $wr++; break;		
		}	
}

function transform_paragraph($c,$n) {
	switch(mt_rand(1,4)) {
			case 1:
				return "Whenever ".EVENT_TRIGGER("",$c,$n).", transform ".$n."."; $wr++; break;
			case 2:
				return "At the beginning of each upkeep, if ".CONDITION_NOFOLLOW("",false,true,$c,$n,$favorable).", transform ".$n."."; $wr++; break;
			default:	
				return "At the beginning of each upkeep, if a player cast two or more spells last turn, transform ".$n."."; $wr++; break;		
		}	
}

function paragraph($cardtype,$c,$n) {
	
	//TODO Implement Sorcery vs. Instant
	//TODO Implement Enchantment (Curses!)
	$favorable = false;
	$may = false;
	
	if ($cardtype == "creature" || $cardtype == "land") {
		// Card is creature
		switch(mt_rand(1,6)) {
			case 1:
			case 2:
			case 3:
				// COST may start on creatures
				switch(mt_rand(1,8)) {
					//COST may be followed by AT TIME
					case 1: $t = COST($c,mt_rand(1,3)).ucfirst(trim(AT_TIME("",$c,$n,$favorable))); break;
					//COST may be followed by UNTIL EOT
					case 2: $t = COST($c,mt_rand(1,3)).ucfirst(trim(UNTIL_EOT("",$c,$n,$favorable))); break;
					//COST may be followed by UNLESS
					case 3: $t = COST($c,mt_rand(1,3)).ucfirst(trim(UNLESS("",$c,$n,$favorable))); break;
					//COST may be followed by EFFECT
					case 4:
					case 5:
					case 6: $t = COST($c,mt_rand(1,3)).ucfirst(trim(EFFECT("",false,false,$c,$n,$favorable))); break;
					//COST may be followed by ACTION
					default:
						if (mt_rand(1,6) == 1) { $may = true; } // TODO tweak this!
						else { $may = false; }
						$t = COST($c,mt_rand(1,3)).ucfirst(trim(ACTION("",PLAYER(),false,false,$c,$n,$favorable,$may))); break;
				}
				//Follow up COST?
				switch(mt_rand(1,15)) {
					case 1: $t=$t.". Activate this ability only once each turn"; break;
					case 2: $t=$t.". Activate this ability only during your turn"; break;
					case 3: $t=$t.". Any player may activate this ability"; break;
					case 4: $t = CONDITION_NOFOLLOW($t.". Activate this ability only if",false,true,$c,$n,$favorable); break;
					case 5: $t = CONDITION_NOFOLLOW($t.". This ability can't be activated if",false,true,$c,$n,$favorable); break;
					case 6: $t=$t.". Any player may activate this ability"; break;
				}
				return $t.".";
			case 4:
				// WHENEVER may start on permanents
					return WHENEVER("",$c,$n,$favorable).".";					
			default:
			  // STATIC EFFECTS without followups may start on permanents.
			  return ucfirst(trim(EFFECT("",false,true,$c,$n,$favorable))).".";
		}
	}
	
	if ($cardtype == "artifact") {
		// Card is creature
		switch(mt_rand(1,5)) {
			case 1:
				// COST may start on creatures
				switch(mt_rand(1,5)) {
					//COST may be followed by AT TIME
					case 1: $t = COST($c,mt_rand(1,3)).ucfirst(trim(AT_TIME("",$c,$n,$favorable))); break;
					//COST may be followed by UNTIL EOT
					case 2: $t = COST($c,mt_rand(1,3)).ucfirst(trim(UNTIL_EOT("",$c,$n,$favorable))); break;
					//COST may be followed by UNLESS
					case 3: $t = COST($c,mt_rand(1,3)).ucfirst(trim(UNLESS("",$c,$n,$favorable))); break;
					//COST may be followed by EFFECT
					case 4: $t = COST($c,mt_rand(1,3)).ucfirst(trim(EFFECT("",false,false,$c,$n,$favorable))); break;
					//COST may be followed by ACTION
					case 5:
						if (mt_rand(1,10) == 1) { $may = true; } // TODO tweak this!
						else { $may = false; }
						$t = COST($c,mt_rand(1,3)).ucfirst(trim(ACTION("",PLAYER(),false,false,$c,$n,$favorable,$may))); break;
				}
				//return $t.".";
				//Follow up COST?
				switch(mt_rand(1,15)) {
					case 1: $t=$t.". Activate this ability only once each turn"; break;
					case 2: $t=$t.". Activate this ability only during your turn"; break;
					case 3: $t=$t.". Any player may activate this ability"; break;
					case 4: $t = CONDITION_NOFOLLOW($t.". Activate this ability only if",false,true,$c,$n,$favorable); break;
					case 5: $t = CONDITION_NOFOLLOW($t.". This ability can't be activated if",false,true,$c,$n,$favorable); break;
					case 6: $t=$t.". Any player may activate this ability"; break;
				}
				return $t.".";
			case 2:
				// WHENEVER may start on permanents
					return WHENEVER("",$c,$n,$favorable).".";					
			default:
			  // STATIC EFFECTS without followups may start on permanents.
			  return ucfirst(trim(EFFECT("",false,true,$c,$n,$favorable))).".";
		}
	}

	elseif ($cardtype == "instant" || $cardtype == "sorcery") {
		// Card is spell
		switch(mt_rand(1,8)) {
				//AT TIME may start on spells
				case 1: return ucfirst(trim(AT_TIME("",$c,$n,$favorable))).".";
				//UNTIL_EOT may start on spells
				case 2: return ucfirst(trim(UNTIL_EOT("",$c,$n,$favorable))).".";					
				//UNLESS may start on spells
				case 3: return ucfirst(trim(UNLESS("",$c,$n,$favorable))).".";					
				//EFFECT may start on spells
				case 4:
				case 5: return ucfirst(trim(EFFECT("",false,false,$c,$n,$favorable))).".";
				//ACTION may start on spells
				default:
					if (mt_rand(1,7) == 1) { $may = true; }
					else { $may = false; }
					return ucfirst(trim(ACTION("",PLAYER(),false,false,$c,$n,$favorable,$may)).".");
		}
	}
	
	elseif ($cardtype == "enchantment") {
		switch(mt_rand(1,3)) {
			// WHENEVER may start on enchantments
			case 1:	return WHENEVER("",$c,$n,$favorable).".";		
		  // STATIC EFFECTS without followups may start on enchantments.
		  default: return ucfirst(trim(EFFECT("",false,true,$c,$n,$favorable))).".";
		}
	}
		
	elseif ($cardtype == "aura") {
		return ucfirst(trim(EFFECT("",false,true,$c,"enchanted creature",$favorable))).".";
	}
}

?>