document.addEventListener("DOMContentLoaded", function () {
    // Handle Food Card Hover Effects
    document.querySelectorAll(".food-card").forEach(card => {
        let button = card.querySelector(".expand-btn");
        
        card.addEventListener("mouseenter", function () {
            // Expand description
            this.querySelector(".food-description").style.opacity = "1";
            this.querySelector(".food-description").style.maxHeight = "200px";

            // Change button text
            button.textContent = "-";
        });

        card.addEventListener("mouseleave", function () {
            // Collapse description
            this.querySelector(".food-description").style.opacity = "0";
            this.querySelector(".food-description").style.maxHeight = "0";

            // Reset button text
            button.textContent = "+";
        });
    });

    // Slideshow for Restaurant Detail Page
    let slides = document.querySelectorAll(".slide");
    let index = 0;

    function showSlide() {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "block" : "none";
        });
        index = (index + 1) % slides.length;
    }

    if (slides.length > 0) { // Only run slideshow if slides exist
        showSlide();
        setInterval(showSlide, 3000); // Change image every 3 seconds
    }
});