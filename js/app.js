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
    if (typeof updateCheckoutButton === 'function') {
        updateCheckoutButton();
    }
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

function showCartNotification(message) {
    let toast = document.getElementById('cart-notice');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'cart-notice';
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        Object.assign(toast.style, {
            position: 'fixed',
            bottom: '24px',
            right: '24px',
            zIndex: '9999',
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#ffffff',
            padding: '14px 18px',
            borderRadius: '18px',
            boxShadow: '0 20px 50px rgba(15, 23, 42, 0.24)',
            fontSize: '13px',
            maxWidth: '320px',
            opacity: '0',
            transition: 'opacity 220ms ease, transform 220ms ease',
            transform: 'translateY(12px)'
        });
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
    if (toast._timeoutId) {
        clearTimeout(toast._timeoutId);
    }
    toast._timeoutId = setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(12px)';
    }, 2200);
}

function findProductDataFromButton(button) {
    const id = parseInt(button.dataset.id) || parseInt(button.closest('[data-id]')?.dataset.id);
    const name = button.dataset.name || button.closest('[data-name]')?.dataset.name || button.closest('article,div')?.querySelector('h3, h2, .product-name')?.textContent.trim();
    const price = parseFloat(button.dataset.price) || parseFloat(button.closest('[data-price]')?.dataset.price) || parseFloat(button.closest('article,div')?.querySelector('[data-price]')?.dataset.price);
    if (!id || !name || !price) {
        return null;
    }
    return { id, name, price };
}

function setButtonAddedState(button) {
    if (!button.dataset.originalHtml) {
        button.dataset.originalHtml = button.innerHTML;
    }
    button.disabled = true;
    button.classList.add('bg-teal-600', 'cursor-not-allowed');
    button.classList.remove('hover:bg-primary/90');
    button.innerHTML = `<span class="material-symbols-outlined text-lg">check</span> Added`;
    setTimeout(() => {
        button.disabled = false;
        button.classList.remove('bg-teal-600', 'cursor-not-allowed');
        button.innerHTML = button.dataset.originalHtml;
    }, 1400);
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
    showCartNotification(`${product.name} imeongezwa kwenye cart`);
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

function normalizeSearchTerm(value) {
    return String(value || '').trim().toLowerCase();
}

function filterCardsBySearch(input) {
    const selector = input.dataset.searchCardSelector || '.grid > *';
    const query = normalizeSearchTerm(input.value);
    const cards = document.querySelectorAll(selector);

    cards.forEach(card => {
        const text = normalizeSearchTerm(card.textContent);
        card.style.display = !query || text.includes(query) ? '' : 'none';
    });
}

function attachGlobalSearchInputs() {
    document.querySelectorAll('input[data-search-target]').forEach(input => {
        input.addEventListener('input', () => {
            const target = input.dataset.searchTarget;
            if (target === 'cards') {
                filterCardsBySearch(input);
                return;
            }

            if (target === 'products' && typeof window.executeProductSearch === 'function') {
                window.executeProductSearch(input.value);
            }
        });
    });
}

async function submitCustomerFeedback(form) {
    const status = document.getElementById('feedback-form-status');
    if (!status) return;

    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const message = form.message.value.trim();

    if (!name || !email || !message) {
        status.textContent = 'Please fill in your name, email, and message.';
        status.className = 'text-sm text-error';
        return;
    }

    status.textContent = 'Sending feedback...';
    status.className = 'text-sm text-slate-300';

    try {
        const response = await fetch('/api/comments.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, message })
        });
        const result = await response.json();

        if (result.status === 'success') {
            status.textContent = 'Thank you — your feedback has been received.';
            status.className = 'text-sm text-teal-500';
            form.reset();
        } else {
            status.textContent = result.message || 'Unable to submit feedback at this time.';
            status.className = 'text-sm text-error';
        }
    } catch (error) {
        status.textContent = 'Submission failed. Please try again.';
        status.className = 'text-sm text-error';
    }
}

function attachFeedbackForm() {
    const feedbackForm = document.getElementById('customer-feedback-form');
    if (!feedbackForm) return;

    feedbackForm.addEventListener('submit', function (event) {
        event.preventDefault();
        submitCustomerFeedback(this);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const product = findProductDataFromButton(this);
            if (!product) return;
            addToCart(product);
            setButtonAddedState(this);
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
    attachGlobalSearchInputs();
    attachFeedbackForm();

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login submitted! (Demo)');
        });
    }
});
