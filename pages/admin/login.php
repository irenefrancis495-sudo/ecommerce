<?php
session_start();
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php'); exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login</title>
  <link rel="stylesheet" href="/Mpemba/css/admin.css">
</head>
<body class="auth-page">
  <main class="auth-box">
    <h1 class="brand">Mpemba Admin</h1>
    <p class="muted">Sign in to your administrator account</p>
    <form method="post" action="auth.php" class="auth-form">
      <label>Email
        <input type="email" name="email" required autocomplete="username">
      </label>
      <label>Password
        <input type="password" name="password" required autocomplete="current-password">
      </label>
      <div class="form-row">
        <label class="checkbox"><input type="checkbox" name="remember"> Remember me</label>
        <button class="btn primary" type="submit">Sign in</button>
      </div>
    </form>
  </main>
</body>
</html>
