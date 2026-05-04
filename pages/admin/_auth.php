<?php
if (empty($_SESSION['admin_logged_in'])) {
    echo '<script>window.location.href="/admin/login";</script>';
    return;
}
