<?php
require_once 'includes/functions.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim($_POST['email'] ?? ''));
    $q = db()->prepare('SELECT id,password_hash FROM users WHERE email=?');
    $q->execute([$email]); $u = $q->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password_hash'])) {
        session_regenerate_id(true); $_SESSION['user_id'] = (int)$u['id'];
        header('Location: account.php'); exit;
    }
    $error = 'Email or password is incorrect.';
}
page_header('Login');
?>
<div class="formbox"><h1>Welcome back</h1><?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Email address</label><input type="email" name="email" required autocomplete="email">
<label>Password</label><input type="password" name="password" required autocomplete="current-password">
<button>Log in</button></form><p>New here? <a href="register.php">Create an account</a>.</p></div>
<?php page_footer(); ?>
