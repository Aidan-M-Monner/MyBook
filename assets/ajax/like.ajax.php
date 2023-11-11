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

    // --------- Sanitize Values --------- //
    $_GET['id'] = addslashes($_GET['id']);
    $_GET['type'] = addslashes($_GET['type']);

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

        // --------- Read Likes --------- //
        $likes = $post_class->get_likes($_GET['id'], $_GET['type']);

        // --------- Check if User Liked Post --------- //
        $post_class = new Post();
        $user_liked = "";
        $i_liked = false;
        $info = "";

        if(isset($_SESSION['mybook_user_id'])) {
            $DB = new Database();
            $sql = "select likes from likes where type = 'post' && content_id = '$_GET[id]' limit 1";
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

        $post_likes = count($likes);
        $info .= '<a id="info_' . $_GET['id'] . '" href="likes.php?type=post&id=' . $_GET['id'] . '" style="text-decoration: none;">';
        if($i_liked) {
            if($post_likes == 1) {
                $user_liked = "You liked this post";
                $info .= '<div style="float: left; font-size: 11px;">' . $user_liked . '</div><br></a>';
            } else {
                $new_post_likes = $post_likes - 1;
                $user_liked = "You and " . $post_class->like_amount($new_post_likes);
                $info .= '<div style="float: left; font-size: 11px;">' . $user_liked . '</div><br></a>';
            }
        } else {
            if($post_likes > 0) {
                $user_liked = $post_class->like_amount($post_likes);
                $info .= '<div style="float: left; font-size: 11px;">' . $user_liked . '</div><br></a>';
            } else {
                $info = "";
            }
        }

        // --------- Create Object Class --------- //
        $obj = (object)[];
        $obj->likes = count($likes);
        $obj->action = "like_post";
        $obj->info = $info;
        $obj->id = "info_$_GET[id]";

        echo json_encode($obj);
    }