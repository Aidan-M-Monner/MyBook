<?php
    session_start();
    include("assets/php/common_assets.php");

    // --------- Grabbing Another User's Account --------- //
    if(isset($_GET['id']) && is_numeric($_GET['id'])){ // White/Black list values that do not exist or are numbers.
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);

        if(is_array($profile_data)) {
            $user_data = $profile_data[0];
        }
    }

    // --------- User Profile Variables --------- //
    $full_name = $user_data['first_name'] . " " . $user_data['last_name'];

    $image = "";
    $image_class = new Image();
    if(file_exists($user_data['profile_image'])) {
        $image = $user_data['profile_image'];
        $ext = pathinfo($image, PATHINFO_EXTENSION);

        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }

        $image = $image_class->get_thumbnail_profile($user_data['profile_image'], $ext);
    } else if ($user_data['gender'] == "Male") {
        $image = "assets/img/male-icon.png";
    } else if ($user_data['gender'] == "Female") {
        $image = "assets/img/female-icon.png";
    }
?>

<html>
    <head>
        <title>MyBook | Profile</title>
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
    </head>
    <body>
        <!----------------- Top Bar ---------------------> 
        <?php include("header.php"); ?>

        <!----------------- Timeline Area ---------------------> 
        <div class="class-5">
            <div class="class-11">
                <!----------------- User Area ---------------------> 
                <div class="class-12">
                    <div class="class-14">
                        <img src="<?php echo $image; ?>" class="class-25"/><br>
                        <a href="profile.php" class="class-26"><?php echo $full_name; ?></a>
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