<?php
    session_start();
    include("assets/php/common_assets.php");

    // --------- Collect User Post --------- //
    $ERROR = "";
    $DB = new Database();
    $Post = new Post();
    if(isset($_GET['id'])) {
        $ROW = $Post->get_post($_GET['id']);

        if(!$ROW) {
            $ERROR = "No such post was found!";
        }

        if($user_id != $ROW['user_id']) {
            $ERROR = "No such post was found!";
        }

        if($ROW['is_profile_image'] == 1 || $ROW['is_cover_image'] == 1) {
            $ERROR = "Cannot edit post";
        }
    } else {
        $ERROR = "No such post was found!";
    }

    // --------- Post Image --------- //
    $image_class = new Image();
    $post_image = $ROW['image'];
    if(file_exists($post_image)) {
        $ext = pathinfo($post_image, PATHINFO_EXTENSION);
        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }
        $post_image = $image_class->get_thumbnail_post($post_image, $ext);
    }

    // --------- Return User to Post Page --------- //
    $_SESSION['return_to'] = "profile.php";
    if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")) {
        $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
    }

    // --------- If Something Was Posted --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $Post->edit_post($user_id, $_POST, $_FILES);
        header("Location: " . $_SESSION['return_to']);
        die;
    }
?>

<html>
    <head>
        <title>MyBook | Edit</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <?php include("header.php"); ?>

        <!----------------- Edit Area ---------------------> 
        <div class="class-5">
            <div class="class-11">

                <!----------------- Editing Post Area ---------------------> 
                <div class="class-13">
                    <div class="class-17">
                        <form method="post" enctype="multipart/form-data">
                            <span> Edit Post </span><br><br>
                            <div style="border: solid thin #AAA;">
                                <?php 
                                    if($ERROR != "") { 
                                        echo "<div style='padding: 5px;'>" . $ERROR . "</div>"; 
                                    } else {
                                        echo '<textarea placeholder="Whats on your mind?" class="class-18" name="post">' . $ROW['post'] . '</textarea>';
                                        if(file_exists($post_image)) {
                                            echo "<img src='$post_image' style='padding-left: 5px; padding-top: 5px; width: 50%;'>";
                                        }
                                        echo '<hr style="width: 95%;"><input type="file" name="file" style="padding-bottom: 5px; padding-left: 5px;">';
                                    }
                                ?>
                            </div>
                            <div style="padding-bottom: 5px; padding-top: 5px;">
                                <input type="hidden" name="post_id" value="<?php echo $ROW['post_id'] ?>">
                                <input type="submit" value="Save" class="class-19"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>