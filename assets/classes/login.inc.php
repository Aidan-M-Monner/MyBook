<?php
    class Login {
        private $error = "";

        public function evaluate($data) {
            $email = addslashes($data['email']);
            $password = addslashes($data['password']);

            $query = "select * from users where email = '$email' limit 1";

            $DB = new Database();
            $result = $DB->read($query);

            // Checks to see if email and password are returned.
            if($result) {
                $row = $result[0]; // grabs array to get password for checking.
                if($password == $row['password']) {
                    // Create a session data
                    $_SESSION['user_id'] = $row['user_id'];
                } else {
                    $error .= "Wrong email or password <br>";
                }
            } else {
                $error .= "No such email was found <br>";
            }
            
            return $error;
        }
    }