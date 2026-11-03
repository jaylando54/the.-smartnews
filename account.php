<?php
require_once 'includes/functions.php';
$u = require_login();
page_header('My account');
?>
<div class="formbox"><h1>Hello, <?= e($u['full_name']) ?></h1><p><?= e($u['email']) ?></p>
<?php if (is_premium()): ?><p class="success">Your premium membership is active.</p><?php else: ?><p>You have a free account. Subscribe to read members-only reports.</p><a class="button" href="membership.php">View membership</a><?php endif; ?>
</div>
<?php page_footer(); ?>
