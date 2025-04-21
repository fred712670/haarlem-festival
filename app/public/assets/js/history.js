//history overview
document.addEventListener('DOMContentLoaded', function() {
    // Select all tour location thumbnails and the display areas for title/description
    const thumbnails = document.querySelectorAll('.location-thumbnail');
    const locationTitle = document.getElementById('location-title');
    const locationText = document.getElementById('location-text');
    
    // Set default content with first location if available
    if (thumbnails.length > 0) {
        const firstThumb = thumbnails[0];
        locationTitle.textContent = firstThumb.getAttribute('data-location');
        locationText.textContent = firstThumb.getAttribute('data-description');
        // highlight initial thumbnail
        firstThumb.classList.add('active');
    }
    // On hover over any thumbnail, update the main display
    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('mouseenter', function() {
            // Read location name/description from data attributes
            const locationName = this.getAttribute('data-location');
            const locationDesc = this.getAttribute('data-description');
            
            // Update description and title
            locationTitle.textContent = locationName;
            locationText.textContent = locationDesc;
            
            // Update active state
            thumbnails.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the map when Google Maps API is loaded
    initMap();
});

//reservation form
document.addEventListener('DOMContentLoaded', function() {
    // Grab references to all form controls by their IDs
    const dateSelect = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    const languageSelect = document.getElementById('language');
    const regularRadio = document.getElementById('regular');
    const familyRadio = document.getElementById('family');
    const seatsInput = document.getElementById('seats');
    const decreaseBtn = document.getElementById('decrease-seats');
    const increaseBtn = document.getElementById('increase-seats');
    const totalPrice = document.getElementById('total-price');
    const bookingForm = document.getElementById('history-booking-form');
    const errorMessage = document.getElementById('error-message');
    
    // Prices
    const regularPrice = 17.50;
    const familyPrice = 60.00;
    
    // If the server returned an error via the URL, display it
    const urlParams = new URLSearchParams(window.location.search);
    const errorParam = urlParams.get('error');
    
    // If there's an error parameter, display it
    if (errorParam) {
        errorMessage.textContent = decodeURIComponent(errorParam);
        errorMessage.style.display = 'block';
    }
    
    // Listen for changes to toggle between ticket types
    regularRadio.addEventListener('change', toggleSeats);
    familyRadio.addEventListener('change', toggleSeats);
    // Listen for clicks to adjust seat count
    decreaseBtn.addEventListener('click', decreaseSeats);
    increaseBtn.addEventListener('click', increaseSeats);
    
    // Update price whenever relevant fields change
    dateSelect.addEventListener('change', updatePrice);
    timeSelect.addEventListener('change', updatePrice);
    languageSelect.addEventListener('change', updatePrice);
    seatsInput.addEventListener('change', updatePrice);
    
    // Show or hide the seat count input based on ticket type
    function toggleSeats() {
        const seatsContainer = document.getElementById('seats-container');
        seatsContainer.style.display = familyRadio.checked ? 'none' : 'block';
        
        // When family package is selected, set seats to 4
        if (familyRadio.checked) {
            seatsInput.value = 4;
        }
        
        updatePrice();
    }
    // Decrease seat count, ensuring it doesn’t go below 1
    function decreaseSeats() {
        if (parseInt(seatsInput.value) > 1) {
            seatsInput.value = parseInt(seatsInput.value) - 1;
            updatePrice();
        }
    }
    // Increase seat count, ensuring it doesn’t exceed 12
    function increaseSeats() {
        if (parseInt(seatsInput.value) < 12) {
            seatsInput.value = parseInt(seatsInput.value) + 1;
            updatePrice();
        }
    }
    // Calculate and display the current total price
    function updatePrice() {
        if (!dateSelect.value || !timeSelect.value || !languageSelect.value) {
            totalPrice.textContent = '0';
            return;
        }
        // For family package, use flat rate; otherwise multiply by seats
        if (familyRadio.checked) {
            totalPrice.textContent = familyPrice.toFixed(2);
        } else {
            const seats = parseInt(seatsInput.value) || 1;
            totalPrice.textContent = (regularPrice * seats).toFixed(2);
        }
    }
    
    // Initialize form state on page load
    toggleSeats();
    updatePrice();
});

