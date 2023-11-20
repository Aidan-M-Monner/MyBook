<?php
    session_start();
    include("assets/php/common_assets.php");

    // --------- Return User to Post Page --------- //
    $_SESSION['return_to'] = "profile.php";
    if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "delete.php")) {
        $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
    }

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
    } else {
        $ERROR = "No such post was found!";
    }

    // --------- If Something Was Posted --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $Post->delete_post($_POST['post_id']);
        header("Location: " . $_SESSION['return_to']);
        die;
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
                        <form method="post">
                            <span> Are You Sure you want to delete this post? </span><br><br>
                            <div style="border: solid thin #AAA;">
                                <?php 
                                    if($ERROR != "") { 
                                        echo "<div style='padding: 5px;'>" . $ERROR . "</div>"; 
                                    } else {
                                        $user = new User();
                                        $ROW_USER = $user->get_user($ROW['user_id']);
                                        include("post_delete.php");
                                    }
                                ?>
                            </div>
                            <div style="padding-bottom: 5px; padding-top: 5px;">
                            <input type="hidden" name="post_id" value="<?php echo $ROW['post_id'] ?>">
                                <input type="submit" value="Delete" class="class-19"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>