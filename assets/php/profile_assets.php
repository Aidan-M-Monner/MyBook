<?php 
    // --------- Grabbing Another User's Account --------- //
    if(isset($_GET['id']) && is_numeric($_GET['id'])){ // White/Black list values that do not exist or are numbers.
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);

        if(is_array($profile_data)) {
            $user_data = $profile_data[0];
        }
    }

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
    
    // --------- Cover Image Section --------- //
    $cover = "assets/img/mountain.jpg";
    if(file_exists($user_data['cover_image'])) {
        $cover = $user_data['cover_image'];
        $ext = pathinfo($cover, PATHINFO_EXTENSION);

        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }

        $cover = $image_class->get_thumbnail_cover($user_data['cover_image'], $ext);
    }

    // --------- Posting Section --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $post = new Post();
        $id = $_SESSION['mybook_user_id'];
        $result = $post->create_post($id, $_POST, $_FILES);

        // Ensure that data cannot be sent again when page refreshes.
        if($result == "") {
            header("Location: profile.php");
            die;
        } else {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
            echo "<br>The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        }
    }

    // --------- Posts Section --------- //
    $post = new Post();
    $id = $user_data['user_id'];
    $posts = $post->get_posts($id);

    // --------- Friends Section --------- //
    $user = new User();
    $id = $_SESSION['mybook_user_id'];
    $friends = $user->get_friends($id);