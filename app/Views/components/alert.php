<?php if (!empty($message)): ?>
<div class="alert alert--<?= htmlspecialchars($type ?? 'info') ?>">
    <?= htmlspecialchars($message) ?>
</div>
<?php endif ?>
