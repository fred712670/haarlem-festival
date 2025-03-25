//history overview
document.addEventListener('DOMContentLoaded', function() {
    // Handle location thumbnail hover effects
    const thumbnails = document.querySelectorAll('.location-thumbnail');
    const locationTitle = document.getElementById('location-title');
    const locationText = document.getElementById('location-text');
    
    // Set default content with first location if available
    if (thumbnails.length > 0) {
        const firstThumb = thumbnails[0];
        locationTitle.textContent = firstThumb.getAttribute('data-location');
        locationText.textContent = firstThumb.getAttribute('data-description');
        firstThumb.classList.add('active');
    }
    
    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('mouseenter', function() {
            // Get location data from data attributes
            const locationName = this.getAttribute('data-location');
            const locationDesc = this.getAttribute('data-description');
            
            // Update description
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
    // Get form elements (using the same IDs as before)
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
    
    // Check URL for error parameters
    const urlParams = new URLSearchParams(window.location.search);
    const errorParam = urlParams.get('error');
    
    // If there's an error parameter, display it
    if (errorParam) {
        errorMessage.textContent = decodeURIComponent(errorParam);
        errorMessage.style.display = 'block';
    }
    
    // Event listeners
    regularRadio.addEventListener('change', toggleSeats);
    familyRadio.addEventListener('change', toggleSeats);
    decreaseBtn.addEventListener('click', decreaseSeats);
    increaseBtn.addEventListener('click', increaseSeats);
    
    // Add listeners for select changes to update price
    dateSelect.addEventListener('change', updatePrice);
    timeSelect.addEventListener('change', updatePrice);
    languageSelect.addEventListener('change', updatePrice);
    seatsInput.addEventListener('change', updatePrice);
    
    // Functions
    function toggleSeats() {
        const seatsContainer = document.getElementById('seats-container');
        seatsContainer.style.display = familyRadio.checked ? 'none' : 'block';
        
        // When family package is selected, set seats to 4
        if (familyRadio.checked) {
            seatsInput.value = 4;
        }
        
        updatePrice();
    }
    
    function decreaseSeats() {
        if (parseInt(seatsInput.value) > 1) {
            seatsInput.value = parseInt(seatsInput.value) - 1;
            updatePrice();
        }
    }
    
    function increaseSeats() {
        if (parseInt(seatsInput.value) < 12) {
            seatsInput.value = parseInt(seatsInput.value) + 1;
            updatePrice();
        }
    }
    
    function updatePrice() {
        if (!dateSelect.value || !timeSelect.value || !languageSelect.value) {
            totalPrice.textContent = '0';
            return;
        }
        
        if (familyRadio.checked) {
            totalPrice.textContent = familyPrice.toFixed(2);
        } else {
            const seats = parseInt(seatsInput.value) || 1;
            totalPrice.textContent = (regularPrice * seats).toFixed(2);
        }
    }
    
    // Initialize form state
    toggleSeats();
    updatePrice();
});

