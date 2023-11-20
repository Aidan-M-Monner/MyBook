<?php
    // --------- Profile Picture --------- //
    $friend_name = $FRIEND_ROW['first_name'] . " " .  $FRIEND_ROW['last_name'];

    // --------- Profile Picture --------- //
    $friend_image = "";
    if(file_exists($FRIEND_ROW['profile_image'])) {
        $friend_image = $FRIEND_ROW['profile_image'];
        $ext = pathinfo($friend_image, PATHINFO_EXTENSION);

        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }

        $friend_image = $image_class->get_thumbnail_profile($friend_image, $ext);
    } else if ($FRIEND_ROW['gender'] == "Male") {
        $friend_image = "assets/img/male-icon.png";
    } else if ($FRIEND_ROW['gender'] == "Female") {
        $friend_image = "assets/img/female-icon.png";
    }
?>

<div class="class-15">
    <a href="profile.php?id=<?php echo $FRIEND_ROW['user_id']; ?>" style="text-decoration: none;">
        <img src="<?php echo $friend_image; ?>" class="class-16"/><br>
        <span style="float:left;"><?php echo $friend_name; ?></span>
    </a>
</div>