<?php
    // --------- Profile Picture --------- //
    $full_name = $FRIEND_ROW['first_name'] . " " .  $FRIEND_ROW['last_name'];

    // --------- Profile Picture --------- //
    $image = "assets/img/male-icon.png";
    if($FRIEND_ROW['gender'] == "Female") {
        $image = "assets/img/female-icon.png";
    }
?>

<div class="class-15">
    <img src="<?php echo $image; ?>" class="class-16"/><br>
    <?php echo $full_name; ?>
</div>