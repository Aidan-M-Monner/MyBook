<?php
    session_start();
    include("assets/php/common_assets.php");

    // --------- Grab Post --------- //
    $ERROR = "";
    $ROW = false;
    $Post = new Post();
    if(isset($_GET['id'])) {
        $ROW = $Post->get_post($_GET['id']);
    } else {
        $ERROR = "No image was found!";
    }

?>

<html>
    <head>
        <title>MyBook | Single Post</title>
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

                            if(is_array($ROW)) {
                                echo "<img src='$ROW[image]' style='width:100%;' />";
                            }
                        ?>
                        <br style="clear:both">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>