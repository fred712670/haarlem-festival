document.addEventListener("DOMContentLoaded", function () {
    let slides = document.querySelectorAll(".slide");
    let readMoreBtn = document.getElementById("read-more-btn");
    let currentIndex = 0;

    function showSlide() {
        slides.forEach((slide, index) => {
            slide.style.opacity = index === currentIndex ? "1" : "0";
        });

        // Update  button dynamically
        let currentSlide = slides[currentIndex];
        let pageLink = currentSlide.getAttribute("data-link");
        readMoreBtn.setAttribute("href", pageLink);

        currentIndex = (currentIndex + 1) % slides.length;
    }

    // Ensure first slide is visible
    if (slides.length > 0) {
        slides[0].style.opacity = "1";
        readMoreBtn.setAttribute("href", slides[0].getAttribute("data-link"));
    }

    setInterval(showSlide, 2000); // Change slide every 2 seconds
});

document.addEventListener("DOMContentLoaded", function () {
    const locationSelect = document.getElementById("locationSelect");
    const locationMap = document.getElementById("locationMap");

    locationSelect.addEventListener("change", function () {
        let selectedLocation = locationSelect.value;

        if (selectedLocation === "Haarlem") {
            locationMap.src = "https://maps.google.com/maps?q=Haarlem&output=embed";
        } else {
            let encodedLocation = encodeURIComponent(selectedLocation);
            locationMap.src = `https://maps.google.com/maps?q=${encodedLocation}&output=embed`;
        }
    });
});
