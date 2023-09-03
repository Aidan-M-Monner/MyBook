<?php
    class Database {

        // --------- Hosting Information --------- //
        private $host = "localhost"; // Swapped out for host provider
        private $username = "root"; // Can be changed in priveledges
        private $password = "";
        private $db = "mybook_db";


        // --------- Connecting to Database --------- //
        function connect() {
            $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
            return $connection;
        }

        // --------- Reading From a Database --------- //
        function read($query) {
            $conn = $this->connect();
            $result = mysqli_query($conn, $query);

            if(!$result) {
                return false;
            } else {
                // Returns arrays, adding records...
                $data = false;
                while($row = mysqli_fetch_assoc($result)) { 
                    $data[] = $row;
                }
                return $data;
            }
        }

        // --------- Writing to a Database --------- //
        function save($query) {
            $conn = $this->connect();
            $result = mysqli_query($conn, $query);

            if(!$result) {
                return false;
            } else {
                return true;
            }
        }
    }

    // --------- Create a new database --------- //
    $DB = new Database();