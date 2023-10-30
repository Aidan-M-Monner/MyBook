<?php
    session_start();
    include("assets/php/common_assets.php");

    if(isset($_GET['find'])) {
        $find = addslashes($_GET['find']);
        $DB = new Database();
        $sql = "select * from users where first_name like '%$find%' || last_name like '%$find%' limit 30"; // like and % means to find something similar
        $result = $DB->read($sql);
    }
?>

<html>
    <head>
        <title>MyBook | Search</title>
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

                            if(is_array($result)) {
                                foreach($result as $row) {
                                    $FRIEND_ROW = $User->get_user($row['user_id']);
                                    include("user.php");
                                }
                            } else {
                                echo "no result were found";
                            }
                        ?>
                        <br style="clear:both">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>