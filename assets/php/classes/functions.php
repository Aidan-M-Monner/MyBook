<?php 
    // --------- Get current URL --------- //
    function pagination_link() {
        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page_number = ($page_number < 1) ? 1 : $page_number;

        $arr['next_page'] = "";
        $arr['prev_page'] = "";

        $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
        $url .= "?";

        if($_GET['page'] = "") {
            $_GET['page'] = 1;
        }

        $next_page_link = $url;
        $prev_page_link = $url;
        $page_found = false;

        $num = 0;
        foreach($_GET as $key => $value) {
            $num++;
            if($num == 1) {
                if($key == "page") {
                    $next_page_link .= $key . "=" . ($page_number + 1);
                    $prev_page_link .= $key . "=" . ($page_number - 1);
                    $page_found = true;
                } else {
                    $next_page_link .= $key . "=" . $value;
                    $prev_page_link .= $key . "=" . $value;
                }
            } else {
                if($key == "page") {
                    $next_page_link .= "&" . $key . "=" . ($page_number + 1);
                    $prev_page_link .= "&" . $key . "=" . ($page_number - 1);
                    $page_found = true;
                } else {
                    $next_page_link .= "&" . $key . "=" . $value;
                    $prev_page_link .= "&" . $key . "=" . $value;
                }
            }
        }

        $arr['next_page'] = $next_page_link;
        $arr['prev_page'] = $prev_page_link;

        if(!$page_found) {
            $arr['next_page'] = $next_page_link ."page=2";
            $arr['prev_page'] = $prev_page_link . "&page=1";
        }

        return $arr;
    }

    // --------- Send Notifications --------- //
    function add_notification($user_id, $activity, $row) {
        $row = (object)$row;
        $user_id = esc($user_id);
        $activity = esc($activity);
        $date = date("Y-m-d H:i:s");
        $content_owner = $row->user_id;
        $content_type = "";
        $content_id = 0;

        if(isset($row->post_id)) {
            $content_id = $row->post_id;
            $content_type = "post";

            if($row->parent > 0) {
                $content_type = "comment";
            }
        } 

        if(isset($row->gender)) {
            $content_type = "profile";
            $content_id = $row->user_id;
        }

        $query = "insert into notifications (user_id, activity, content_id, content_type, content_owner, date) values ('$user_id', '$activity', '$content_id', '$content_type', '$content_owner', '$date')";
        $DB = new Database();
        $DB->save($query);
    }

    // --------- Send Following Notifications --------- //
    function content_i_follow($user_id, $row) {
        $user_id = esc($user_id);
        $date = date("Y-m-d H:i:s");
        $content_type = "";
        $content_id = 0;

        if(isset($row->post_id)) {
            $content_id = $row->post_id;
            $content_type = "post";

            if($row->parent > 0) {
                $content_type = "comment";
            }
        }

        if(isset($row->gender)) {
            $content_type = "profile";
        }

        $query = "insert into content_i_follow (user_id, content_id, content_type, date) values ('$user_id', '$content_id', '$content_type', '$date')";
        $DB = new Database();
        $DB->save($query);
    }

    // --------- Prevent Mallicious Data --------- //
    function esc($value) {
        return addslashes($value);
    }