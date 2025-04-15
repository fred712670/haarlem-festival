document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("booking-modal");
  const cancelBtn = document.getElementById("cancel-btn");

  // Open modal by adding 'active' class
  document.querySelectorAll(".book-button").forEach((button) => {
    button.addEventListener("click", () => {
      modal.classList.add("active");
    });
  });

  // Close modal by removing 'active' class
  cancelBtn.addEventListener("click", () => {
    modal.classList.remove("active");
  });
});
