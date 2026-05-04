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
            <a href="/cart">Cart <span id="cart-count" style="background:#66a6ff;color:#fff;border-radius:50%;padding:2px 8px;font-size:0.9em;vertical-align:top;margin-left:2px;"></span></a>
            <a href="/login">Login</a>
            <a href="/register" id="register-link-header">Register</a>
        </nav>
        <!-- Admin quick access link -->
        <a href="/admin" class="nav-item admin-link">Admin</a>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const registerLink = document.getElementById('register-link-header');
        if (!registerLink) return;

        try {
            const response = await fetch('/api/auth.php?action=check');
            const result = await response.json();
            if (result.success && result.user) {
                registerLink.style.display = 'none';
            }
        } catch (error) {
            if (localStorage.getItem('user')) {
                registerLink.style.display = 'none';
            }
        }
    });
</script>
