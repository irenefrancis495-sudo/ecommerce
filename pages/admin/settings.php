<?php
require_once __DIR__ . '/../../config/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'settings';
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

  body {
    background:
      radial-gradient(circle at 10% 0%, rgba(20, 184, 166, 0.08) 0%, transparent 30%),
      radial-gradient(circle at 100% 20%, rgba(245, 158, 11, 0.08) 0%, transparent 35%),
      #f5f7fb;
  }

  .admin-shell { position: relative; }
  .admin-shell::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background-image: linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
    background-size: 42px 42px;
    mask-image: radial-gradient(circle at center, black, transparent 78%);
    z-index: 0;
  }

  .surface-glass {
    background: rgba(255, 255, 255, 0.74);
    backdrop-filter: blur(16px);
  }

  .admin-sidebar {
    border-right: 1px solid rgba(255, 255, 255, 0.45);
    box-shadow: 0 24px 40px -32px rgba(15, 23, 42, 0.5);
  }

  .admin-topbar {
    border-bottom: 1px solid rgba(255, 255, 255, 0.7);
    box-shadow: 0 12px 28px -24px rgba(15, 23, 42, 0.35);
  }

  .admin-main { width: calc(100% - 16rem); }
  .admin-content { position: relative; z-index: 1; }

  @media (max-width: 1024px) {
    .admin-sidebar { position: static; width: 100%; height: auto; margin-bottom: 1rem; }
    .admin-topbar { position: static; left: auto; right: auto; width: 100%; margin: 0 1rem 1rem; border-radius: 1rem; }
    .admin-main { width: 100%; margin-left: 0; }
    .admin-content { padding-top: 1.25rem; }
  }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search setting controls..." type="text" />
      </div>
    </div>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications"><span class="material-symbols-outlined">notifications</span><?php if ($notificationCount > 0): ?><span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span><?php endif; ?></a>
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">help_outline</span></button>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin" />
        <div class="text-right">
          <p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p>
          <p class="text-[10px] text-slate-400">Operations Lead</p>
        </div>
      </div>
    </div>
  </header>

  <main class="admin-main admin-content ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-8">
      <div>
        <h2 class="text-3xl font-black text-primary tracking-tight">Settings Hub</h2>
        <p class="text-on-surface-variant mt-1">Configure admin system, notifications, and business preferences.</p>
      </div>

      <style>
        .status-card { transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
        .status-card:hover { transform: translateY(-2px); box-shadow: 0 12px 28px -8px rgba(15,23,42,.12); border-color: rgba(15,23,42,.06); }
        .toggle-switch { appearance: none; width: 48px; height: 28px; background: #e2e8f0; border-radius: 9999px; cursor: pointer; position: relative; transition: background .2s; }
        .toggle-switch:checked { background: #0f766e; }
        .toggle-switch::after { content: ''; position: absolute; width: 24px; height: 24px; background: white; border-radius: 50%; top: 2px; left: 2px; transition: left .2s; }
        .toggle-switch:checked::after { left: 22px; }
      </style>
      <div class="grid gap-4 md:grid-cols-3">
        <div class="status-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div class="flex items-start justify-between gap-4 mb-3">
            <div>
              <p class="text-xs uppercase tracking-widest font-bold text-slate-400">System Status</p>
              <p class="text-2xl font-black text-primary mt-2 leading-none"><?php echo !empty($settings['maintenance_mode']) ? 'Maintenance' : 'Live'; ?></p>
            </div>
            <div class="w-12 h-12 rounded-2xl <?php echo !empty($settings['maintenance_mode']) ? 'bg-orange-50' : 'bg-emerald-50'; ?> flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-2xl <?php echo !empty($settings['maintenance_mode']) ? 'text-orange-600' : 'text-emerald-600'; ?>" style="font-variation-settings:'FILL' 1"><?php echo !empty($settings['maintenance_mode']) ? 'warning' : 'check_circle'; ?></span>
            </div>
          </div>
          <p class="text-xs text-slate-500">Storefront <?php echo !empty($settings['maintenance_mode']) ? 'paused for maintenance' : 'accepting orders'; ?></p>
        </div>

        <div class="status-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div class="flex items-start justify-between gap-4 mb-3">
            <div>
              <p class="text-xs uppercase tracking-widest font-bold text-slate-400">Notifications</p>
              <p class="text-2xl font-black text-primary mt-2 leading-none"><?php echo !empty($settings['email_notifications']) || !empty($settings['sms_notifications']) ? 'Enabled' : 'Off'; ?></p>
            </div>
            <div class="w-12 h-12 rounded-2xl <?php echo !empty($settings['email_notifications']) || !empty($settings['sms_notifications']) ? 'bg-blue-50' : 'bg-slate-100'; ?> flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-2xl <?php echo !empty($settings['email_notifications']) || !empty($settings['sms_notifications']) ? 'text-blue-600' : 'text-slate-400'; ?>" style="font-variation-settings:'FILL' 1">notifications<?php echo !empty($settings['email_notifications']) || !empty($settings['sms_notifications']) ? '_active' : '_off'; ?></span>
            </div>
          </div>
          <p class="text-xs text-slate-500"><?php echo !empty($settings['email_notifications']) ? 'Email ' : ''; ?><?php echo !empty($settings['sms_notifications']) ? 'SMS' : ''; ?><?php echo !empty($settings['email_notifications']) || !empty($settings['sms_notifications']) ? ' active' : 'All alerts disabled'; ?></p>
        </div>

        <div class="status-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
          <div class="flex items-start justify-between gap-4 mb-3">
            <div>
              <p class="text-xs uppercase tracking-widest font-bold text-slate-400">Weekly Digest</p>
              <p class="text-2xl font-black text-primary mt-2 leading-none"><?php echo !empty($settings['weekly_digest']) ? 'Enabled' : 'Off'; ?></p>
            </div>
            <div class="w-12 h-12 rounded-2xl <?php echo !empty($settings['weekly_digest']) ? 'bg-purple-50' : 'bg-slate-100'; ?> flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-2xl <?php echo !empty($settings['weekly_digest']) ? 'text-purple-600' : 'text-slate-400'; ?>" style="font-variation-settings:'FILL' 1">calendar_month</span>
            </div>
          </div>
          <p class="text-xs text-slate-500"><?php echo !empty($settings['weekly_digest']) ? 'Sunday summaries' : 'No weekly reports'; ?></p>
        </div>
      </div>

      <?php if ($flash !== ''): ?>
        <div class="rounded-lg px-4 py-3 text-sm font-semibold flex items-center gap-3 <?php echo $flashType === 'error' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200'; ?>">
          <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1"><?php echo $flashType === 'error' ? 'error' : 'check_circle'; ?></span>
          <?php echo htmlspecialchars($flash); ?>
        </div>
      <?php endif; ?>

      <form method="post" action="/admin/settings" class="grid grid-cols-1 xl:grid-cols-5 gap-6">
        <section class="xl:col-span-3 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 space-y-5">
          <div class="flex items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
              <h3 class="text-lg font-black text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600" style="font-variation-settings:'FILL' 1">store</span>
                General Settings
              </h3>
              <p class="text-xs text-slate-500 mt-1">Store identity, support, currency, and timezone</p>
            </div>
          </div>

          <label class="block">
            <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Store Name</span>
            <input name="store_name" value="<?php echo htmlspecialchars((string) $settings['store_name']); ?>" class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="text" required />
          </label>

          <label class="block">
            <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Support Email</span>
            <input name="support_email" value="<?php echo htmlspecialchars((string) $settings['support_email']); ?>" class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="email" required />
          </label>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Currency</span>
              <input name="currency" value="<?php echo htmlspecialchars((string) $settings['currency']); ?>" class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="text" required />
            </label>
            <label class="block">
              <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Timezone</span>
              <input name="timezone" value="<?php echo htmlspecialchars((string) $settings['timezone']); ?>" class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="text" required />
            </label>
          </div>

          <label class="block">
            <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Low Stock Threshold</span>
            <input name="low_stock_threshold" value="<?php echo (int) $settings['low_stock_threshold']; ?>" class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="number" min="1" max="500" required />
          </label>
        </section>

        <section class="xl:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 space-y-4">
          <div class="flex items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <h3 class="text-lg font-black text-primary flex items-center gap-2">
              <span class="material-symbols-outlined text-purple-600" style="font-variation-settings:'FILL' 1">notifications</span>
              Controls
            </h3>
          </div>

          <label class="flex items-start justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-colors cursor-pointer">
            <div>
              <p class="text-sm font-bold text-slate-700">Maintenance Mode</p>
              <p class="text-xs text-slate-500 mt-1">Pause customer access for updates</p>
            </div>
            <style>
              .toggle-switch { appearance: none; width: 48px; height: 28px; background: #e2e8f0; border-radius: 9999px; cursor: pointer; position: relative; transition: background .2s; }
              .toggle-switch:checked { background: #0f766e; }
              .toggle-switch::after { content: ''; position: absolute; width: 24px; height: 24px; background: white; border-radius: 50%; top: 2px; left: 2px; transition: left .2s; }
              .toggle-switch:checked::after { left: 22px; }
            </style>
            <input type="checkbox" name="maintenance_mode" class="toggle-switch flex-shrink-0" <?php echo !empty($settings['maintenance_mode']) ? 'checked' : ''; ?> />
          </label>

          <label class="flex items-start justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-colors cursor-pointer">
            <div>
              <p class="text-sm font-bold text-slate-700">Email Notifications</p>
              <p class="text-xs text-slate-500 mt-1">Orders, refunds, stock alerts</p>
            </div>
            <input type="checkbox" name="email_notifications" class="toggle-switch flex-shrink-0" <?php echo !empty($settings['email_notifications']) ? 'checked' : ''; ?> />
          </label>

          <label class="flex items-start justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-colors cursor-pointer">
            <div>
              <p class="text-sm font-bold text-slate-700">SMS Notifications</p>
              <p class="text-xs text-slate-500 mt-1">Urgent shipping & stock alerts</p>
            </div>
            <input type="checkbox" name="sms_notifications" class="toggle-switch flex-shrink-0" <?php echo !empty($settings['sms_notifications']) ? 'checked' : ''; ?> />
          </label>

          <label class="flex items-start justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition-colors cursor-pointer">
            <div>
              <p class="text-sm font-bold text-slate-700">Weekly Digest</p>
              <p class="text-xs text-slate-500 mt-1">Summary of orders & stock</p>
            </div>
            <input type="checkbox" name="weekly_digest" class="toggle-switch flex-shrink-0" <?php echo !empty($settings['weekly_digest']) ? 'checked' : ''; ?> />
          </label>

          <button type="submit" class="w-full mt-4 bg-gradient-to-r from-primary to-teal-600 text-white py-2.5 rounded-lg font-bold text-sm shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 transition-all duration-200 uppercase tracking-wide flex items-center justify-center gap-2">
            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1">save</span>
            Save Settings
          </button>
        </section>
      </form>
    </div>
  </main>
</div>
<script src="/js/admin.js"></script>