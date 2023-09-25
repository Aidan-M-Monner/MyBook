<?php 
    class Image {
        public function generate_filename($length) {
            // Create a unique file identifier
            $array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
            $text = "";

            for($i = 0; $i < $length; $i++) {
                $random = rand(0,61);
                $text .= $array[$random];
            }

            return $text;
        }

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
            
            // Size adjustment for cover 
            if($max_width != $max_height) {
                if($max_height > $max_width) {
                    if($max_height > $new_height) {
                        $adjustment = ($max_height / $new_height);
                    } else {
                        $adjustment = ($new_height / $max_height);
                    }
                    $new_width = $new_width * $adjustment;
                    $new_height = $new_height * $adjustment;
                } else {
                    if($max_width > $new_width) {
                        $adjustment = ($max_width / $new_width);
                    } else {
                        $adjustment = ($new_width / $max_width);
                    }
                    $new_width = $new_width * $adjustment;
                    $new_height = $new_height * $adjustment;
                }
            }

            $new_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
            imagedestroy($original_image);

            // Creating crop variables
            if($max_width != $max_height) {
                if($max_width > $max_height) {
                    $diff = ($new_height - $max_height);

                    if($diff < 0) {
                        $diff = $diff * -1;
                    }

                    $y = round($diff / 2);
                    $x = 0;
                } else {
                    $diff = ($new_width - $max_height);

                    if($diff < 0) {
                        $diff = $diff * -1;
                    }

                    $x = round($diff / 2);
                    $y = 0;
                }
            } else {
                if($new_height > $new_width) {
                    $diff = ($new_height - $new_width);
                    $y = round($diff / 2);
                    $x = 0;
                } else {
                    $diff = ($new_width - $new_height);
                    $x = round($diff / 2);
                    $y = 0;
                }
            }

            $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
            imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);
            imagedestroy($new_image);

            // Check image type then save
            if($file_type == 'image/jpeg') {
                imagejpeg($new_cropped_image, $cropped_file_name, 90);
            } else if ($file_type == 'image/png') {
                imagepng($new_cropped_image, $cropped_file_name);
            }
            imagedestroy($new_cropped_image);
        }
    }