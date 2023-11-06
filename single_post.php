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
        $ERROR = "No post was found!";
    }

    // --------- Posting Section --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $post = new Post();
        $id = $_SESSION['mybook_user_id'];
        $result = $post->create_post($id, $_POST, $_FILES);

        // Ensure that data cannot be sent again when page refreshes.
        if($result == "") {
            header("Location: single_post.php?id=$_GET[id]");
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
                                $ROW_USER = $User->get_user($ROW['user_id']);
                                include("post.php");
                            }
                        ?>
                        <br style="clear:both">
                        <div class="class-17">
                            <form method="post" enctype="multipart/form-data">
                                <textarea placeholder="Write a comment" class="class-18" name="post"></textarea>
                                <input type="hidden" name="parent" value="<?php echo $ROW['post_id'] ?>">
                                <input type="file" name="file"/>
                                <input type="submit" value="Post" class="class-19"/><br><br>
                            </form>
                        </div>

                        <?php
                            $Post = new Post();
                            $comments = $Post->get_comments($ROW['post_id']);
                            if(is_array($comments)) {

                                foreach($comments as $COMMENT) {
                                    echo "<hr>";
                                    $ROW_USER = $User->get_user($COMMENT['user_id']);
                                    include("comment.php");
                                }
                            }
                            
                            // --------- Get Current URL --------- //
                            $pg = pagination_link();
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