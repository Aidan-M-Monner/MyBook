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
    $full_name = $user_data['first_name'] . "<br>" . $user_data['last_name'];

    // --------- Collect User Image --------- //
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
            $filename = $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $filename);
        } else {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
            echo "<br>The following errors occured: <br><br>";
            echo "Please add a valid image!";
            echo "</div>";
        }
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>