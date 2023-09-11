<?php
    // --------- Necessary Files/Expressions to Start --------- //
    session_start();
    include("assets/classes/connect.php");
    include("assets/classes/login.inc.php"); 
    include("assets/classes/post.inc.php"); 
    include("assets/classes/user.inc.php");

    // --------- Check user logged in --------- //
    $login = new Login();
    $user_data = $login->check_login($_SESSION['mybook_user_id']);

    // --------- User Information Variables --------- //
    $full_name = $user_data['first_name'] . " " . $user_data['last_name'];


    // --------- Posting Section --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $post = new Post();
        $id = $_SESSION['mybook_user_id'];
        $result = $post->create_post($id, $_POST);

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
?>

<html>
    <head>
        <title>MyBook | Profile</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <?php include("header.php"); ?>

        <!----------------- Cover Area ---------------------> 
        <div class="class-5">
            <div class="class-6">
                <img src="assets/img/mountain.jpg" class="class-7"/>
                <img src="assets/img/selfie.jpg" class="class-8"/><br>
                <div class="class-c"> 
                    <a href="change_profile_image.php" class="class-d">Change Image</a> | 
                    <a href="" class="class-d">Change Cover</a>
                </div>
                <div class="class-9"><?php echo $full_name ?></div><br>
                <a href="timeline.php"><div class="class-10">Timeline</div></a>
                <div class="class-10">About</div> 
                <div class="class-10">Friends</div> 
                <div class="class-10">Photos</div> 
                <div class="class-10">Settings</div>
            </div>

            <!----------------- Below Cover Area ---------------------> 
            <div class="class-11">
                <!----------------- Friends Area ---------------------> 
                <div class="class-12">
                    <div class="class-14">
                        Friends <br>
                        <?php
                            if($posts) {
                                foreach($friends as $FRIEND_ROW) {
                                    include("user.php");
                                }
                            }
                        ?>
                    </div>
                </div>

                <!----------------- Posting Area ---------------------> 
                <div class="class-13">
                    <div class="class-17">
                        <form method="post">
                            <textarea placeholder="What's on your mind?" class="class-18" name="post"></textarea>
                            <input type="submit" value="Post" class="class-19"/><br><br>
                        </form>
                    </div>

                <!----------------- Posts Area ---------------------> 
                    <div class="class-20">
                        <?php
                            if($posts) {
                                foreach($posts as $ROW) {
                                    $user = new User();
                                    $ROW_USER = $user->get_user($ROW['user_id']);
                                    include("post.php");
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>