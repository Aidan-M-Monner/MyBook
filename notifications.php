<?php
    session_start();
    include("assets/php/common_assets.php");

    // --------- Variables --------- //
    $Post = new Post();
    $User = new User();
?>

<style>
    #notification {
        background-color: #eee;
        border: 1px solid #aaa;
        color: #666;
        height: 35px;
        margin: 4px;
    }
</style>

<html>
    <head>
        <title>MyBook | Notifications</title>
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
                            $DB = new Database();
                            $id = esc($user_id);
                            $query = "select * from notifications where content_owner = '$id' order by id desc limit 30";
                            $data = $DB->read($query);
                        ?>

                        <?php 
                            if(is_array($data)) { 
                                foreach($data as $notif_row) {
                                    include("single_notification.php");
                                }
                            } else {
                                echo "No notifications were found.";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>