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
            <?php 
                echo '<a id="info_' . $post_id . '" href="likes.php?type=post&id=' . $post_id . '" style="text-decoration: none;">';
                    echo '<div style="float: left; font-size: 11px;">' . $user_liked . '</div><br>';
                echo '</a>';
            ?>
        </div>
        <hr>
        <div>
            <a onclick="like_post(event)" href="like.php?type=post&id=<?php echo $post_id; ?>" style="text-decoration: none;">Like<?php echo $likes ?></a> . 
            <a href="single_post.php?id=<?php echo $ROW['post_id']; ?>" style="text-decoration: none;"><?php echo $comment_count; ?></a> . 
            <span class="class-24"><?php echo $post_time; ?></span>

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

<script type="text/javascript">
    function ajax_send(data, element) {
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange', function(){
            if(ajax.readyState == 4 && ajax.status == 200){ // Get to recieve (state 4) and get okay (status 200)
                response(ajax.responseText, element);
            } 
        });

        data = JSON.stringify(data);

        ajax.open("post", "ajax.php", true); // Send the data asynchronously to not freeze data (State change 0->1)
        ajax.send(data); // (state change 1->2)
    }

    function response(result, element) {
        if(result != ""){
            var obj = JSON.parse(result);
            if(typeof obj.action != 'undefined') {
                if(obj.action == 'like_post') {
                    var likes = "";

                    if(typeof obj.likes != 'undefined') {
                        likes = (parseInt(obj.likes) > 0) ? "Likes(" + obj.likes + ")" : "Like";
                        element.innerHTML = likes;
                    }

                    if(typeof obj.info != 'undefined') {
                        var info_element = document.getElementById(obj.id);
                        // console.log(info_element);
                        info_element.innerHTML = obj.info;
                    }
                }
            }
        }
    }

    function like_post(e) {
        e.preventDefault(); // Prevents a refresh

        var link = e.target.href;

        var data = {};
        data.link = link;
        data.action = "like_post";

        ajax_send(data, e.target);
    }
</script>
