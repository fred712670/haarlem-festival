document.addEventListener("DOMContentLoaded", function () {
  // Handle Artist Card Hover Effects
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

  // Audio player initialization and management
  let currentAudio = null;
  let currentPlayButton = null;
  let currentTrackItem = null;
  let progressInterval = null;

  // Initialize play buttons for tracks
  const initializeAudioPlayers = () => {
    // Create audio duration elements for each track
    const trackItems = document.querySelectorAll(".track-item");
    trackItems.forEach((trackItem) => {
      // Create progress container if it doesn't exist
      if (!trackItem.querySelector(".audio-controls")) {
        // Create audio controls container
        const audioControls = document.createElement("div");
        audioControls.className =
          "audio-controls d-flex align-items-center me-2";

        // Time display
        const timeDisplay = document.createElement("div");
        timeDisplay.className = "time-display small text-muted me-2";

        const currentTimeSpan = document.createElement("span");
        currentTimeSpan.className = "current-time";
        currentTimeSpan.textContent = "0:00";

        const separator = document.createElement("span");
        separator.textContent = " / ";

        const durationSpan = document.createElement("span");
        durationSpan.className = "track-duration";
        durationSpan.textContent = "--:--";

        timeDisplay.appendChild(currentTimeSpan);
        timeDisplay.appendChild(separator);
        timeDisplay.appendChild(durationSpan);

        // Create Bootstrap progress
        const progressContainer = document.createElement("div");
        progressContainer.className = "progress mx-2";
        progressContainer.style.width = "80px";
        progressContainer.style.height = "6px";
        progressContainer.style.cursor = "pointer";

        const progressBar = document.createElement("div");
        progressBar.className = "progress-bar";
        progressBar.style.width = "0%";
        progressBar.setAttribute("role", "progressbar");
        progressBar.setAttribute("aria-valuenow", "0");
        progressBar.setAttribute("aria-valuemin", "0");
        progressBar.setAttribute("aria-valuemax", "100");

        progressContainer.appendChild(progressBar);

        // Add elements to audio controls
        audioControls.appendChild(timeDisplay);
        audioControls.appendChild(progressContainer);

        // Add audio controls to track controls
        const controlsDiv = trackItem.querySelector(".track-controls");
        controlsDiv.insertBefore(audioControls, controlsDiv.firstChild);
      }
    });

    const playButtons = document.querySelectorAll(".play-button");
    playButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const trackItem = this.closest(".track-item");
        currentTrackItem = trackItem;

        const trackTitle = trackItem.querySelector(".track-title").textContent;
        const trackId = trackItem.getAttribute("data-track-id") || "";

        // Create an audio filename based on artist and track name
        const artistName = document
          .getElementById("artist-name")
          .textContent.trim();
        const audioFile = getAudioFileName(artistName, trackTitle, trackId);

        console.log("Trying to play:", audioFile);

        // If we're clicking the same button that's currently playing, pause/resume
        if (currentPlayButton === this && currentAudio) {
          if (currentAudio.paused) {
            currentAudio.play();
            updatePlayButtonState(this, "playing");
            startProgressUpdates();
          } else {
            currentAudio.pause();
            updatePlayButtonState(this, "paused");
            stopProgressUpdates();
          }
          return;
        }

        // Stop any currently playing audio
        if (currentAudio) {
          currentAudio.pause();
          if (currentPlayButton) {
            updatePlayButtonState(currentPlayButton, "stopped");
          }
          stopProgressUpdates();
        }

        // Reset any previous active tracks
        document.querySelectorAll(".track-item").forEach((item) => {
          item.classList.remove(
            "active",
            "border-primary",
            "border-start",
            "border-3"
          );
        });

        // Mark current track as active with Bootstrap classes
        trackItem.classList.add(
          "active",
          "border-start",
          "border-primary",
          "border-3"
        );

        // Create and play new audio
        currentAudio = new Audio(audioFile);
        currentPlayButton = this;

        // Show loading state
        updatePlayButtonState(this, "loading");

        // Reset time display to 0:00
        const currentTimeSpan = trackItem.querySelector(".current-time");
        if (currentTimeSpan) {
          currentTimeSpan.textContent = "0:00";
        }

        // Add event listeners for audio
        currentAudio.addEventListener("loadedmetadata", function () {
          // Display duration once we have it
          const duration = formatTime(currentAudio.duration);
          trackItem.querySelector(".track-duration").textContent = duration;
        });

        currentAudio.addEventListener("canplay", function () {
          this.play();
          updatePlayButtonState(currentPlayButton, "playing");
          startProgressUpdates();
        });

        currentAudio.addEventListener("ended", function () {
          updatePlayButtonState(currentPlayButton, "stopped");
          stopProgressUpdates();
          resetProgress();
          currentAudio = null;
          currentPlayButton = null;
          currentTrackItem = null;
        });

        currentAudio.addEventListener("error", function (e) {
          console.error("Error loading audio:", e);

          // Show error and reset state
          updatePlayButtonState(currentPlayButton, "error");
          stopProgressUpdates();
          showAudioErrorMessage(trackItem);

          // Reset after a short delay
          setTimeout(() => {
            updatePlayButtonState(currentPlayButton, "stopped");
            currentAudio = null;
            currentPlayButton = null;
            currentTrackItem = null;
          }, 1500);
        });

        // Load the audio
        currentAudio.load();
      });
    });
  };

  // Format time in MM:SS format
  function formatTime(seconds) {
    if (isNaN(seconds) || !isFinite(seconds)) return "--:--";

    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins}:${secs < 10 ? "0" + secs : secs}`;
  }

  // Start updating progress bar
  function startProgressUpdates() {
    stopProgressUpdates(); // Clear any existing interval

    progressInterval = setInterval(() => {
      if (!currentAudio || !currentTrackItem) return;

      // Update progress bar
      const progressBar = currentTrackItem.querySelector(".progress-bar");
      if (progressBar) {
        const percent =
          (currentAudio.currentTime / currentAudio.duration) * 100;
        progressBar.style.width = `${percent}%`;
        progressBar.setAttribute("aria-valuenow", percent);
      }

      // Update current time display
      const currentTimeSpan = currentTrackItem.querySelector(".current-time");
      if (currentTimeSpan) {
        currentTimeSpan.textContent = formatTime(currentAudio.currentTime);
      }
    }, 100);
  }

  // Stop progress updates
  function stopProgressUpdates() {
    if (progressInterval) {
      clearInterval(progressInterval);
      progressInterval = null;
    }
  }

  // Reset progress bar
  function resetProgress() {
    if (!currentTrackItem) return;

    const progressBar = currentTrackItem.querySelector(".progress-bar");
    if (progressBar) {
      progressBar.style.width = "0%";
      progressBar.setAttribute("aria-valuenow", "0");
    }

    const currentTimeSpan = currentTrackItem.querySelector(".current-time");
    if (currentTimeSpan) {
      currentTimeSpan.textContent = "0:00";
    }
  }

  // Function to get an audio filename based on artist and track
  const getAudioFileName = (artistName, trackTitle, trackId) => {
    // Clean up artist name and track title to create valid filename
    const cleanArtistName = artistName
      .replace(/[^\w\s]/gi, "")
      .replace(/\s+/g, "")
      .toLowerCase();
    const cleanTrackTitle = trackTitle
      .replace(/[^\w\s]/gi, "")
      .replace(/\s+/g, "")
      .toLowerCase();

    // Special case for known files
    if (
      cleanArtistName === "gumbokings" &&
      cleanTrackTitle === "bourbonstreetparade"
    ) {
      return "/assets/audio/jazz/gumbokings.bourbonstreetparade.mp3.mp3";
    }

    // Try multiple possible paths
    return `/assets/audio/jazz/${cleanArtistName}.${cleanTrackTitle}.mp3`;
  };

  // Update play button state and icon
  const updatePlayButtonState = (button, state) => {
    // First, remove all state classes
    button.classList.remove(
      "btn-primary",
      "btn-danger",
      "btn-warning",
      "btn-secondary"
    );

    // Add appropriate Bootstrap classes based on state
    switch (state) {
      case "playing":
        button.classList.add("btn-danger"); // Red for playing
        break;
      case "paused":
        button.classList.add("btn-warning"); // Yellow/orange for paused
        break;
      case "loading":
        button.classList.add("btn-secondary"); // Gray for loading
        break;
      case "error":
        button.classList.add("btn-danger"); // Red for error
        break;
      default:
        button.classList.add("btn-primary"); // Blue for default state
    }

    // Update the icon
    const icon = button.querySelector(".play-icon");
    if (icon) {
      switch (state) {
        case "playing":
          icon.innerHTML = "⏸"; // pause icon
          break;
        case "paused":
          icon.innerHTML = "▶"; // play icon
          break;
        case "loading":
          icon.innerHTML = "⏳"; // loading icon
          break;
        case "error":
          icon.innerHTML = "⚠️"; // error icon
          break;
        default:
          icon.innerHTML = "▶"; // play icon
      }
    }
  };

  // Show error message when audio can't be played
  const showAudioErrorMessage = (trackItem) => {
    const errorMsg = document.createElement("div");
    errorMsg.className = "alert alert-danger py-1 px-3 mt-2";
    errorMsg.style.fontSize = "0.875rem";
    errorMsg.textContent = "Track unavailable";

    // Remove any existing error messages
    const existingError = trackItem.querySelector(".alert-danger");
    if (existingError) {
      existingError.remove();
    }

    // Insert the error message after track info
    const trackInfo = trackItem.querySelector(".track-info");
    if (trackInfo) {
      trackInfo.appendChild(errorMsg);
    } else {
      trackItem.appendChild(errorMsg);
    }

    // Remove the message after 3 seconds
    setTimeout(() => {
      if (errorMsg.parentNode) {
        errorMsg.parentNode.removeChild(errorMsg);
      }
    }, 3000);
  };

  // Make progress bars clickable to seek
  document.addEventListener("click", function (e) {
    if (e.target.closest(".progress") && currentAudio) {
      const progressContainer = e.target.closest(".progress");
      const rect = progressContainer.getBoundingClientRect();
      const clickPos = (e.clientX - rect.left) / rect.width;

      // Set audio position based on click
      currentAudio.currentTime = clickPos * currentAudio.duration;

      // Update progress bar immediately
      const progressBar = progressContainer.querySelector(".progress-bar");
      progressBar.style.width = `${clickPos * 100}%`;
      progressBar.setAttribute("aria-valuenow", clickPos * 100);

      // Update current time display immediately
      const currentTimeSpan = currentTrackItem.querySelector(".current-time");
      if (currentTimeSpan) {
        currentTimeSpan.textContent = formatTime(currentAudio.currentTime);
      }
    }
  });

  // Initialize the audio players when the DOM is loaded
  initializeAudioPlayers();

  // Day Pass Modal Functionality
  const modal = document.getElementById("dayPassModal");
  const dayPassBtn = document.getElementById("day-pass-btn");
  const closeBtn = document.querySelector(".day-pass-close");
  const cancelBtn = document.querySelector(".btn-cancel");
  const confirmBtn = document.querySelector(".btn-confirm");
  const dayOptions = document.querySelectorAll('input[name="selectedDay"]');
  const selectedDateInput = document.getElementById("selected-date-input");
  const dayPassForm = document.querySelector(".day-pass-form");

  if (dayPassBtn) {
    dayPassBtn.addEventListener("click", function (e) {
      e.preventDefault();
      if (modal) {
        modal.style.display = "block";
        document.body.style.overflow = "hidden";
      }
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener("click", function () {
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    });
  }

  if (cancelBtn) {
    cancelBtn.addEventListener("click", function () {
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    });
  }

  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    }
  });

  // Handle day selection
  dayOptions.forEach(function (option) {
    option.addEventListener("change", function () {
      if (confirmBtn) {
        confirmBtn.disabled = false;
        confirmBtn.classList.remove("disabled");
      }

      if (selectedDateInput) {
        selectedDateInput.value = this.value;
        console.log("Selected date:", this.value);
      }
    });
  });

  // Add form submission handling
  if (dayPassForm) {
    dayPassForm.addEventListener("submit", function (e) {
      if (!selectedDateInput || !selectedDateInput.value) {
        e.preventDefault();
        alert("Please select a day first");
        return false;
      }

      // Form will submit naturally to /reserve endpoint
      console.log(
        "Submitting day pass form with date:",
        selectedDateInput.value
      );
    });
  }
});
