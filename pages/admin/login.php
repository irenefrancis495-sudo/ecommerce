<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: index.php'); exit;
}
$error = $_SESSION['auth_error'] ?? '';
unset($_SESSION['auth_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin Login - Mpemba</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        "colors": {
          "surface-container-lowest": "#ffffff",
          "surface-container-low": "#f2f4f6",
          "on-background": "#191c1e",
          "surface-dim": "#d9dadc",
          "on-tertiary-fixed": "#221b00",
          "tertiary-container": "#c9a900",
          "secondary-fixed": "#ffdcc3",
          "on-tertiary-container": "#4c3f00",
          "secondary-container": "#ffa454",
          "inverse-primary": "#96ceeb",
          "on-error": "#ffffff",
          "primary": "#003345",
          "surface-bright": "#f8f9fb",
          "on-secondary": "#ffffff",
          "on-primary-fixed": "#001f2b",
          "surface-container-high": "#e7e8ea",
          "tertiary-fixed": "#ffe16d",
          "on-error-container": "#93000a",
          "on-secondary-fixed-variant": "#6e3900",
          "inverse-on-surface": "#f0f1f3",
          "outline-variant": "#c0c7cd",
          "surface": "#f8f9fb",
          "error": "#ba1a1a",
          "surface-container": "#edeef0",
          "inverse-surface": "#2e3133",
          "background": "#f8f9fb",
          "outline": "#71787d",
          "error-container": "#ffdad6",
          "on-tertiary": "#ffffff",
          "primary-fixed-dim": "#96ceeb",
          "primary-fixed": "#bfe8ff",
          "on-surface-variant": "#40484c",
          "secondary-fixed-dim": "#ffb77d",
          "secondary": "#904d00",
          "primary-container": "#004b63",
          "on-primary-fixed-variant": "#044d65",
          "on-secondary-container": "#713b00",
          "surface-variant": "#e1e2e5",
          "on-primary": "#ffffff",
          "surface-container-highest": "#e1e2e5",
          "surface-tint": "#2a657e",
          "on-secondary-fixed": "#2f1500",
          "on-tertiary-fixed-variant": "#544600",
          "tertiary": "#705d00",
          "on-primary-container": "#83bad6",
          "on-surface": "#191c1e",
          "tertiary-fixed-dim": "#e9c400"
        },
        "borderRadius": {
          "DEFAULT": "0.25rem",
          "lg": "0.5rem",
          "xl": "0.75rem",
          "full": "9999px"
        },
        "fontFamily": {
          "headline": ["Epilogue"],
          "body": ["Manrope"],
          "label": ["Manrope"]
        }
      },
    },
  }
</script>
<style>
  .material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
  }
</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-primary via-primary-container to-secondary-container flex items-center justify-center p-4">
<div class="w-full max-w-md">
<!-- Logo/Brand -->
<div class="text-center mb-8">
<div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
<span class="material-symbols-outlined text-3xl text-on-primary">admin_panel_settings</span>
</div>
<h1 class="text-3xl font-black font-display text-primary mb-2">Mpemba Admin</h1>
<p class="text-on-surface-variant">Sign in to access the admin dashboard</p>
</div>

<!-- Login Form -->
<div class="bg-surface-container-lowest rounded-3xl p-8 shadow-2xl shadow-primary/10">
<?php if ($error): ?>
<div class="mb-6 p-4 bg-error-container border border-error/20 rounded-xl">
<p class="text-on-error-container text-sm font-medium"><?php echo htmlspecialchars($error); ?></p>
</div>
<?php endif; ?>

<form method="post" action="auth.php" class="space-y-6">
<div>
<label class="block text-sm font-bold text-primary mb-2">Email Address</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">email</span>
<input type="email" name="email" required autocomplete="username" class="w-full pl-12 pr-4 py-3 bg-surface-container border border-outline rounded-xl text-on-surface placeholder-on-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-all" placeholder="admin@mpemba.local">
</div>
</div>

<div>
<label class="block text-sm font-bold text-primary mb-2">Password</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">lock</span>
<input type="password" name="password" required autocomplete="current-password" class="w-full pl-12 pr-4 py-3 bg-surface-container border border-outline rounded-xl text-on-surface placeholder-on-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-all" placeholder="Enter your password">
</div>
</div>

<div class="flex items-center justify-between">
<label class="flex items-center gap-2 text-sm text-on-surface-variant">
<input type="checkbox" name="remember" class="w-4 h-4 text-primary bg-surface-container border-outline rounded focus:ring-primary">
<span>Remember me</span>
</label>
</div>

<button type="submit" class="w-full py-4 bg-primary text-on-primary rounded-xl font-bold text-lg hover:bg-primary-container hover:text-primary transition-all transform hover:scale-105 shadow-lg shadow-primary/20">
Sign In to Dashboard
</button>
</form>

<!-- Demo Credentials -->
<div class="mt-8 p-4 bg-surface-container rounded-xl border border-outline/50">
<h3 class="text-sm font-bold text-primary mb-2">Demo Credentials</h3>
<p class="text-xs text-on-surface-variant mb-1"><strong>Email:</strong> admin@mpemba.local</p>
<p class="text-xs text-on-surface-variant"><strong>Password:</strong> Admin@123</p>
</div>
</div>
</div>
</body>
</html>
