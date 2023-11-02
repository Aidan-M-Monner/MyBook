<?php
    include("assets/php/post_assets.php");
?>

<div class="class-21" style="background-color: #FFF;">
    <div>
        <img src="<?php echo $poster_image; ?>" class="class-22"/>
    </div>
    <div style="width: 100%;">
        <div class="class-23">
            <?php 
                echo "<a href='profile.php?id=$ROW[user_id]' style='text-decoration: none;'>" . $poster_name . "</a>";
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
        <div>
            <?php if($post_likes > 0) { ?>
                <span style="color: #999; float: left; font-size: 11px;">
                    <a href="likes.php?type=post&id=<?php echo $post_id; ?>" style="text-decoration: none;">
                        <?php echo $user_liked; ?>
                    </a>
                </span><br>
            <?php } ?>
        </div>
        <hr>
        <div>
            <a href="like.php?type=post&id=<?php echo $post_id; ?>" style="text-decoration: none;">Like<?php echo $likes ?></a> . 
            <a href="single_post.php?id=<?php echo $ROW['post_id']; ?>" style="text-decoration: none;"><?php echo $comment_count; ?></a> . 
            <span class="class-24"><?php echo $ROW['date']; ?></span>

            <?php
                if($ROW['has_image']) {
                    echo ". <a href='image_view.php?id=$ROW[post_id]' style='text-decoration: none;'>View Full Image</a>"; 
                }
            ?>

            <?php if($user_post) { ?>
                <span style="color: #999; float: right;">
                    <?php if(!$update_post) { ?>
                        <a href="edit.php?id=<?php echo $post_id; ?>" style="text-decoration: none;">Edit</a> . 
                    <?php } ?>
                    <a href="delete.php?id=<?php echo $post_id; ?>" style="text-decoration: none;">Delete</a>
                </span>
            <?php } ?>

        </div>
    </div>
</div>