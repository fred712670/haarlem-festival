//history overview
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.location-thumbnail');
    const locationTitle = document.getElementById('location-title');
    const locationText = document.getElementById('location-text');
    
    // Location information
    const locationInfo = {
        'Church of St. Bavo': 'The Church of St. Bavo, an iconic Gothic masterpiece in Haarlem, dates back to the 14th century. Known for its towering spire and stunning architecture, it houses the world-famous Müller organ, once played by Mozart himself. A true symbol of Haarlem\'s rich history and grandeur.',
        'Grote Markt': 'The Grote Markt, Haarlem\'s historic main square, is the heart of the city. Surrounded by landmarks like the Town Hall and the Church of St. Bavo, it serves as a vibrant gathering place for markets, events, and cultural celebrations.',
        'De Hallen': 'De Hallen Haarlem, a striking cultural landmark, is home to the Frans Hals Museum\'s contemporary art collection. Located in a historic building on the Grote Markt, it offers a blend of modern creativity and Haarlem\'s rich artistic heritage.',
        'Proveniershof': 'Proveniershof, a serene 17th-century courtyard in Haarlem, is nestled among picturesque historic houses. Once home to retired tradesmen, it now offers a peaceful escape, showcasing the city\'s rich architectural and cultural heritage.',
        'Jopenkerk': 'Jopenkerk Haarlem, a former church turned brewery, blends history with modern craft beer culture. This unique venue offers visitors a chance to enjoy locally brewed Jopen beers while surrounded by stunning stained-glass windows and Gothic architecture, making it a must-visit landmark.',
        'Waalse Kerk Haarlem': 'The Waalse Kerk, a charming 14th-century chapel in Haarlem, is renowned for its intimate atmosphere and beautiful acoustics. Once a refuge for French Huguenots, it now serves as a cultural venue for concerts and events.',
        'Molen de Adriaan': 'Molen de Adriaan, a historic windmill on the banks of the Spaarne River, offers panoramic views of Haarlem. Originally built in 1779, this iconic landmark showcases the Netherlands\' rich milling heritage and provides a fascinating glimpse into traditional Dutch craftsmanship.',
        'Amsterdamse Poort': 'The Amsterdamse Poort, Haarlem\'s last remaining city gate, is a stunning medieval structure dating back to the 14th century. Once a key entry point to the city, it now stands as a testament to Haarlem\'s rich history and architectural grandeur.',
        'Hof van Bakenes': 'Hof van Bakenes, Haarlem\'s oldest hofje, is a tranquil courtyard dating back to the 14th century. Surrounded by charming historic houses, it offers a peaceful retreat and a glimpse into the city\'s tradition of community living'
    };
    
    // Set initial active state for first thumbnail
    thumbnails[0].classList.add('active');
    
    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('mouseenter', function() {
            // Get location name from data attribute
            const location = this.getAttribute('data-location');
            
            // Update description
            locationTitle.textContent = location;
            locationText.textContent = locationInfo[location];
            
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
