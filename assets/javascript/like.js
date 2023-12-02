
    function ajax_send(data) {
        var ajax = new XMLHttpRequest();

        // Listens for readystatechange (trigger) to launch function.
        ajax.addEventListener('readystatechange', function(){
            // 200 means okay (object found), 4 is to not open right away
            if(ajax.readyState == 4 && ajax.status == 200) {
                response(ajax.responseText);
            }
        });

        data = JSON.stringify(data);

        ajax.open("post", "ajax.php", true);
        ajax.send(data);
    }

    function like_post(e) {
        // Prevent page from refresh
        e.preventDefault(); 

        var link = e.target.href;

        // Data processing
        var data = {};
        data.link = link;
        data.action = "like_post";

        ajax_send(data);
    }

    function response(result) {
        alert(result);
    }