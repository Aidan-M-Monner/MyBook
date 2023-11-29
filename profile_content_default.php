<div class="class-11">
    <!----------------- Friends Area ---------------------> 
    <div class="class-12">
        <div class="class-14">
            Friends <br>
            <?php
                if($friends) {
                    foreach($friends as $friend) {
                        $FRIEND_ROW = $user->get_user($friend['user_id']);
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
        <div class="class-20" style="background-color: #CDCDCD;">
            <?php
                if($posts) {
                    foreach($posts as $ROW) {
                        $user = new User();
                        $ROW_USER = $user->get_user($ROW['user_id']);
                        include("post.php");
                    }
                }

                // --------- Get Current URL --------- //
                $pg = pagination_link();
            ?>
            <a href="<?php echo $pg['prev_page']; ?>">
                <input type="submit" value="Prev Page" class="class-19" style="cursor: pointer; float: left; width: 150px;"/>
            </a>

            <a href="<?php echo $pg['next_page']; ?>">
                <input type="submit" value="Next Page" class="class-19" style="cursor: pointer; float: right; width: 150px;"/>
            </a>
            <br>
        </div>
    </div>
</div>