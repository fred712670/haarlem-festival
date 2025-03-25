document.addEventListener("DOMContentLoaded", function () {
  // Handle Artist Card Hover Effects
  // (Similar hover effects as in yummy.js, but adapted for artist cards)
  const artistCards = document.querySelectorAll(".artist-card");

  artistCards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      // Show preview content with animation
      const preview = this.querySelector(".artist-preview");
      if (preview) {
        preview.style.opacity = "1";
      }
    });

    card.addEventListener("mouseleave", function () {
      // Hide preview content with animation
      const preview = this.querySelector(".artist-preview");
      if (preview) {
        preview.style.opacity = "0";
      }
    });
  });

  // Schedule Tabs Functionality
  const scheduleTabs = document.querySelectorAll(".schedule-tab");
  const scheduleDays = document.querySelectorAll(".schedule-day");

  scheduleTabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      // Remove active class from all tabs and days
      scheduleTabs.forEach((t) => t.classList.remove("active"));
      scheduleDays.forEach((day) => day.classList.remove("active"));

      // Add active class to clicked tab
      this.classList.add("active");

      // Get day value from data attribute
      const day = this.getAttribute("data-day");

      // Activate the corresponding schedule day
      document.getElementById(`day-${day}`).classList.add("active");
    });
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();

      const targetId = this.getAttribute("href");
      if (targetId === "#") return;

      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 100,
          behavior: "smooth",
        });
      }
    });
  });

  // Gallery functionality (if on artist details page)
  const galleryItems = document.querySelectorAll(".gallery-item");
  if (galleryItems.length > 0) {
    // When gallery item is clicked, show larger version
    galleryItems.forEach((item) => {
      item.addEventListener("click", function () {
        const imageSrc = this.querySelector("img").src;
        showGalleryModal(imageSrc);
      });
    });
  }

  // Function to show gallery image in modal
  function showGalleryModal(imageSrc) {
    // Create modal elements
    const modal = document.createElement("div");
    modal.classList.add("gallery-modal");

    const modalContent = document.createElement("div");
    modalContent.classList.add("gallery-modal-content");

    const closeBtn = document.createElement("span");
    closeBtn.classList.add("gallery-close");
    closeBtn.innerHTML = "&times;";

    const modalImage = document.createElement("img");
    modalImage.src = imageSrc;

    // Append elements
    modalContent.appendChild(closeBtn);
    modalContent.appendChild(modalImage);
    modal.appendChild(modalContent);
    document.body.appendChild(modal);

    // Add modal styles
    modal.style.display = "flex";
    modal.style.position = "fixed";
    modal.style.zIndex = "1000";
    modal.style.left = "0";
    modal.style.top = "0";
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.backgroundColor = "rgba(0,0,0,0.9)";
    modal.style.alignItems = "center";
    modal.style.justifyContent = "center";

    modalContent.style.position = "relative";
    modalContent.style.maxWidth = "90%";
    modalContent.style.maxHeight = "90%";

    closeBtn.style.position = "absolute";
    closeBtn.style.top = "-40px";
    closeBtn.style.right = "0";
    closeBtn.style.color = "white";
    closeBtn.style.fontSize = "40px";
    closeBtn.style.fontWeight = "bold";
    closeBtn.style.cursor = "pointer";

    modalImage.style.width = "100%";
    modalImage.style.height = "auto";
    modalImage.style.maxHeight = "80vh";
    modalImage.style.objectFit = "contain";

    // Close modal when clicking close button
    closeBtn.addEventListener("click", function () {
      document.body.removeChild(modal);
    });

    // Close modal when clicking outside image
    modal.addEventListener("click", function (e) {
      if (e.target === modal) {
        document.body.removeChild(modal);
      }
    });
  }
});
