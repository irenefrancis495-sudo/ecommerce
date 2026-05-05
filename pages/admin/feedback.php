<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';
$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'feedback';

$commentsFile = __DIR__ . '/../../data/customer_comments.json';
$comments = [];
if (file_exists($commentsFile)) {
    $comments = json_decode(file_get_contents($commentsFile), true) ?: [];
}
usort($comments, function ($a, $b) {
    return strtotime($b['created_at'] ?? '1970-01-01') <=> strtotime($a['created_at'] ?? '1970-01-01');
});
$totalComments   = count($comments);
$newComments     = count(array_filter($comments, fn($c) => ($c['status'] ?? '') === 'new'));
$repliedComments = count(array_filter($comments, fn($c) => ($c['status'] ?? '') === 'replied'));
$responseRate    = $totalComments > 0 ? round(($repliedComments / $totalComments) * 100, 1) : 0;
?>

<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }
    body {
        background:
            radial-gradient(circle at 8% 0%, rgba(20,184,166,.07) 0%, transparent 30%),
            radial-gradient(circle at 92% 12%, rgba(245,158,11,.07) 0%, transparent 32%),
            #f1f4f8;
    }
    .admin-shell { position: relative; }
    .admin-shell::before {
        content: ""; position: fixed; inset: 0; pointer-events: none;
        background-image: linear-gradient(rgba(148,163,184,.055) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(148,163,184,.055) 1px, transparent 1px);
        background-size: 44px 44px;
        mask-image: radial-gradient(ellipse at 50% 40%, black 0%, transparent 72%);
        z-index: 0;
    }
    .admin-sidebar { border-right: 1px solid rgba(255,255,255,.45); box-shadow: 0 24px 40px -32px rgba(15,23,42,.5); }
    .admin-topbar  { border-bottom: 1px solid rgba(255,255,255,.7); box-shadow: 0 12px 28px -24px rgba(15,23,42,.35); }
    .admin-main    { width: calc(100% - 16rem); }
    .admin-content { position: relative; z-index: 1; }
    .kpi-card { transition: transform .18s ease, box-shadow .18s ease; }
    .kpi-card:hover { transform: translateY(-3px); box-shadow: 0 20px 36px -18px rgba(15,23,42,.16); }
    .av-teal    { background:#0d9488; color:#fff; }
    .av-indigo  { background:#4f46e5; color:#fff; }
    .av-rose    { background:#e11d48; color:#fff; }
    .av-amber   { background:#d97706; color:#fff; }
    .av-violet  { background:#7c3aed; color:#fff; }
    .av-cyan    { background:#0891b2; color:#fff; }
    .av-lime    { background:#65a30d; color:#fff; }
    .av-fuchsia { background:#c026d3; color:#fff; }
    .fb-row { transition: background .12s; }
    .fb-row:hover { background: #f0f9ff; }
    .fb-row.is-new { border-left: 4px solid #f59e0b; }
    .reply-panel { background: linear-gradient(135deg,#f8fafc,#eff6ff); border: 1.5px solid #e0e7ff; border-radius: 1.25rem; }
    .reply-panel textarea {
        width: 100%; border: 1.5px solid #e2e8f0; border-radius: .875rem;
        padding: .875rem 1rem; font-size: .875rem; background: #fff;
        outline: none; transition: border-color .15s, box-shadow .15s; resize: vertical; min-height: 90px;
    }
    .reply-panel textarea:focus { border-color: #003345; box-shadow: 0 0 0 3px rgba(0,51,69,.08); }
    .rate-bar { height: 6px; border-radius: 99px; background: #e2e8f0; overflow: hidden; }
    .rate-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg,#0d9488,#06b6d4); }
    @media (max-width: 1024px) {
        .admin-sidebar { position:static; width:100%; height:auto; margin-bottom:1rem; }
        .admin-topbar  { position:static; left:auto; right:auto; width:100%; }
        .admin-main { width:100%; margin-left:0; }
        .admin-content { padding-top:1.25rem; }
    }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
    <?php require_once __DIR__ . '/_sidebar.php'; ?>

    <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
        <div class="flex items-center gap-6 w-1/2">
            <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-teal-900/10 rounded-xl">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                <input id="fbSearch" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2 pl-10 pr-4 text-sm focus:ring-0 focus:border-primary transition" placeholder="Search feedback by name or message..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Notifications">
                <span class="material-symbols-outlined">notifications</span>
                <?php if ($notificationCount > 0): ?>
                <span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span>
                <?php endif; ?>
            </a>
            <button class="text-slate-600 hover:text-amber-700 transition-colors" type="button"><span class="material-symbols-outlined">help_outline</span></button>
            <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
                <img alt="Admin" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
                <div class="text-right">
                    <p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p>
                    <p class="text-[10px] text-slate-400">Operations Lead</p>
                </div>
            </div>
        </div>
    </header>

    <main class="admin-main admin-content ml-64 pt-24 p-8 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Page header -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div>
                    <div class="flex items-center gap-1.5 text-xs text-slate-400 mb-1 font-semibold">
                        <span class="material-symbols-outlined text-sm">home</span>Admin
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                        <span class="text-primary">Feedback</span>
                    </div>
                    <h2 class="text-3xl font-black text-primary tracking-tight flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-amber-500 text-white shadow-lg shadow-amber-400/30">
                            <span class="material-symbols-outlined text-xl" style="font-variation-settings:'FILL' 1">rate_review</span>
                        </span>
                        Customer Feedback
                    </h2>
                    <p class="text-slate-500 mt-1 text-sm">Review and respond to customer comments and suggestions.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="flex bg-slate-100 rounded-xl p-1 gap-1">
                        <button class="fb-filter-tab px-4 py-1.5 rounded-lg text-xs font-bold bg-primary text-white shadow-sm transition-all" data-filter="all" type="button">
                            All <span class="ml-1 opacity-70"><?php echo $totalComments; ?></span>
                        </button>
                        <button class="fb-filter-tab px-4 py-1.5 rounded-lg text-xs font-bold text-slate-500 hover:text-primary transition-all" data-filter="new" type="button">
                            New <span class="ml-1 opacity-70"><?php echo $newComments; ?></span>
                        </button>
                        <button class="fb-filter-tab px-4 py-1.5 rounded-lg text-xs font-bold text-slate-500 hover:text-primary transition-all" data-filter="replied" type="button">
                            Replied <span class="ml-1 opacity-70"><?php echo $repliedComments; ?></span>
                        </button>
                    </div>
                    <button id="exportFbBtn" class="flex items-center gap-2 bg-secondary text-on-secondary px-5 py-2 rounded-xl text-sm font-bold shadow-lg shadow-secondary/20 hover:opacity-90 transition" type="button">
                        <span class="material-symbols-outlined text-base">download</span>
                        Export CSV
                    </button>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-amber-500 text-2xl" style="font-variation-settings:'FILL' 1">forum</span>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-primary leading-none"><?php echo $totalComments; ?></p>
                        <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Total</p>
                    </div>
                </div>
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-orange-500 text-2xl" style="font-variation-settings:'FILL' 1">mark_unread_chat_alt</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-baseline gap-2">
                            <p class="text-2xl font-black text-orange-600 leading-none"><?php echo $newComments; ?></p>
                            <?php if ($newComments > 0): ?><span class="inline-block w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span><?php endif; ?>
                        </div>
                        <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Unread</p>
                    </div>
                </div>
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-teal-600 text-2xl" style="font-variation-settings:'FILL' 1">mark_chat_read</span>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-teal-700 leading-none"><?php echo $repliedComments; ?></p>
                        <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wide">Replied</p>
                    </div>
                </div>
                <div class="kpi-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between gap-2">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Response Rate</p>
                        <span class="text-lg font-black text-primary"><?php echo $responseRate; ?>%</span>
                    </div>
                    <div class="rate-bar"><div class="rate-fill" style="width:<?php echo $responseRate; ?>%"></div></div>
                    <p class="text-[11px] text-slate-400"><?php echo $repliedComments; ?> of <?php echo $totalComments; ?> replied</p>
                </div>
            </div>

            <!-- Feedback Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-black text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-lg" style="font-variation-settings:'FILL' 1">rate_review</span>
                        All Feedback
                    </h3>
                    <p id="fbVisibleCount" class="text-xs font-bold text-slate-400">Showing <?php echo $totalComments; ?> item<?php echo $totalComments !== 1 ? 's' : ''; ?></p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Message</th>
                                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell">Date</th>
                                <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                                <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if (empty($comments)): ?>
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <span class="material-symbols-outlined text-5xl text-slate-200 block mb-3" style="font-variation-settings:'FILL' 1">rate_review</span>
                                    <p class="text-sm font-bold text-slate-400">No feedback yet</p>
                                    <p class="text-xs text-slate-300 mt-1">Customer comments will appear here once submitted.</p>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php
                                $avPalette = ['av-teal','av-indigo','av-rose','av-amber','av-violet','av-cyan','av-lime','av-fuchsia'];
                                foreach ($comments as $cidx => $comment):
                                    $name      = $comment['name'] ?? 'Anonymous';
                                    $email     = $comment['email'] ?? '';
                                    $message   = $comment['message'] ?? '';
                                    $status    = $comment['status'] ?? 'new';
                                    $createdAt = $comment['created_at'] ?? '';
                                    $initials  = strtoupper(substr($name, 0, 1) . substr(strrchr(' ' . $name, ' '), 1, 1));
                                    $avClass   = $avPalette[$cidx % count($avPalette)];
                                    $isNew     = $status === 'new';
                                    $isReplied = $status === 'replied';
                                ?>
                                <tr class="fb-row <?php echo $isNew ? 'is-new' : ''; ?>"
                                    data-status="<?php echo htmlspecialchars($status); ?>"
                                    data-name="<?php echo htmlspecialchars(strtolower($name)); ?>"
                                    data-message="<?php echo htmlspecialchars(strtolower($message)); ?>">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl <?php echo $avClass; ?> flex items-center justify-center text-[11px] font-black flex-shrink-0 shadow-sm">
                                                <?php echo htmlspecialchars(trim($initials) ?: strtoupper(substr($name,0,1))); ?>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-primary truncate"><?php echo htmlspecialchars($name); ?></p>
                                                <p class="text-xs text-slate-400 truncate"><?php echo htmlspecialchars($email); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 max-w-xs">
                                        <p class="text-sm text-slate-600 line-clamp-2"><?php echo htmlspecialchars(substr($message, 0, 110) . (strlen($message) > 110 ? '...' : '')); ?></p>
                                        <?php if (!empty($comment['reply'])): ?>
                                        <div class="mt-2 rounded-xl bg-teal-50 border border-teal-100 px-3 py-2">
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-teal-600 mb-1">Admin reply</p>
                                            <p class="text-xs text-slate-700 line-clamp-2"><?php echo htmlspecialchars($comment['reply']); ?></p>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-4 hidden md:table-cell">
                                        <p class="text-xs font-semibold text-slate-500"><?php echo $createdAt ? date('M d, Y', strtotime($createdAt)) : '-'; ?></p>
                                        <p class="text-[10px] text-slate-400"><?php echo $createdAt ? date('H:i', strtotime($createdAt)) : ''; ?></p>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <?php if ($isNew): ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-orange-50 text-orange-600 text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>New
                                            </span>
                                        <?php elseif ($isReplied): ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-teal-50 text-teal-700 text-[11px] font-bold">
                                                <span class="material-symbols-outlined" style="font-size:13px;font-variation-settings:'FILL' 1">check_circle</span>Replied
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[11px] font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>Read
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="toggleReplyForm(<?php echo (int)$comment['id']; ?>)"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-primary text-xs font-bold hover:bg-primary hover:text-white transition-all"
                                                type="button">
                                            <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">reply</span>
                                            <?php echo $isReplied ? 'Edit Reply' : 'Reply'; ?>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="reply-row-<?php echo (int)$comment['id']; ?>" class="hidden bg-slate-50/60">
                                    <td colspan="5" class="px-6 py-4">
                                        <div class="reply-panel p-5 flex flex-col gap-3">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-xl <?php echo $avClass; ?> flex items-center justify-center text-[10px] font-black flex-shrink-0">
                                                        <?php echo htmlspecialchars(trim($initials) ?: strtoupper(substr($name,0,1))); ?>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-primary">Reply to <?php echo htmlspecialchars($name); ?></p>
                                                        <p class="text-xs text-slate-400">Reply will be visible in their account feedback center.</p>
                                                    </div>
                                                </div>
                                                <button onclick="toggleReplyForm(<?php echo (int)$comment['id']; ?>)" class="text-slate-400 hover:text-slate-600 transition p-1" type="button">
                                                    <span class="material-symbols-outlined text-lg">close</span>
                                                </button>
                                            </div>
                                            <textarea id="reply-text-<?php echo (int)$comment['id']; ?>" placeholder="Write your reply here..."><?php echo htmlspecialchars($comment['reply'] ?? ''); ?></textarea>
                                            <div class="flex items-center justify-between gap-3">
                                                <p id="reply-status-<?php echo (int)$comment['id']; ?>" class="text-xs text-slate-400"></p>
                                                <button onclick="submitReply(<?php echo (int)$comment['id']; ?>)"
                                                        class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-2 text-sm font-bold text-white hover:bg-primary/90 shadow-md shadow-primary/20 transition"
                                                        type="button">
                                                    <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">send</span>
                                                    Send Reply
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 bg-slate-50 border-t border-slate-100">
                    <p class="text-xs text-slate-400 font-semibold"><?php echo $totalComments; ?> feedback item<?php echo $totalComments !== 1 ? 's' : ''; ?> total</p>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    function toggleReplyForm(id) {
        var row = document.getElementById('reply-row-' + id);
        if (!row) return;
        var isHidden = row.classList.contains('hidden');
        document.querySelectorAll('[id^="reply-row-"]').forEach(function(r) { r.classList.add('hidden'); });
        if (isHidden) row.classList.remove('hidden');
    }

    async function submitReply(id) {
        var textarea = document.getElementById('reply-text-' + id);
        var statusEl = document.getElementById('reply-status-' + id);
        if (!textarea || !statusEl) return;
        var reply = textarea.value.trim();
        if (!reply) {
            statusEl.textContent = 'Please enter a reply before sending.';
            statusEl.className = 'text-xs text-red-500 font-semibold';
            return;
        }
        statusEl.textContent = 'Saving...';
        statusEl.className = 'text-xs text-slate-400';
        try {
            var response = await fetch('/api/comments.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'reply', id: id, reply: reply })
            });
            var result = await response.json();
            if (result.status === 'success') {
                statusEl.textContent = 'Reply saved successfully.';
                statusEl.className = 'text-xs text-teal-600 font-semibold';
                setTimeout(function() { window.location.reload(); }, 800);
            } else {
                statusEl.textContent = result.message || 'Could not save reply.';
                statusEl.className = 'text-xs text-red-500 font-semibold';
            }
        } catch (err) {
            statusEl.textContent = 'Network error - please try again.';
            statusEl.className = 'text-xs text-red-500 font-semibold';
        }
    }

    var fbActiveFilter = 'all';
    function applyFbFilter() {
        var q = (document.getElementById('fbSearch') ? document.getElementById('fbSearch').value : '').toLowerCase().trim();
        var count = 0;
        document.querySelectorAll('.fb-row').forEach(function(row) {
            var statusMatch  = fbActiveFilter === 'all' || row.dataset.status === fbActiveFilter;
            var searchMatch  = !q || (row.dataset.name || '').includes(q) || (row.dataset.message || '').includes(q);
            var show = statusMatch && searchMatch;
            row.style.display = show ? '' : 'none';
            var replyRow = row.nextElementSibling;
            if (replyRow && replyRow.id && replyRow.id.startsWith('reply-row-') && !show) {
                replyRow.classList.add('hidden');
            }
            if (show) count++;
        });
        var el = document.getElementById('fbVisibleCount');
        if (el) el.textContent = 'Showing ' + count + ' item' + (count !== 1 ? 's' : '');
    }

    document.querySelectorAll('.fb-filter-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            fbActiveFilter = this.dataset.filter;
            document.querySelectorAll('.fb-filter-tab').forEach(function(b) {
                b.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                b.classList.add('text-slate-500');
            });
            this.classList.add('bg-primary', 'text-white', 'shadow-sm');
            this.classList.remove('text-slate-500');
            applyFbFilter();
        });
    });

    if (document.getElementById('fbSearch')) {
        document.getElementById('fbSearch').addEventListener('input', applyFbFilter);
    }

    document.getElementById('exportFbBtn') && document.getElementById('exportFbBtn').addEventListener('click', function() {
        var rows = document.querySelectorAll('.fb-row');
        var csv = ['Name,Email,Message,Date,Status'];
        rows.forEach(function(row) {
            if (row.style.display === 'none') return;
            var cells = row.querySelectorAll('td');
            var name    = (row.dataset.name || '').replace(/"/g, '""');
            var email   = (cells[0] ? cells[0].querySelector('p:last-child') ? cells[0].querySelector('p:last-child').textContent.trim() : '' : '').replace(/"/g, '""');
            var message = (row.dataset.message || '').replace(/"/g, '""');
            var date    = (cells[2] ? cells[2].textContent.trim().replace(/\s+/g, ' ') : '').replace(/"/g, '""');
            var status  = (row.dataset.status || '').replace(/"/g, '""');
            csv.push('"' + name + '","' + email + '","' + message + '","' + date + '","' + status + '"');
        });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([csv.join('\n')], { type: 'text/csv' }));
        a.download = 'feedback_export.csv';
        a.click();
    });
</script>
