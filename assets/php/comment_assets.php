<?php 
    // --------- General Poster Information --------- //
    $commenter_name = $ROW_USER['first_name'] . " " . $ROW_USER['last_name'];
    $poster_comment = $COMMENT['post'];
    $comment_id = $COMMENT['post_id'];
    $comment_likes = $COMMENT['likes'];

    // --------- Poster Profile Image --------- //
    $poster_image = "";
    if(file_exists($ROW_USER['profile_image'])) {
        $poster_image = $ROW_USER['profile_image'];
        $ext = pathinfo($poster_image, PATHINFO_EXTENSION);

        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }

        $poster_image = $image_class->get_thumbnail_profile($poster_image, $ext);
    } else if ($ROW_USER['gender'] == "Male") {
        $poster_image = "assets/img/male-icon.png";
    } else if ($ROW_USER['gender'] == "Female") {
        $poster_image = "assets/img/female-icon.png";
    }

    // --------- Post Image --------- //
    $image_class = new Image();
    $comment_image = $COMMENT['image'];
    if(file_exists($comment_image)) {
        $ext = pathinfo($comment_image, PATHINFO_EXTENSION);
        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }
        $comment_image = $image_class->get_thumbnail_post($comment_image, $ext);
    }

    // --------- Poster Gender --------- //
    $pronoun = "";
    if($ROW_USER['gender'] == 'Male') {
        $pronoun = "his";
    } else if($ROW_USER['gender'] == 'Female') {
        $pronoun = "her";
    }

    // --------- Check If Post User --------- //
    $user_comment = false;
    if($user_id == $COMMENT['user_id']) {
        $user_comment = true;
    }

    // --------- Check If Profile Post --------- //
    $update_comment = false;
    if($COMMENT['is_profile_image'] == 1 || $COMMENT['is_cover_image'] == 1) {
        $update_comment = true;
    }

    // --------- Check for likes --------- //
    $likes = "";
    $likes = ($comment_likes > 0) ? "s(".$comment_likes.")" : "";

    // --------- Check if User liked Post --------- //
    $post_class = new Post();
    $user_liked = "";
    $i_liked = false;

    if(isset($_SESSION['mybook_user_id'])) {
        $DB = new Database();
        $sql = "select likes from likes where type = 'post' && content_id = '$comment_id' limit 1";
        $result = $DB->read($sql);

        if(is_array($result)) {
            // User/like data
            $array_likes = json_decode($result[0]['likes'], true); // true prevents $likes from being an object rather than an array.
            $user_ids = array_column($array_likes, "user_id");

            if(in_array($user_id, $user_ids)) {
                $i_liked = true;
            }
        }
    }

    if($i_liked) {
        if($post_likes == 1) {
           $user_liked = "You liked this post";
        } else {
            $new_post_likes = $comment_likes - 1;
            $user_liked = "You and " . $post_class->like_amount($new_post_likes);
        }
    } else {
        $user_liked = $post_class->like_amount($comment_likes);
    }
