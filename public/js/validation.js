let statel = false;

function toggle() {
    if (statel) {
        document.getElementById("password").setAttribute("type", "password");
        statel = false;
    } else {
        document.getElementById("password").setAttribute("type", "text");
        statel = true;
    }
}

function myFunction(show) {
    show.classList.toggle("fa-eye-slash");
}
