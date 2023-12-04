<?php 
    $user_id = $_SESSION['mybook_user_id'];
    if(!isset($user_id)) {
        die;
    }

    // --------- Get Data From Query --------- //
    $query_string = explode("?", $data->link);
    $query_string = end($query_string); //Gets last item from array

    // --------- Set $_GET values --------- //
    $str = explode("&", $query_string);
    foreach($str as $value) {
        $value = explode("=", $value);
        $_GET[$value[0]] = $value[1];
    }

    // --------- Return User to Profile Page --------- //
    if(isset($_SERVER['HTTP_REFERER'])) {
        $return_to = $_SERVER['HTTP_REFERER'];
    } else {
        $return_to = "profile.php";
    }

    // --------- Add Like to Post --------- //
    if(isset($_GET['type']) && isset($_GET['id'])) {
        if(is_numeric($_GET['id'])) {
            $allowed = ['post', 'user', 'comment']; // Whitelist what types of posts can be liked.

            if(in_array($_GET['type'], $allowed)) {
                $post_class = new Post();
                $user_class = new User();

                $post_class->like_post($_GET['id'], $_GET['type'], $user_id);

                if($_GET['type'] == "user") {
                    $user_class->follow_user($_GET['id'], $_GET['type'], $user_id);
                }
            }
        }
    }