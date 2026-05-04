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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Messages - Mpemba Admin</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="/css/admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<?php include __DIR__ . '/_sidebar.php'; ?>

<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Messages</h4>
        <span class="text-muted">Welcome, <?= htmlspecialchars($adminName) ?></span>
    </div>

    <!-- Stats row -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center p-3 border-0 shadow-sm">
                <div class="fs-2 fw-bold text-primary"><?= $totalMessages ?></div>
                <div class="text-muted small">Total Messages</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 border-0 shadow-sm">
                <div class="fs-2 fw-bold text-danger"><?= $newMessages ?></div>
                <div class="text-muted small">Unread</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 border-0 shadow-sm">
                <div class="fs-2 fw-bold text-success"><?= $totalMessages - $newMessages ?></div>
                <div class="text-muted small">Read</div>
            </div>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?php if (empty($messages)): ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                    No contact messages yet.
                </div>
            <?php else: ?>
            <table id="messagesTable" class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($messages) as $msg): ?>
                    <tr class="<?= ($msg['status'] ?? 'new') === 'new' ? 'fw-semibold' : '' ?>">
                        <td><?= (int)$msg['id'] ?></td>
                        <td><?= htmlspecialchars($msg['name']) ?></td>
                        <td><?= htmlspecialchars($msg['email']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($msg['subject'])) ?></td>
                        <td><?= htmlspecialchars($msg['created_at'] ?? '-') ?></td>
                        <td>
                            <?php if (($msg['status'] ?? 'new') === 'new'): ?>
                                <span class="badge bg-danger">New</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Read</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- View button -->
                            <button class="btn btn-sm btn-outline-primary me-1"
                                data-bs-toggle="modal"
                                data-bs-target="#msgModal"
                                data-id="<?= (int)$msg['id'] ?>"
                                data-name="<?= htmlspecialchars($msg['name'], ENT_QUOTES) ?>"
                                data-email="<?= htmlspecialchars($msg['email'], ENT_QUOTES) ?>"
                                data-subject="<?= htmlspecialchars(ucfirst($msg['subject']), ENT_QUOTES) ?>"
                                data-message="<?= htmlspecialchars($msg['message'], ENT_QUOTES) ?>"
                                data-date="<?= htmlspecialchars($msg['created_at'] ?? '-', ENT_QUOTES) ?>">
                                <i class="fas fa-eye"></i>
                            </button>
                            <!-- Mark read -->
                            <?php if (($msg['status'] ?? 'new') === 'new'): ?>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="mark_read" value="<?= (int)$msg['id'] ?>" />
                                <button type="submit" class="btn btn-sm btn-outline-success me-1" title="Mark as read">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                            <!-- Delete -->
                            <form method="POST" class="d-inline delete-form">
                                <input type="hidden" name="delete_id" value="<?= (int)$msg['id'] ?>" />
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- View Message Modal -->
<div class="modal fade" id="msgModal" tabindex="-1" aria-labelledby="msgModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="msgModalLabel">Message Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>From:</strong> <span id="mName"></span> &lt;<span id="mEmail"></span>&gt;</p>
                <p><strong>Subject:</strong> <span id="mSubject"></span></p>
                <p><strong>Date:</strong> <span id="mDate"></span></p>
                <hr />
                <p id="mMessage" class="text-slate-700 whitespace-pre-wrap"></p>
            </div>
            <div class="modal-footer">
                <a id="mReply" href="#" class="btn btn-primary">
                    <i class="fas fa-reply me-1"></i>Reply via Email
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="/assets/jquery/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/DataTables/datatables.min.js"></script>
<script src="/assets/sweetalert2/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function () {
    $('#messagesTable').DataTable({ order: [[0, 'desc']], pageLength: 25 });

    // Populate modal
    $('#msgModal').on('show.bs.modal', function (e) {
        const btn = e.relatedTarget;
        $('#mName').text(btn.dataset.name);
        $('#mEmail').text(btn.dataset.email);
        $('#mSubject').text(btn.dataset.subject);
        $('#mMessage').text(btn.dataset.message);
        $('#mDate').text(btn.dataset.date);
        $('#mReply').attr('href', 'mailto:' + btn.dataset.email + '?subject=Re: ' + encodeURIComponent(btn.dataset.subject));
    });

    // Confirm delete
    $('.delete-form').on('submit', function (e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Delete this message?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, delete it'
        }).then(result => { if (result.isConfirmed) form.submit(); });
    });
});
</script>
</body>
</html>
