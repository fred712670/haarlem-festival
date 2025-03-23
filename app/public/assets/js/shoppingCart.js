function addQuantity(index) {
    var input = document.getElementById('quantity' + index);  // Unique ID for quantity input
    var currentQuantity = parseInt(input.value, 10);
    var currentPrice = parseFloat(document.getElementById('ticketPrice' + index).textContent.replace('€', '').trim());
    var totalPriceElement = document.getElementById('totalPrice');
    var totalPrice = parseFloat(totalPriceElement.textContent.replace('€', '').trim());

    if (currentQuantity < 20) {
        var newQuantity = currentQuantity + 1;
        input.value = newQuantity;

        // Calculate the new total price for this item
        var newItemTotalPrice = currentPrice * newQuantity;

        // Update the displayed price for this item (if you have such an element)
        document.getElementById('itemTotalPrice' + index).textContent = newItemTotalPrice.toFixed(2) + '€';

        // Calculate and update the overall total price
        totalPrice = totalPrice - (currentPrice * currentQuantity) + newItemTotalPrice;
        totalPriceElement.textContent = totalPrice.toFixed(2) + '€';
    }
}

function subtractQuantity(index) {
    var input = document.getElementById('quantity' + index);  // Unique ID for quantity input
    var currentQuantity = parseInt(input.value, 10);
    var currentPrice = parseFloat(document.getElementById('ticketPrice' + index).textContent.replace('€', '').trim());
    var totalPriceElement = document.getElementById('totalPrice');
    var totalPrice = parseFloat(totalPriceElement.textContent.replace('€', '').trim());

    if (currentQuantity > 1) {
        var newQuantity = currentQuantity - 1;
        input.value = newQuantity;

        // Calculate the new total price for this item
        var newItemTotalPrice = currentPrice * newQuantity;

        // Update the displayed price for this item (if you have such an element)
        document.getElementById('itemTotalPrice' + index).textContent = newItemTotalPrice.toFixed(2) + '€';

        // Calculate and update the overall total price
        totalPrice = totalPrice - (currentPrice * currentQuantity) + newItemTotalPrice;
        totalPriceElement.textContent = totalPrice.toFixed(2) + '€';
    }
}

document.getElementById('createOrderBtn').addEventListener('click', function() {
    window.location.href = '/create/order';
});
