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
        <style>
            .class-e {
                background-color: #405D9B;
                border: none;
                border-radius: 2px;
                color: #FFF;
                cursor: pointer;
                font-size: 14px;
                margin-right: 10px;
                min-width: 50px;
                padding: 4px;
            }
        </style>

        <!----------------- Cover Area ---------------------> 
        <div class="class-5">
            <div class="class-6">
                <img src="<?php echo $cover; ?>" class="class-7"/>
                <img src="<?php echo $image; ?>" class="class-8"/><br>
                <?php if(!$user_page) { ?>
                <div style="text-align: right; width:100%;">
                    <a href="like.php?type=user&id=<?php echo $user_data['user_id'] ?>">
                        <input id="post_button" type="submit" value="<?php echo $user_follow; ?>" class="class-e">
                    </a>
                </div>
                <?php } ?>
                <?php if($user_page) { ?>
                    <div class="class-c"> 
                        <a href="change_profile_image.php?change=profile" class="class-d">Change Image</a> | 
                        <a href="change_profile_image.php?change=cover" class="class-d">Change Cover</a>
                    </div>
                <?php } ?>
                <div class="class-9"><a href="profile.php?id=<?php echo $user_data['user_id'] ?>" style="text-decoration: none;"><?php echo $full_name ?></a></div>
                <div style="font-size: 12px;">
                    <a href="likes.php?type=user&id=<?php echo $user_data['user_id']; ?>" style="text-decoration: none;">
                        <?php echo $user_followers; ?>
                    </a>
                </div><br>
                <a href="index.php?id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Timeline</div></a>
                <a href="profile.php?section=about&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">About</div></a>
                <a href="profile.php?section=following&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Following</div></a>
                <a href="profile.php?section=followers&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Followers</div></a>
                <a href="profile.php?section=photos&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Photos</div></a>
                <a href="profile.php?section=settings"><div class="class-10">Settings</div></a>
            </div>

            <!----------------- Below Cover Area ---------------------> 
            <?php 
                $section = "default";
                if(isset($_GET['section'])) {
                    $section = $_GET['section'];
                }

                if($section == "default") {
                    include("profile_content_default.php");
                } else if($section == "following") {
                    include("profile_content_following.php");
                } else if($section == "followers") {
                    include("profile_content_followers.php");
                } else if($section == "photos") {
                    include("profile_content_photos.php");
                }
            ?>
        </div>
    </body>
</html>