<?php 

    Class Profile {
        function get_profile($id) {
            $id = addslashes($id); // Helps prevent SQL Injection
            $DB = new Database();
            $query = "select * from users where user_id = '$id' limit 1";
            return $DB->read($query);
        }
    }