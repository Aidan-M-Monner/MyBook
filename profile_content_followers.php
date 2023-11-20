<div style="background-color: #FFF; min-height: 400px; padding-right: 0px; text-align: center; width: 100%;">
    <div style="padding: 20px;">
        <?php 
            $DB = new Database();
            $sql = "select image, post_id from posts where has_image = 1 && user_id = $user_data[user_id] order by id desc limit 30";
            $images = $DB->read($sql);

            $image_class = new Image();
            $post_class = new Post();
            $user_class = new User();
            $followers = $post_class->get_likes($user_data['user_id'], "user");

            if(is_array($followers) && $followers != []) {
                foreach ($followers as $follower) {
                    $FRIEND_ROW = $user_class->get_user($follower['user_id']);
                    include("user.php");
                }
            } else {
                echo "No followers were found!";
            }
        ?>
    </div>
</div>