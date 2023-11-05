<?php
    session_start();
    include("assets/php/common_assets.php");

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

    // --------- Posting Section --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $post = new Post();
        $id = $_SESSION['mybook_user_id'];
        $result = $post->create_post($id, $_POST, $_FILES);

        // Ensure that data cannot be sent again when page refreshes.
        if($result == "") {
            header("Location: index.php");
            die;
        } else {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
            echo "<br>The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        }
    }
?>

<html>
    <head>
        <title>MyBook | Profile</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <?php include("header.php"); ?>

        <!----------------- Timeline Area ---------------------> 
        <div class="class-5">
            <div class="class-11">
                <!----------------- User Area ---------------------> 
                <div class="class-12">
                    <div class="class-14">
                        <img src="<?php echo $image; ?>" class="class-25"/><br>
                        <a href="profile.php" class="class-26"><?php echo $full_name; ?></a>
                    </div>
                </div>

                <!----------------- Posting Area ---------------------> 
                <div class="class-13">
                    <div class="class-17">
                        <form method="post" enctype="multipart/form-data">
                            <textarea placeholder="What's on your mind?" class="class-18" name="post"></textarea>
                            <input type="file" name="file"/>
                            <input type="submit" value="Post" class="class-19"/><br><br>
                        </form>
                    </div>

                    <!----------------- Posts Area ---------------------> 
                    <div class="class-20">
                        <?php
                            $DB = new Database();
                            $user_class = new User();

                            // --------- Limits & Offsets --------- //
                            $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $page_number = ($page_number < 1) ? 1 : $page_number;
                            
                            $limit = 2;
                            $offset = ($page_number - 1) * $limit;

                            // --------- Get current URL --------- //
                            $pg = pagination_link();


                            $followers = $user_class->get_following($user_id, "user");

                            // --------- Grab Followed Posts --------- //
                            $follower_ids = false;
                            if(is_array($followers)) {
                                $follower_ids = array_column($followers, "user_id");
                                array_push($follower_ids, $user_id);
                                $follower_ids = implode("','", $follower_ids);
                            }
                            if($follower_ids) {
                                $sql = "select * from posts where parent = 0 and user_id in('" . $follower_ids . "') order by date desc limit $limit offset $offset";
                                $posts = $DB->read($sql);
                            } else {
                                $sql = "select * from posts where parent = 0 and user_id = '$user_id' order by date desc limit $limit offset $offset";
                                $posts = $DB->read($sql);
                            }

                            // --------- All Posts --------- //
                            if(isset($posts) && $posts) {
                                foreach($posts as $ROW) {
                                    $user = new User();
                                    $ROW_USER = $user->get_user($ROW['user_id']);
                                    include("post.php");
                                }
                            }
                        ?>
                        <a href="<?php echo $pg['next_page']; ?>">
                            <input type="button" value="Next Page" class="class-19" style="float: right;"/>
                        </a>

                        <a href="<?php echo $pg['prev_page']; ?>">
                            <input type="button" value="Prev Page" class="class-19" style="float: left;"/>
                        </a>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>