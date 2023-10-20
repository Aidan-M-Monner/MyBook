<?php
    session_start();
    include("assets/php/common_assets.php");

    // --------- Collect User Post --------- //
    $ERROR = "";
    $DB = new Database();
    if(isset($_GET['id'])) {
        $Post = new Post();
        $row = $Post->get_post($_GET['id']);

        if(!$row) {
            $ERROR = "No such post was found!";
        }
    } else {
        $ERROR = "No such post was found!";
    }
?>

<html>
    <head>
        <title>MyBook | Delete</title>
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
                        <h2>Delete Post</h2><br>
                        <form method="post">
                            <span> Are You Sure you want to delete this post? </span><br>
                            <hr><?php echo htmlspecialchars($row['post']); ?><hr>
                            <input type="submit" value="Delete" class="class-19"/><br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>