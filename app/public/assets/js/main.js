document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".sidebar-toggle").addEventListener("click", function () {
        document.querySelector(".sidebar").classList.toggle("open");
    });
});
