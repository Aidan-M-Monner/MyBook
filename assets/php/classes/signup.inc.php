<?php 
    class Signup {
        private $error = "";

        // --------- Checking The Data --------- //
        public function evaluate($data) {
            foreach($data as $key => $value) {
                // Check for empty values
                if(empty($value)) {
                    $this->error .= $key . " is empty!<br/>";
                } else {
                    // Checking first name for numeric values and spaces
                    if($key == "first_name") {
                        if(preg_match('~[0-9]+~', $value)) {
                            $this->error = $this->error . " First name cannot have a numeric value. <br>";
                        }

                        if(strstr($value, " ")) {
                            $this->error = $this->error . " First name cannot have a space. <br>";
                        }
                    }

                    // Checking last name for numeric values and spaces
                    if($key == "last_name") {
                        if(preg_match('~[0-9]+~', $value)) {
                            $this->error = $this->error . " Last name cannot have a numeric value. <br>";
                        }

                        if(strstr($value, " ")) {
                            $this->error = $this->error . " Last name cannot have a space. <br>";
                        }
                    }

                    // Make sure gender is male/female.
                    if($key == "gender") {
                        echo $value;
                        if($value != 'Male' && $value != 'Female') {
                            $this->error = $this->error . " Please select either male or female. <br>";
                        }
                    }

                    // Checking the email
                    if($key == "email") {
                        if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
                            $this->error = $this->error . " Invalid email address! <br>";
                        }
                    }
                }
            }

            if($this->error == "") {
                // No Errors!
                $this->create_user($data);
            } else {
                return $this->error;
            }
        }

        // --------- Creating a User --------- //
        public function create_user($data) {
            $first_name = ucfirst($data['first_name']); // ucfirst makes first letter capital
            $last_name = ucfirst($data['last_name']);
            $gender = $data['gender'];
            $email = $data['email'];
            $password = hash("sha1", $data['password']);

            // PHP Created Variables
            $user_id = $this->create_user_id();
            $url_address = strtolower($first_name) . "." . strtolower($last_name);

            $query = "insert into users (user_id, first_name, last_name, gender, email, password, url_address) values ('$user_id', '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";

            $DB = new Database();
            $DB->save($query);
        }

        // --------- Creating a User ID --------- //
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