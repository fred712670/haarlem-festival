document.addEventListener("DOMContentLoaded", function () {
  // Toggle password visibility
  var togglePassword = document.getElementById("togglePassword");
  var toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
  var toggleNewPassword = document.getElementById("toggleNewPassword");

  // Toggle for password field
  if (togglePassword) {
    togglePassword.addEventListener("click", function () {
      var passwordField = document.getElementById("password");
      if (passwordField.type === "password") {
        passwordField.type = "text";
      } else {
        passwordField.type = "password";
      }
    });
  }

  // Toggle for confirm password field
  if (toggleConfirmPassword) {
    toggleConfirmPassword.addEventListener("click", function () {
      var confirmField = document.getElementById("confirmPassword");
      if (confirmField.type === "password") {
        confirmField.type = "text";
      } else {
        confirmField.type = "password";
      }
    });
  }

  // Toggle for new password field (reset form)
  if (toggleNewPassword) {
    toggleNewPassword.addEventListener("click", function () {
      var newPasswordField = document.getElementById("newPassword");
      if (newPasswordField.type === "password") {
        newPasswordField.type = "text";
      } else {
        newPasswordField.type = "password";
      }
    });
  }

  // Form submission check for password matching
  var forms = document.querySelectorAll("form");
  forms.forEach(function (form) {
    form.addEventListener("submit", function (e) {
      // Find password fields
      var password =
        document.getElementById("password") ||
        document.getElementById("newPassword");
      var confirmPassword = document.getElementById("confirmPassword");

      // Check if both fields exist and if they match
      if (password && confirmPassword) {
        if (password.value !== confirmPassword.value) {
          alert("Passwords do not match");
          e.preventDefault();
        }
      }
    });
  });
  document.addEventListener("DOMContentLoaded", function () {
    // Handle gallery image removal
    const removedImagesInput = document.getElementById(
      "removed_gallery_images"
    );
    const removedImages = [];

    const removeButtons = document.querySelectorAll(".remove-gallery-image");
    removeButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const imageItem = this.closest(".gallery-image-item");
        const imageName = imageItem.dataset.image;

        removedImages.push(imageName);
        removedImagesInput.value = removedImages.join(",");

        imageItem.remove();
      });
    });
  });
});
