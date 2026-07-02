<?php
$s = $submission;
$m = submission_metrics($s);
$sg = $s['student_growth'] ?? [];
$dg = $s['department_growth'] ?? [];
$sa = $s['special_achievements'] ?? [];
$ev = $s['events_conducted'] ?? [];
$ig = $s['income_generation'] ?? [];
$ri = $s['research_innovations'] ?? [];
$ip = $s['industry_partnerships'] ?? [];
?>
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-slgti-primary text-white d-flex justify-content-between">
        <span>Reference: <?= e($s['reference_number']) ?></span>
        <span class="badge bg-light text-dark"><?= ucfirst(e($s['status'])) ?></span>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6"><strong>Department:</strong> <?= e($s['department_name']) ?></div>
            <div class="col-md-6"><strong>Staff Name:</strong> <?= e($s['staff_name']) ?></div>
            <div class="col-md-4 mt-2"><strong>Submitted By:</strong> <?= e($s['submitted_by']) ?></div>
            <div class="col-md-4 mt-2"><strong>Designation:</strong> <?= e($s['designation'] ?? 'N/A') ?></div>
            <div class="col-md-4 mt-2"><strong>Date:</strong> <?= e(date('d M Y', strtotime($s['submission_date']))) ?></div>
            <div class="col-md-6 mt-2"><strong>Email:</strong> <?= e($s['email']) ?></div>
            <div class="col-md-6 mt-2"><strong>Phone:</strong> <?= e($s['phone']) ?></div>
        </div>
        <h6 class="text-slgti-primary border-bottom pb-2">Student Growth</h6>
        <p class="small">Students: <?= $m['total_students'] ?> | Graduates: <?= $m['total_graduates'] ?> | Employment: <?= $m['employment_rate'] ?>%</p>
        <p class="small"><?= e($sg['student_achievements'] ?? '') ?></p>
        <h6 class="text-slgti-primary border-bottom pb-2">Income & Research</h6>
        <p class="small">Total Income: LKR <?= number_format($m['total_income'], 2) ?> | Research Output: <?= $m['research_output'] ?> | Achievements: <?= $m['achievement_score'] ?></p>
        <?php if (!empty($s['supporting_documents'])): ?>
        <p><strong>Document:</strong> <a href="<?= url($s['supporting_documents']) ?>" target="_blank">Download</a></p>
        <?php endif; ?>
    </div>
</div>
