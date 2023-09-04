<?php 
    class Signup {
        private $error = "";

        public function evaluate($data) {
            foreach($data as $key => $value) {
                if(empty($value)) {
                    $this->error .= $key . " is empty!<br/>";
                }
            }

            if($this->error == "") {
                // No Errors!
                $this->create_user($data);
            } else {
                return $this->error;
            }
        }

        public function create_user($data) {
            $first_name = $data['first_name'];
            $last_name = $data['last_name'];
            $gender = $data['gender'];
            $email = $data['email'];
            $password = $data['password'];

            // PHP Creates
            $user_id = strtolower($first_name) . "." . strtolower($last_name);
            $url_address = create_user_id();

            $query = "insetr into users (user_id, first_name, last_name, gender, email, password, url_address) values ('$user_id', '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";

            return $query;
            // $DB = new Database();
            // $DB->save($query);
        }

        private function create_user_id() {
            $length = rand(4, 19);
            $number = "";
            for($i = 0; $i < $length; $i++) {
                $new_rand = rand(0,9);
                $number = $number . $new_rand;
            }
            return $number;
        }
    }