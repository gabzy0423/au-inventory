<?php if (!empty($show)): ?>
<div class="modal">
    <div class="modal__content">
        <h2><?= htmlspecialchars($title ?? '') ?></h2>
        <?= $slot ?? '' ?>
        <button onclick="this.closest('.modal').remove()">Close</button>
    </div>
</div>
<?php endif ?>
