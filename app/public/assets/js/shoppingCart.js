function addQuantity() {
    var input = document.getElementById('quantity');
    var currentQuantity = parseInt(input.value);
    var currentPrice = parseFloat(document.getElementById('ticketPrice').textContent); 
    var totalPriceElement = document.getElementById('totalPrice');
    var totalPrice = parseFloat(totalPriceElement.textContent.replace('€', '').trim()); 

    if (currentQuantity < 20) {
        var newQuantity = currentQuantity + 1;
        input.value = newQuantity; 
        var newTotalPrice = currentPrice * newQuantity;
        totalPriceElement.textContent = newTotalPrice.toFixed(2); 
    }
}


function subtractQuantity() {
    var input = document.getElementById('quantity');
    var currentQuantity = parseInt(input.value); 
    var currentPrice = parseFloat(document.getElementById('ticketPrice').textContent); 
    var totalPriceElement = document.getElementById('totalPrice');
    var totalPrice = parseFloat(totalPriceElement.textContent.replace('€', '').trim());

    if (currentQuantity > 1) {
        var newQuantity = currentQuantity - 1;
        input.value = newQuantity; 
        var newTotalPrice = currentPrice * newQuantity; 
        totalPriceElement.textContent = newTotalPrice.toFixed(2); 
    }
}
