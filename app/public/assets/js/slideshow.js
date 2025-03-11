document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".slide");
    let currentIndex = 0;

    function showSlide() {
        slides.forEach((slide, index) => {
            slide.style.display = index === currentIndex ? "block" : "none";
        });

        currentIndex = (currentIndex + 1) % slides.length;
    }

    showSlide();
    setInterval(showSlide, 2000); // Change image every 2 seconds
});
