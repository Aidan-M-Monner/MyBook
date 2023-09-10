<?php 
    class User {
        // --------- Get The Database's Data --------- //
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

        // --------- Get The User's Data --------- //
        public function get_user($id) {
            $query = "select * from users where user_id = '$id' limit 1";
            $DB = new Database();
            $result = $DB->read($query);

            if($result) {
                return $result[0];
            } else {
                return false;
            }
        }

        // --------- Get The User's Friends --------- //
        public function get_friends($id) {
            $query = "select * from users where user_id != '$id'";
            $DB = new Database();
            $result = $DB->read($query);

            if($result) {
                return $result;
            } else {
                return false;
            }
        }
    }