<?php
    session_start();
    include("assets/php/common_assets.php");

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        include("assets/php/profile_image_assets.php");
    }
?>

<html>
    <head>
        <title>MyBook | Change Profile Image</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <?php include("header.php"); ?>

        <!----------------- Upload Area ---------------------> 
        <div class="class-5">
            <div class="class-11">
                <div class="class-13">
                    <form method="post" enctype="multipart/form-data">
                        <div class="class-17">
                            <input type="file" name="file">
                            <input type="submit" value="Change" class="class-19"/><br>
                            
                            <div style="text-align: center;">
                                <?php 
                                    $change = "profile";

                                    // Check for mode
                                    if(isset($_GET['change']) && $_GET['change'] == "cover") {
                                        $change = "cover";
                                        echo "<img src='$user_data[cover_image]' style='max-width: 500px;'>";
                                    } else {
                                        echo "<img src='$user_data[profile_image]' style='max-width: 500px; max-height: 500px;'>";
                                    }
                                    echo "<img src=''>"; 
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>