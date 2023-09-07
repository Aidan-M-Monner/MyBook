<?php
    // --------- Necessary Files/Expressions to Start --------- //
    session_start();
    include("assets/classes/connect.php");
    include("assets/classes/login.inc.php"); 

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
            header("Location: profile.php");
            die;
        }

        // Set user information already typed in
        $email = $_POST['email'];
        $password = $_POST['password'];
    }
?>

<html>
    <head>
        <title>MyBook | Login</title>
        <link rel="stylesheet" type="text/css" href="assets/css/login-signup.css">
    </head>
    <body>
        <!----------- Top Bar ------------->
        <div class="class-1">
            <div class="class-2">MyBook</div>
            <div class="class-3">Signup</div>
        </div>

        <!----------- Login Area ------------->
        <div class="class-4">
            <form method="post">
                Login to MyBook <br><br>
                <input name="email" value="<?php echo $email ?>" type="text" placeholder="Email" class="class-5"><br><br>
                <input name="password" value="<?php echo $password ?>" type="password" placeholder="Password" class="class-5"><br><br>
                <input type="submit" id="button" value="Login" class="class-6"/><br><br>
            </form>
        </div>
    </body>
</html>