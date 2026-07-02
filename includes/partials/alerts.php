<?php if ($flash = get_flash()): ?>
<div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : e($flash['type']) ?> alert-dismissible fade show m-3" role="alert">
    <?= e($flash['message']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
    <strong>Please fix the following errors:</strong>
    <ul class="mb-0 mt-2">
        <?php foreach ($errors as $error): ?>
            <li><?= e($error) ?></li>
        <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
