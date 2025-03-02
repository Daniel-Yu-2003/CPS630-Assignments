// make cart in local storage
if (!localStorage.getItem('cart')) {
    localStorage.setItem('cart', JSON.stringify({}));
}

// Allow drop event
function allowDrop(event) {
    event.preventDefault();
}

// Drag function - Store item data
function drag(event) {
    let item = event.target.closest('.product');
    if (!item) return;
    let itemName = item.getAttribute("data-name");
    let itemPrice = parseFloat(item.getAttribute("data-price"));

    if (!itemName || isNaN(itemPrice)) {
        console.error("Invalid drag data");
        return;
    }

    event.dataTransfer.setData("name", itemName);
    event.dataTransfer.setData("price", itemPrice);
}

// Drop function - Add to cart
function drop(event) {
    event.preventDefault();
    let itemName = event.dataTransfer.getData("name");
    let itemPrice = parseFloat(event.dataTransfer.getData("price"));

    if (!itemName || isNaN(itemPrice)) {
        console.error("Invalid drop data");
        return;
    }

    addItemToCart(itemName, itemPrice);
}

// Add item to cart
function addItemToCart(itemName, itemPrice) {
    if (cart[itemName]) {
        cart[itemName].quantity += 1;
    } else {
        cart[itemName] = { price: itemPrice, quantity: 1 };
    }
    updateCart();
}

// Update cart display
function updateCart() {
    let cartTable = document.getElementById("cart-items");
    cartTable.innerHTML = "";
    let subtotal = 0;

    Object.keys(cart).forEach((itemName) => {
        let item = cart[itemName];
        subtotal += item.price * item.quantity;

        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${itemName}</td>
            <td>${item.quantity}</td>
            <td>$${item.price.toFixed(2)}</td>
        `;

        row.addEventListener("click", () => removeItemFromCart(itemName));
        cartTable.appendChild(row);
    });

    document.getElementById("subtotal").innerText = `Subtotal: $${subtotal.toFixed(2)}`;
}

// Remove item from cart
function removeItemFromCart(itemName) {
    if (cart[itemName].quantity > 1) {
        cart[itemName].quantity -= 1;
    } else {
        delete cart[itemName];
    }
    updateCart();
}

// Toggle Cart
const toggleCart = () => {
    let cart = document.getElementById("cart-container");
    cart.classList.toggle("open");
}

function reviewInvoice(){
    localStorage.setItem('cart', JSON.stringify(cart));
    window.location.replace("cart.html")
}

function displayInvoiceSummary(){
    const cart = JSON.parse(localStorage.getItem('cart'));
    const cartSummary = document.getElementById('cart-items');
    let subtotal = 0;

    Object.keys(cart).forEach((itemName) => {
        let item = cart[itemName];
        subtotal += item.price * item.quantity;

        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${itemName}</td>
            <td>${item.quantity}</td>
            <td>$${item.price.toFixed(2)}</td>
        `;
        cartSummary.appendChild(row);
    });
    document.getElementById("subtotal-invoice").innerText = `Subtotal: $${subtotal.toFixed(2)}`;
    document.getElementById("tax-invoice").innerText = `Tax: $${(subtotal*0.13).toFixed(2)}`;
    document.getElementById("total-invoice").innerText = `Total: $${((subtotal*0.13)+subtotal).toFixed(2)}`;
}

if (document.body.contains(document.getElementById('subtotal-invoice'))) {
    displayInvoiceSummary();
}

function submitPayment(){
    window.location.replace("checkout.html")
}