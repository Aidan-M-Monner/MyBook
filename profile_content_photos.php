<div style="background-color: #FFF; min-height: 400px; padding-right: 0px; text-align: center; width: 100%;">
    <div style="padding: 20px;">
        <?php 
            $DB = new Database();
            $sql = "select image, post_id from posts where has_image = 1 && user_id = $user_data[user_id] order by id desc limit 30";
            $images = $DB->read($sql);

            $image_class = new Image();

            if(is_array($images)) {
                foreach ($images as $image_row) {
                    $ext = pathinfo($image_row['image'], PATHINFO_EXTENSION);
                    if($ext == 'jpg' || $ext == "jpeg") {
                        $ext = 'image/jpeg';
                    } else if ($ext == 'png') {
                        $ext = 'image/png';
                    }

                    echo "<a href='single_post.php?id=$image_row[post_id]'>";
                    echo "<img src='" . $image_class->get_thumbnail_post($image_row['image'], $ext) . "' style='margin: 10px; width: 150px;'/>";
                    echo "</a>";
                }
            } else {
                echo "No images were found!";
            }
        ?>
    </div>
</div>