<?php
    // --------- Necessary Files/Expressions to Start --------- //
    session_start();
    include("assets/classes/connect.php");
    include("assets/classes/login.inc.php"); 
    include("assets/classes/post.inc.php"); 
    include("assets/classes/user.inc.php");
    include("assets/classes/image.php");

    // --------- Check user logged in --------- //
    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_user_id']);

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
                    }

                    $image = new Image();
                    $file_type = $_FILES['file']['type'];

                    $filename = $folder . $image->generate_filename(15) . ".jpg";
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename);
                    $change = "profile";

                    // Ensure that change is set
                    if(isset($_GET['change'])) {
                        $change = $_GET['change'];
                    }

                    // Check which type of image to crop
                    if($change == "cover") {
                        $image->crop_image($file_type, $filename, $filename, 1366, 488);
                    } else {
                        $image->crop_image($file_type, $filename, $filename, 800, 800);
                    }

                    // Add image path to database
                    if(file_exists($filename)) {
                        $user_id = $user_data['user_id'];

                        // Check which column to send data to
                        if($change == "cover") {
                            $query = "update users set cover_image = '$filename' where user_id = '$user_id' limit 1";
                        } else {
                            $query = "update users set profile_image = '$filename' where user_id = '$user_id' limit 1";
                        }
        
                        $DB = new Database();
                        $DB->save($query);
        
                        header("Location: profile.php");
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
?>

<html>
    <head>
        <title>MyBook | Change Profile Image</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <?php include("header.php"); ?>

        <!----------------- Upload Area ---------------------> 
        <div class="class-5">
            <div class="class-11">
                <div class="class-13">
                    <form method="post" enctype="multipart/form-data">
                        <div class="class-17">
                            <input type="file" name="file">
                            <input type="submit" value="Change" class="class-19"/><br>
                            
                            <div style="text-align: center;">
                                <?php 
                                    $change = "profile";

                                    // Check for mode
                                    if(isset($_GET['change']) && $_GET['change'] == "cover") {
                                        $change = "cover";
                                        echo "<img src='$user_data[cover_image]' style='max-width: 500px;'>";
                                    } else {
                                        echo "<img src='$user_data[profile_image]' style='max-width: 200px; max-height: 200px;'>";
                                    }
                                    echo "<img src=''>"; 
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>