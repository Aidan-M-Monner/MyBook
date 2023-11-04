<div class="class-1">
    <form method="get" action="search.php">
        <div class="class-2">
            <a href="index.php" class="class-a">MyBook</a> &nbsp; &nbsp;

                <input type="text" name="find" placeholder="Search for people..." class="class-3">

            <a href="profile.php?id=<?php echo $user_id; ?>">
                <img src="<?php echo $user_image; ?>" class="class-4"/>
            </a>
            
            <a href="logout.php">
                <span class="class-b">Logout</span>
            </a>
        </div>
    </form>
</div>