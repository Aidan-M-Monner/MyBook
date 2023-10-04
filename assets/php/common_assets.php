<?php 
    // --------- Necessary Files/Expressions to Start --------- //
    include("classes/connect.php");
    include("classes/image.php");
    include("classes/login.inc.php"); 
    include("classes/post.inc.php"); 
    include("classes/user.inc.php");

    // --------- Check user logged in --------- //
    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_user_id']);

    // --------- User Profile Variables --------- //
    $full_name = $user_data['first_name'] . " " . $user_data['last_name'];

    $image = "";
    $image_class = new Image();
    if(file_exists($user_data['profile_image'])) {
        $image = $user_data['profile_image'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);

        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }

        $image = $image_class->get_thumbnail_profile($user_data['profile_image'], $ext);
    } else if ($user_data['gender'] == "Male") {
        $image = "assets/img/male-icon.png";
    } else if ($user_data['gender'] == "Female") {
        $image = "assets/img/female-icon.png";
    }