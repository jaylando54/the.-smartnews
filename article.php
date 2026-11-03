<?php
require_once 'includes/functions.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$q = db()->prepare('SELECT * FROM articles WHERE id=? AND status="published"');
$q->execute([$id ?: 0]); $a = $q->fetch();
if (!$a) { http_response_code(404); page_header('Not found'); echo '<h1>Article not found</h1>'; page_footer(); exit; }
$allowed = !$a['is_premium'] || is_premium();
page_header($a['title']);
?>
<article class="article"><p class="meta"><?= e($a['category']) ?> · <?= e(date('d M Y', strtotime($a['created_at']))) ?></p><h1><?= e($a['title']) ?></h1><p class="lead"><?= e($a['summary'] ?? '') ?></p>
<?php if ($allowed): ?><div class="article-body"><?= nl2br(e($a['body'])) ?></div>
<?php else: ?><div class="paywall"><h2>This is a members-only report</h2><p>Create a free account, then choose a membership plan to read the complete report.</p><a class="button" href="register.php">Create free account</a> <a href="membership.php">View membership plans</a></div><?php endif; ?>
</article>
<?php page_footer(); ?>
