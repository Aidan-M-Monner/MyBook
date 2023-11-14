<a href="" style="text-decoration: none;">
    <div id="notification">
        <?php
            $actor = $User->get_user($notif_row['user_id']);
            $owner = $User->get_user($notif_row['content_owner']);

            if(is_array($actor)) {
                echo "<img src='assets/img/male-icon.png' style='width:32px; margin: 2px; float: left;' />";
                echo $actor['first_name'] . " " . $actor['last_name'];
                if($notif_row['activity'] == "like") {
                    echo " liked ";
                }
                echo $owner['first_name'] . " " . $owner['last_name'];
                echo "'s ";
                echo $notif_row['content_type'];
                echo " ";
            }
        ?>
    </div>
</a>