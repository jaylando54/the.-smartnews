<?php
require_once 'includes/functions.php';
$category = trim($_GET['category'] ?? '');
if ($category !== '') {
    $q = db()->prepare('SELECT id,title,summary,category,is_premium,created_at FROM articles WHERE status="published" AND category=? ORDER BY created_at DESC');
    $q->execute([$category]);
} else {
    $q = db()->query('SELECT id,title,summary,category,is_premium,created_at FROM articles WHERE status="published" ORDER BY created_at DESC');
}
$articles = $q->fetchAll();
page_header('Latest news');
?>
<section class="hero"><p class="eyebrow">NEWS · RWANDA · THE REGION · THE WORLD</p><h1>Stay informed.<br><span>Understand more.</span></h1><p>Latest news, trusted reporting and in-depth special coverage.</p></section>
<div class="section-title"><h2><?= $category ? e($category) : 'Latest stories' ?></h2><a href="membership.php">Explore membership →</a></div>
<div class="grid">
<?php foreach ($articles as $a): ?>
<article class="card">
  <div class="thumb"><?= $a['is_premium'] ? 'PREMIUM REPORT' : 'LATEST NEWS' ?></div>
  <p class="meta"><?= e($a['category']) ?> · <?= e(date('d M Y', strtotime($a['created_at']))) ?></p>
  <h3><a href="article.php?id=<?= (int)$a['id'] ?>"><?= e($a['title']) ?></a></h3>
  <p><?= e($a['summary'] ?? '') ?></p>
  <?php if ($a['is_premium']): ?><span class="tag">MEMBERS ONLY</span><?php else: ?><span class="tag free">FREE</span><?php endif; ?>
</article>
<?php endforeach; ?>
<?php if (!$articles): ?><p>No published articles yet. Add stories from the database or admin tools.</p><?php endif; ?>
</div>
<?php page_footer(); ?>
