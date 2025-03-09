
    document.addEventListener("DOMContentLoaded", function () {
    function expandCard(card) {
        card.classList.add("expanded");
    }

    function collapseCard(card) {
        card.classList.remove("expanded");
    }

    document.querySelectorAll(".food-card").forEach(card => {
        card.addEventListener("mouseover", function () {
            expandCard(this);
        });
        card.addEventListener("mouseleave", function () {
            collapseCard(this);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".slide");
    let index = 0;

    function showSlide() {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "block" : "none";
        });
        index = (index + 1) % slides.length;
    }

    showSlide();
    setInterval(showSlide, 3000); // Change image every 3 seconds
});

