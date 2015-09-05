function toggle_decoder() {
    var decoder = document.getElementById('inline_decoder');
    var nav = document.getElementById('decoder_nav');
    
    if (nav.innerHTML == "Show Decoder") {
        nav.innerHTML = "Hide Decoder";
        decoder.style.display = "block";
    } else {
        nav.innerHTML = "Show Decoder";
        decoder.style.display = "none";
    }
}