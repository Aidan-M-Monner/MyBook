<?php 
    class Image {
        public function crop_image($file_type, $original_file_name, $cropped_file_name, $max_width, $max_height) {
            // Check if file exists
            if(file_exists($original_file_name)) {
                // Check image type then create copy
                if($file_type == 'image/jpeg') {
                    $original_image = imagecreatefromjpeg($original_file_name);
                } else if ($file_type == 'image/png') {
                    $original_image = imagecreatefrompng($original_file_name);
                }

                // Collect image height and width
                $original_width = imagesx($original_image);
                $original_height = imagesy($original_image);

                if($original_height > $original_width) {
                    // Make width = max width!
                    $ratio = $max_width / $original_width;
                    $new_width = $max_width;
                    $new_height = $original_height * $ratio;
                } else {
                    // Make height = max height!
                    $ratio = $max_height / $original_height;
                    $new_height = $max_height;
                    $new_width = $original_width * $ratio;
                }
            }
            
            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

            // Check image type then save
            if($file_type == 'image/jpeg') {
                imagejpeg($new_image, $cropped_file_name, 90);
            } else if ($file_type == 'image/png') {
                imagepng($new_image, $cropped_file_name);
            }
        }
    }