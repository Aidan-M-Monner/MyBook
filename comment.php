<?php
    include("assets/php/comment_assets.php");
?>

<div class="class-21" style="background-color: #FFF;">
    <div>
        <img src="<?php echo $poster_image; ?>" class="class-22"/>
    </div>
    <div style="width: 100%;">
        <div class="class-23">
            <?php 
                echo "<a href='profile.php?id=$COMMENT[user_id]' style='text-decoration: none;'>" . $poster_name . "</a>";
                if($COMMENT['is_profile_image']) {
                    echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun profile image.</span>";
                } else if($COMMENT['is_cover_image']) {
                    echo "<span style='font-weight: normal; color: #aaa;'> updated $pronoun cover image.</span>";
                }
            ?>
        </div>
        <?php
            if(!$poster_comment == "") {
                echo htmlspecialchars($poster_comment) . "<br><br>";
            }
        ?>
        <?php 
            if(file_exists($comment_image)) {
                echo "<img src='$comment_image' style='width: 300px; height: 300px;'/><br><br>";
            }
        ?>
        <div>
            <?php if($comment_likes > 0) { ?>
                <span style="color: #999; float: left; font-size: 11px;">
                    <a href="likes.php?type=post&id=<?php echo $comment_id; ?>" style="text-decoration: none;">
                        <?php echo $user_liked; ?>
                    </a>
                </span><br>
            <?php } ?>
        </div>
        <hr>
        <div>
            <a href="like.php?type=post&id=<?php echo $comment_id; ?>" style="text-decoration: none;">Like<?php echo $likes ?></a> . 
            <span class="class-24"><?php echo $COMMENT['date']; ?></span>

            <?php
                if($COMMENT['has_image']) {
                    echo ". <a href='image_view.php?id=$COMMENT[post_id]' style='text-decoration: none;'>View Full Image</a>"; 
                }
            ?>

            <?php if($user_comment) { ?>
                <span style="color: #999; float: right;">
                    <?php if(!$update_comment) { ?>
                        <a href="edit.php?id=<?php echo $comment_id; ?>" style="text-decoration: none;">Edit</a> . 
                    <?php } ?>
                    <a href="delete.php?id=<?php echo $comment_id; ?>" style="text-decoration: none;">Delete</a>
                </span>
            <?php } ?>

        </div>
    </div>
</div>