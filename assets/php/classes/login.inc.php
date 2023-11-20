<?php
    class Login {
        private $error = "";

        // --------- Checks if User Profile Exists and Information Correct --------- //
        public function evaluate($data) {
            $email = addslashes($data['email']);
            $password = addslashes($data['password']);

            $query = "select * from users where email = '$email' limit 1";

            $DB = new Database();
            $result = $DB->read($query);

            // Checks to see if email and password are returned.
            if($result) {
                $row = $result[0]; // grabs array to get password for checking.
                if($this->hash_text($password) == $row['password']) {
                    // Create a session data
                    $_SESSION['mybook_user_id'] = $row['user_id'];
                } else {
                    $this->error .= "Wrong email or password <br>";
                }
            } else {
                $this->error .= "Wrong email or password <br>";
            }
            
            return $this->error;
        }

        // --------- Checks if User Profile is Logged In --------- //
        public function check_login($id) {
            if(is_numeric($id)) {
                $query = "select * from users where user_id = '$id' limit 1";

                $DB = new Database();
                $result = $DB->read($query);

                // Checks to see if user_id is returned.
                if($result) {
                    $user_data = $result[0];
                    return $user_data;
                } else {
                    header("Location: login.php");
                    die;
                }   
            } else {
                header("Location: login.php");
                die;
            }
        }

        // --------- Encrypts/Decrypts User Passwords --------- //
        private function hash_text($text) {
            $text = hash("sha1", $text);
            return $text;
        }
    }