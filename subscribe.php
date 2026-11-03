<?php
require_once 'includes/functions.php';
$u = require_login();
$plan = $_GET['plan'] ?? 'monthly';
if (!in_array($plan, ['monthly','yearly'], true)) $plan = 'monthly';
$amount = $plan === 'monthly' ? MONTHLY_PRICE_RWF : YEARLY_PRICE_RWF;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $provider = $_POST['provider'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $reference = trim($_POST['reference'] ?? '');
    if (!in_array($provider, ['MTN','Airtel'], true) || !preg_match('/^[0-9+ ]{9,16}$/', $phone) || $reference === '') {
        $error = 'Enter a valid mobile money number and payment transaction reference.';
    } else {
        $q = db()->prepare("INSERT INTO payment_requests(user_id,plan,amount_rwf,provider,phone,transaction_reference,status) VALUES(?,?,?,?,?,?,'pending')");
        $q->execute([$u['id'],$plan,$amount,$provider,$phone,$reference]);
        header('Location: account.php?payment=pending'); exit;
    }
}
page_header('Payment verification');
?>
<div class="formbox"><h1>Request membership</h1><p>Plan: <b><?= e(ucfirst($plan)) ?></b> · Amount: <b><?= number_format($amount) ?> RWF</b></p>
<p>1. Send the exact amount using your MTN or Airtel Money service to the official Rwanda Today merchant number supplied by the site administrator.</p>
<p>2. Enter the payment transaction reference below. Do not share your mobile money PIN or OTP.</p>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Payment provider</label><select name="provider"><option value="MTN">MTN Mobile Money</option><option value="Airtel">Airtel Money</option></select>
<label>Your mobile money number</label><input name="phone" required placeholder="e.g. 07XXXXXXXX">
<label>Transaction reference / ID</label><input name="reference" required maxlength="100">
<button>Submit for verification</button></form><p><a href="membership.php">Back to plans</a></p></div>
<?php page_footer(); ?>
