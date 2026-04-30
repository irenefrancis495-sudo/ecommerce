// Cart logic using localStorage
function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCartCount() {
    let cart = getCart();
    let count = cart.reduce((sum, item) => sum + item.qty, 0);
    document.querySelectorAll('#cart-count').forEach(el => {
        el.textContent = count > 0 ? count : '';
    });
}

function renderCart() {
    const container = document.getElementById('cart-items');
    if (!container) return;

    const cart = getCart();
    const summarySubtotal = document.getElementById('cart-subtotal');
    const summaryTotal = document.getElementById('cart-total');
    const emptyMessage = document.getElementById('cart-empty-message');
    const shippingAmount = 24.00;
    const taxAmount = 110.55;

    container.innerHTML = '';
    if (emptyMessage) emptyMessage.classList.toggle('hidden', cart.length > 0);

    if (!cart.length) {
        if (summarySubtotal) summarySubtotal.textContent = '$0.00';
        if (summaryTotal) summaryTotal.textContent = '$0.00';
        return;
    }

    let subtotal = 0;
    cart.forEach(item => {
        const itemTotal = item.price * item.qty;
        subtotal += itemTotal;

        const itemElement = document.createElement('div');
        itemElement.className = 'flex flex-col md:flex-row gap-6 p-6 bg-surface-container-lowest rounded-xl group transition-all duration-300 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)]';
        itemElement.innerHTML = `
            <div class="w-full md:w-48 h-48 rounded-lg overflow-hidden flex-shrink-0 bg-surface-container-low flex items-center justify-center text-on-surface-variant">
                <img src="${item.image || ''}" alt="${item.name}" class="w-full h-full object-cover" />
            </div>
            <div class="flex flex-col flex-grow justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-headline text-xl font-bold text-primary mb-1">${item.name}</h3>
                        <p class="font-label text-sm text-on-surface-variant">Qty: ${item.qty}</p>
                    </div>
                    <button class="text-outline hover:text-error transition-colors remove-from-cart" type="button" data-id="${item.id}">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
                <div class="flex justify-between items-end mt-6">
                    <div class="flex items-center bg-surface-container-high rounded-full px-4 py-2 space-x-4">
                        <button class="text-primary font-bold hover:scale-125 transition-transform quantity-decrease" type="button" data-id="${item.id}">—</button>
                        <span class="font-label font-semibold text-primary">${item.qty}</span>
                        <button class="text-primary font-bold hover:scale-125 transition-transform quantity-increase" type="button" data-id="${item.id}">+</button>
                    </div>
                    <span class="font-headline text-lg font-bold text-primary">$${itemTotal.toFixed(2)}</span>
                </div>
            </div>
        `;
        container.appendChild(itemElement);
    });

    const total = subtotal + shippingAmount + taxAmount;
    if (summarySubtotal) summarySubtotal.textContent = `$${subtotal.toFixed(2)}`;
    if (summaryTotal) summaryTotal.textContent = `$${total.toFixed(2)}`;
    attachCartControls();
}

function attachCartControls() {
    document.querySelectorAll('.remove-from-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.dataset.id);
            removeFromCart(productId);
        });
    });

    document.querySelectorAll('.quantity-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.dataset.id);
            changeQty(productId, -1);
        });
    });

    document.querySelectorAll('.quantity-increase').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.dataset.id);
            changeQty(productId, 1);
        });
    });
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
    alert(`${product.name} added to cart`);
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

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = parseInt(this.dataset.id);
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            addToCart({ id, name, price });
        });
    });

    document.addEventListener('click', function(event) {
        const button = event.target.closest('.add-to-collection');
        if (button) {
            const productCard = button.closest('.product-card');
            if (!productCard) return;
            const id = parseInt(productCard.dataset.id);
            const name = productCard.dataset.name;
            const price = parseFloat(productCard.dataset.price);
            const image = productCard.dataset.image || productCard.querySelector('img')?.src || '';
            addToCart({ id, name, price, image });
        }
    });

    document.querySelectorAll('#cart-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = this.getAttribute('href') || '/cart';
        });
    });

    updateCartCount();
    if (typeof renderCart === 'function') renderCart();

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login submitted! (Demo)');
        });
    }
});
