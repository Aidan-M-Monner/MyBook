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
        /* border: solid 1px black; */
        margin: auto;
    }

    #cropper {
        background-color: rgba(0,0,0,0.5);
        width: 400px;
        height: 400px;
        position: absolute;
        cursor: move;
    }
</style>

<div id="container" onmousedown="mouseDown_on(event)" onmouseup="mouseDown_off(event)" onmouseenter="mouseMove_on(event)" onmouseleave="mouseMove_off(event)">
    <img id="image" src="image.jpg" style="width: 400px;">
    <div id="cropper"></div>
</div>
<div id="info"></div>

<script type="text/javascript">
    var info = document.getElementById("info");
    var image = document.getElementById("image");
    var container = document.getElementById("container");
    var cropper = document.getElementById("cropper");

    var mouseMove = false;
    var mouseDown = false;

    var initMouseX = 0;
    var initMouseY = 0;
    var initImageX = 0;
    var initImageY = 0;

    var ratio = 1;
    reset_image();

    cropper.style.left = container.offsetLeft;
    cropper.style.top = container.offsetTop;

    window.onmousemove = function(event) {
        info.innerHTML = event.clientX + ":" + event.clientY; // Takes in mouse movements on x/y axis

        if(mouseMove && mouseDown) {
            var x = event.clientX - initMouseX;
            var y = event.clientY - initMouseY;

            x = initImageX + x; // current position of image + movement
            y = initImageY + y;

            image.style.left = x;
            image.style.top = y;
        }
    }

    window.onmouseup = function(event) {
        mouseDown = false;
    }

    function reset_image() {
        if(image.naturalWidth > image.naturalHeight) {
            ratio = image.naturalWidth / image.naturalHeight;
            image.style.height = container.clientHeight; // Make height as big as cropping space
            image.style.width = container.clientWidth * ratio;
            image.style.top = 0;
        }
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