<!DOCTYPE html>
<html><head><meta charset="utf-8"><style>
body{font-family:DejaVu Sans,sans-serif;font-size:11px;color:#333}
h1{color:#005BAC;text-align:center;border-bottom:2px solid #FFC107}
table{width:100%;border-collapse:collapse;margin-top:10px}
th,td{border:1px solid #ddd;padding:6px}th{background:#005BAC;color:#fff}
</style></head><body>
<h1>SLGTI <?= e($title ?? 'Report') ?></h1>
<p style="text-align:center">Generated: <?= date('d M Y') ?></p>
<?php if (!empty($comparative)): ?>
<table><thead><tr><th>Department</th><th>Students</th><th>Graduates</th><th>Employment %</th><th>Income</th><th>Research</th></tr></thead><tbody>
<?php foreach ($submissions as $s): $m = submission_metrics($s); ?>
<tr><td><?= e($s['department_name']) ?></td><td><?= $m['total_students'] ?></td><td><?= $m['total_graduates'] ?></td><td><?= $m['employment_rate'] ?>%</td><td><?= number_format($m['total_income'],2) ?></td><td><?= $m['research_output'] ?></td></tr>
<?php endforeach; ?></tbody></table>
<?php elseif (!empty($department)): ?>
<p><strong><?= e($department['department_name']) ?></strong></p>
<?php foreach ($submissions as $s): $m = submission_metrics($s); ?>
<p><strong><?= e($s['reference_number']) ?></strong> — Staff: <?= e($s['staff_name'] ?? '') ?> — Students: <?= $m['total_students'] ?>, Graduates: <?= $m['total_graduates'] ?>, Income: LKR <?= number_format($m['total_income'],2) ?></p>
<?php endforeach; ?>
<?php else: foreach ($submissions as $s): $m = submission_metrics($s); ?>
<h3 style="color:#005BAC"><?= e($s['department_name']) ?></h3>
<p>Ref: <?= e($s['reference_number']) ?> | Staff: <?= e($s['staff_name'] ?? '') ?> | Students: <?= $m['total_students'] ?> | Graduates: <?= $m['total_graduates'] ?> | Income: LKR <?= number_format($m['total_income'],2) ?></p>
<?php endforeach; endif; ?>
</body></html>
