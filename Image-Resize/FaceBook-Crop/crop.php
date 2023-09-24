<?php 
    // --------- Crop Variables --------- //
    $source = imagecreatefromjpeg("image.jpg");
    $dest = imagecreatetruecolor(400, 400);


    // --------- Final Crop --------- //
    imagecopyresampled($dest, $source, 0, 0, $_GET['x'], $_GET['y'], 400, 400, $_GET['width'], $_GET['height']);

    // --------- Final Image --------- //
    imagejpeg($dest, "cropped.jpg", 98);
    echo "<img src='cropped.jpg?" . rand(0, 100) . "' style='width:400px'>";