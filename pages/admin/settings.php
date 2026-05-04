<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$settingsFile = __DIR__ . '/../../data/admin_settings.json';

$defaultSettings = [
    'store_name' => 'Mpemba Marketplace',
    'support_email' => 'support@mpemba.com',
    'currency' => 'USD',
    'timezone' => 'Africa/Nairobi',
    'low_stock_threshold' => 20,
    'maintenance_mode' => false,
    'email_notifications' => true,
    'sms_notifications' => false,
    'weekly_digest' => true,
];

$settings = $defaultSettings;
if (file_exists($settingsFile)) {
    $saved = json_decode((string) file_get_contents($settingsFile), true);
    if (is_array($saved)) {
        $settings = array_merge($settings, $saved);
    }
}

$flash = '';
$flashType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storeName = trim((string) ($_POST['store_name'] ?? $settings['store_name']));
    $supportEmail = trim((string) ($_POST['support_email'] ?? $settings['support_email']));
    $currency = strtoupper(trim((string) ($_POST['currency'] ?? $settings['currency'])));
    $timezone = trim((string) ($_POST['timezone'] ?? $settings['timezone']));
    $threshold = (int) ($_POST['low_stock_threshold'] ?? $settings['low_stock_threshold']);

    if ($storeName === '') {
        $storeName = $defaultSettings['store_name'];
    }
    if (!filter_var($supportEmail, FILTER_VALIDATE_EMAIL)) {
        $supportEmail = $defaultSettings['support_email'];
    }
    if ($threshold < 1) {
        $threshold = 1;
    }
    if ($threshold > 500) {
        $threshold = 500;
    }

    $settings = [
        'store_name' => $storeName,
        'support_email' => $supportEmail,
        'currency' => $currency !== '' ? $currency : $defaultSettings['currency'],
        'timezone' => $timezone !== '' ? $timezone : $defaultSettings['timezone'],
        'low_stock_threshold' => $threshold,
        'maintenance_mode' => isset($_POST['maintenance_mode']),
        'email_notifications' => isset($_POST['email_notifications']),
        'sms_notifications' => isset($_POST['sms_notifications']),
        'weekly_digest' => isset($_POST['weekly_digest']),
    ];

    $ok = @file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    if ($ok === false) {
        $flash = 'Settings could not be saved. Check write permissions in the data folder.';
        $flashType = 'error';
    } else {
        $flash = 'Settings have been saved successfully.';
    }
}
?>

<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 430, 'GRAD' 0, 'opsz' 24; }
</style>

<div class="bg-background text-on-background min-h-screen">
  <aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
    <div class="mb-10 px-2">
      <h1 class="text-teal-900 font-black tracking-tighter text-2xl">Mpemba Heritage</h1>
      <p class="font-['Epilogue'] tracking-tight font-bold text-sm text-slate-500">Digital Atelier Console</p>
    </div>
    <nav class="flex-1 space-y-1">
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/index"><span class="material-symbols-outlined">dashboard</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Dashboard</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/inventory"><span class="material-symbols-outlined">inventory_2</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Inventory</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/orders"><span class="material-symbols-outlined">shopping_cart</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Orders</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/customers"><span class="material-symbols-outlined">group</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Users</span></a>
      <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-teal-800 transition-all duration-300 hover:bg-white rounded-lg" href="/admin/reports"><span class="material-symbols-outlined">analytics</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Analytics</span></a>
      <a class="flex items-center gap-3 px-4 py-3 bg-white text-teal-900 font-bold rounded-lg shadow-sm shadow-slate-200/50 scale-102 transition-transform duration-200" href="/admin/settings"><span class="material-symbols-outlined">settings</span><span class="font-['Epilogue'] tracking-tight font-bold text-lg">Settings</span></a>
    </nav>
    <div class="mt-auto space-y-2">
      <a class="group w-full bg-gradient-to-r from-primary via-primary-container to-primary text-on-primary py-3.5 px-4 rounded-xl font-black tracking-wide uppercase text-sm flex items-center justify-center gap-2 shadow-lg shadow-primary/25 border border-primary/20 hover:scale-[1.03] hover:shadow-xl hover:shadow-primary/35 transition-all duration-300" href="/admin/reports">
        <span class="material-symbols-outlined text-base group-hover:rotate-90 transition-transform duration-300">add</span>
        NEW REPORT
        <span class="text-[9px] px-1.5 py-0.5 rounded-full bg-white/20 border border-white/30">AI</span>
      </a>
      <a class="w-full bg-surface-container-high text-primary py-2.5 px-4 rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-colors" href="/admin/logout">
        <span class="material-symbols-outlined text-sm">logout</span>
        Logout
      </a>
    </div>
  </aside>

  <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search setting controls..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-6">
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">notifications</span></button>
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">help_outline</span></button>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right">
          <p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p>
          <p class="text-[10px] text-slate-400">Operations Lead</p>
        </div>
      </div>
    </div>
  </header>

  <main class="ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-8">
      <div>
        <h2 class="text-3xl font-black text-primary tracking-tight">Settings Hub</h2>
        <p class="text-on-surface-variant mt-1">Configure admin system, notifications, and business preferences.</p>
      </div>

      <?php if ($flash !== ''): ?>
        <div class="rounded-xl px-4 py-3 text-sm font-semibold <?php echo $flashType === 'error' ? 'bg-error-container text-on-error-container border border-error/20' : 'bg-teal-50 text-teal-700 border border-teal-200'; ?>">
          <?php echo htmlspecialchars($flash); ?>
        </div>
      <?php endif; ?>

      <form method="post" action="/admin/settings" class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <section class="xl:col-span-2 bg-surface-container-lowest rounded-2xl p-6 shadow-sm shadow-slate-200/40 space-y-5">
          <h3 class="text-lg font-black text-primary">General</h3>

          <label class="block">
            <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Store Name</span>
            <input name="store_name" value="<?php echo htmlspecialchars((string) $settings['store_name']); ?>" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="text" required />
          </label>

          <label class="block">
            <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Support Email</span>
            <input name="support_email" value="<?php echo htmlspecialchars((string) $settings['support_email']); ?>" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="email" required />
          </label>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Currency</span>
              <input name="currency" value="<?php echo htmlspecialchars((string) $settings['currency']); ?>" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="text" required />
            </label>
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Timezone</span>
              <input name="timezone" value="<?php echo htmlspecialchars((string) $settings['timezone']); ?>" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="text" required />
            </label>
          </div>

          <label class="block">
            <span class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Low Stock Threshold</span>
            <input name="low_stock_threshold" value="<?php echo (int) $settings['low_stock_threshold']; ?>" class="mt-2 w-full rounded-xl border border-outline-variant bg-surface-container-low px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20" type="number" min="1" max="500" required />
          </label>
        </section>

        <section class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm shadow-slate-200/40 space-y-4">
          <h3 class="text-lg font-black text-primary">Controls</h3>

          <label class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low border border-outline-variant/30">
            <span class="text-sm font-semibold text-primary">Maintenance Mode</span>
            <input type="checkbox" name="maintenance_mode" class="rounded border-outline-variant text-primary focus:ring-primary/20" <?php echo !empty($settings['maintenance_mode']) ? 'checked' : ''; ?> />
          </label>

          <label class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low border border-outline-variant/30">
            <span class="text-sm font-semibold text-primary">Email Notifications</span>
            <input type="checkbox" name="email_notifications" class="rounded border-outline-variant text-primary focus:ring-primary/20" <?php echo !empty($settings['email_notifications']) ? 'checked' : ''; ?> />
          </label>

          <label class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low border border-outline-variant/30">
            <span class="text-sm font-semibold text-primary">SMS Notifications</span>
            <input type="checkbox" name="sms_notifications" class="rounded border-outline-variant text-primary focus:ring-primary/20" <?php echo !empty($settings['sms_notifications']) ? 'checked' : ''; ?> />
          </label>

          <label class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low border border-outline-variant/30">
            <span class="text-sm font-semibold text-primary">Weekly Digest</span>
            <input type="checkbox" name="weekly_digest" class="rounded border-outline-variant text-primary focus:ring-primary/20" <?php echo !empty($settings['weekly_digest']) ? 'checked' : ''; ?> />
          </label>

          <button type="submit" class="w-full mt-2 bg-gradient-to-r from-primary to-primary-container text-on-primary py-3 rounded-xl font-black tracking-wide uppercase text-sm shadow-lg shadow-primary/25 hover:scale-[1.02] transition-transform">
            Save Settings
          </button>
        </section>
      </form>
    </div>
  </main>
</div>