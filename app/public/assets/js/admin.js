/**
 * Enhanced Admin JavaScript with dark mode and responsive features
 */
document.addEventListener("DOMContentLoaded", function () {
  // Initialize Bootstrap components
  initBootstrapComponents();

  // Setup theme preferences
  setupThemePreferences();

  // Setup responsive sidebar
  setupSidebar();

  // Add form validation
  setupFormValidation();

  // Initialize advanced components
  initializeCharts();
  initializeDataTables();
  setupSessionTimeout();
});

/**
 * Initialize Bootstrap components
 */
function initBootstrapComponents() {
  // Enable tooltips
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Enable popovers
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });

  // Auto-hide alerts after 5 seconds
  setTimeout(function () {
    document.querySelectorAll(".alert-dismissible").forEach(function (alert) {
      var bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    });
  }, 5000);

  // Handle date pickers
  document.querySelectorAll(".datepicker").forEach(function (input) {
    flatpickr(input, {
      dateFormat: "Y-m-d",
      allowInput: true,
    });
  });
}

/**
 * Setup theme preferences (light/dark mode)
 */
function setupThemePreferences() {
  const themeToggleBtn = document.getElementById("theme-toggle");
  if (!themeToggleBtn) return;

  // Check for saved theme preference or prefer-color-scheme
  const savedTheme = localStorage.getItem("admin-theme");
  const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

  // Set initial theme
  if (savedTheme === "dark" || (!savedTheme && prefersDark)) {
    document.body.classList.add("dark-mode");
    themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
  } else {
    themeToggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
  }

  // Handle theme toggle click
  themeToggleBtn.addEventListener("click", function () {
    if (document.body.classList.contains("dark-mode")) {
      document.body.classList.remove("dark-mode");
      localStorage.setItem("admin-theme", "light");
      this.innerHTML = '<i class="fas fa-moon"></i>';
    } else {
      document.body.classList.add("dark-mode");
      localStorage.setItem("admin-theme", "dark");
      this.innerHTML = '<i class="fas fa-sun"></i>';
    }
  });

  // Listen for OS theme changes
  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
      if (!localStorage.getItem("admin-theme")) {
        if (e.matches) {
          document.body.classList.add("dark-mode");
          themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
          document.body.classList.remove("dark-mode");
          themeToggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
        }
      }
    });
}

/**
 * Setup responsive sidebar
 */
function setupSidebar() {
  const toggleSidebarBtn = document.querySelector(".toggle-sidebar");
  const sidebar = document.querySelector(".admin-sidebar");
  const backdrop = document.createElement("div");

  if (!toggleSidebarBtn || !sidebar) return;

  // Create backdrop for mobile
  backdrop.className = "sidebar-backdrop";
  backdrop.style.position = "fixed";
  backdrop.style.top = "0";
  backdrop.style.left = "0";
  backdrop.style.width = "100%";
  backdrop.style.height = "100%";
  backdrop.style.backgroundColor = "rgba(0,0,0,0.3)";
  backdrop.style.zIndex = "999";
  backdrop.style.display = "none";
  document.body.appendChild(backdrop);

  // Handle toggle click
  toggleSidebarBtn.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    if (sidebar.classList.contains("show")) {
      backdrop.style.display = "block";
    } else {
      backdrop.style.display = "none";
    }
  });

  // Close sidebar when clicking backdrop
  backdrop.addEventListener("click", function () {
    sidebar.classList.remove("show");
    backdrop.style.display = "none";
  });

  // Close sidebar on window resize if screen becomes larger
  window.addEventListener("resize", function () {
    if (window.innerWidth > 768 && sidebar.classList.contains("show")) {
      sidebar.classList.remove("show");
      backdrop.style.display = "none";
    }
  });
}

/**
 * Setup form validation
 */
function setupFormValidation() {
  // Get all forms with the class 'needs-validation'
  const forms = document.querySelectorAll(".needs-validation");

  if (forms.length === 0) return;

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );

    // Custom password validation
    const passwordField = form.querySelector('input[type="password"]');
    const confirmPasswordField = form.querySelector(
      "input[data-match-password]"
    );

    if (passwordField && confirmPasswordField) {
      confirmPasswordField.addEventListener("input", function () {
        if (this.value !== passwordField.value) {
          this.setCustomValidity("Passwords do not match");
        } else {
          this.setCustomValidity("");
        }
      });

      passwordField.addEventListener("input", function () {
        if (
          confirmPasswordField.value !== "" &&
          confirmPasswordField.value !== this.value
        ) {
          confirmPasswordField.setCustomValidity("Passwords do not match");
        } else {
          confirmPasswordField.setCustomValidity("");
        }
      });
    }

    // Custom email validation
    const emailField = form.querySelector('input[type="email"]');
    if (emailField) {
      emailField.addEventListener("blur", function () {
        // Check if email is already in use
        if (this.value) {
          checkEmailAvailability(this.value, this);
        }
      });
    }
  });
}

/**
 * Check if email is available (not already in use)
 */
function checkEmailAvailability(email, field) {
  const userId = document.getElementById("userId")
    ? document.getElementById("userId").value
    : null;

  // Skip AJAX call if the field is not part of a form
  if (!field.form) return;

  fetch(
    `/api/admin/check-email?email=${encodeURIComponent(email)}${
      userId ? "&userId=" + userId : ""
    }`
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.exists) {
        field.setCustomValidity("This email is already in use");

        // Show feedback message
        let feedback = field.nextElementSibling;
        if (!feedback || !feedback.classList.contains("invalid-feedback")) {
          feedback = document.createElement("div");
          feedback.className = "invalid-feedback";
          field.parentNode.insertBefore(feedback, field.nextSibling);
        }
        feedback.textContent = "This email is already in use.";
      } else {
        field.setCustomValidity("");
      }
    })
    .catch((error) => {
      console.error("Error checking email:", error);
    });
}

/**
 * Initialize charts for dashboard
 */
function initializeCharts() {
  const userChartCanvas = document.getElementById("userRegistrationChart");
  if (!userChartCanvas) return;

  // User registration chart
  const ctx = userChartCanvas.getContext("2d");
  new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      datasets: [
        {
          label: "New Users",
          data: userChartData || [
            65, 59, 80, 81, 56, 55, 40, 30, 45, 60, 70, 85,
          ],
          fill: false,
          borderColor: "rgb(78, 115, 223)",
          tension: 0.1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0,
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
            drawBorder: false,
          },
        },
        y: {
          ticks: {
            beginAtZero: true,
          },
          grid: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: "rgb(255,255,255)",
          bodyColor: "#858796",
          titleMarginBottom: 10,
          titleColor: "#6e707e",
          titleFontSize: 14,
          borderColor: "#dddfeb",
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
          callbacks: {
            label: function (context) {
              return `New Users: ${context.raw}`;
            },
          },
        },
      },
    },
  });

  // User roles distribution chart
  const userRolesCanvas = document.getElementById("userRolesChart");
  if (!userRolesCanvas) return;

  new Chart(userRolesCanvas.getContext("2d"), {
    type: "doughnut",
    data: {
      labels: ["Customers", "Employees", "Administrators"],
      datasets: [
        {
          data: userRolesData || [70, 20, 10],
          backgroundColor: ["#4e73df", "#1cc88a", "#e74a3b"],
          hoverBackgroundColor: ["#2e59d9", "#17a673", "#e02d1b"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "bottom",
        },
        tooltip: {
          backgroundColor: "rgb(255,255,255)",
          bodyColor: "#858796",
          borderColor: "#dddfeb",
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
      },
      cutout: "70%",
    },
  });
}

/**
 * Initialize DataTables for enhanced table functionality
 */
function initializeDataTables() {
  const dataTablesEnabled = document.querySelectorAll(".datatable");
  if (dataTablesEnabled.length === 0) return;

  dataTablesEnabled.forEach(function (table) {
    $(table).DataTable({
      responsive: true,
      pageLength: 10,
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"],
      ],
      dom: '<"top"fl>rt<"bottom"ip>',
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search...",
      },
    });
  });
}

/**
 * Setup session timeout warning
 */
function setupSessionTimeout() {
  // Check if we're on an admin page
  if (!window.location.pathname.includes("/admin")) return;

  const sessionTimeout = 30 * 60 * 1000; // 30 minutes
  const warningTime = 5 * 60 * 1000; // Show warning 5 minutes before timeout

  let timeoutWarningShown = false;
  let timeoutTimer = null;

  // Reset the timer whenever there's user activity
  ["click", "mousemove", "keypress", "scroll", "touchstart"].forEach(
    (event) => {
      document.addEventListener(event, resetSessionTimer, true);
    }
  );

  // Start the initial timer
  resetSessionTimer();

  /**
   * Reset the session timeout timer
   */
  function resetSessionTimer() {
    // Clear existing timer
    if (timeoutTimer) {
      clearTimeout(timeoutTimer);
    }

    // Hide warning if shown
    if (timeoutWarningShown) {
      hideSessionWarning();
    }

    // Set new timer
    timeoutTimer = setTimeout(showSessionWarning, sessionTimeout - warningTime);
  }

  /**
   * Show session timeout warning
   */
  function showSessionWarning() {
    timeoutWarningShown = true;

    // Create warning element if it doesn't exist
    let warningEl = document.getElementById("session-timeout-warning");
    if (!warningEl) {
      warningEl = document.createElement("div");
      warningEl.id = "session-timeout-warning";
      warningEl.className = "session-timeout-warning";
      warningEl.innerHTML = `
        <div class="session-timeout-content">
          <h4>Session Timeout Warning</h4>
          <p>Your session will expire in <span id="timeout-countdown">5:00</span> minutes due to inactivity.</p>
          <button class="btn btn-primary" id="session-extend-btn">Stay Logged In</button>
        </div>
      `;
      warningEl.style.position = "fixed";
      warningEl.style.top = "20px";
      warningEl.style.right = "20px";
      warningEl.style.backgroundColor = "#fff";
      warningEl.style.boxShadow = "0 0.5rem 1rem rgba(0, 0, 0, 0.15)";
      warningEl.style.borderRadius = "0.35rem";
      warningEl.style.padding = "1.5rem";
      warningEl.style.zIndex = "1060";
      document.body.appendChild(warningEl);

      // Add event listener to extend button
      document
        .getElementById("session-extend-btn")
        .addEventListener("click", function () {
          // Send request to extend session
          fetch("/api/admin/extend-session", { method: "POST" })
            .then((response) => {
              if (response.ok) {
                resetSessionTimer();
              }
            })
            .catch((error) => {
              console.error("Error extending session:", error);
            });
        });
    } else {
      warningEl.style.display = "block";
    }

    // Start countdown
    let secondsLeft = warningTime / 1000;
    const countdownEl = document.getElementById("timeout-countdown");

    function updateCountdown() {
      const minutes = Math.floor(secondsLeft / 60);
      const seconds = secondsLeft % 60;
      countdownEl.textContent = `${minutes}:${seconds
        .toString()
        .padStart(2, "0")}`;

      if (secondsLeft <= 0) {
        clearInterval(countdownInterval);
        window.location.href = "/login?session_expired=1";
      }

      secondsLeft--;
    }

    updateCountdown();
    const countdownInterval = setInterval(updateCountdown, 1000);
  }

  /**
   * Hide session timeout warning
   */
  function hideSessionWarning() {
    timeoutWarningShown = false;
    const warningEl = document.getElementById("session-timeout-warning");
    if (warningEl) {
      warningEl.style.display = "none";
    }
  }
}

/**
 * Show toast notification
 * @param {string} message - Toast message
 * @param {string} type - Toast type (success, error, warning, info)
 */
function showToast(message, type = "info") {
  // Create toast container if it doesn't exist
  let toastContainer = document.querySelector(".toast-container");
  if (!toastContainer) {
    toastContainer = document.createElement("div");
    toastContainer.className = "toast-container";
    document.body.appendChild(toastContainer);
  }

  // Create toast element
  const toast = document.createElement("div");
  toast.className = `toast toast-${type}`;

  // Set icon based on type
  let icon = "info-circle";
  switch (type) {
    case "success":
      icon = "check-circle";
      break;
    case "error":
      icon = "exclamation-circle";
      break;
    case "warning":
      icon = "exclamation-triangle";
      break;
  }

  // Set toast content
  toast.innerHTML = `
    <div class="toast-header">
      <i class="fas fa-${icon} me-2"></i>
      <strong class="me-auto">${
        type.charAt(0).toUpperCase() + type.slice(1)
      }</strong>
      <button type="button" class="btn-close" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      ${message}
    </div>
  `;

  // Add to container
  toastContainer.appendChild(toast);

  // Show toast
  setTimeout(() => {
    toast.classList.add("show");
  }, 100);

  // Add close button event
  toast.querySelector(".btn-close").addEventListener("click", () => {
    toast.classList.remove("show");
    setTimeout(() => {
      toast.remove();
    }, 300);
  });

  // Auto-close after 5 seconds
  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => {
      toast.remove();
    }, 300);
  }, 5000);
}

/**
 * Export table data to CSV
 * @param {string} tableId - ID of the table to export
 * @param {string} filename - Filename for the CSV
 */
function exportTableToCSV(tableId, filename = "export.csv") {
  const table = document.getElementById(tableId);
  if (!table) return;

  let csv = [];
  let rows = table.querySelectorAll("tr");

  for (let i = 0; i < rows.length; i++) {
    let row = [],
      cols = rows[i].querySelectorAll("td, th");

    for (let j = 0; j < cols.length; j++) {
      // Get text content and clean it
      let cellText = cols[j].innerText
        .replace(/(\r\n|\n|\r)/gm, "")
        .replace(/"/g, '""');

      // Skip action buttons column
      if (cols[j].classList.contains("actions-column")) continue;

      row.push('"' + cellText + '"');
    }

    csv.push(row.join(","));
  }

  // Download CSV file
  downloadCSV(csv.join("\n"), filename);
}

/**
 * Download CSV data as a file
 * @param {string} csv - CSV content
 * @param {string} filename - Filename for the download
 */
function downloadCSV(csv, filename) {
  let csvFile = new Blob([csv], { type: "text/csv" });
  let downloadLink = document.createElement("a");

  // Set file name
  downloadLink.download = filename;

  // Create a link to the file
  downloadLink.href = window.URL.createObjectURL(csvFile);

  // Hide download link
  downloadLink.style.display = "none";

  // Add the link to the DOM
  document.body.appendChild(downloadLink);

  // Click download link
  downloadLink.click();

  // Clean up
  document.body.removeChild(downloadLink);
}

/**
 * Add keyboard shortcuts for admin functionality
 */
document.addEventListener("keydown", function (e) {
  // Only apply shortcuts if user is on an admin page
  if (!window.location.pathname.includes("/admin")) return;

  // Only apply if not in an input, textarea, or other form control
  if (e.target.matches("input, textarea, select, [contenteditable]")) return;

  // Ctrl+S for save form (if present)
  if (e.ctrlKey && e.key === "s") {
    e.preventDefault();
    const saveBtn = document.querySelector(
      'button[type="submit"], input[type="submit"]'
    );
    if (saveBtn) saveBtn.click();
  }

  // Ctrl+N for new item
  if (e.ctrlKey && e.key === "n") {
    e.preventDefault();
    const newBtn = document.querySelector(
      'a.btn-new, button.btn-new, a[href*="create"]'
    );
    if (newBtn) {
      if (newBtn.tagName === "A") {
        window.location.href = newBtn.href;
      } else {
        newBtn.click();
      }
    }
  }

  // Esc for cancel/back
  if (e.key === "Escape") {
    const cancelBtn = document.querySelector("a.btn-cancel, button.btn-cancel");
    if (cancelBtn) cancelBtn.click();
  }

  // Ctrl+F for focus search
  if (e.ctrlKey && e.key === "f" && !e.shiftKey) {
    e.preventDefault();
    const searchInput = document.querySelector(
      'input[type="search"], #search-users'
    );
    if (searchInput) {
      searchInput.focus();
    }
  }
});

/**
 * Handle confirmation dialogs
 */
document.querySelectorAll(".confirm-action").forEach(function (button) {
  button.addEventListener("click", function (e) {
    e.preventDefault();

    const message =
      this.dataset.confirmMessage ||
      "Are you sure you want to perform this action?";
    const title = this.dataset.confirmTitle || "Confirmation Required";
    const confirmBtnText = this.dataset.confirmButtonText || "Confirm";
    const confirmBtnClass = this.dataset.confirmButtonClass || "btn-danger";
    const cancelBtnText = this.dataset.cancelButtonText || "Cancel";

    // Create backdrop
    const backdrop = document.createElement("div");
    backdrop.className = "admin-modal-backdrop";
    document.body.appendChild(backdrop);

    // Create modal
    const modal = document.createElement("div");
    modal.className = "admin-modal";
    modal.innerHTML = `
      <div class="admin-modal-header">
        <h5 class="admin-modal-title">${title}</h5>
        <button type="button" class="admin-modal-close" aria-label="Close">&times;</button>
      </div>
      <div class="admin-modal-body">
        <p>${message}</p>
      </div>
      <div class="admin-modal-footer">
        <button type="button" class="btn btn-secondary" id="modal-cancel-btn">${cancelBtnText}</button>
        <button type="button" class="btn ${confirmBtnClass}" id="modal-confirm-btn">${confirmBtnText}</button>
      </div>
    `;

    document.body.appendChild(modal);

    // Show backdrop and modal
    setTimeout(() => {
      backdrop.style.display = "block";
      modal.style.display = "block";
    }, 10);

    // Handle close button
    modal.querySelector(".admin-modal-close").addEventListener("click", () => {
      closeModal();
    });

    // Handle cancel button
    document
      .getElementById("modal-cancel-btn")
      .addEventListener("click", () => {
        closeModal();
      });

    // Handle confirm button
    document
      .getElementById("modal-confirm-btn")
      .addEventListener("click", () => {
        closeModal(true);

        // Perform the original action
        const originalAction = this.dataset.action;
        if (originalAction) {
          window.location.href = originalAction;
        } else if (this.tagName === "A") {
          window.location.href = this.href;
        } else if (this.form) {
          this.form.submit();
        }
      });

    /**
     * Close the modal
     */
    function closeModal(confirmed = false) {
      backdrop.style.display = "none";
      modal.style.display = "none";

      setTimeout(() => {
        document.body.removeChild(backdrop);
        document.body.removeChild(modal);

        // Restore focus to the button that triggered the modal
        if (!confirmed) {
          button.focus();
        }
      }, 300);
    }
  });
});

/**
 * Initialize WYSIWYG editors for textareas with class 'richtext'
 */
document.querySelectorAll("textarea.richtext").forEach(function (textarea) {
  // Check if we've loaded the editor library
  if (typeof tinymce !== "undefined") {
    tinymce.init({
      target: textarea,
      height: 300,
      menubar: false,
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table paste code help wordcount",
      ],
      toolbar:
        "undo redo | formatselect | " +
        "bold italic backcolor | alignleft aligncenter " +
        "alignright alignjustify | bullist numlist outdent indent | " +
        "removeformat | help",
      content_style:
        "body { font-family:Helvetica,Arial,sans-serif; font-size:14px }",
    });
  }
});

/**
 * Lazy load images for better performance
 */
document.addEventListener("DOMContentLoaded", function () {
  const lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

  if ("IntersectionObserver" in window) {
    let lazyImageObserver = new IntersectionObserver(function (
      entries,
      observer
    ) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          let lazyImage = entry.target;
          lazyImage.src = lazyImage.dataset.src;
          if (lazyImage.dataset.srcset) {
            lazyImage.srcset = lazyImage.dataset.srcset;
          }
          lazyImage.classList.remove("lazy");
          lazyImageObserver.unobserve(lazyImage);
        }
      });
    });

    lazyImages.forEach(function (lazyImage) {
      lazyImageObserver.observe(lazyImage);
    });
  } else {
    // Fallback for browsers that don't support IntersectionObserver
    let active = false;

    const lazyLoad = function () {
      if (active === false) {
        active = true;

        setTimeout(function () {
          lazyImages.forEach(function (lazyImage) {
            if (
              lazyImage.getBoundingClientRect().top <= window.innerHeight &&
              lazyImage.getBoundingClientRect().bottom >= 0 &&
              getComputedStyle(lazyImage).display !== "none"
            ) {
              lazyImage.src = lazyImage.dataset.src;
              if (lazyImage.dataset.srcset) {
                lazyImage.srcset = lazyImage.dataset.srcset;
              }
              lazyImage.classList.remove("lazy");

              lazyImages = lazyImages.filter(function (image) {
                return image !== lazyImage;
              });

              if (lazyImages.length === 0) {
                document.removeEventListener("scroll", lazyLoad);
                window.removeEventListener("resize", lazyLoad);
                window.removeEventListener("orientationchange", lazyLoad);
              }
            }
          });

          active = false;
        }, 200);
      }
    };

    document.addEventListener("scroll", lazyLoad);
    window.addEventListener("resize", lazyLoad);
    window.addEventListener("orientationchange", lazyLoad);
    lazyLoad();
  }
});
