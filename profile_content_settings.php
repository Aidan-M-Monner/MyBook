<div style="background-color: #FFF; min-height: 400px; padding-right: 0px; text-align: center; width: 100%;">
    <div style="display: inline-block; max-width:350px; padding: 20px;">
        <form method="post" enctype="multipart/form-data">
            <?php 
                $settings_class = new Settings();
                $settings = $settings_class->get_settings($user_id);

                if(is_array($settings)) {
                    echo "<input type='text' name='first_name' class='class-3-a' placeholder='First Name' value='" . htmlspecialchars($settings['first_name']) . "'/>";
                    echo "<input type='text' name='last_name' class='class-3-a' placeholder='Last Name' value='" . htmlspecialchars($settings['last_name']) ."'/>";
                    echo "<select class='class-3-a' name='gender' style='height: 30px;' value='" . htmlspecialchars($settings['gender']) . "'>
                            <option>Male</option>
                            <option>Female</option>
                        </select>";
                    echo "<input type='text' name='email_name' class='class-3-a' placeholder='Email' value='" . htmlspecialchars($settings['email']) . "'/>";
                    echo "<input type='password' name='password_name' class='class-3-a' placeholder='Password' value='" . htmlspecialchars($settings['password']) . "'/>";
                    echo "<input type='password' name='password_name' class='class-3-a' placeholder='Retype Password' value='" . htmlspecialchars($settings['password']). "'/>";
                    echo "<br>About Me: <br><textarea name='about' class='class-3-a' style='height: 200px;'>" . htmlspecialchars($settings['about']) . "</textarea>";

                    echo "<input type='submit' value='Save' class='class-19'/>";
                }
            ?>
        </form>
    </div>
</div>