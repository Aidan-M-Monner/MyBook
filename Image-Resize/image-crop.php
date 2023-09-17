<?php
    function crop_image($file, $max_resolution) {
        if(file_exists($file)) {
            $original_image = imagecreatefromjpeg($file);

            // Resolution
            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            // Try Width First
            if($original_height > $original_width) {
                $ratio = $max_resolution / $original_width;
                $new_width = $max_resolution;
                $new_height = $original_height * $ratio;
                $diff = $new_height - $new_width;

                $x = 0;
                $y = round($diff / 2);
            } else {
                $ratio = $max_resolution / $original_height;
                $new_height = $max_resolution;
                $new_width = $original_width * $ratio;
                $diff = $new_width - $new_height;

                $x = round($diff / 2);
                $y = 0;
            }

            if($original_image) {
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

                $new_crop_image = imagecreatetruecolor($max_resolution, $max_resolution);
                imagecopyresampled($new_crop_image, $new_image, 0, 0, $x, $y, $max_resolution, $max_resolution, $max_resolution, $max_resolution);

                imagejpeg($new_crop_image, $file, 90);
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_FILES['image']) && $_FILES['image']['type'] == 'image/jpeg') {
            move_uploaded_file($_FILES['image']['tmp_name'], $_FILES['image']['name']);
            $file = $_FILES['image']['name'];
            crop_image($file, "300");
            echo "<img src='$file'/>";
        }
    }
?>

<form method='post' enctype='multipart/form-data'>
    <input type='file' name='image'/><br>
    <input type='submit' value='post'/>
</form>