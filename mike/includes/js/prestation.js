function handlePriceTypeChange() {
    var priceType = document.getElementById('price_type').value;
    var kmInput = document.getElementById('kmInput');
    var hourInput = document.getElementById('hourInput');
    var fixedPriceInput = document.getElementById('fixedPriceInput');

    kmInput.style.display = 'none';
    hourInput.style.display = 'none';
    fixedPriceInput.style.display = 'none';

    if (priceType === 'km') {
        kmInput.style.display = 'block';
    } else if (priceType === 'hour') {
        hourInput.style.display = 'block';
    } else if (priceType === 'fixed') {
        fixedPriceInput.style.display = 'block';
    }
}



function toggleDayHours(checkbox) {
var day = checkbox.id; 
var hoursDiv = document.getElementById(day + "_hours");
var startInput = document.getElementById("hours_" + day + "_start");
var endInput = document.getElementById("hours_" + day + "_end");

if (checkbox.checked) {
    hoursDiv.style.display = "block";
    startInput.required = true; 
    endInput.required = true;
} else {
    hoursDiv.style.display = "none";
    startInput.required = false; 
    endInput.required = false; 
}
}

function formatDecimal(input) {
let value = input.value;
if (!value.includes('.')) {
    input.value = value + '.00';
} else {
    let parts = value.split('.');
    let integerPart = parts[0];
    let decimalPart = parts[1];

    if (decimalPart.length === 1) {
        input.value = integerPart + '.' + decimalPart + '0';
    } else if (decimalPart.length > 2) {
        input.value = integerPart + '.' + decimalPart.substring(0, 2);
    }
}
}