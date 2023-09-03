<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<pre>";
        print_r($_POST); // Contains all data posted by user
        echo "</pre>";
    }
?>

<html>
    <head>
        <title>MyBook | Signup</title>
        <link rel="stylesheet" type="text/css" href="assets/css/login-signup.css">
    </head>
    <body>
        <!----------- Top Bar ------------->
        <div class="class-1">
            <div class="class-2">MyBook</div>
            <div class="class-3">Login</div>
        </div>

        <!----------- Signup Area ------------->
        <div class="class-4">
            Signup to MyBook <br><br>
            <form method="post" action="signup.php">
                <input type="text" placeholder="First Name" class="class-5" name="first_name"><br><br>
                <input type="text" placeholder="Last Name" class="class-5" name="last_name"><br><br>

                <select class="class-5" name="gender">
                    <option value="" disabled selected>Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select><br><br>

                <input type="text" placeholder="Email" class="class-5" name="email"><br><br>
                <input type="password" placeholder="Password" class="class-5" name="password"><br><br>
                <input type="password" placeholder="Retype Password" class="class-5" name="password2"><br><br>
                <input type="submit" id="button" value="Signup" class="class-6"/><br><br>
            </form>
        </div>
    </body>
</html>