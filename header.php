<?php
    $image = "";
    if(file_exists($user_data['profile_image'])) {
        $image = $user_data['profile_image'];
    } else if ($user_data['gender'] == "Male") {
        $image = "assets/img/male-icon.png";
    } else if ($user_data['gender'] == "Female") {
        $image = "assets/img/female-icon.png";
    }
?>

<div class="class-1">
    <div class="class-2">
        <a href="timeline.php" class="class-a">MyBook</a> &nbsp; &nbsp;
        <input type="text" placeholder="Search for people..." class="class-3">

        <a href="profile.php">
            <img src="<?php echo $image; ?>" class="class-4"/>
        </a>
        
        <a href="logout.php">
            <span class="class-b">Logout</span>
        </a>
    </div>
</div>