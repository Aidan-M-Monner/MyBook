<?php 
    // --------- Necessary Files/Expressions to Start --------- //
    include("classes/connect.php");
    include("classes/login.inc.php"); 
    
    // --------- User Information Variables --------- //
    $email = "";
    $password = "";

    // --------- Check variables are correct  --------- //
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = new Login();
        $result = $login->evaluate($_POST);

        if($result != "") {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
            echo "<br>The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        } else {
            header("Location: profile.php?id=" . $row['user_id']);
            die;
        }

        // Set user information already typed in
        $email = $_POST['email'];
        $password = $_POST['password'];
    }