<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';

$file = __DIR__ . '/../../data/contact_messages.json';
$messages = [];
if (file_exists($file)) {
    $messages = json_decode(file_get_contents($file), true) ?: [];
}

// Mark as read
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read'])) {
    $id = (int) $_POST['mark_read'];
    foreach ($messages as &$msg) {
        if ($msg['id'] === $id) {
            $msg['status'] = 'read';
        }
    }
    unset($msg);
    file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));
    header('Location: /admin/messages');
    exit;
}

// Delete message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    $messages = array_values(array_filter($messages, fn($m) => $m['id'] !== $id));
    file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));
    header('Location: /admin/messages');
    exit;
}

$totalMessages = count($messages);
$newMessages   = count(array_filter($messages, fn($m) => ($m['status'] ?? 'new') === 'new'));
$readMessages  = $totalMessages - $newMessages;
$notificationCount = $newMessages;
$subjectLabels = ['general'=>'General Inquiry','order'=>'Order & Shipping','return'=>'Returns & Refunds','artisan'=>'Artisan Partnership','media'=>'Media & Press','other'=>'Other'];
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
  <!-- Sidebar -->
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <!-- Top Bar -->
  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <div class="flex items-center gap-6 w-1/2">
      <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-lg">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input id="globalSearch" class="w-full bg-slate-50 border-none rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-0" placeholder="Search messages..." type="text"/>
      </div>
    </div>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications">
        <span class="material-symbols-outlined">notifications</span>
        <?php if ($notificationCount > 0): ?>
        <span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?= $notificationCount > 99 ? '99+' : $notificationCount ?></span>
        <?php endif; ?>
      </a>
      <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">help_outline</span></button>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right">
          <p class="text-xs font-bold text-teal-900"><?= htmlspecialchars($adminName) ?></p>
          <p class="text-[10px] text-slate-400">Operations Lead</p>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="admin-main admin-content ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
          <h2 class="text-3xl font-black text-primary tracking-tight">Contact Messages</h2>
          <p class="text-on-surface-variant mt-1">Incoming messages from the Contact Us page.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
          <div class="flex bg-surface-container rounded-full p-1">
            <button onclick="filterTable('all')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold bg-primary text-on-primary shadow-sm" data-filter="all">All</button>
            <button onclick="filterTable('new')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-colors" data-filter="new">Unread</button>
            <button onclick="filterTable('read')" class="filter-btn px-4 py-1.5 rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-colors" data-filter="read">Read</button>
          </div>
          <a href="/contact" target="_blank" class="flex items-center gap-1.5 bg-surface-container-high px-4 py-2 rounded-xl text-sm font-semibold text-primary hover:bg-surface-container-highest transition-colors">
            <span class="material-symbols-outlined text-base">open_in_new</span> View Form
          </a>
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Total</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-primary/10"><span class="material-symbols-outlined text-primary text-lg">mail</span></span></div>
          <p class="text-3xl font-black text-primary"><?= $totalMessages ?></p>
          <p class="text-xs text-on-surface-variant mt-1">All messages</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Unread</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50"><span class="material-symbols-outlined text-red-500 text-lg">mark_email_unread</span></span></div>
          <p class="text-3xl font-black text-red-500"><?= $newMessages ?></p>
          <p class="text-xs text-on-surface-variant mt-1">Need attention</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Read</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-green-50"><span class="material-symbols-outlined text-green-600 text-lg">mark_email_read</span></span></div>
          <p class="text-3xl font-black text-green-600"><?= $readMessages ?></p>
          <p class="text-xs text-on-surface-variant mt-1">Reviewed</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm shadow-slate-200/50 border border-slate-100">
          <div class="flex items-center justify-between mb-3"><span class="text-on-surface-variant text-sm font-semibold">Response Rate</span><span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-cyan-50"><span class="material-symbols-outlined text-cyan-600 text-lg">trending_up</span></span></div>
          <p class="text-3xl font-black text-cyan-600"><?= $totalMessages > 0 ? round(($readMessages / $totalMessages) * 100) : 0 ?>%</p>
          <p class="text-xs text-on-surface-variant mt-1">Read ratio</p>
        </div>
      </div>

      <!-- Inbox -->
      <div class="bg-white rounded-2xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
          <h3 class="font-black text-on-surface text-lg">Inbox</h3>
          <span class="text-xs text-on-surface-variant"><?= $totalMessages ?> total</span>
        </div>
        <?php if (empty($messages)): ?>
        <div class="flex flex-col items-center justify-center py-20 text-on-surface-variant">
          <span class="material-symbols-outlined text-6xl mb-4 opacity-30">inbox</span>
          <p class="font-bold text-lg">No messages yet</p>
          <p class="text-sm mt-1">Contact form submissions will appear here.</p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-slate-50" id="messagesList">
          <?php foreach (array_reverse($messages) as $msg):
            $isNew = ($msg['status'] ?? 'new') === 'new';
            $subjectLabel = $subjectLabels[$msg['subject'] ?? ''] ?? ucfirst($msg['subject'] ?? 'General');
            $badgeMap = ['general'=>'bg-blue-50 text-blue-700','order'=>'bg-amber-50 text-amber-700','return'=>'bg-orange-50 text-orange-700','artisan'=>'bg-emerald-50 text-emerald-700','media'=>'bg-purple-50 text-purple-700','other'=>'bg-slate-100 text-slate-600'];
            $badgeClass = $badgeMap[$msg['subject'] ?? 'other'] ?? 'bg-slate-100 text-slate-600';
            $nameParts = explode(' ', $msg['name']);
            $initials = strtoupper(substr($nameParts[0], 0, 1) . (count($nameParts) > 1 ? substr(end($nameParts), 0, 1) : ''));
            $msgJson = htmlspecialchars(json_encode(['id'=>(int)$msg['id'],'name'=>$msg['name'],'email'=>$msg['email'],'subject'=>$subjectLabel,'message'=>$msg['message'],'date'=>$msg['created_at']??'-','status'=>$msg['status']??'new']), ENT_QUOTES);
          ?>
          <div class="message-row flex items-start gap-4 px-6 py-4 hover:bg-slate-50/70 transition-colors cursor-pointer <?= $isNew ? 'bg-blue-50/30' : '' ?>"
               data-status="<?= $msg['status'] ?? 'new' ?>"
               onclick="openMessage(<?= $msgJson ?>)">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-primary to-cyan-500 flex items-center justify-center text-white font-black text-sm"><?= htmlspecialchars($initials) ?></div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 flex-wrap">
                <span class="font-bold <?= $isNew ? 'text-teal-900' : 'text-slate-700' ?>"><?= htmlspecialchars($msg['name']) ?></span>
                <?php if ($isNew): ?><span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10px] font-bold"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>NEW</span><?php endif; ?>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $badgeClass ?>"><?= $subjectLabel ?></span>
              </div>
              <p class="text-sm text-on-surface-variant truncate mt-0.5"><?= htmlspecialchars($msg['email']) ?></p>
              <p class="text-sm text-slate-500 truncate mt-0.5 max-w-xl"><?= htmlspecialchars($msg['message']) ?></p>
            </div>
            <div class="flex-shrink-0 flex flex-col items-end gap-2">
              <span class="text-xs text-on-surface-variant whitespace-nowrap"><?= date('M d, Y', strtotime($msg['created_at'] ?? 'now')) ?></span>
              <div class="flex items-center gap-1.5" onclick="event.stopPropagation()">
                <?php if ($isNew): ?>
                <form method="POST"><input type="hidden" name="mark_read" value="<?= (int)$msg['id'] ?>" /><button type="submit" title="Mark as read" class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 transition-colors"><span class="material-symbols-outlined text-sm">check</span></button></form>
                <?php endif; ?>
                <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= rawurlencode($subjectLabel) ?>" title="Reply" class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"><span class="material-symbols-outlined text-sm">reply</span></a>
                <form method="POST" class="delete-form"><input type="hidden" name="delete_id" value="<?= (int)$msg['id'] ?>" /><button type="submit" title="Delete" class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors"><span class="material-symbols-outlined text-sm">delete</span></button></form>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
</div>

<!-- Message Detail Drawer -->
<div id="msgDrawer" class="fixed inset-y-0 right-0 w-full max-w-lg bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 flex flex-col">
  <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
    <h3 class="font-black text-on-surface text-lg">Message Details</h3>
    <button onclick="closeDrawer()" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors"><span class="material-symbols-outlined">close</span></button>
  </div>
  <div class="flex-1 overflow-y-auto p-6 space-y-6">
    <div class="flex items-center gap-4">
      <div id="dAvatar" class="w-14 h-14 rounded-full bg-gradient-to-br from-primary to-cyan-500 flex items-center justify-center text-white font-black text-xl"></div>
      <div><p id="dName" class="font-black text-on-surface text-lg"></p><a id="dEmail" href="#" class="text-sm text-primary hover:underline"></a></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div class="bg-slate-50 rounded-xl p-4"><p class="text-xs text-on-surface-variant mb-1">Subject</p><p id="dSubject" class="font-bold text-on-surface text-sm"></p></div>
      <div class="bg-slate-50 rounded-xl p-4"><p class="text-xs text-on-surface-variant mb-1">Date</p><p id="dDate" class="font-bold text-on-surface text-sm"></p></div>
    </div>
    <div class="bg-slate-50 rounded-xl p-5">
      <p class="text-xs text-on-surface-variant mb-3 font-semibold uppercase tracking-wide">Message</p>
      <p id="dMessage" class="text-on-surface text-sm leading-relaxed whitespace-pre-wrap"></p>
    </div>
  </div>
  <div class="px-6 py-4 border-t border-slate-100 flex gap-3">
    <a id="dReply" href="#" class="flex-1 flex items-center justify-center gap-2 bg-primary text-on-primary py-2.5 rounded-xl font-bold text-sm hover:bg-primary/90 transition-colors"><span class="material-symbols-outlined text-base">reply</span>Reply via Email</a>
    <button onclick="closeDrawer()" class="px-4 py-2.5 rounded-xl bg-surface-container-high text-on-surface font-bold text-sm hover:bg-surface-container-highest transition-colors">Close</button>
  </div>
</div>
<div id="drawerOverlay" onclick="closeDrawer()" class="fixed inset-0 bg-black/30 z-40 hidden"></div>

<script src="/assets/sweetalert2/sweetalert2.all.min.js"></script>
<script>
function openMessage(data) {
    const parts = data.name.trim().split(' ');
    const initials = (parts[0].charAt(0) + (parts.length > 1 ? parts[parts.length-1].charAt(0) : '')).toUpperCase();
    document.getElementById('dAvatar').textContent  = initials;
    document.getElementById('dName').textContent    = data.name;
    document.getElementById('dEmail').textContent   = data.email;
    document.getElementById('dEmail').href          = 'mailto:' + data.email;
    document.getElementById('dSubject').textContent = data.subject;
    document.getElementById('dDate').textContent    = data.date;
    document.getElementById('dMessage').textContent = data.message;
    document.getElementById('dReply').href          = 'mailto:' + data.email + '?subject=Re: ' + encodeURIComponent(data.subject);
    document.getElementById('msgDrawer').classList.remove('translate-x-full');
    document.getElementById('drawerOverlay').classList.remove('hidden');
}
function closeDrawer() {
    document.getElementById('msgDrawer').classList.add('translate-x-full');
    document.getElementById('drawerOverlay').classList.add('hidden');
}
function filterTable(filter) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        const active = btn.dataset.filter === filter;
        btn.classList.toggle('bg-primary', active);
        btn.classList.toggle('text-on-primary', active);
        btn.classList.toggle('shadow-sm', active);
        btn.classList.toggle('text-on-surface-variant', !active);
    });
    document.querySelectorAll('.message-row').forEach(row => {
        row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
    });
}
document.getElementById('globalSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.message-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const f = this;
        Swal.fire({ title: 'Delete this message?', text: 'This cannot be undone.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Yes, delete' })
            .then(r => { if (r.isConfirmed) f.submit(); });
    });
});
</script>
