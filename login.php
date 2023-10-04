<?php
    // --------- Necessary Files/Expressions to Start --------- //
    session_start();
    include("assets/php/login_assets.php");
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
            <a href="signup.php"><div class="class-3">Signup</div></a>
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