<style type="text/css">
    #image {
        position: relative;
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

    cropper.style.left = container.offsetLeft;
    cropper.style.top = container.offsetTop;

    window.onmousemove = function(event) {
        info.innerHTML = event.clientX + ":" + event.clientY; // Takes in mouse movements on x/y axis

        if(mouseMove && mouseDown) {
            image.style.left = event.clientX - container.offsetLeft;
            image.style.top = event.clientY - container.offsetTop;
        }
    }

    function mouseDown_on() {
        mouseDown = true;
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