<?php
require_once __DIR__ . '/../../config/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'admin/newsletters';

function readJsonArray(string $path): array {
    if (!file_exists($path)) {
        return [];
    }

    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

function slugToLabel(string $value): string {
    return ucwords(str_replace(['-', '_'], ' ', $value));
}

function buildNewsletter(array $products, int $subscriberCount, string $theme, string $ctaUrl, string $tone): array {
    $dateLabel = date('F j, Y');
    $activeProducts = array_values(array_filter($products, function ($product) {
        return strtolower((string) ($product['status'] ?? 'active')) === 'active';
    }));

    usort($activeProducts, function ($a, $b) {
        $featuredA = (int) ($a['featured'] ?? 0);
        $featuredB = (int) ($b['featured'] ?? 0);
        if ($featuredA !== $featuredB) {
            return $featuredB <=> $featuredA;
        }

        $ratingA = (float) ($a['rating'] ?? 0);
        $ratingB = (float) ($b['rating'] ?? 0);
        return $ratingB <=> $ratingA;
    });

    $highlights = array_slice($activeProducts, 0, 4);
    $themeLabel = slugToLabel($theme);

    $toneLine = 'Carefully selected new arrivals for your lifestyle.';
    if ($tone === 'premium') {
        $toneLine = 'Elevated, editorial picks curated for refined taste.';
    } elseif ($tone === 'friendly') {
        $toneLine = 'Fresh, practical picks we think you will love this week.';
    }

    $subject = 'Mpemba Weekly: ' . $themeLabel . ' Picks (' . date('M d') . ')';
    $preview = 'New highlights in ' . strtolower($themeLabel) . ', crafted for our ' . number_format($subscriberCount) . ' subscribers.';

    $htmlItems = '';
    $textItems = [];

    foreach ($highlights as $item) {
        $name = (string) ($item['name'] ?? 'Featured Product');
        $desc = trim((string) ($item['description'] ?? 'Discover this featured selection at Mpemba.'));
        $price = (float) ($item['price'] ?? 0);
        $category = slugToLabel((string) ($item['category'] ?? 'general'));

        $htmlItems .= '<tr>'
            . '<td style="padding:14px 0;border-bottom:1px solid #e2e8f0;">'
            . '<div style="font-size:16px;font-weight:800;color:#0f172a;">' . htmlspecialchars($name) . '</div>'
            . '<div style="font-size:12px;color:#475569;margin:4px 0 6px;">' . htmlspecialchars($category) . '</div>'
            . '<div style="font-size:13px;color:#334155;line-height:1.5;">' . htmlspecialchars($desc) . '</div>'
            . '<div style="margin-top:8px;font-size:14px;font-weight:700;color:#003345;">$' . number_format($price, 2) . '</div>'
            . '</td>'
            . '</tr>';

        $textItems[] = '- ' . $name . ' (' . $category . ') - $' . number_format($price, 2) . PHP_EOL . '  ' . $desc;
    }

    if ($htmlItems === '') {
        $htmlItems = '<tr><td style="padding:14px 0;color:#64748b;">No highlighted products available right now.</td></tr>';
        $textItems[] = '- No highlighted products available right now.';
    }

    $html = '<!doctype html>'
        . '<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>'
        . '<body style="margin:0;padding:0;background:#f1f5f9;font-family:Manrope,Segoe UI,Arial,sans-serif;color:#0f172a;">'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:24px 0;">'
        . '<tr><td align="center">'
        . '<table role="presentation" width="640" cellpadding="0" cellspacing="0" style="max-width:640px;width:100%;background:#ffffff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;">'
        . '<tr><td style="padding:28px;background:linear-gradient(135deg,#003345 0%,#0f766e 100%);color:#ffffff;">'
        . '<div style="font-size:12px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;opacity:.9;">Mpemba Heritage</div>'
        . '<h1 style="margin:10px 0 6px;font-size:28px;line-height:1.15;">' . htmlspecialchars($themeLabel) . ' Newsletter</h1>'
        . '<p style="margin:0;font-size:14px;opacity:.92;line-height:1.5;">' . htmlspecialchars($toneLine) . '</p>'
        . '</td></tr>'
        . '<tr><td style="padding:24px 28px;">'
        . '<p style="margin:0 0 14px;font-size:14px;color:#475569;">Published: ' . htmlspecialchars($dateLabel) . '</p>'
        . '<p style="margin:0 0 20px;font-size:15px;line-height:1.65;color:#1e293b;">Thank you for being part of our community of ' . number_format($subscriberCount) . ' subscribers. Here are this week\'s most notable picks.</p>'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0">' . $htmlItems . '</table>'
        . '<div style="margin-top:22px;">'
        . '<a href="' . htmlspecialchars($ctaUrl) . '" style="display:inline-block;padding:12px 18px;border-radius:10px;background:#003345;color:#ffffff;text-decoration:none;font-weight:800;">Shop Featured Picks</a>'
        . '</div>'
        . '</td></tr>'
        . '<tr><td style="padding:18px 28px;background:#f8fafc;border-top:1px solid #e2e8f0;color:#64748b;font-size:12px;line-height:1.6;">'
        . 'You are receiving this email because you subscribed to Mpemba updates.<br>Mpemba Heritage, Dar es Salaam, Tanzania'
        . '</td></tr>'
        . '</table>'
        . '</td></tr></table>'
        . '</body></html>';

    $text = "MPemba Heritage - " . $themeLabel . " Newsletter" . PHP_EOL
        . "Published: " . $dateLabel . PHP_EOL
        . "Subscribers: " . number_format($subscriberCount) . PHP_EOL . PHP_EOL
        . $toneLine . PHP_EOL . PHP_EOL
        . "Highlights:" . PHP_EOL
        . implode(PHP_EOL . PHP_EOL, $textItems) . PHP_EOL . PHP_EOL
        . "Shop now: " . $ctaUrl . PHP_EOL
        . "---" . PHP_EOL
        . "You are receiving this because you subscribed to Mpemba updates.";

    return [
        'subject' => $subject,
        'preview' => $preview,
        'theme' => $theme,
        'tone' => $tone,
        'cta_url' => $ctaUrl,
        'generated_at' => date('Y-m-d H:i:s'),
        'html' => $html,
        'text' => $text,
    ];
}

$subscribers = readJsonArray(__DIR__ . '/../../data/subscribers.json');
$products = readJsonArray(__DIR__ . '/../../data/products.json');

$subscriberCount = count($subscribers);
$activeProductsCount = count(array_filter($products, function ($product) {
    return strtolower((string) ($product['status'] ?? 'active')) === 'active';
}));

$theme = (string) ($_POST['theme'] ?? 'new-arrivals');
$tone = (string) ($_POST['tone'] ?? 'premium');
$ctaUrl = trim((string) ($_POST['cta_url'] ?? '/products'));
if ($ctaUrl === '') {
    $ctaUrl = '/products';
}
if (strpos($ctaUrl, '/') !== 0 && !preg_match('#^https?://#i', $ctaUrl)) {
    $ctaUrl = '/' . $ctaUrl;
}

$flash = '';
$generated = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (string) ($_POST['action'] ?? '') === 'generate') {
    $generated = buildNewsletter($products, $subscriberCount, $theme, $ctaUrl, $tone);

    $newslettersFile = __DIR__ . '/../../data/newsletters.json';
    $history = readJsonArray($newslettersFile);
    array_unshift($history, [
        'subject' => $generated['subject'],
        'preview' => $generated['preview'],
        'theme' => $generated['theme'],
        'tone' => $generated['tone'],
        'cta_url' => $generated['cta_url'],
        'generated_at' => $generated['generated_at'],
    ]);
    $history = array_slice($history, 0, 30);
    file_put_contents($newslettersFile, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    $flash = 'Newsletter ime-generate successfully.';
}

$newsletterHistory = readJsonArray(__DIR__ . '/../../data/newsletters.json');
?>

<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }

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

  .admin-topbar {
    border-bottom: 1px solid rgba(255, 255, 255, 0.7);
    box-shadow: 0 12px 28px -24px rgba(15, 23, 42, 0.35);
  }

  .admin-main { width: calc(100% - 16rem); }
  .admin-content { position: relative; z-index: 1; }

  @media (max-width: 1024px) {
    .admin-topbar { position: static; left: auto; right: auto; width: 100%; margin: 0 1rem 1rem; border-radius: 1rem; }
    .admin-main { width: 100%; margin-left: 0; }
    .admin-content { padding-top: 1.25rem; }
  }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-3">
      <span class="material-symbols-outlined text-primary">campaign</span>
      <h2 class="font-black text-primary text-xl tracking-tight">Newsletter Studio</h2>
    </div>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications">
        <span class="material-symbols-outlined">notifications</span>
        <?php if ($notificationCount > 0): ?>
        <span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span>
        <?php endif; ?>
      </a>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right">
          <p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p>
          <p class="text-[10px] text-slate-400">Campaign Manager</p>
        </div>
      </div>
    </div>
  </header>

  <main class="admin-main admin-content ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">
      <section class="rounded-3xl bg-white/80 border border-white/65 shadow-xl shadow-slate-300/25 p-7">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
          <div>
            <p class="text-[11px] tracking-[0.24em] uppercase text-slate-500 font-bold mb-2">Email Campaigns</p>
            <h3 class="text-3xl font-black text-primary tracking-tight mb-2">Generate Newsletter</h3>
            <p class="text-slate-500 max-w-2xl">Create newsletter from live catalog data in one click. Subject, preview text, HTML body, na plain text vinatengenezwa automatically.</p>
          </div>
          <div class="grid grid-cols-2 gap-3 min-w-[250px]">
            <div class="rounded-2xl bg-white border border-slate-200 px-4 py-3 text-center">
              <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Subscribers</p>
              <p class="text-2xl font-black text-primary"><?php echo number_format($subscriberCount); ?></p>
            </div>
            <div class="rounded-2xl bg-white border border-slate-200 px-4 py-3 text-center">
              <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Active Products</p>
              <p class="text-2xl font-black text-primary"><?php echo number_format($activeProductsCount); ?></p>
            </div>
          </div>
        </div>
      </section>

      <?php if ($flash !== ''): ?>
      <div class="rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-700 px-5 py-3 text-sm font-semibold">
        <?php echo htmlspecialchars($flash); ?>
      </div>
      <?php endif; ?>

      <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
          <h4 class="text-lg font-black text-primary mb-4">Generator Settings</h4>
          <form method="POST" class="space-y-4">
            <input type="hidden" name="action" value="generate">

            <div>
              <label class="block text-xs font-bold tracking-wider uppercase text-slate-500 mb-2">Theme</label>
              <select name="theme" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20">
                <option value="new-arrivals" <?php echo $theme === 'new-arrivals' ? 'selected' : ''; ?>>New Arrivals</option>
                <option value="top-rated" <?php echo $theme === 'top-rated' ? 'selected' : ''; ?>>Top Rated</option>
                <option value="seasonal-favorites" <?php echo $theme === 'seasonal-favorites' ? 'selected' : ''; ?>>Seasonal Favorites</option>
                <option value="editor-picks" <?php echo $theme === 'editor-picks' ? 'selected' : ''; ?>>Editor Picks</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold tracking-wider uppercase text-slate-500 mb-2">Tone</label>
              <select name="tone" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20">
                <option value="premium" <?php echo $tone === 'premium' ? 'selected' : ''; ?>>Premium</option>
                <option value="friendly" <?php echo $tone === 'friendly' ? 'selected' : ''; ?>>Friendly</option>
                <option value="direct" <?php echo $tone === 'direct' ? 'selected' : ''; ?>>Direct</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold tracking-wider uppercase text-slate-500 mb-2">CTA URL</label>
              <input name="cta_url" value="<?php echo htmlspecialchars($ctaUrl); ?>" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="/products" />
            </div>

            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-primary to-teal-700 text-white px-4 py-3 text-sm font-black tracking-wide uppercase shadow-lg shadow-primary/20 hover:opacity-95 transition-opacity">
              Generate Newsletter
            </button>
          </form>
        </div>

        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
          <h4 class="text-lg font-black text-primary mb-4">Generated Output</h4>
          <?php if ($generated === null): ?>
          <div class="rounded-2xl border border-dashed border-slate-300 p-10 text-center text-slate-500">
            <span class="material-symbols-outlined text-5xl opacity-40">mark_email_read</span>
            <p class="font-bold mt-2">No newsletter generated yet.</p>
            <p class="text-sm mt-1">Chagua settings upande wa kushoto kisha bonyeza Generate Newsletter.</p>
          </div>
          <?php else: ?>
          <div class="space-y-4">
            <div>
              <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold mb-1">Subject</p>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-800"><?php echo htmlspecialchars($generated['subject']); ?></div>
            </div>
            <div>
              <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold mb-1">Preview Text</p>
              <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700"><?php echo htmlspecialchars($generated['preview']); ?></div>
            </div>
            <div>
              <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold mb-1">Plain Text</p>
              <textarea readonly class="w-full h-56 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-700"><?php echo htmlspecialchars($generated['text']); ?></textarea>
            </div>
            <div>
              <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold mb-1">HTML</p>
              <textarea readonly class="w-full h-64 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-700"><?php echo htmlspecialchars($generated['html']); ?></textarea>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h4 class="text-lg font-black text-primary tracking-tight">Recent Generated Newsletters</h4>
          <span class="text-xs text-slate-500 font-semibold"><?php echo count($newsletterHistory); ?> records</span>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50/70 text-slate-500 text-xs uppercase tracking-wider">
                <th class="px-6 py-3 font-bold">Generated At</th>
                <th class="px-6 py-3 font-bold">Subject</th>
                <th class="px-6 py-3 font-bold">Theme</th>
                <th class="px-6 py-3 font-bold">Tone</th>
                <th class="px-6 py-3 font-bold">CTA</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($newsletterHistory)): ?>
              <tr>
                <td colspan="5" class="px-6 py-8 text-center text-slate-500">No generated newsletters yet.</td>
              </tr>
              <?php else: ?>
                <?php foreach ($newsletterHistory as $entry): ?>
                <tr class="border-t border-slate-100 hover:bg-slate-50/60 transition-colors">
                  <td class="px-6 py-3 text-sm text-slate-600"><?php echo htmlspecialchars((string) ($entry['generated_at'] ?? '-')); ?></td>
                  <td class="px-6 py-3 text-sm font-semibold text-slate-800"><?php echo htmlspecialchars((string) ($entry['subject'] ?? '-')); ?></td>
                  <td class="px-6 py-3 text-sm text-slate-600"><?php echo htmlspecialchars(slugToLabel((string) ($entry['theme'] ?? '-'))); ?></td>
                  <td class="px-6 py-3 text-sm text-slate-600"><?php echo htmlspecialchars(slugToLabel((string) ($entry['tone'] ?? '-'))); ?></td>
                  <td class="px-6 py-3 text-sm text-primary"><?php echo htmlspecialchars((string) ($entry['cta_url'] ?? '-')); ?></td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </main>
</div>
