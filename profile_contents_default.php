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
        <div class="class-20" style="background-color: #CDCDCD;">
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