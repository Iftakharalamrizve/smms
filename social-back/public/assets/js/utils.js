function openLoader(){
    let gLoading = document.getElementById("loading");
    gLoading.style.opacity = '1';
    gLoading.style.zIndex = '3';
    gLoading.addEventListener("transitionend", function () {
        gLoading.style.display = "block";
    }, {once: true});
}

function closeLoader(){
    let gLoading = document.getElementById("loading");
    gLoading.style.opacity = '0';
    gLoading.style.zIndex = '0';
    gLoading.addEventListener("transitionend", function () {
        gLoading.style.display = "none";
    }, {once: true});
}