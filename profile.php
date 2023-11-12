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

        <!----------------- Change Profile Image ---------------------> 
        <div id="change_profile_image" style="display: none; position: absolute; width: 100%; height: 100%;">
            <div class="class-5" style="max-width: 600px;">
                <div class="class-11">
                    <div class="class-13">
                        <button onclick="hide_change_profile_image()">X</button>
                        <form method="post" action="profile.php?change=profile" enctype="multipart/form-data">
                            <div class="class-17">
                                <input type="file" name="file">
                                <input type="submit" value="Change" class="class-19" style="width: 120px;"/><br>
                                
                                <div style="text-align: center;"><br>
                                    <?php 
                                        echo "<img src='$user_data[profile_image]' style='max-width: 500px; max-height: 500px;'>";
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!----------------- Change Profile Image ---------------------> 
        <div id="change_cover_image" style="display: none; position: absolute; width: 100%; height: 100%;">
            <div class="class-5" style="max-width: 600px;">
                <div class="class-11">
                    <div class="class-13">
                        <button onclick="hide_change_cover_image()">X</button>
                        <form method="post" action="profile.php?change=cover" enctype="multipart/form-data">
                            <div class="class-17">
                                <input type="file" name="file">
                                <input type="submit" value="Change" class="class-19" style="width: 120px;"/><br>
                                
                                <div style="text-align: center;"><br>
                                    <?php 
                                        echo "<img src='$user_data[cover_image]' style='max-width: 500px;'>";
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!----------------- Cover Area ---------------------> 
        <div class="class-5">
            <div class="class-6">
                <img src="<?php echo $cover; ?>" class="class-7"/>
                <img src="<?php echo $image; ?>" class="class-8"/><br>
                <?php if(!$user_page && $user_id != 0) { ?>
                <div style="text-align: right; width:100%;">
                    <a href="like.php?type=user&id=<?php echo $user_data['user_id'] ?>">
                        <input id="post_button" type="submit" value="<?php echo $user_follow; ?>" class="class-e">
                    </a>
                </div>
                <?php } ?>
                <?php if($user_page) { ?>
                    <div class="class-c"> 
                        <a onclick="show_change_profile_image(event)" href="change_profile_image.php?change=profile" class="class-d">Change Image</a> | 
                        <a onclick="show_change_cover_image(event)" href="change_profile_image.php?change=cover" class="class-d">Change Cover</a>
                    </div>
                <?php } ?>
                <div class="class-9"><a href="profile.php?id=<?php echo $user_data['user_id'] ?>" style="text-decoration: none;"><?php echo $full_name ?></a></div>
                <div style="font-size: 12px;">
                    <a href="likes.php?type=user&id=<?php echo $user_data['user_id']; ?>" style="text-decoration: none;">
                        <?php echo $user_followers; ?>
                    </a>
                </div><br>
                <a href="index.php"><div class="class-10">Timeline</div></a>
                <a href="profile.php?section=about&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">About</div></a>
                <a href="profile.php?section=following&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Following</div></a>
                <a href="profile.php?section=followers&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Followers</div></a>
                <a href="profile.php?section=photos&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Photos</div></a>
                <?php if($user_page) { ?>
                    <a href="profile.php?section=settings&id=<?php echo $user_data['user_id']; ?>"><div class="class-10">Settings</div></a>
                <?php } ?>
            </div>

            <!----------------- Below Cover Area ---------------------> 
            <?php 
                $section = "default";
                if(isset($_GET['section'])) {
                    $section = $_GET['section'];
                }

                if($section == "default") {
                    include("profile_content_default.php");
                } else if($section == "about") {
                    include("profile_content_about.php");
                } else if($section == "following") {
                    include("profile_content_following.php");
                } else if($section == "followers") {
                    include("profile_content_followers.php");
                } else if($section == "photos") {
                    include("profile_content_photos.php");
                } else if($section == "settings") {
                    include("profile_content_settings.php");
                }
            ?>
        </div>
    </body>
</html>

<script src="assets/javascript/change_image.js" type="text/javascript"></script>