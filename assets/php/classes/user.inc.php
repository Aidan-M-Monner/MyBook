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

        // --------- Follow User --------- //
        public function follow_user($id, $type, $user_id) {
            $DB = new Database();

            // Save likes details
            $sql = "select following from likes where type = '$type' && content_id = '$user_id' limit 1";
            $result = $DB->read($sql);

            if(is_array($result)) {
                // User/following data
                $follows = json_decode($result[0]['following'], true); // true prevents $likes from being an object rather than an array.
                $user_ids = array_column($follows, "user_id");

                if(!in_array($id, $user_ids)) {
                    $arr['user_id'] = $id;
                    $arr['date'] = date("Y-m-d H:i:s");

                    $follows[] = $arr;
                    $follow_string = json_encode($follows);

                    // Save user/follow data
                    $sql = "update likes set following = '$follow_string' where type='$type' && content_id = '$user_id' limit 1";
                    $result = $DB->save($sql);

                    // Add notification
                    $user = new User();
                    $single_user = $user->get_user($user_id);
                    add_notification($user_id, "follow", $single_user);
                } else {
                    $key = array_search($id, $user_ids); // Find array key with user
                    unset($follows[$key]); //Removes user once like is clicked again. They can unlike.
                    $follow_string = json_encode($follows);

                    // Save user/unfollow data
                    $sql = "update likes set following = '$follow_string' where type='$type' && content_id = '$user_id' limit 1";
                    $result = $DB->save($sql);
                } 
            } else {
                // User/like data
                $arr['user_id'] = $id;
                $arr['date'] = date("Y-m-d H:i:s");
                $arr2[] = $arr;
                $following = json_encode($arr2);

                // Save user/like data
                $sql = "insert into likes (type, content_id, following) values ('$type', '$user_id', '$following')";
                $result = $DB->save($sql);

                // Add notification
                $user = new User();
                $single_user = $user->get_user($user_id);
                add_notification($user_id, "follow", $single_user);
            }
        }

        // --------- Get Follows --------- //
        public function get_following($id, $type) {
            $DB = new Database();
            $type = addslashes($type);

            if(is_numeric($id)) {
                // Get follow details
                $sql = "select following from likes where type = '$type' && content_id = '$id' limit 1";
                $result = $DB->read($sql);

                if(is_array($result)) {
                    // User/follow data
                    $follows = json_decode($result[0]['following'], true); // true prevents $likes from being an object rather than an array.
                    return $follows;
                }
            }

            return false;
        }
    }