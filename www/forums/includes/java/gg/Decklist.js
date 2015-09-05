function parseLine( line )
{
    line = line.replace(/^\s*/, "");

    if(     line.toLowerCase().indexOf("sideboard") == 0
        ||     line.toLowerCase().indexOf("maindeck") == 0
        ||    line.match( /^\s*(\/\/.*)?\s*$/ ) )
    {
        return undefined;
    }
    
    var cardname = line;
    var cardcount = 1;
            
    // ignore extra info for lists from apprentice
    cardname = cardname.replace(/^SB: /, "");
    cardname = cardname.replace(/\[.*?\]/, "" );

    if( /^\d+x?\s+/.test(cardname) )
    {    
        var name = cardname.replace(/^\d+\s*(x\s+)?/, "");
        cardcount = cardname.substr( 0, cardname.length - name.length );
        cardcount = parseInt( cardcount );
        cardname = name;
    }    
    
    return { name : cardname, count : cardcount };
}
