<?php
    // --------- General Poster Information --------- //
    $poster_name = $ROW_USER['first_name'] . " " . $ROW_USER['last_name'];
    $poster_post = $ROW['post'];
    $post_id = $ROW['post_id'];

    // --------- Poster Profile Image --------- //
    $poster_image = "";
    if(file_exists($ROW_USER['profile_image'])) {
        $poster_image = $ROW_USER['profile_image'];
        $ext = pathinfo($poster_image, PATHINFO_EXTENSION);

        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }

        $poster_image = $image_class->get_thumbnail_profile($poster_image, $ext);
    } else if ($ROW_USER['gender'] == "Male") {
        $poster_image = "assets/img/male-icon.png";
    } else if ($ROW_USER['gender'] == "Female") {
        $poster_image = "assets/img/female-icon.png";
    }

    // --------- Post Image --------- //
    $image_class = new Image();
    $post_image = $ROW['image'];
    if(file_exists($post_image)) {
        $ext = pathinfo($post_image, PATHINFO_EXTENSION);
        if($ext == 'jpg' || $ext == "jpeg") {
            $ext = 'image/jpeg';
        } else if ($ext == 'png') {
            $ext = 'image/png';
        }
        $post_image = $image_class->get_thumbnail_post($post_image, $ext);
    }

    // --------- Poster Gender --------- //
    $pronoun = "";
    if($ROW_USER['gender'] == 'Male') {
        $pronoun = "his";
    } else if($ROW_USER['gender'] == 'Female') {
        $pronoun = "her";
    }

    // --------- Check If Post User --------- //
    $user_post = false;
    if($user_id == $ROW['user_id']) {
        $user_post = true;
    }
?>

<div class="class-21">
    <div>
        <img src="<?php echo $poster_image; ?>" class="class-22"/>
    </div>
    <div style="width: 100%;">
        <div class="class-23">
            <?php 
                echo $poster_name;
                if($ROW['is_profile_image']) {
                    echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun profile image.</span>";
                } else if($ROW['is_cover_image']) {
                    echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun cover image.</span>";
                }
            ?>
        </div>
        <?php
            if(!$poster_post == "") {
                echo htmlspecialchars($poster_post) . "<br><br>";
            }
        ?>
        <?php 
            if(file_exists($post_image)) {
                echo "<img src='$post_image' style='width: 300px; height: 300px;'/><br><br>";
            }
        ?>
        <a href="like.php?type=post&id=<?php echo $post_id; ?>">Like</a> . 
        <a href="#">Comment</a> . 
        <span class="class-24"><?php echo $ROW['date']; ?></span> 
        <?php if($user_post) { ?>
            <span style="color: #999; float: right;">
                <a href="edit.php">Edit</a> . 
                <a href="delete.php?id=<?php echo $post_id; ?>">Delete</a>
            </span>
        <?php } ?>
    </div>
</div>