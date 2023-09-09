<?php
    // --------- Necessary Files/Expressions to Start --------- //
    session_start();
    include("assets/classes/connect.php");
    include("assets/classes/login.inc.php"); 
    include("assets/classes/post.inc.php"); 
    include("assets/classes/user.php");

    // --------- Check user logged in --------- //
    if(isset($_SESSION['mybook_user_id']) && is_numeric($_SESSION['mybook_user_id'])) {
        $id = $_SESSION['mybook_user_id'];
        $login = new Login();
        $result = $login->check_login($id);


        if($result) {
            // Retrieve user data
            $user = new User();
            $user_data = $user->get_data($id);

            if(!$user_data) { // In case of an error where there is no data/row
                header("Location: login.php");
                die;
            }
        } else {
            header("Location: login.php");
            die;
        }
    } else {
        header("Location: login.php");
        die;
    }

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
?>

<html>
    <head>
        <title>MyBook | Profile</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <div class="class-1">
            <div class="class-2">
                MyBook &nbsp; &nbsp;
                <input type="text" placeholder="Search for people..." class="class-3">
                <img src="assets/img/selfie.jpg" class="class-4"/>
                <a href="logout.php">
                    <span class="class-a">Logout</span>
                </a>
            </div>
        </div>

        <!----------------- Cover Area ---------------------> 
        <div class="class-5">
            <div class="class-6">
                <img src="assets/img/mountain.jpg" class="class-7"/>
                <img src="assets/img/selfie.jpg" class="class-8"/><br>
                <div class="class-9"><?php echo $full_name ?></div><br>
                <div class="class-10">Timeline</div> 
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
                        <div class="class-15">
                            <img src="assets/img/user1.jpg" class="class-16"/><br>
                            First User
                        </div>

                        <div class="class-15">
                            <img src="assets/img/user2.jpg" class="class-16"/><br>
                            Second User
                        </div>

                        <div class="class-15">
                            <img src="assets/img/user3.jpg" class="class-16"/><br>
                            Third User
                        </div>

                        <div class="class-15">
                            <img src="assets/img/user4.jpg" class="class-16"/><br>
                            Fourth User
                        </div>
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
                                foreach($posts as $row) {
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