<?php 
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
    $id = $_SESSION['mybook_user_id'];
    $posts = $post->get_posts($id);

    // --------- Friends Section --------- //
    $user = new User();
    $id = $_SESSION['mybook_user_id'];
    $friends = $user->get_friends($id);