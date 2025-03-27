function validatePaymentForm() {
    const cardNum = document.getElementById('card-number').value.replace(/\s/g, '');
    const expiry = document.getElementById('expiry').value;
    const cvv = document.getElementById('cvv').value;

    if (!/^\d{16}$/.test(cardNum)) {
        alert("Card number must be 16 digits.");
        return false;
    }
    if (!/^\d{2}\/\d{2}$/.test(expiry)) {
        alert("Expiry format must be MM/YY.");
        return false;
    }
    if (!/^\d{3,4}$/.test(cvv)) {
        alert("CVV must be 3 or 4 digits.");
        return false;
    }
    return true;
}