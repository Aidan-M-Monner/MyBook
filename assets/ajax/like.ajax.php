<?php 
    if(!isset($user_id)) {
        die;
    }

    $query_string = explode("?", $data->link);
    $query_string = end($query_string); // end grabs last item in an array
    
    $str = explode("&", $query_string);
    foreach($str as $value) {
        $value = explode("=", $value);
        $_GET[$value[0]] = $value[1];
    }

    // --------- Add Like to Post --------- //
    if(isset($_GET['type']) && isset($_GET['id'])) {
        $post_class = new Post();
        $user_class = new User();

        if(is_numeric($_GET['id'])) {
            $allowed = ['post', 'user', 'comment']; // Whitelist what types of posts can be liked.

            if(in_array($_GET['type'], $allowed)) {
                $post_class->like_post($_GET['id'], $_GET['type'], $user_id);

                if($_GET['type'] == "user") {
                    $user_class->follow_user($_GET['id'], $_GET['type'], $user_id);
                }
            }
        }

        // Read Likes
        $likes = $post_class->get_likes($_GET['id'], $_GET['type']);

        $obj = (object)[];
        $obj->likes = count($likes);
        $obj->action = "like_post";

        echo json_encode($obj);
    }