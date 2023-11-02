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
    $user_likes = $user_data['likes'];

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

    if($user_likes == 1) {
        $user_followers = $user_likes . " Follower";
    } else {
        $user_followers = $user_likes . " Followers";
    }

    // --------- Check if User Follows --------- //
    $post_class = new Post();
    $user_follow = "";
    $i_liked = false;

    if(isset($_SESSION['mybook_user_id'])) {
        $DB = new Database();
        $sql = "select likes from likes where type = 'user' && content_id = '$user_data[user_id]' limit 1";
        $result = $DB->read($sql);

        if(is_array($result) && $result[0]['likes'] != "") {
            // User/like data
            $array_follows = json_decode($result[0]['likes'], true); // true prevents $likes from being an object rather than an array.
            $user_ids = array_column($array_follows, "user_id");

            if(in_array($user_id, $user_ids)) {
                $i_liked = true;
            }
        }
    }

    if($i_liked) {
        $user_follow = "Unfollow";
    } else {
        $user_follow = "Follow";
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
        if(isset($_GET['change']) && ($_GET['change'] == "profile" || $_GET['change'] == "cover")) {
            include("profile_image_assets.php");
        }else if(isset($_POST['first_name'])) {
            $settings_class = new Settings();
            $settings_class->save_settings($_POST, $user_id);
        } else {
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
    }

    // --------- Follow Section --------- //
    $Follow = "Follow";

    // --------- Posts Section --------- //
    $post = new Post();
    $id = $user_data['user_id'];
    $posts = $post->get_posts($id);

    // --------- Friends Section --------- //
    $user = new User();
    $friends = $user->get_following($user_id, "user");