<div style="background-color: #FFF; min-height: 400px; padding-right: 0px; text-align: center; width: 100%;">
    <div style="max-width: 95%; padding: 20px;">
        <form method="post" enctype="multipart/form-data">
            <?php 
                $settings_class = new Settings();
                $settings = $settings_class->get_settings($user_id);

                if(is_array($settings)) {
                    echo "<br>About Me: <br><div name='about' class='class-3-a' style='text-align: left; height: 200px; width: 95%;'>" . htmlspecialchars($settings['about']) . "</div>";
                }
            ?>
        </form>
    </div>
</div>