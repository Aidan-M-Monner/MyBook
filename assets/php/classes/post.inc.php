<?php 
    class Post {
        private $error = "";

        // --------- Create Posts --------- //
        public function create_post($user_id, $data, $files) {
            if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image'])) {
                print_r("Second <br>");
                // Check for images
                $myImage = "";
                $has_image = 0;
                $is_cover_image = 0;
                $is_profile_image = 0;

                if(isset($data['is_profile_image']) || isset($data['is_cover_image'])) {
                    $myImage = $files;
                    $has_image = 1;

                    if(isset($data['is_profile_image'])) {
                        $is_profile_image = 1;
                    } else if(isset($data['is_cover_image'])) {
                        $is_cover_image = 1;
                    }

                } else {

                    if(!empty($files['file']['name'])) {
                        // Move image into the uploads folder
                        $folder = "uploads/" . $user_id . "/posts/";

                        // Create Folder
                        if(!file_exists($folder)) {
                            mkdir($folder, 0777, true);
                            file_put_contents($folder . "index.php", ""); // Creates index to keep users from seeing content.
                        }

                        // Variables
                        $image_class = new Image();
                        $file_type = $_FILES['file']['type'];

                        // Check out file extension
                        if($file_type == 'image/png') {
                            $myImage = $folder . $image_class->generate_filename(15) . ".png";
                        } else if ($file_type == 'image/jpg' || $file_type == 'image/jpeg') {
                            $myImage = $folder . $image_class->generate_filename(15) . ".jpg";
                        }

                        move_uploaded_file($_FILES['file']['tmp_name'], $myImage);
                        $image_class->resize_image($file_type, $myImage, $myImage, 1500, 1500);

                        $has_image = 1;
                    }
                }
                
                // Ensure post is set.
                $post = "";
                if(isset($data['post'])) {
                    $post = addslashes($data['post']);
                }

                $post_id = $this->create_post_id();

                $query = "insert into posts (user_id, post_id, post, has_image, is_profile_image, is_cover_image, image) values ('$user_id', '$post_id', '$post', '$has_image', '$is_profile_image', '$is_cover_image', '$myImage')";

                $DB = new Database();
                $DB->save($query);
            } else {
                $this->error = "Please type something before posting! <br>";
            }
            return $this->error;
        }

        // --------- Grabbing Posts --------- //
        public function get_posts($id) {
            $query = "select * from posts where user_id = '$id' order by id desc limit 10";

            $DB = new Database();
            $result = $DB->read($query);

            if($result) {
                return $result;
            } else {
                return false;
            }
        }

        // --------- Grabbing Singular Post --------- //
        public function get_post($post_id) {
            if(!is_numeric($post_id)) {
                return false; // stops function if user tries to input non-numeric characters, improving security.
            }

            $query = "select * from posts where post_id = '$post_id' limit 1";

            $DB = new Database();
            $result = $DB->read($query);

            if($result) {
                return $result[0];
            } else {
                return false;
            }
        }

        // --------- Deleting Post --------- //
        public function delete_post($post_id) {
            if(!is_numeric($post_id)) {
                return false; // stops function if user tries to input non-numeric characters, improving security.
            }

            $query = "delete from posts where post_id = '$post_id' limit 1";

            $DB = new Database();
            $DB->save($query);
        }

        // --------- Like Post --------- //
        public function like_post($id, $type, $user_id) {
            $DB = new Database();
            if($type = "post") {
                // Increment the Posts table
                $sql = "update posts set likes = likes + 1 where post_id = '$id' limit 1";
                $DB->save($sql);

                // Save likes details
                $sql = "select likes from likes where type = 'post' && content_id = '$id' limit 1";
                $result = $DB->read($sql);

                if(is_array($result)) {
                    // User/like data
                    $likes = json_decode($result[0]['likes'], true); // true prevents $likes from being an object rather than an array.
                    $user_ids = array_column($likes, "user_id");

                    if(!in_array($user_id, $user_ids)) {
                        $arr['user_id'] = $user_id;
                        $arr['date'] = date("Y-m-d H:i:s");

                        $likes[] = $arr;
                        $likes_string = json_encode($likes);

                        // Save user/like data
                        $sql = "update likes set likes = '$likes_string' where type='post' && content_id = '$id' limit 1";
                        $result = $DB->save($sql);
                    }
                } else {
                    // User/like data
                    $arr['user_id'] = $user_id;
                    $arr['date'] = date("Y-m-d H:i:s");
                    $arr2[] = $arr;
                    $likes = json_encode($arr2);

                    // Save user/like data
                    $sql = "insert into likes (type, content_id, likes) values ('$type', '$id', '$likes')";
                    $result = $DB->save($sql);
                }
            }
        }

        // --------- Creating a Post ID --------- //
        private function create_post_id() {
            $length = rand(4, 19);
            $number = "";
            for($i = 0; $i < $length; $i++) {
                $new_rand = rand(0,9);
                $number = $number . $new_rand;
            }
            return $number;
        }
    }