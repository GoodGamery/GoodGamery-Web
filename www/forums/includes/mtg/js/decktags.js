jQuery(document).ready(decklist_init);

function parseLine( line ) {
	line = line.replace(/^\s*/, "");

	if( 	line.toLowerCase().indexOf("sideboard") == 0
		|| 	line.toLowerCase().indexOf("maindeck") == 0
		||	line.match( /^\s*(\/\/.*)?\s*$/ ) )
	{
		return undefined;
	}
	
	var cardname = line;
	var cardcount = 1;
			
	// ignore extra info for lists from apprentice
	cardname = cardname.replace(/^SB: /, "");
	cardname = cardname.replace(/\[.*?\]/, "" );

	if( /^\d+x?\s+/.test(cardname) ) {	
		var name = cardname.replace(/^\d+\s*(x\s+)?/, "");
		cardcount = cardname.substr( 0, cardname.length - name.length );
		cardcount = parseInt( cardcount );
		cardname = name;
	}	
	
	return { name : cardname, count : cardcount };
}

function decklist_init() {
    jQuery("span.decklist").each(function () {
        var item = jQuery(this);
        var inner = item.html();
        inner = inner.replace(/<br *\/?>/gi, "\n");
        var lines = inner.split("\n");
        
        var text = "";
        for (var ix = 0; ix < lines.length; ++ix) {
            var parsed = parseLine( lines[ix] );
                
            if( parsed == undefined ) {
                text += lines[ix] + "<br />";
            } else {
                var replacement = ' <a href="https://goodgamery.com/api/mtg/html?card={SIMPLETEXT}" class="jTip" name="" onclick="window.open(\'http://magiccards.info/card.php?card={SIMPLETEXT}\')" >{SIMPLETEXT}</a>';
                replacement = replacement.replace(/{SIMPLETEXT}/g, parsed.name);
                text += parsed.count + replacement + "<br />";
            }
        }
        
        item.replaceWith("<div>"+text+"</div>");
    });
}
