/*
 * JTip
 * By Cody Lindley (http://www.codylindley.com)
 * Under an Attribution, Share Alike License
 * JTip is built on top of the very light weight jquery library.
 */

//on page load (as soon as its ready) call JT_init
jQuery(document).ready(JT_init);

function JT_init(){
	       jQuery("a.jTip")
		   .hover(	function(){
						JT_show(this.href,this,this.name)},
					function(){
						jQuery('#JT').remove()
						})
           .click(function(){return false});	   
}

function JT_show(url,linkId,title)
{
	if(title == false)title="&nbsp;";
	var de = document.documentElement;
	var w = self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
	var hasArea = w - getAbsoluteLeft(linkId);
	var clickElementy = getAbsoluteTop(linkId) - 3; //set y position
	
	//check if the tooltip would overlap
	var pScroll = getPageScroll();
	var pSize = getPageSize();
	var overLap = false;
	if ( ( clickElementy + 290 ) > ( pScroll[1] + pSize[3] ) ){
		clickElementy -= 266;
		overLap = true;
	}
	
	var queryString = url.replace(/^[^\?]+\??/,'');
	var params = parseQuery( queryString );
	if(params['width'] === undefined){params['width'] = 250};
	if(params['link'] !== undefined){
	jQuery(linkId).bind('click',function(){window.location = params['link']});
	jQuery(linkId).css('cursor','pointer');
	}
	
	if(hasArea>((params['width']*1)+75)){
		jQuery("body").append("<div id='JT' style='display:none;width:"+params['width']*1+"px'><div id='JT_arrow'></div><div id='JT_copy'></div>");//right side
		var arrowOffset = getElementWidth(linkId) + 11;
		var clickElementx = getAbsoluteLeft(linkId) + arrowOffset; //set x position
		jQuery('#JT_arrow').addClass('JT_arrow_left');
	}else{
		jQuery("body").append("<div id='JT' style='display:none;width:"+params['width']*1+"px'><div id='JT_arrow' style='left:"+((params['width']*1)+1)+"px'></div><div id='JT_copy'></div>");//left side
		var clickElementx = getAbsoluteLeft(linkId) - ((params['width']*1) + 15); //set x position
		jQuery('#JT_arrow').addClass('JT_arrow_right');
	}
	
	jQuery('#JT').css({left: clickElementx+"px", top: clickElementy+"px"});
	
	if ( overLap ){
		jQuery('#JT_arrow').addClass('JT_arrow_bottom');
	}else{
		jQuery('#JT_arrow').addClass('JT_arrow_top');
	}
	//jQuery('#JT').show();
	
	jQuery('#JT').fadeIn("slow");
	jQuery('#JT_copy').load(url);

}

function getElementWidth(objectId) {
	x = objectId;
	return x.offsetWidth;
}

function getAbsoluteLeft(objectId) {
	// Get an object left position from the upper left viewport corner
	o = objectId;
	oLeft = o.offsetLeft            // Get left position from the parent object
	while(o.offsetParent!=null) {   // Parse the parent hierarchy up to the document element
		oParent = o.offsetParent    // Get parent object reference
		oLeft += oParent.offsetLeft // Add parent left position
		o = oParent
	}
	return oLeft
}

function getAbsoluteTop(objectId) {
	// Get an object top position from the upper left viewport corner
	o = objectId;
	oTop = o.offsetTop            // Get top position from the parent object
	while(o.offsetParent!=null) { // Parse the parent hierarchy up to the document element
		oParent = o.offsetParent  // Get parent object reference
		oTop += oParent.offsetTop // Add parent top position
		o = oParent
	}
	return oTop
}

function parseQuery ( query ) {
   var Params = new Object ();
   if ( ! query ) return Params; // return empty object
   var Pairs = query.split(/[;&]/);
   for ( var i = 0; i < Pairs.length; i++ ) {
      var KeyVal = Pairs[i].split('=');
      if ( ! KeyVal || KeyVal.length != 2 ) continue;
      var key = unescape( KeyVal[0] );
      var val = unescape( KeyVal[1] );
      val = val.replace(/\+/g, ' ');
      Params[key] = val;
   }
   return Params;
}

function blockEvents(evt) {
              if(evt.target){
              evt.preventDefault();
              }else{
              evt.returnValue = false;
              }
}

//cardzoomer for the draft view
jQuery(document).ready(cardzoomer_init);
function cardzoomer_init(){
	jQuery("img.cardzoomer")
	.hover( function(){
		show_card(this, this.src, "zoom")
	},
	function(){
	}
	)
	.click(function(){return false});
	
	jQuery("img.cardfader")
	.hover( function(){
		show_card(this, this.src, "fade")
	},
	function(){
	}
	)
	.click(function(){return false});
}

function show_card(element, src, mode){
	var dim = jQuery(element).offset();
	
	speed_zoom = 100; 
	speed_fade = 600;
	e_top 		= dim['top'];
	e_left 		= dim['left'];
	e_height	= jQuery(element).innerHeight();
	e_width		= jQuery(element).innerWidth();
	
	jQuery("body").append("<div id='card_hider' onmouseout='card_hider();'></div>"+
					"<div id='display_card_box' onmouseout='card_hider();'><img id='display_card' src=''/></div>");
	
	jQuery('#display_card_box').css('display','block')
							.css('position','absolute')
							.css('top',e_top)
							.css('left',e_left)
							.css('height',e_height)
							.css('width',e_width)
							.css('background-color','#000000');
	jQuery('#display_card').attr('src',src)
						.css('width',e_width)
						.css('height',e_height)
						.css('z-index','100');
	jQuery('#card_hider').css('position','absolute')
					.css('top',e_top)
					.css('left',e_left)
					.css('width',e_width)
					.css('height',e_height)
					.css('z-index','101');
	
	if(jQuery(element).hasClass('cardpick_border')){
		jQuery('#display_card_box').addClass('cardpick_border');
	}
	
	if( mode == "fade" ){
	
		var top = e_top-parseInt((285-e_height)/2);
		var left = e_left-parseInt((200-e_width)/2);
	
		jQuery('#display_card_box').css('display','block')
							.css('position','absolute')
							.css('top', (top+'px'))
							.css('left', (left+'px'))
							.css('height', '285px')
							.css('width', '200px')
							.css('background-color','#000000');
		jQuery('#display_card').attr('src',src)
							.css('width', '200px')
							.css('height', '285px')
							.css('z-index','100px');

		jQuery("#display_card_box").stop().css('display','none').fadeIn(speed_fade);
	}else{
		jQuery("#display_card").stop().animate({ 
			width: '200px',
			height: '285px'
			}, speed_zoom );

		jQuery("#display_card_box").stop().animate({ 
			width: '200px',
			height: '285px',
			top: e_top-((285-e_height)/2)+'px',
			left: e_left-((200-e_width)/2)+'px'
			}, speed_zoom );
	}
}
function card_hider(){
	if(jQuery('#display_card_box').length > 0){
		jQuery('#display_card_box').stop().remove();
		jQuery('#card_hider').stop().remove();
	}
}

function toggle_pick(elem){
	parent = jQuery(elem).parent().parent().parent().attr('id');
	jQuery('#'+parent+' .cardpick').each(function()
	{
		a_element = jQuery(this);

		if( a_element.is('img') ){
			if ( a_element.hasClass('cardpick_border') )
			{
				a_element.removeClass('cardpick_border');
				var n_width = (parseInt(a_element.css('width'))+4)+'px';
				a_element.css('width',n_width);
				var n_height = (parseInt(a_element.css('height'))+4)+'px';
				a_element.css('height',n_height);
				jQuery(elem).html('show pick');
			} else {
				a_element.addClass('cardpick_border');
				var n_width = (parseInt(a_element.css('width'))-4)+'px';
				a_element.css('width',n_width);
				var n_height = (parseInt(a_element.css('height'))-4)+'px';
				a_element.css('height',n_height);
				jQuery(elem).html('hide pick');
			}
		}
		if( a_element.is('a') ){
			if ( a_element.hasClass('cardpick_border') )
			{
				a_element.removeClass('cardpick_border');
				jQuery(elem).html('show pick');
			} else {
				a_element.addClass('cardpick_border');
				jQuery(elem).html('hide pick');
			}		
		}
	});
	return false;
}

// getPageScroll()
// Returns array with x,y page scroll values.
// Core code from - quirksmode.com
//
function getPageScroll(){

	var xScroll, yScroll;

	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
		xScroll = self.pageXOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		yScroll = document.documentElement.scrollTop;
		xScroll = document.documentElement.scrollLeft;
	} else if (document.body) {// all other Explorers
		yScroll = document.body.scrollTop;
		xScroll = document.body.scrollLeft;
	}

	arrayPageScroll = new Array(xScroll,yScroll)
	return arrayPageScroll;
}

//
// getPageSize()
// Returns array with page width, height and window width, height
// Core code from - quirksmode.com
// Edit for Firefox by pHaez
//
function getPageSize(){

	var xScroll, yScroll;

	if (window.innerHeight && window.scrollMaxY) {
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}

	var windowWidth, windowHeight;

//	console.log(self.innerWidth);
//	console.log(document.documentElement.clientWidth);

	if (self.innerHeight) {	// all except Explorer
		if(document.documentElement.clientWidth){
			windowWidth = document.documentElement.clientWidth;
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}

	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else {
		pageHeight = yScroll;
	}

//	console.log("xScroll " + xScroll)
//	console.log("windowWidth " + windowWidth)

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){
		pageWidth = xScroll;
	} else {
		pageWidth = windowWidth;
	}
//	console.log("pageWidth " + pageWidth)

	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight)
	return arrayPageSize;
}

function mtgh_tab(id,value,count,color,selected){
	for(i=0;i<=(count-1);i++){
		if(i==value){
			jQuery('#'+id+'_mtghtab_'+i).show();
			jQuery('#'+id+'_mtghtab_cat_'+i).attr('style','color:#FFFFFF;background:'+selected+';');
		}
		else{
			jQuery('#'+id+'_mtghtab_'+i).hide();
			jQuery('#'+id+'_mtghtab_cat_'+i).attr('style','color:#000000;background:'+color+';');
		}
	}
}