<?php
require_once 'includes/functions.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 10) {
        $error = 'Enter your name, a valid email and a password of at least 10 characters.';
    } else {
        try {
            $q = db()->prepare('INSERT INTO users(full_name,email,password_hash) VALUES(?,?,?)');
            $q->execute([$name,$email,password_hash($password, PASSWORD_DEFAULT)]);
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)db()->lastInsertId();
            header('Location: account.php'); exit;
        } catch (PDOException $ex) { $error = 'That email may already be registered.'; }
    }
}
page_header('Create account');
?>
<div class="formbox"><h1>Create your free account</h1><p>Register to save your preferences and access member reports after subscribing.</p>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Full name</label><input name="full_name" required maxlength="120" autocomplete="name">
<label>Email address</label><input type="email" name="email" required autocomplete="email">
<label>Password (at least 10 characters)</label><input type="password" name="password" required minlength="10" autocomplete="new-password">
<button>Create account</button></form><p>Already registered? <a href="login.php">Log in</a>.</p></div>
<?php page_footer(); ?>
