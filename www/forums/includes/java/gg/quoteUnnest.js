function installQuoteUnnester()
{
	return;	// This doesn't work yet
    var qpost = getQPostElement();
    if(    qpost != undefined 
        && qpost.parentNode != undefined )
    {
        var buttonRemove = document.createElement("input");
        buttonRemove.setAttribute("type", "button");
        buttonRemove.setAttribute("value", "remove nested quotes");
        buttonRemove.onclick = removeNestedQuotes;
            
        qpost.parentNode.appendChild( document.createElement("br") );
        qpost.parentNode.appendChild( buttonRemove );
        
        var buttonBreak = document.createElement("input");
        buttonBreak.setAttribute("type", "button");
        buttonBreak.setAttribute("value", "shift up");
        buttonBreak.onclick = shiftQuoteUp;
        buttonBreak.setAttribute("id", "quoteShifter");
        qpost.parentNode.appendChild( buttonBreak );

        var buttonBreakShift = document.createElement("input");
        buttonBreakShift.setAttribute("type", "button");
        buttonBreakShift.setAttribute("value", "break and shift up");
        buttonBreakShift.onclick = breakQuote;
        buttonBreakShift.setAttribute("id", "quoteBreaker");
        qpost.parentNode.appendChild( buttonBreakShift );
    }
}

function shiftQuoteUp()
{
    var qpost = getQPostElement();
    var post = getPostElement();
    
    var author = "";
    var inputs = document.getElementsByTagName("input");
    for( var ix = 0; ix < inputs.length; ix++ )
    {
        if( inputs[ix].name == "QAuthorN" )
        {
            author = '=' + inputs[ix].value;
        }
    }
    
    
    if( qpost != undefined && post != undefined)
    {
        post.value = "[quote" + author + "]\n" + qpost.value + "\n[/quote]" + post.value;
        if(         undefined != qpost.parentNode
            &&    qpost.parentNode.parentNode != undefined)
        {
            qpost.parentNode.parentNode.removeChild( qpost.parentNode );
        }
    }    
}

function removeNestedQuotes()
{
    var qpost = getQPostElement();
    if( qpost != undefined )
    {
        var begin, end;
        
        while( -1 != (begin = qpost.value.toLowerCase().lastIndexOf("[quote")))
        {
            if( -1 == (end = qpost.value.toLowerCase().indexOf("[/quote]", begin)))
            {
                break;
            }
            
            qpost.value = trim_whitespace(qpost.value.substr(0, begin) + qpost.value.substr(end + "[/quote]".length));
        }
    }
}

function breakQuote()
{
    removeNestedQuotes();
    var qpost = getQPostElement();
    var post = getPostElement();
    if (!post || !qpost) return;
 
    var author = "";
    var inputs = document.getElementsByTagName("input");
    for( var ix = 0; ix < inputs.length; ix++ )
    {
        if( inputs[ix].name == "QAuthorN" )
        {
            author = '=' + inputs[ix].value;
        }
    }
    
    var qblocks = qpost.value.split('\n');    
    for (var i = 0; i < qblocks.length; i++) {
       if (qblocks[i].match("^\s*$")) continue;
       
       post.value += "[quote" + author + "]" + qblocks[i] + "[/quote]\n\n";
    }
    
    if(         undefined != qpost.parentNode
        &&    qpost.parentNode.parentNode != undefined)
    {
        qpost.parentNode.parentNode.removeChild( qpost.parentNode );
    }
}

function getQPostElement()
{
    var textareas = document.getElementsByTagName("textarea");
    for( var ix = 0; ix < textareas.length; ix++ )
    {
        if( textareas[ix].name == "Qmessage" )
        {
            return textareas[ix];
        }
    }
    
    return document.getElementById("txt_quote");
}

function getPostElement()
{    
    var textareas = document.getElementsByTagName("textarea");
    for( var ix = 0; ix < textareas.length; ix++ )
    {
        if( textareas[ix].name == "message" )
        {
            return textareas[ix];
        }
    }
    
    return document.getElementById("c_post-text");
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
