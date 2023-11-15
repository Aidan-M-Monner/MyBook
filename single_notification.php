<?php
    $actor = $User->get_user($notif_row['user_id']);
    $owner = $User->get_user($notif_row['content_owner']);
    $id = esc($user_id);

    $link = "";

    if($notif_row['content_type'] == "post") {
        $link = "single_post.php?id=" . $notif_row['content_id'];
    } else if($notif_row['content_type'] == "profile") {

    } else if($notif_row['content_type'] == "comment") {

    }
?>

<a href="<?php echo $link ?>" style="text-decoration: none;">
    <div id="notification">
        <?php
            if(is_array($actor)) {
                echo "<img src='assets/img/male-icon.png' style='width:32px; margin: 2px; float: left;' />";

                if($actor['user_id'] != $id) {
                    echo $actor['first_name'] . " " . $actor['last_name'];
                } else {
                    echo "You ";
                }

                if($notif_row['activity'] == "like") {
                    echo " liked ";
                } else if($notif_row['activity'] == "follow") {
                    echo " follow ";
                }

                if($owner['user_id'] == $id) {
                    echo "your ";
                } else {
                    echo $owner['first_name'] . " " . $owner['last_name'] . "'s ";
                }

                echo $notif_row['content_type'];
                $date = date("jS M Y H:i:s", strtotime($notif_row['date']));
                echo "<br><span style='color: #888; display: inline-block; float: right; font-size: 11px; margin-right: 10px;'>$date</span>";
            }
        ?>
    </div>
</a>