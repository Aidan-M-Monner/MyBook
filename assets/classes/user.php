<?php 
    class User {
        // --------- Get The User's Data --------- //
        public function get_data($id) {
            $DB = new Database();

            $query = "select * from users where user_id = '$id' limit 1";
            $result = $DB->read($query);

            if($result) {
                $row = $result[0]; 
                return $row;
            } else {
                return false;
            }
        }
    }