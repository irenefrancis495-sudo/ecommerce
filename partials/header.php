<?php

// ...existing code...
?>
<header class="site-header">
    <div class="container">
        <div class="logo">
            <a href="/home">Mpemba</a>
        </div>
        <nav class="main-nav">
            <a href="/home">Home</a>
            <a href="/products">Products</a>
            <a href="/user#feedback-center">My Account</a>
            <a href="/cart">Cart <span id="cart-count" style="background:#66a6ff;color:#fff;border-radius:50%;padding:2px 8px;font-size:0.9em;vertical-align:top;margin-left:2px;"></span></a>
            <a href="/login">Login</a>
            <a href="/register" id="register-link-header">Register</a>
        </nav>
        <!-- Admin quick access link -->
        <a href="/admin" class="nav-item admin-link">Admin</a>
    </div>
</header>
<div style="position:fixed;right:20px;bottom:20px;z-index:40;display:flex;flex-direction:column;gap:12px;">
    <a id="classic-quick-feedback-link" href="/login?next=%2Fuser%23feedback-center" title="Send feedback" style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:999px;background:rgba(255,255,255,0.96);border:1px solid #e2e8f0;color:#1e293b;text-decoration:none;font-weight:700;box-shadow:0 20px 40px rgba(15,23,42,0.12);backdrop-filter:blur(8px);">
        <span style="display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:999px;background:#0f4c75;color:#fff;">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                <path d="M8 10h8"></path>
                <path d="M8 7h8"></path>
            </svg>
        </span>
        <span>Send Feedback</span>
    </a>
    <a id="classic-quick-message-link" href="/contact" title="Send message" style="display:flex;align-items:center;gap:12px;padding:12px 16px;border-radius:999px;background:rgba(255,255,255,0.96);border:1px solid #e2e8f0;color:#1e293b;text-decoration:none;font-weight:700;box-shadow:0 20px 40px rgba(15,23,42,0.12);backdrop-filter:blur(8px);">
        <span style="display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:999px;background:#0f172a;color:#fff;">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                <path d="m22 6-10 7L2 6"></path>
            </svg>
        </span>
        <span>Message</span>
    </a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const registerLink = document.getElementById('register-link-header');
        const quickFeedbackLink = document.getElementById('classic-quick-feedback-link');
        if (!registerLink) return;

        try {
            const response = await fetch('/api/auth.php?action=check');
            const result = await response.json();
            if (result.success && result.user) {
                registerLink.style.display = 'none';
                if (quickFeedbackLink) {
                    quickFeedbackLink.href = '/user#feedback-center';
                }
                // Update cart count
                updateCartCount();
            }
        } catch (error) {
            if (localStorage.getItem('user')) {
                registerLink.style.display = 'none';
                if (quickFeedbackLink) {
                    quickFeedbackLink.href = '/user#feedback-center';
                }
                // Update cart count
                updateCartCount();
            }
        }

        async function updateCartCount() {
            try {
                const response = await fetch('/api/cart_count.php');
                const result = await response.json();
                if (result.success) {
                    const count = result.count;
                    document.querySelectorAll('#cart-count').forEach(el => {
                        el.textContent = count > 0 ? count : '';
                    });
                }
            } catch (error) {
                console.error('Failed to update cart count:', error);
            }
        }
    });
</script>
