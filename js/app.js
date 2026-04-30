// Cart logic using localStorage
function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function formatCurrency(amount) {
    return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
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
    if (typeof renderCart === 'function') renderCart();

    // Show success notification
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Added to cart!',
            text: `${product.name} has been added to your cart.`,
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            background: '#003345',
            color: '#ffffff'
        });
    } else {
        alert('Added to cart!');
    }
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
    if (el) {
        if (count > 0) {
            el.textContent = count;
            el.style.display = 'inline-flex';
        } else {
            el.style.display = 'none';
        }
    }
}

function updateCartSummary() {
    const cart = getCart();
    const subtotal = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
    const shipping = cart.length ? 24 : 0;
    const taxes = subtotal * 0.07;
    const total = subtotal + shipping + taxes;

    const subtotalEl = document.getElementById('cart-subtotal');
    const shippingEl = document.getElementById('cart-shipping');
    const taxEl = document.getElementById('cart-tax');
    const totalEl = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-button');

    if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);
    if (shippingEl) shippingEl.textContent = formatCurrency(shipping);
    if (taxEl) taxEl.textContent = formatCurrency(taxes);
    if (totalEl) totalEl.textContent = formatCurrency(total);
    if (checkoutBtn) checkoutBtn.disabled = cart.length === 0;
}

function renderCart() {
    const cart = getCart();
    const cartItemsContainer = document.getElementById('cart-items');
    const emptyNotice = document.getElementById('cart-empty');

    if (!cartItemsContainer) return;

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '';
        if (emptyNotice) emptyNotice.classList.remove('hidden');
        updateCartSummary();
        return;
    }

    if (emptyNotice) emptyNotice.classList.add('hidden');

    cartItemsContainer.innerHTML = cart.map(item => `
        <div class="flex flex-col md:flex-row gap-6 p-6 bg-surface-container-lowest rounded-xl group transition-all duration-300 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)]">
            <div class="w-full md:w-48 h-48 rounded-lg overflow-hidden flex-shrink-0 bg-surface-container-low flex items-center justify-center text-slate-400">
                <span class="text-xl font-semibold">${item.name.charAt(0)}</span>
            </div>
            <div class="flex flex-col flex-grow justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-headline text-xl font-bold text-primary mb-1">${item.name}</h3>
                        <p class="font-label text-sm text-on-surface-variant">Unit price: ${formatCurrency(item.price)}</p>
                    </div>
                    <button data-id="${item.id}" class="cart-delete text-outline hover:text-error transition-colors">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
                <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-end mt-6">
                    <div class="flex items-center bg-surface-container-high rounded-full px-4 py-2 space-x-4">
                        <button data-id="${item.id}" class="cart-decrease text-primary font-bold hover:scale-125 transition-transform">—</button>
                        <span class="font-label font-semibold text-primary">${item.qty}</span>
                        <button data-id="${item.id}" class="cart-increase text-primary font-bold hover:scale-125 transition-transform">+</button>
                    </div>
                    <span class="font-headline text-lg font-bold text-primary">${formatCurrency(item.price * item.qty)}</span>
                </div>
            </div>
        </div>
    `).join('');

    cartItemsContainer.querySelectorAll('.cart-delete').forEach(button => {
        button.addEventListener('click', function () {
            removeFromCart(parseInt(this.dataset.id));
        });
    });

    cartItemsContainer.querySelectorAll('.cart-decrease').forEach(button => {
        button.addEventListener('click', function () {
            changeQty(parseInt(this.dataset.id), -1);
        });
    });

    cartItemsContainer.querySelectorAll('.cart-increase').forEach(button => {
        button.addEventListener('click', function () {
            changeQty(parseInt(this.dataset.id), 1);
        });
    });

    updateCartSummary();
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = parseInt(this.dataset.id);
            const name = this.dataset.name;
            const price = parseInt(this.dataset.price);
            addToCart({ id, name, price });
        });
    });
    updateCartCount();
    if (typeof renderCart === 'function') renderCart();

    const checkoutBtn = document.getElementById('checkout-button');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function () {
            const cart = getCart();
            if (cart.length === 0) return;
            window.location.href = '/payment-methods';
        });
    }

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login submitted! (Demo)');
        });
    }
});
