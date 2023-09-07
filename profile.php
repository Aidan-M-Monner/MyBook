<?php
    // --------- Necessary Files/Expressions to Start --------- //
    session_start();
    include("assets/classes/connect.php");
    include("assets/classes/login.inc.php"); 
    include("assets/classes/user.php"); 

    // --------- Check user logged in --------- //
    if(isset($_SESSION['mybook_user_id']) && is_numeric($_SESSION['mybook_user_id'])) {
        $id = $_SESSION['mybook_user_id'];
        $login = new Login();
        $result = $login->check_login($id);


        if($result) {
            // Retrieve user data
            $user = new User();
            $user_data = $user->get_data($id);

            if(!$user_data) { // In case of an error where there is no data/row
                header("Location: login.php");
                die;
            }
        } else {
            header("Location: login.php");
            die;
        }
    } else {
        header("Location: login.php");
        die;
    }

    // --------- User Information Variables --------- //
    $full_name = $user_data['first_name'] . " " . $user_data['last_name'];
?>

<html>
    <head>
        <title>MyBook | Profile</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <div class="class-1">
            <div class="class-2">
                MyBook &nbsp; &nbsp;
                <input type="text" placeholder="Search for people..." class="class-3">
                <img src="assets/img/selfie.jpg" class="class-4"/>
                <a href="logout.php">
                    <span class="class-a">Logout</span>
                </a>
            </div>
        </div>

        <!----------------- Cover Area ---------------------> 
        <div class="class-5">
            <div class="class-6">
                <img src="assets/img/mountain.jpg" class="class-7"/>
                <img src="assets/img/selfie.jpg" class="class-8"/><br>
                <div class="class-9"><?php echo $full_name ?></div><br>
                <div class="class-10">Timeline</div> 
                <div class="class-10">About</div> 
                <div class="class-10">Friends</div> 
                <div class="class-10">Photos</div> 
                <div class="class-10">Settings</div>
            </div>

            <!----------------- Below Cover Area ---------------------> 
            <div class="class-11">
                <!----------------- Friends Area ---------------------> 
                <div class="class-12">
                    <div class="class-14">
                        Friends <br>
                        <div class="class-15">
                            <img src="assets/img/user1.jpg" class="class-16"/><br>
                            First User
                        </div>

                        <div class="class-15">
                            <img src="assets/img/user2.jpg" class="class-16"/><br>
                            Second User
                        </div>

                        <div class="class-15">
                            <img src="assets/img/user3.jpg" class="class-16"/><br>
                            Third User
                        </div>

                        <div class="class-15">
                            <img src="assets/img/user4.jpg" class="class-16"/><br>
                            Fourth User
                        </div>
                    </div>
                </div>

                <!----------------- Posting Area ---------------------> 
                <div class="class-13">
                    <div class="class-17">
                        <textarea placeholder="What's on your mind?" class="class-18"></textarea>
                        <input type="submit" value="Post" class="class-19"/><br><br>
                    </div>

                <!----------------- Posts Area ---------------------> 
                    <div class="class-20">
                        <div class="class-21">
                            <div>
                                <img src="assets/img/user1.jpg" class="class-22"/>
                            </div>
                            <div>
                                <div class="class-23">First User</div>
                                Finn Mertens[1] (also called Finn the Human, Pen in the original short, 
                                and identified as P-G-8-7 Mertens[2]) is the main protagonist in Adventure Time. 
                                He also appeared in the spin-off series Adventure Time: Distant Lands. He was voiced by Jeremy Shada in most appearances. 
                                The character made his debut in the original pilot, where he is named "Pen" and voiced by Zack Shada, Jeremy's older brother. 
                                Jonathan Frakes voices Finn as an adult in some appearances.
                                <br><br>
                                <a href="#">Like</a> . <a href="#">Comment</a> . <span class="class-24">August 30 2023</span>
                            </div>
                        </div>

                        <div class="class-21">
                            <div>
                                <img src="assets/img/user2.jpg" class="class-22"/>
                            </div>
                            <div>
                                <div class="class-23">Second User</div>
                                Jake (full title: Jacob "Jake" the Dog, Sr.[2]) is the deuteragonist of Adventure Time. 
                                He is a dog/shape-shifter hybrid, referred to by others as a "magical dog," 
                                and Finn's constant companion, best friend, and adoptive brother.
                                <br><br>
                                <a href="#">Like</a> . <a href="#">Comment</a> . <span class="class-24">August 30 2023</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>