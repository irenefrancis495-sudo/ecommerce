<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
session_unset();
session_destroy();

?>


<section class="min-h-screen bg-gradient-to-b from-surface to-surface-container-low flex items-center justify-center p-6">
	<div class="w-full max-w-md rounded-3xl bg-surface-container-lowest border border-outline-variant/20 shadow-2xl shadow-slate-300/20 p-8 text-center">
		<div class="mx-auto w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-5">
			<span class="material-symbols-outlined text-3xl">logout</span>
		</div>

		<h1 class="text-2xl font-black text-primary">Signed Out Successfully</h1>
		<p class="text-sm text-on-surface-variant mt-2">You have been signed out of the admin dashboard. Redirecting to login page...</p>

		<div class="mt-6 h-2 w-full rounded-full bg-surface-container-high overflow-hidden">
			<div class="h-full w-full bg-gradient-to-r from-primary via-primary-container to-secondary animate-pulse"></div>
		</div>

		<div class="mt-6 flex gap-3">
			<a href="/admin/login" class="flex-1 bg-primary text-on-primary py-2.5 rounded-xl font-bold text-sm hover:opacity-95 transition-opacity">Login Again</a>
			<a href="/" class="flex-1 bg-surface-container-high text-primary py-2.5 rounded-xl font-bold text-sm hover:bg-surface-container-highest transition-colors">Go Home</a>
		</div>
	</div>
</section>

<script>
	setTimeout(function () {
		window.location.href = '/admin/login';
	}, 1800);
</script>
