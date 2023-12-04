<?php 
    // --------- Necessary Files/Expressions to Start --------- //
    include("necessary_files.php");

    // --------- Check user logged in --------- //
    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_user_id']);

    // --------- User ID --------- //
    $user_id = $user_data['user_id'];

    // --------- User Profile Image --------- //
    $user_image = "";
    $image_class = new Image();
    if(file_exists($user_data['profile_image'])) {
        $user_image = $user_data['profile_image'];
        $ext = pathinfo($user_image, PATHINFO_EXTENSION);

        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }

        $user_image = $image_class->get_thumbnail_profile($user_data['profile_image'], $ext);
    } else if ($user_data['gender'] == "Male") {
        $user_image = "assets/img/male-icon.png";
    } else if ($user_data['gender'] == "Female") {
        $user_image = "assets/img/female-icon.png";
    }