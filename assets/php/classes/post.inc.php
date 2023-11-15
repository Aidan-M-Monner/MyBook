<?php 
    class Post {
        private $error = "";

        // --------- Create Posts --------- //
        public function create_post($user_id, $data, $files) {
            if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image'])) {
                $DB = new Database();
                
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
                    // Move image into the uploads folder
                    $folder = "uploads/" . $user_id . "/posts/";

                    // Create Folder
                    if(!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", ""); // Creates index to keep users from seeing content.
                    }

                    if(!empty($files['file']['name'])) {

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
                
                // Find if there is a parent post
                $parent = 0;
                if(isset($data['parent']) && is_numeric($data['parent'])) {
                    $parent = $data['parent'];
                    $sql = "update posts set comments = comments + 1 where post_id = '$parent' limit 1";
                    $DB->save($sql);
                }

                $query = "insert into posts (user_id, post_id, parent, post, has_image, is_profile_image, is_cover_image, image) values ('$user_id', '$post_id', $parent, '$post', '$has_image', '$is_profile_image', '$is_cover_image', '$myImage')";

                $DB->save($query);
            } else {
                $this->error = "Please type something before posting! <br>";
            }
            return $this->error;
        }

        // --------- Edit Post --------- //
        public function edit_post($user_id, $data, $files) {
            if(!empty($data['post']) || !empty($files['file']['name'])) {
                // Check for images
                $myImage = "";
                $has_image = 0;

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

                // Ensure post is set.
                $post = "";
                if(isset($data['post'])) {
                    $post = addslashes($data['post']);
                }

                $post_id = addslashes($data['post_id']);

                if($has_image) {
                    $query = "update posts set post = '$post', image = '$myImage' where post_id = '$post_id' limit 1";
                } else {
                    $query = "update posts set post = '$post' where post_id = '$post_id' limit 1";
                }

                $DB = new Database();
                $DB->save($query);
            } else {
                $this->error = "Please type something before posting! <br>";
            }
            return $this->error;
        }

        // --------- Grabbing Posts --------- //
        public function get_posts($id) {
            $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page_number = ($page_number < 1) ? 1 : $page_number;
            
            $limit = 2;
            $offset = ($page_number - 1) * $limit;

            $query = "select * from posts where user_id = '$id' && parent = 0 order by id desc limit $limit offset $offset";

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

        // --------- Grabbing Comments --------- //
        public function get_comments($id) {
            $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page_number = ($page_number < 1) ? 1 : $page_number;
            
            $limit = 2;
            $offset = ($page_number - 1) * $limit;

            $query = "select * from posts where parent = '$id' order by id asc limit $limit offset $offset";

            $DB = new Database();
            $result = $DB->read($query);

            if($result) {
                return $result;
            } else {
                return false;
            }
        }

        // --------- Deleting Post --------- //
        public function delete_post($post_id) {
            $DB = new Database();

            if(!is_numeric($post_id)) {
                return false; // stops function if user tries to input non-numeric characters, improving security.
            }

            $Post = new Post();
            $one_post = $Post->get_post($post_id); 

            $sql = "select parent from posts where post_id = '$post_id' limit 1";
            $result = $DB->read($sql);

            // Find if there is a parent post
            if(is_array($result)) {
                if($result[0]['parent'] > 0) {
                    $parent = $result[0]['parent'];
                    $sql = "update posts set comments = comments - 1 where post_id = '$parent' limit 1";
                    $DB->save($sql);
                }
            }

            $query = "delete from posts where post_id = '$post_id' limit 1";
            $DB->save($query);

            // Delete any images and thumbnails
            if($one_post['image'] != "" && file_exists($one_post['image'])) {
                unlink($one_post['image']); // unlink deletes image
            }

            if($one_post['image'] != "" && file_exists($one_post['image'] . "_post_thumb")) {
                unlink($one_post['image'] . "_post_thumb"); // unlink deletes image
            }

            if($one_post['image'] != "" && file_exists($one_post['image'] . "_profile_thumb")) {
                unlink($one_post['image'] . "_profile_thumb"); // unlink deletes image
            }

            if($one_post['image'] != "" && file_exists($one_post['image'] . "_cover_thumb")) {
                unlink($one_post['image'] . "_cover_thumb"); // unlink deletes image
            }

            // Delete all comments
            $query = "delete from posts where parent = '$post_id'";
            $DB->save($query);
        }

        // --------- Like Post --------- //
        public function like_post($id, $type, $user_id) {
            $DB = new Database();

            // Save likes details
            $sql = "select likes from likes where type = '$type' && content_id = '$id' limit 1";
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
                    $sql = "update likes set likes = '$likes_string' where type='$type' && content_id = '$id' limit 1";
                    $result = $DB->save($sql);

                    // Increment the Posts table
                    $sql = "update {$type}s set likes = likes + 1 where {$type}_id = '$id' limit 1";
                    $DB->save($sql);

                    // Add notification
                    $post = new Post();
                    $single_post = $post->get_post($id);
                    add_notification($user_id, "like", $single_post);
                } else {
                    $key = array_search($user_id, $user_ids); // Find array key with user
                    unset($likes[$key]); //Removes user once like is clicked again. They can unlike.
                    $likes_string = json_encode($likes);

                    // Save user/unlike data
                    $sql = "update likes set likes = '$likes_string' where type='$type' && content_id = '$id' limit 1";
                    $result = $DB->save($sql);

                    // Decrement the right table
                    $sql = "update {$type}s set likes = likes - 1 where {$type}_id = '$id' limit 1";
                    $DB->save($sql);
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

                // Increment the right table
                $sql = "update {$type}s set likes = likes + 1 where {$type}_id = '$id' limit 1";
                $DB->save($sql);

                // Add notification
                $post = new Post();
                $single_post = $post->get_post($id);
                add_notification($user_id, "like", $single_post);
            }
        }

        // --------- Get Likes --------- //
        public function get_likes($id, $type) {
            $DB = new Database();
            $type = addslashes($type);
            
            if(is_numeric($id)) {
                // Get like details
                $sql = "select likes from likes where type = '$type' && content_id = '$id' limit 1";
                $result = $DB->read($sql);

                if(is_array($result)) {
                    // User/like data
                    $likes = json_decode($result[0]['likes'], true); // true prevents $likes from being an object rather than an array.
                    return $likes;
                }
            }

            return false;
        }

        // --------- Like Amount --------- //
        public function like_amount($likes) {
            $like_amount = ($likes > 1) ? $likes . " people liked this post" : $likes . " person liked this post";
            return $like_amount;
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