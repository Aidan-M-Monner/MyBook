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