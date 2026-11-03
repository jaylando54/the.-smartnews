<?php
require_once 'includes/functions.php';
$admin = require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = filter_input(INPUT_POST, 'payment_id', FILTER_VALIDATE_INT);
    $action = $_POST['action'] ?? '';
    if ($id && in_array($action, ['approve','reject'], true)) {
        $pdo = db(); $pdo->beginTransaction();
        $q = $pdo->prepare("SELECT * FROM payment_requests WHERE id=? AND status='pending' FOR UPDATE");
        $q->execute([$id]); $p = $q->fetch();
        if ($p) {
            $status = $action === 'approve' ? 'approved' : 'rejected';
            $pdo->prepare('UPDATE payment_requests SET status=?, reviewed_by=?, reviewed_at=NOW() WHERE id=?')->execute([$status,$admin['id'],$id]);
            if ($action === 'approve') {
                $months = $p['plan'] === 'yearly' ? 12 : 1;
                $pdo->prepare("INSERT INTO subscriptions(user_id,plan,starts_at,ends_at,status) VALUES(?,?,NOW(),DATE_ADD(NOW(), INTERVAL ? MONTH),'active')")
                    ->execute([$p['user_id'],$p['plan'],$months]);
            }
        }
        $pdo->commit();
    }
    header('Location: admin.php'); exit;
}
$requests = db()->query("SELECT p.*,u.full_name,u.email FROM payment_requests p JOIN users u ON u.id=p.user_id WHERE p.status='pending' ORDER BY p.created_at")->fetchAll();
page_header('Admin dashboard');
?>
<h1>Payment verification</h1><p>Verify each transaction in the relevant mobile money merchant statement before approving it.</p>
<?php foreach ($requests as $p): ?><div class="card"><h3><?= e($p['full_name']) ?> · <?= number_format((int)$p['amount_rwf']) ?> RWF</h3><p><?= e($p['email']) ?> · <?= e($p['provider']) ?> · <?= e($p['phone']) ?></p><p>Reference: <b><?= e($p['transaction_reference']) ?></b> · <?= e($p['plan']) ?></p>
<form method="post" class="inline"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="payment_id" value="<?= (int)$p['id'] ?>"><button name="action" value="approve">Approve verified payment</button><button class="secondary" name="action" value="reject">Reject</button></form></div><?php endforeach; ?>
<?php if (!$requests): ?><p>No pending payment requests.</p><?php endif; ?>
<?php page_footer(); ?>
