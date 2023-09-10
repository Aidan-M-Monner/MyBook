<?php
    // --------- Profile Picture --------- //
    $image = "assets/img/male-icon.png";
    if($ROW_USER['gender'] == "Female") {
        $image = "assets/img/female-icon.png";
    }
?>

<div class="class-21">
    <div>
        <img src="<?php echo $image; ?>" class="class-22"/>
    </div>
    <div>
        <div class="class-23"><?php echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name']; ?></div>
        <?php echo $ROW['post']; ?>
        <br><br>
        <a href="#">Like</a> . <a href="#">Comment</a> . <span class="class-24"><?php echo $ROW['date']; ?></span>
    </div>
</div>