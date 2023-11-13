<div class="class-1">
    <form method="get" action="search.php">
        <div class="class-2">
            <a href="index.php?user_id=<?php echo $user_id; ?>&page=1" class="class-a">MyBook</a> &nbsp; &nbsp;

                <input type="text" name="find" placeholder="Search for people..." class="class-3">

            <?php if($user_id != 0) { ?>
                <a href="profile.php?id=<?php echo $user_id; ?>">
                    <img src="<?php echo $user_image; ?>" class="class-4"/>
                </a>
                
                <a href="logout.php">
                    <span class="class-b">Logout</span>
                </a>
            <?php } else { ?>
                <a href="signup.php">
                    <span class="class-b">Signup</span>
                </a>
                <a href="login.php">
                    <span class="class-b">Login</span>
                </a>
            <?php } ?>
        </div>
    </form>
</div>