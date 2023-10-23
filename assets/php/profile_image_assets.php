<?php 
    // --------- Image Upload Variables --------- //
    $allowed_size = (1024 * 1024) * 3;
    $allowed_types = ['image/jpeg', 'image/png'];

    // --------- Collect User Image --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {

            if(in_array($_FILES['file']['type'], $allowed_types)) {
                if($_FILES['file']['size'] < $allowed_size) {
                    // Move image into the uploads folder
                    $folder = "uploads/" . $user_data['user_id'] . "/";

                    // Create Folder
                    if(!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", ""); // Creates index to keep users from seeing content.
                    }

                    $image = new Image();
                    $file_type = $_FILES['file']['type'];

                    if($file_type == 'image/png') {
                        $filename = $folder . $image->generate_filename(15) . ".png";
                    } else if ($file_type == 'image/jpg' || $file_type == 'image/jpeg') {
                        $filename = $folder . $image->generate_filename(15) . ".jpg";
                    }
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename);
                    $change = "profile";

                    // Ensure that change is set
                    if(isset($_GET['change'])) {
                        $change = $_GET['change'];
                    }

                    // Check which type of image to crop
                    if($change == "cover") {
                        if(file_exists($user_data['cover_image'])) {
                            unlink($user_data['cover_image']);
                        }
                        $image->resize_image($file_type, $filename, $filename, 1500, 1500);

                    } else {
                        if(file_exists($user_data['profile_image'])) {
                            unlink($user_data['profile_image']);
                        }
                        $image->resize_image($file_type, $filename, $filename, 1500, 1500);
                    }

                    // Add image path to database
                    if(file_exists($filename)) {
                        $user_id = $user_data['user_id'];

                        // Check which column to send data to
                        if($change == "cover") {
                            $query = "update users set cover_image = '$filename' where user_id = '$user_id' limit 1";
                            $_POST['is_cover_image'] = 1;
                        } else {
                            $query = "update users set profile_image = '$filename' where user_id = '$user_id' limit 1";
                            $_POST['is_profile_image'] = 1;
                        }
        
                        $DB = new Database();
                        $DB->save($query);

                        // Create a post
                        $post = new Post();
                        $post->create_post($user_id, $_POST, $filename);
        
                        header("Location: profile.php");
                        die;
                    }
                } else {
                    echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
                    echo "<br>The following errors occured: <br><br>";
                    echo "Only images of size 3MB or lower are accepted.";
                    echo "</div>";
                }
            } else {
                echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
                echo "<br>The following errors occured: <br><br>";
                echo "Image type not supported.";
                echo "</div>";
            }
        } else {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
            echo "<br>The following errors occured: <br><br>";
            echo "Please add a valid image!";
            echo "</div>";
        }
    }