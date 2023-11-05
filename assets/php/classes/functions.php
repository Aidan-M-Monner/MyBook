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
        if(!isset($_GET['user_id'])) {
            $_GET['user_id'] = $_SESSION['mybook_user_id'];
        } 

        $next_page_link = $url;
        $prev_page_link = $url;

        $num = 0;
        foreach($_GET as $key => $value) {
            $num++;
            if($num == 1) {
                if($key == "page") {
                    $next_page_link .= $key . "=" . ($page_number + 1);
                    $prev_page_link .= $key . "=" . ($page_number - 1);
                } else {
                    $next_page_link .= $key . "=" . $value;
                    $prev_page_link .= $key . "=" . $value;
                }
            } else {
                if($key == "page") {
                    $next_page_link .= "&" . $key . "=" . ($page_number + 1);
                    $prev_page_link .= "&" . $key . "=" . ($page_number - 1);
                } else {
                    $next_page_link .= "&" . $key . "=" . $value;
                    $prev_page_link .= "&" . $key . "=" . $value;
                }
            }
        }
        $arr['next_page'] = $next_page_link;
        $arr['prev_page'] = $prev_page_link;
        return $arr;
    }