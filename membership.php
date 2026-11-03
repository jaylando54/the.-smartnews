<?php
require_once 'includes/functions.php';
page_header('Membership');
?>
<section class="hero compact"><p class="eyebrow">RWANDA TODAY MEMBERSHIP</p><h1>Go beyond the headlines.</h1><p>Support independent reporting and read our special coverage.</p></section>
<div class="plans">
<div class="plan"><h2>Monthly</h2><p class="price">2,000 <small>RWF / month</small></p><p>Access all published premium reports while your membership is active.</p><a class="button" href="subscribe.php?plan=monthly">Choose monthly</a></div>
<div class="plan"><h2>Yearly</h2><p class="price"><?= number_format(YEARLY_PRICE_RWF) ?> <small>RWF / year*</small></p><p>Annual access to premium reports.</p><a class="button" href="subscribe.php?plan=yearly">Choose yearly</a><small>*Suggested placeholder price. Confirm before launch.</small></div>
</div><p class="notice">Payments: MTN Mobile Money or Airtel Money. Payment requests are recorded for administrator verification in this starter version.</p>
<?php page_footer(); ?>
