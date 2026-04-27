// Cart logic using localStorage
function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}


function addToCart(product) {
    let cart = getCart();
    const index = cart.findIndex(item => item.id === product.id);
    if (index > -1) {
        cart[index].qty += 1;
    } else {
        cart.push({ ...product, qty: 1 });
    }
    setCart(cart);
    updateCartCount();
    alert('Imeongezwa kwenye kikapu!');
    if (typeof renderCart === 'function') renderCart();
}

function removeFromCart(productId) {
    let cart = getCart();
    cart = cart.filter(item => item.id !== productId);
    setCart(cart);
    updateCartCount();
    if (typeof renderCart === 'function') renderCart();
}

function changeQty(productId, delta) {
    let cart = getCart();
    const index = cart.findIndex(item => item.id === productId);
    if (index > -1) {
        cart[index].qty += delta;
        if (cart[index].qty < 1) cart[index].qty = 1;
        setCart(cart);
        updateCartCount();
        if (typeof renderCart === 'function') renderCart();
    }
}

function updateCartCount() {
    let cart = getCart();
    let count = cart.reduce((sum, item) => sum + item.qty, 0);
    let el = document.getElementById('cart-count');
    if (el) el.textContent = count > 0 ? count : '';
}

document.addEventListener('DOMContentLoaded', function() {
    // Add to Cart button handler
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = parseInt(this.dataset.id);
            const name = this.dataset.name;
            const price = parseInt(this.dataset.price);
            addToCart({ id, name, price });
        });
    });
    updateCartCount();

    // Login form handler
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login submitted! (Demo)');
        });
    }
});
