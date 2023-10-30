<?php 
    Class Settings {

        // --------- Grabbing Settings Section --------- //
        public function get_settings($id) {
            $DB = new Database();
            $sql = "select * from users where user_id = '$id' limit 1";
            $row = $DB->read($sql);

            if(is_array($row)) {
                return $row[0];
            }
        }

        // --------- Saving Settings --------- //
        public function save_settings($data) {
            $password = $data['password'];

            if(strlen($password) < 30) {
                if($data['passwoord'] == $data['password2']) {
                    $data['password'] = hash("sha1", $password);
                } else {
                    unset($data['password']);
                }
            }

            unset($data['password2']);

        }
    }