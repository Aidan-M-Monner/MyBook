function show_change_profile_image(event) {
    event.preventDefault();
    var profile_image = document.getElementById("change_profile_image");
    profile_image.style.display = "block";
}

function hide_change_profile_image() {
    var profile_image = document.getElementById("change_profile_image");
    profile_image.style.display = "none";
}

function show_change_cover_image(event) {
    event.preventDefault();
    var cover_image = document.getElementById("change_cover_image");
    cover_image.style.display = "block";
}

function hide_change_cover_image() {
    var cover_image = document.getElementById("change_cover_image");
    cover_image.style.display = "none";
}