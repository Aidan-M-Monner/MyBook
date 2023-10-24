<?php 
    session_start();
    include("assets/php/common_assets.php");

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
                $post = new Post();
                $post->like_post($_GET['id'], $_GET['type'], $user_id);
            }
        }
    }

    header("Location: " . $return_to);
    die;