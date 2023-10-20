<?php
    session_start();
    include("assets/php/common_assets.php");
    include("assets/php/profile_assets.php");

    // --------- Is User's Page? --------- //
    $user_page = false;
    if($user_id == $user_data['user_id']) {
        $user_page = true;
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

        <!----------------- Cover Area ---------------------> 
        <div class="class-5">
            <div class="class-6">
                <img src="<?php echo $cover; ?>" class="class-7"/>
                <img src="<?php echo $image; ?>" class="class-8"/><br>
                <?php if($user_page) { ?>
                    <div class="class-c"> 
                        <a href="change_profile_image.php?change=profile" class="class-d">Change Image</a> | 
                        <a href="change_profile_image.php?change=cover" class="class-d">Change Cover</a>
                    </div>
                <?php } ?>
                <div class="class-9"><?php echo $full_name ?></div><br>
                <a href="timeline.php"><div class="class-10">Timeline</div></a>
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
                        <?php
                            if($friends) {
                                foreach($friends as $FRIEND_ROW) {
                                    include("user.php");
                                }
                            }
                        ?>
                    </div>
                </div>

                <!----------------- Posting Area ---------------------> 
                <div class="class-13">
                    <div class="class-17">
                        <form method="post" enctype="multipart/form-data">
                            <textarea placeholder="What's on your mind?" class="class-18" name="post"></textarea>
                            <input type="file" name="file"/>
                            <input type="submit" value="Post" class="class-19"/><br><br>
                        </form>
                    </div>

                <!----------------- Posts Area ---------------------> 
                    <div class="class-20">
                        <?php
                            if($posts) {
                                foreach($posts as $ROW) {
                                    $user = new User();
                                    $ROW_USER = $user->get_user($ROW['user_id']);
                                    include("post.php");
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>