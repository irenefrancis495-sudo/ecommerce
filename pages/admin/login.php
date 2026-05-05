<?php
if (!empty($_SESSION['admin_logged_in'])) {
  echo '<script>window.location.href="/admin/index";</script>';
  return;
}

$authError = $_SESSION['auth_error'] ?? '';
unset($_SESSION['auth_error']);
?>
<style>
  .login-ambient::before,
  .login-ambient::after {
    content: "";
    position: absolute;
    border-radius: 9999px;
    filter: blur(60px);
    pointer-events: none;
  }

  .login-ambient::before {
    width: 20rem;
    height: 20rem;
    background: rgba(42, 101, 126, 0.18);
    top: -6rem;
    right: -4rem;
  }

  .login-ambient::after {
    width: 18rem;
    height: 18rem;
    background: rgba(144, 77, 0, 0.14);
    bottom: -5rem;
    left: -4rem;
  }
</style>

<section class="min-h-screen w-full bg-gradient-to-b from-surface to-surface-container-low login-ambient relative overflow-hidden flex items-center justify-center p-6">
  <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 rounded-3xl overflow-hidden border border-outline-variant/30 shadow-2xl shadow-slate-300/20 bg-surface-container-lowest">
    <div class="hidden lg:flex flex-col justify-between p-10 bg-primary text-on-primary relative">
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_45%)]"></div>
      <div class="relative z-10">
        <p class="text-xs uppercase tracking-[0.3em] text-primary-fixed mb-5 font-bold">Digital Atelier Console</p>
        <h1 class="text-4xl leading-tight font-black font-headline">Mpemba Heritage<br/>Admin Portal</h1>
        <p class="mt-4 text-sm text-primary-fixed">Manage inventory, orders, and marketplace analytics from one modern panel.</p>
      </div>
      <div class="relative z-10 rounded-2xl bg-white/10 p-4 backdrop-blur-sm border border-white/20">
        <p class="text-xs uppercase tracking-wider text-primary-fixed font-bold mb-1">Secure Access</p>
        <p class="text-sm">Only admin staff are authorized to access.</p>
      </div>
    </div>

    <div class="p-8 md:p-12">
      <div class="mb-8">
        <h2 class="text-3xl font-black font-headline text-primary">Sign In</h2>
        <p class="text-sm text-on-surface-variant mt-2">Sign in to the Mpemba Marketplace admin dashboard.</p>
      </div>

      <?php if ($authError): ?>
        <div class="mb-6 rounded-xl border border-error/20 bg-error-container px-4 py-3 text-sm font-semibold text-on-error-container">
          <?php echo htmlspecialchars($authError); ?>
        </div>
      <?php endif; ?>

      <form method="post" action="/admin/auth" class="space-y-5">
        <label class="block">
          <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Email or Username</span>
          <input class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="text" name="login" required autocomplete="username" placeholder="admin or admin@mpemba.local">
        </label>

        <label class="block">
          <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Password</span>
          <input class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="password" name="password" required autocomplete="current-password" placeholder="Enter password">
        </label>

        <div class="flex items-center justify-between gap-4">
          <label class="inline-flex items-center gap-2 text-xs text-on-surface-variant font-semibold">
            <input class="rounded border-outline-variant text-primary focus:ring-primary/20" type="checkbox" name="remember">
            Remember me
          </label>
          <span class="text-[11px] font-bold text-secondary">Admin Access Only</span>
        </div>

        <button class="w-full rounded-xl bg-primary text-on-primary py-3.5 font-bold tracking-wide hover:opacity-95 transition-opacity shadow-lg shadow-primary/20" type="submit">
          Sign In to Dashboard
        </button>
      </form>
    </div>
  </div>
</section>
