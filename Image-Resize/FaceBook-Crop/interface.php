<style type="text/css">
    #image {
        position: relative;
        -khtml-user-select: none;
        -o-user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        user-select: none;
    }

    #container {
        width: 400px;
        height: 400px;
        margin: auto;
        overflow: hidden;
    }

    #cropper {
        background-color: rgba(0,0,0,0.5);
        width: 400px;
        height: 400px;
        position: absolute;
        cursor: move;
    }

    #range {
        width: 400px;
        margin: auto;
        display: block;
    }
</style>

<div id="container" onmousedown="mouseDown_on(event)" onmouseup="mouseDown_off(event)" onmouseenter="mouseMove_on(event)" onmouseleave="mouseMove_off(event)">
    <img id="image" src="image.jpg" style="width: 400px;">
    <div id="cropper"></div>
</div><br>
<input id="range" type="range" min="10" max="40" onmousemove="resize_image(event)">
<div id="info"></div>

<script type="text/javascript">
    var info = document.getElementById("info");
    var image = document.getElementById("image");
    var container = document.getElementById("container");
    var cropper = document.getElementById("cropper");
    var range = document.getElementById("range");

    var mouseMove = false;
    var mouseDown = false;

    var initMouseX = 0;
    var initMouseY = 0;
    var initImageX = 0;
    var initImageY = 0;

    var ratio = 1;
    var margin = 50;

    cropper.style.left = container.offsetLeft;
    cropper.style.top = container.offsetTop;

    reset_image();

    // Starting values
    var originalImageWidth = image.clientWidth;
    var originalImageHeight = image.clientHeight;


    window.onmousemove = function(event) {
        info.innerHTML = event.clientX + ":" + event.clientY; // Takes in mouse movements on x/y axis

        if(mouseMove && mouseDown) {
            var x = event.clientX - initMouseX;
            var y = event.clientY - initMouseY;

            // current position of image + movement
            x = initImageX + x; 
            y = initImageY + y;

            // Prevent image from going out of bounds
            xlimit = container.clientWidth - image.clientWidth - margin;
            ylimit = container.clientHeight - image.clientHeight - margin;

            if(x > margin) { //Prevents Left
                x = margin;
            }

            if(y > margin) { // Prevents Bottom
                y = margin;
            }

            if(x < xlimit) { // Prevents Right
                x = xlimit;
            }

            if(y < ylimit) { // Prevents Top
                y = ylimit;
            }

            image.style.left = x;
            image.style.top = y;
        }
    }

    window.onmouseup = function(event) {
        mouseDown = false;
    }

    function resize_image() {
        // See initial location
        var w = image.clientWidth;
        var h = image.clientHeight;

        // Change Image
        image.style.width = (range.value / 10) * originalImageWidth;
        image.style.height = (range.value / 10) * originalImageHeight;

        // See how image is moving (zoom into center)
        var w2 = image.clientWidth;
        var h2 = image.clientHeight;

        if(w - w2 != 0) {
            var diff = (w - w2) / 2;
            var diff2 = (h - h2) /2;
            var x = (image.offsetLeft - container.offsetLeft) + diff;
            var y = (image.offsetTop - container.offsetTop) + diff2;

            // Prevent image from going out of bounds
            xlimit = container.clientWidth - image.clientWidth - margin;
            ylimit = container.clientHeight - image.clientHeight - margin;

            if(x > margin) { //Prevents Left
                x = margin;
            }

            if(y > margin) { // Prevents Bottom
                y = margin;
            }

            if(x < xlimit) { // Prevents Right
                x = xlimit;
            }

            if(y < ylimit) { // Prevents Top
                y = ylimit;
            }

            image.style.left = x;
            image.style.top = y;
        }
    }

    function reset_image() {
        if(image.naturalWidth > image.naturalHeight) {
            ratio = image.naturalWidth / image.naturalHeight;
            image.style.height = container.clientHeight - (margin * 2); // Make height as big as cropping space
            image.style.width = (container.clientWidth - (margin * 2)) * ratio;
            image.style.top = margin;

            // Center image
            var extra = (image.clientWidth - container.clientWidth) / 2;
            image.style.left = extra * -1;
        }

        range.value = 20;
    }

    function mouseDown_on() {
        mouseDown = true;
        initMouseX = event.clientX; // Takes in distance moved horizontally
        initMouseY = event.clientY; // Takes in distance moved vertically
        initImageX = image.offsetLeft - container.offsetLeft; // Movement of image Left
        initImageY = image.offsetTop - container.offsetTop; // Movement Image Top
    }

    function mouseDown_off() {
        mouseDown = false;
    }

    function mouseMove_on() {
        mouseMove = true;
    }

    function mouseMove_off() {
        mouseMove = false;
    }
</script>