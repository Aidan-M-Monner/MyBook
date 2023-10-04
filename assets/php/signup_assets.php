<?php 
    // --------- Necessary Files --------- //
    include("classes/connect.php");
    include("classes/signup.inc.php"); 

    // --------- User Information Variables --------- //
    $first_name = "";
    $last_name = "";
    $gender = "Gender";
    $email = "";

    // --------- Check variables are correct  --------- //
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $signup = new Signup();
        $result = $signup->evaluate($_POST);

        if($result != "") {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: grey'>";
            echo "<br>The following errors occured: <br><br>";
            echo $result;
            echo "</div>";
        } else {
            header("Location: login.php");
            die;
        }

        // Set user information already typed in
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
    }