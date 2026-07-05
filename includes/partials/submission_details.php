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
$sd = $s['staff_development'] ?? [];
$cs = $s['community_services'] ?? [];
$fp = $s['future_plans'] ?? [];

$detailText = static function ($value): string {
    $value = trim((string)($value ?? ''));
    return $value !== '' ? nl2br(e($value)) : '<span class="text-muted">—</span>';
};

$detailNumber = static function ($value): string {
    if ($value === null || $value === '') {
        return '0';
    }
    return e((string)$value);
};

$detailCurrency = static function ($value): string {
    return 'LKR ' . number_format((float)($value ?? 0), 2);
};
?>
<div class="submission-details-card">
    <div class="submission-details-header">
        <div class="submission-details-header-main">
            <span class="submission-details-ref">
                <i class="bi bi-hash"></i><?= e($s['reference_number']) ?>
            </span>
            <span class="submission-details-dept"><?= e($s['department_name']) ?></span>
        </div>
        <span class="submission-status-badge submission-status-<?= e($s['status']) ?>">
            <?= ucfirst(e($s['status'])) ?>
        </span>
    </div>
    <div class="submission-details-body">
        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-building me-2"></i>Department Information</h6>
            <div class="row g-3 detail-field-grid">
                <div class="col-md-6"><div class="detail-field"><span class="detail-label">Department</span><div class="detail-value"><?= e($s['department_name']) ?></div></div></div>
                <div class="col-md-6"><div class="detail-field"><span class="detail-label">Staff Name</span><div class="detail-value"><?= e($s['staff_name']) ?></div></div></div>
                <div class="col-md-4"><div class="detail-field"><span class="detail-label">Submitted By</span><div class="detail-value"><?= e($s['submitted_by']) ?></div></div></div>
                <div class="col-md-4"><div class="detail-field"><span class="detail-label">Designation</span><div class="detail-value"><?= e($s['designation'] ?? 'N/A') ?></div></div></div>
                <div class="col-md-4"><div class="detail-field"><span class="detail-label">Submission Date</span><div class="detail-value"><?= e(date('d M Y, h:i A', strtotime($s['submission_date']))) ?></div></div></div>
                <div class="col-md-6"><div class="detail-field"><span class="detail-label">Email</span><div class="detail-value"><?= e($s['email']) ?></div></div></div>
                <div class="col-md-6"><div class="detail-field"><span class="detail-label">Phone</span><div class="detail-value"><?= e($s['phone']) ?></div></div></div>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-people me-2"></i>Student Growth</h6>
            <div class="row g-3 detail-metric-grid">
                <div class="col-md-3"><div class="detail-metric"><span class="detail-label">Total Students (2016–2026)</span><div class="detail-value detail-value-metric"><?= $detailNumber($sg['total_students'] ?? 0) ?></div></div></div>
                <div class="col-md-3"><div class="detail-metric"><span class="detail-label">Total Graduates</span><div class="detail-value detail-value-metric"><?= $detailNumber($sg['total_graduates'] ?? 0) ?></div></div></div>
                <div class="col-md-3"><div class="detail-metric"><span class="detail-label">Employment Rate</span><div class="detail-value detail-value-metric"><?= $detailNumber($sg['employment_rate'] ?? 0) ?>%</div></div></div>
                <div class="col-12"><div class="detail-text-block"><span class="detail-label">Student Achievements</span><div class="detail-value"><?= $detailText($sg['student_achievements'] ?? '') ?></div></div></div>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-graph-up-arrow me-2"></i>Department Growth</h6>
            <div class="row g-3">
                <?php foreach (['new_programs'=>'New Programs Introduced','curriculum_improvements'=>'Curriculum Improvements','new_facilities'=>'New Facilities','equipment_upgrades'=>'Equipment Upgrades'] as $k => $l): ?>
                <div class="col-md-6"><span class="detail-label"><?= $l ?></span><div class="detail-value"><?= $detailText($dg[$k] ?? '') ?></div></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-trophy me-2"></i>Special Achievements</h6>
            <div class="row g-3">
                <?php foreach (['awards'=>'Awards','accreditations'=>'Accreditations','national_recognition'=>'National Recognition','international_recognition'=>'International Recognition'] as $k => $l): ?>
                <div class="col-md-3 col-6"><span class="detail-label"><?= $l ?></span><div class="detail-value"><?= $detailNumber($sa[$k] ?? 0) ?></div></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-calendar-event me-2"></i>Events Conducted</h6>
            <div class="row g-3">
                <?php foreach (['workshops'=>'Workshops','seminars'=>'Seminars','competitions'=>'Competitions','exhibitions'=>'Exhibitions','industrial_visits'=>'Industrial Visits'] as $k => $l): ?>
                <div class="col-md-4 col-6"><span class="detail-label"><?= $l ?></span><div class="detail-value"><?= $detailNumber($ev[$k] ?? 0) ?></div></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-currency-dollar me-2"></i>Income Generation (LKR)</h6>
            <div class="row g-3">
                <?php foreach (['consultancy_income'=>'Consultancy Income','training_programs'=>'Training Programs','industry_projects'=>'Industry Projects','other_revenue'=>'Other Revenue Sources'] as $k => $l): ?>
                <div class="col-md-6"><span class="detail-label"><?= $l ?></span><div class="detail-value"><?= $detailCurrency($ig[$k] ?? 0) ?></div></div>
                <?php endforeach; ?>
                <div class="col-12"><div class="detail-total-bar"><span class="detail-label">Total Income</span><div class="detail-value"><?= $detailCurrency($m['total_income']) ?></div></div></div>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-lightbulb me-2"></i>Research and Innovation</h6>
            <div class="row g-3">
                <?php foreach (['research_projects'=>'Research Projects','publications'=>'Publications','innovations'=>'Innovations','patents'=>'Patents'] as $k => $l): ?>
                <div class="col-md-3 col-6"><span class="detail-label"><?= $l ?></span><div class="detail-value"><?= $detailNumber($ri[$k] ?? 0) ?></div></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-briefcase me-2"></i>Industry Collaboration</h6>
            <div class="row g-3">
                <div class="col-md-6"><span class="detail-label">Industry Partners</span><div class="detail-value"><?= $detailText($ip['industry_partners'] ?? '') ?></div></div>
                <div class="col-md-3 col-6"><span class="detail-label">MoUs</span><div class="detail-value"><?= $detailNumber($ip['mous'] ?? 0) ?></div></div>
                <div class="col-md-3 col-6"><span class="detail-label">Internships</span><div class="detail-value"><?= $detailNumber($ip['internships'] ?? 0) ?></div></div>
                <div class="col-12"><span class="detail-label">Industry Training</span><div class="detail-value"><?= $detailText($ip['industry_training'] ?? '') ?></div></div>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-person-workspace me-2"></i>Staff Development</h6>
            <div class="row g-3">
                <?php foreach (['training_programs'=>'Training Programs','higher_education'=>'Higher Education','professional_certifications'=>'Professional Certifications'] as $k => $l): ?>
                <div class="col-md-4"><span class="detail-label"><?= $l ?></span><div class="detail-value"><?= $detailText($sd[$k] ?? '') ?></div></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-hammer me-2"></i>Infrastructure Development</h6>
            <div class="detail-text-block">
                <div class="detail-value"><?= $detailText($s['infrastructure_development'] ?? '') ?></div>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-heart me-2"></i>Community Services</h6>
            <div class="row g-3">
                <?php foreach (['outreach_programs'=>'Outreach Programs','csr_activities'=>'CSR Activities','environmental_activities'=>'Environmental Activities'] as $k => $l): ?>
                <div class="col-md-4"><div class="detail-text-block"><span class="detail-label"><?= $l ?></span><div class="detail-value"><?= $detailText($cs[$k] ?? '') ?></div></div></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="submission-detail-section">
            <h6 class="submission-detail-title"><i class="bi bi-flag me-2"></i>Future Development Plans</h6>
            <div class="row g-3">
                <div class="col-md-6"><div class="detail-text-block"><span class="detail-label">Next 5-Year Strategic Plan</span><div class="detail-value"><?= $detailText($fp['strategic_plan'] ?? '') ?></div></div></div>
                <div class="col-md-6"><div class="detail-text-block"><span class="detail-label">Required Resources</span><div class="detail-value"><?= $detailText($fp['required_resources'] ?? '') ?></div></div></div>
            </div>
        </div>

        <div class="submission-detail-section mb-0">
            <h6 class="submission-detail-title"><i class="bi bi-paperclip me-2"></i>Documents</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-doc-card">
                        <span class="detail-label">Uploaded File</span>
                        <div class="detail-value">
                            <?php if (!empty($s['supporting_documents'])): ?>
                            <a href="<?= url($s['supporting_documents']) ?>" target="_blank" rel="noopener" class="detail-doc-link">
                                <i class="bi bi-file-earmark-arrow-down"></i>
                                <span>Download Document</span>
                            </a>
                            <?php else: ?>
                            <span class="text-muted">—</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-doc-card">
                        <span class="detail-label">Google Drive Link</span>
                        <div class="detail-value">
                            <?php if (!empty($s['google_drive_link'])): ?>
                            <a href="<?= e($s['google_drive_link']) ?>" target="_blank" rel="noopener" class="detail-doc-link">
                                <i class="bi bi-google"></i>
                                <span>Open Google Drive</span>
                            </a>
                            <?php else: ?>
                            <span class="text-muted">—</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
