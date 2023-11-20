<?php
    session_start();
    include("assets/php/common_assets.php");

    // --------- Collect Post Likes --------- //
    $ERROR = "";
    $likes = false;
    $Post = new Post();
    if(isset($_GET['id']) && isset($_GET['type'])) {
        $likes = $Post->get_likes($_GET['id'], $_GET['type']);
    } else {
        $ERROR = "No information was found!";
    }

?>

<html>
    <head>
        <title>MyBook | Likes</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <?php include("header.php"); ?>

        <!----------------- Delete Area ---------------------> 
        <div class="class-5">
            <div class="class-11">

                <!----------------- Deleting Post Area ---------------------> 
                <div class="class-13">
                    <div class="class-17">
                        <?php 
                            $User = new User();

                            if(is_array($likes)) {
                                foreach($likes as $row) {
                                    $FRIEND_ROW = $User->get_user($row['user_id']);
                                    include("user.php");
                                    echo "<span style='float:right;'>" . $row['date'] . "</span>";
                                }
                            }
                        ?>
                        <br style="clear:both">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>