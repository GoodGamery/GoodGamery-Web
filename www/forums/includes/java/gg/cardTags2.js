var UID = 0;

function getImageSource(cardname, set)
{
    set = set || "general";
    if( cardname === undefined || cardname.length == 0 )
    {
        return;
    }
    cardname = cardname.toLowerCase();
   
    cardname = cardname.replace(/ \(foil\)/g, "");             // ignore foils
    cardname = cardname.replace( /[ ]?\/\/[ ]?/g, "__" );      // Split cards
    cardname = cardname.replace( /[ ]?\/[ ]?/g, "_" );         // Who/What/When/Where/Why
    cardname = cardname.replace( /[ -]/g, "_" );               // Punctuation that becomes _
    cardname = cardname.replace( /[',:!\"]/g, "");             // Punctuation that is erased
    cardname = cardname.replace( /[\xE6\xE9]/g, "ae");         // AE ligature
    cardname = cardname.replace( /[\xE8\xE9é]/g, "e");          //'e
   
    if (set == "CON") {
        set = "general";
    }
   
    return "http://www.wizards.com/global/images/magic/" + set + "/" + cardname + ".jpg";
}

function installCardTags()
{
    var elementsZeta = document.getElementsByTagName("div"); 

    for( var ix = 0; ix < elementsZeta.length; ix++ )
    {
        if( elementsZeta[ix].className == "postbody" )
        {
            fixPost( elementsZeta[ix] );
        }
    }   
}

function replaceTags( toscan, tag, getReplacement )
{
    var begin, end;
    
    var opening = "[" + tag + "]";
    var closing = "[/" + tag + "]";
    
    var result = "";
    
    // Work from the end so that a hanging beginning tag screws up less.
    while( -1 != (begin = toscan.toLowerCase().lastIndexOf(opening)))
    {
        if( -1 == (end = toscan.toLowerCase().indexOf(closing, begin)))
        {
            break;
        }
        
        var innerText = toscan.substring( begin + opening.length, end );
        var replacement = getReplacement( innerText );
        
        if( undefined != replacement )
        {
            result = replacement + toscan.substring(end + closing.length) + result;
            toscan = toscan.substring(0,begin);
            found = true;
        }
        else
        {
            break;
        }
    }
    
    return toscan + result;
}


function proxyWindow( deck ) {
    OpenWindow = window.open("", "newwin", "toolbar=no,menubar=no,scrollbars=yes");
    OpenWindow.document.write("<TITLE>Printable Proxies 1.1</TITLE>");
    OpenWindow.document.write("<style>img { width: 2.37in; border: 0.03in solid black; }</style>");
    OpenWindow.document.write("<!-- Make sure you use 1/4&quot; margins and 100% scaling (do not fit to page). -->");
    
    var lines = deck.split ("&");
            
    var text = "";
    for (var i = 0; i < lines.length - 1; i++) {
        text += "<img src=" + lines[i] + " />";
    }
    
    OpenWindow.document.write(text);
    OpenWindow.document.write("</BODY></HTML>");

    OpenWindow.document.close();
}


function timeto(to) {
	var dateTo = new Date(to);
	if( Object.prototype.toString.call(dateTo) !== "[object Date]" || isNaN(dateTo.getTime()) ) {
		return "Invalid date entered in countdown tag.";
	}
	
	var dateNow = new Date();
    var diff = dateTo - dateNow;
    if(diff <= 0) {
        return "FIN.";
    }
    var one_second = 1000;
    var one_minute = one_second * 60;
    var one_hour = one_minute * 60;
    var one_day = one_hour * 24;
	var one_week = one_day * 7;
	var one_year = one_day * 365;

	var years = Math.floor( diff / one_year );
	diff -= years * one_year;
    var weeks = Math.floor( diff / one_week );
	diff -= weeks * one_week;
	var days = Math.floor(diff / one_day);
    diff -= days * one_day;
    var hours = Math.floor(diff / one_hour);
    diff -= hours * one_hour;
    var minutes = Math.floor(diff / one_minute);
    diff -= minutes * one_minute
    var seconds = Math.floor(diff / one_second);
	diff -= seconds * one_second;

    var rv = '';
    rv += years ? years + (years == 1 ? ' year, ' : ' years, ') : '';
    rv += weeks ? weeks + (weeks == 1 ? ' week, ' : ' weeks, ') : '';
    rv += days ? days + (days == 1 ? ' day, ' : ' days, ') : '';
    rv += hours ? hours + (hours == 1 ? ' hour, ' : ' hours, ') : '';
    rv += minutes + (minutes == 1 ? ' minute, ' : ' minutes, ');
    rv += seconds + (seconds == 1 ? ' second' : ' seconds');

    return rv;
}

function trim_whitespace(s) {
    while (s.charAt(0).match(/\s/)) {
        s = s.substring(1, s.length);
    }

    while (s.charAt(s.length - 1).match(/\s/)) {
        s = s.substring(0, s.length - 1);
    }

    return s;
}

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


function fixPost( post )
{
    var innerHTML = post.innerHTML;
    var initial = innerHTML;
    
    innerHTML = replaceTags( innerHTML,
                 "poker",
                 function( inner )
                 {
                     var base = '<img src="https://goodgamery.com/mt2/cards/';
                     var end = '.gif">';
                     
                     var rx = /\[([\dTJQKA][csdh])\]/g;
                     inner = inner.replace( rx, base+'$1'+end );
                     
                     rx = /\[([\dTJQKA][csdh]) ([\dTJQKA][csdh])\]/g;
                     inner = inner.replace( rx, base+'$1'+end+base+'$2'+end );
                     
                     rx = /\[([\dTJQKA][csdh]) ([\dTJQKA][csdh]) ([\dTJQKA][csdh])\]/g;
                     inner = inner.replace( rx, base+'$1'+end+base+'$2'+end+base+'$3'+end );
                     
                     rx = /\[([\dTJQKA][csdh]) ([\dTJQKA][csdh]) ([\dTJQKA][csdh]) ([\dTJQKA][csdh])\]/g;
                     inner = inner.replace( rx, base+'$1'+end+base+'$2'+end+base+'$3'+end+base+'$4'+end );                     

                     rx = /\[([\dTJQKA][csdh]) ([\dTJQKA][csdh]) ([\dTJQKA][csdh]) ([\dTJQKA][csdh]) ([\dTJQKA][csdh])\]/g;
                     inner = inner.replace( rx, base+'$1'+end+base+'$2'+end+base+'$3'+end+base+'$4'+end+base+'$5'+end );    
                     
                     inner = inner.replace( /\*\*\* SHOW DOWN \*\*\*(.*)\n\n/, "[spoiler]$1[/spoiler]\n\n" );
                     
                     return inner;
                 } );                

    innerHTML = replaceTags( innerHTML,
                 "deck",
                 function( inner )
                 {
                     inner = inner.replace(/^(<br>)+/, "");
                     inner = inner.replace(/(<br>)+$/, "");
                     inner = inner.replace( /<br>/gi, "\n" );
                     
                     var text = "";
                     var cardList = "";
                     
                     var blocks = inner.split(/\n\n/);
                     for (var bnum = 0; bnum < blocks.length; bnum++) {
                         var out_text = "";
                         var lines = blocks[bnum].split("\n");

                         for( var ix = 0; ix < lines.length; ix++ )
                         {
                             if (lines[ix].match(/^-{2,}$/)) {
                                 out_text += "<hr>";
                                 continue;
                             }
                             var parsed = parseLine( lines[ix] );
                         
                             if( parsed == undefined )
                             {
                                 out_text += lines[ix] + "<br>";
                             }
                             else
                             {
                                 out_text += '<a href="https://goodgamery.com/api/mtg/html?card=' + parsed.name + '" class="jTip" name=""  onclick=\'window.open("http://magiccards.info/card.php?card=' + parsed.name + '")\' >' + parsed.name + '</a><br/>';
                                 for (var jx = 0; jx < parsed.count; jx++)
                                 {
                                     cardList += getImageSource(parsed.name) + "&";
                                 }
                             }
                         }
                     
                         if (out_text != "") {
                             text += '<div class="deckbox">' + out_text + '</div>';
                         }
                     }
                     
                     text += "<div style='clear:left;'></div>"
                     
                     
                     var anchor = "";
                     anchor += "<a onclick='proxyWindow(\"";
                     anchor += cardList;
                     anchor += "\")'>Print Proxies</a>";
                     text += "<br>" + anchor + "<br>";
                     
                     return text;
                 
                 } );
              
               
    innerHTML = replaceTags( innerHTML,
                "draftcap",
                function draftcapReplace(inner) {
                  inner = inner.replace(/<br>/gi, "\n");
                  
                  var input_array = trim_whitespace(inner).split("\n");
                  var output = "";
                  var pack_counter = 1;
                  var last_size = 100;
  
                  while (input_array.length > 0) {
                    // handle pack
                    var pack_line = input_array.shift();
                    var pack_array = pack_line.split("%");
                    
                    if (pack_array.length > last_size) {
                      pack_counter++;
                    }
                    
                    last_size = pack_array.length;
                    
                    output += "&nbsp;&nbsp;p" + pack_counter + "p" + (16 - (pack_array.length / 2)) + "<br/>";
                    
                    while (pack_array.length > 0) {
                      var card = pack_array.shift();
                      if (card == "") { continue; }
                      
                      var set = pack_array.shift();
                      
                      var color = "black";
                      
                      if (card.match(/FOIL/) != null) {
                        color = "silver";
                      }
                      
                      output += "<img src='" + getImageSource(card, set) + "' style='height:143px; width:100px; margin:5px; border:4px solid " + color + ";'>";
                    }
                    
                    output += "<br/>";
                    
                    // handle pick
                    var pick = input_array.shift();
                    var set = input_array.shift();
                    output += "<img src='" + getImageSource(pick, set) + "' style='height:143px; width:100px; margin:5px; border:4px solid gold;'>";
                    output += "<br/><br/>";
                  }
                                  
                  output += "This draft converter created by <a href='mailto:ben@mundy.net'>Benjamin Peebles-Mundy</a>.<br/>\n";
                  output += "Visit the <a href='http://www.zizibaloob.com/'>draft converter</a> today!";
                  
                  return output;
                } );
                
    innerHTML = replaceTags( innerHTML,
                "countdown",
                function(inner) {
                    var id = 'countdown_' + UID++;         
                    setInterval(function() {
                        var t = timeto(inner)
                        var el = document.getElementById(id);
                        el.innerHTML = t;
                    }, 1000);
                    return "<span id='" + id + "'>" + inner + "</span>";                    
                });
                
    if(initial != innerHTML)
    {
        post.innerHTML = innerHTML;
    }
}

