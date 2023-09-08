<?php 
    session_start();

    // --------- Check If Login is Set Then Unset --------- //
    if(isset($_SESSION['mybook_user_id'])) {
        $_SESSION['mybook_user_id'] = NULL;
        unset($_SESSION['mybook_user_id']);
    }

    // --------- Back to Login --------- //
    header("Location: login.php");
    die;