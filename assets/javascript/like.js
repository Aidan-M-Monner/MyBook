function ajax_send(data) {
    var ajax = new XMLHttpRequest();

    ajax.addEventListener('readystatechange', function() { // Listens for readystatechange (trigger) to launch function.
        if(ajax.readyState == 4 && ajax.status == 200) { // 200 means okay (object found), 4 is to not open right away
            response(ajax.responseText); 
        }
    }); 

    data = JSON.stringify(data);

    ajax.open("post", "ajax.php", true); // Sends the data asynchronously, or without freeze.
    ajax.send(data);
}

function response(result) {
    alert(result);
}

function like_post(e) {
    e.preventDefault(); // Prevents refresh
    var link = e.target.href;

    var data = {};
    data.link = link; // add data to string
    data.action = "like_post";
    ajax_send(data);
}