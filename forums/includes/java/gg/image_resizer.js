function toggle_image(img) {
	var elem = $(img);
	const cls = 'resized';

	if (elem.hasClass(cls)) {
		elem.removeAttr('width');
		elem.removeAttr('height');
	} else {
		var w = elem.attar('width');
		elem.attr('width', 800);
		elem.attr('height', elem.attr('height') / (w / 800));
	}
	elem.toggleClass(cls);
}

function image_resizer() {
  var max_width = 800;
  var images = document.getElementsByTagName('img');

  for (var i = 0; i < images.length; i++) {
    if (images[i].width > max_width) {
      var w = images[i].width;
      var h = images[i].height;
      var ratio = w / max_width;
      var src = images[i].src;
      var parent = images[i].parentNode;
      var children = parent.childNodes;
      var new_children = [];

      for (var j = 0; j < children.length; j++) {
        new_children[j] = children[j];
        if (children[j] == images[i]) {
          var wrapper = document.createElement("div");
          wrapper.innerHTML = "<center>The following image has been resized. Click to see the original.</center>";
          wrapper.style.border = "1px dotted black";
          wrapper.style.padding = "5px";
          wrapper.style.fontSize = "smaller";
          wrapper.style.display = "block";
          wrapper.style.width = (max_width + 2) + "px";
		  /*
          var link = document.createElement("a");
          link.setAttribute("href", src);
          link.setAttribute("target", "_blank");
		  */
          var image = document.createElement("img");
          image.setAttribute("src", src);
          image.setAttribute("height", (h / ratio));
          image.setAttribute("width", (w / ratio));
          image.style.border = "1px dotted black";
          image.style.margin = "5px 0px 0px 0px";
	  image.className += "resized";
	  image.setAttribute("onClick", "toggle_image(this);");
          //link.appendChild(image);
          //wrapper.appendChild(link);
		  wrapper.appendChild(image);
          new_children[j] = wrapper;
        }
      }

      while (parent.childNodes.length > 0) {
        parent.removeChild(parent.firstChild);
      }

      for (var k = 0; k < new_children.length; k++) {
        parent.appendChild(new_children[k]);
      }
    }
  }
}
