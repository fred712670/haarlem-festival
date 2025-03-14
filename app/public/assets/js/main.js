document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".sidebar-toggle").addEventListener("click", function () {
        document.querySelector(".sidebar").classList.toggle("open");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const toggleBtn = document.querySelector(".toggle-btn");
    const logo = document.getElementById("logo");

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("expanded");

        // Change logo dynamically
        if (sidebar.classList.contains("expanded")) {
            logo.src = "/assets/img/home/logo-extended.png"; // Expanded logo
            toggleBtn.innerHTML = '<i class="fas fa-angle-double-right"></i>'; // Change to >>
        } else {
            logo.src = "/assets/img/home/logo-not-extended.png"; // Collapsed logo
            toggleBtn.innerHTML = '<i class="fas fa-angle-double-left"></i>'; // Change to <<
        }
    });
});
