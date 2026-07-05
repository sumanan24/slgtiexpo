<?php
$s = $submission ?? null;
$hodLocked = $hodLocked ?? false;
$lockedDepartment = $lockedDepartment ?? null;
$sg = $s['student_growth'] ?? [];
$dg = $s['department_growth'] ?? [];
$sa = $s['special_achievements'] ?? [];
$ev = $s['events_conducted'] ?? [];
$ig = $s['income_generation'] ?? [];
$ip = $s['industry_partnerships'] ?? [];
$ri = $s['research_innovations'] ?? [];
$sd = $s['staff_development'] ?? [];
$cs = $s['community_services'] ?? [];
$fp = $s['future_plans'] ?? [];
?>
<div class="form-section">
    <h5><i class="bi bi-building me-2"></i>Department Information</h5>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Department Name <span class="text-danger">*</span></label>
            <?php if ($hodLocked && $lockedDepartment): ?>
                <input type="text" class="form-control" readonly value="<?= e($lockedDepartment['department_name']) ?>">
                <input type="hidden" name="department_id" value="<?= (int)$lockedDepartment['id'] ?>">
            <?php else: ?>
            <select name="department_id" id="department_id" class="form-select" required>
                <option value="">Select Department</option>
                <?php foreach ($departments as $department): ?>
                <option value="<?= $department['id'] ?>"
                    <?= (int)($s['department_id'] ?? $_POST['department_id'] ?? 0) === (int)$department['id'] ? 'selected' : '' ?>>
                    <?= e($department['department_name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label class="form-label">Staff Name <span class="text-danger">*</span></label>
            <input type="text" name="staff_name" class="form-control" required
                placeholder="Enter staff name"
                value="<?= e($s['staff_name'] ?? $_POST['staff_name'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Submitted By <span class="text-danger">*</span></label>
            <input type="text" name="submitted_by" class="form-control" required value="<?= e($s['submitted_by'] ?? $_POST['submitted_by'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" value="<?= e($s['designation'] ?? $_POST['designation'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" required value="<?= e($s['email'] ?? $_POST['email'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control" required value="<?= e($s['phone'] ?? $_POST['phone'] ?? '') ?>">
        </div>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-people me-2"></i>Student Growth</h5>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Total Students Enrolled (2016-2026) <span class="text-danger">*</span></label>
            <input type="number" name="student_growth[total_students]" class="form-control" min="0" required value="<?= e($sg['total_students'] ?? $_POST['student_growth']['total_students'] ?? 0) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Total Graduates <span class="text-danger">*</span></label>
            <input type="number" name="student_growth[total_graduates]" class="form-control" min="0" required value="<?= e($sg['total_graduates'] ?? $_POST['student_growth']['total_graduates'] ?? 0) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Employment Rate (%) <span class="text-danger">*</span></label>
            <input type="number" name="student_growth[employment_rate]" class="form-control" min="0" max="100" step="0.01" required value="<?= e($sg['employment_rate'] ?? $_POST['student_growth']['employment_rate'] ?? 0) ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Student Achievements</label>
            <textarea name="student_growth[student_achievements]" class="form-control" rows="3"><?= e($sg['student_achievements'] ?? $_POST['student_growth']['student_achievements'] ?? '') ?></textarea>
        </div>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-graph-up-arrow me-2"></i>Department Growth</h5>
    <div class="row g-3">
        <?php foreach (['new_programs'=>'New Programs Introduced','curriculum_improvements'=>'Curriculum Improvements','new_facilities'=>'New Facilities','equipment_upgrades'=>'Equipment Upgrades'] as $k=>$l): ?>
        <div class="col-md-6">
            <label class="form-label"><?= $l ?></label>
            <textarea name="department_growth[<?= $k ?>]" class="form-control" rows="2"><?= e($dg[$k] ?? $_POST['department_growth'][$k] ?? '') ?></textarea>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-trophy me-2"></i>Special Achievements</h5>
    <div class="row g-3">
        <?php foreach (['awards'=>'Awards','accreditations'=>'Accreditations','national_recognition'=>'National Recognition','international_recognition'=>'International Recognition'] as $k=>$l): ?>
        <div class="col-md-3">
            <label class="form-label"><?= $l ?></label>
            <input type="number" name="special_achievements[<?= $k ?>]" class="form-control" min="0" value="<?= e($sa[$k] ?? $_POST['special_achievements'][$k] ?? 0) ?>">
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-calendar-event me-2"></i>Events Conducted</h5>
    <div class="row g-3">
        <?php foreach (['workshops'=>'Workshops','seminars'=>'Seminars','competitions'=>'Competitions','exhibitions'=>'Exhibitions','industrial_visits'=>'Industrial Visits'] as $k=>$l): ?>
        <div class="col-6 col-md-4 col-lg">
            <label class="form-label"><?= $l ?></label>
            <input type="number" name="events_conducted[<?= $k ?>]" class="form-control" min="0" value="<?= e($ev[$k] ?? $_POST['events_conducted'][$k] ?? 0) ?>">
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-currency-dollar me-2"></i>Income Generation (LKR)</h5>
    <div class="row g-3">
        <?php foreach (['consultancy_income'=>'Consultancy Income','training_programs'=>'Training Programs','industry_projects'=>'Industry Projects','other_revenue'=>'Other Revenue Sources'] as $k=>$l): ?>
        <div class="col-md-6">
            <label class="form-label"><?= $l ?></label>
            <input type="number" name="income_generation[<?= $k ?>]" class="form-control" min="0" step="0.01" value="<?= e($ig[$k] ?? $_POST['income_generation'][$k] ?? 0) ?>">
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-lightbulb me-2"></i>Research and Innovation</h5>
    <div class="row g-3">
        <?php foreach (['research_projects'=>'Research Projects','publications'=>'Publications','innovations'=>'Innovations','patents'=>'Patents'] as $k=>$l): ?>
        <div class="col-md-3">
            <label class="form-label"><?= $l ?></label>
            <input type="number" name="research_innovations[<?= $k ?>]" class="form-control" min="0" value="<?= e($ri[$k] ?? $_POST['research_innovations'][$k] ?? 0) ?>">
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-briefcase me-2"></i>Industry Collaboration</h5>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Industry Partners</label>
            <textarea name="industry_partnerships[industry_partners]" class="form-control" rows="2"><?= e($ip['industry_partners'] ?? $_POST['industry_partnerships']['industry_partners'] ?? '') ?></textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">MoUs</label>
            <input type="number" name="industry_partnerships[mous]" class="form-control" min="0" value="<?= e($ip['mous'] ?? $_POST['industry_partnerships']['mous'] ?? 0) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Internships</label>
            <input type="number" name="industry_partnerships[internships]" class="form-control" min="0" value="<?= e($ip['internships'] ?? $_POST['industry_partnerships']['internships'] ?? 0) ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Industry Training</label>
            <textarea name="industry_partnerships[industry_training]" class="form-control" rows="2"><?= e($ip['industry_training'] ?? $_POST['industry_partnerships']['industry_training'] ?? '') ?></textarea>
        </div>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-person-workspace me-2"></i>Staff Development</h5>
    <div class="row g-3">
        <?php foreach (['training_programs'=>'Training Programs','higher_education'=>'Higher Education','professional_certifications'=>'Professional Certifications'] as $k=>$l): ?>
        <div class="col-md-4">
            <label class="form-label"><?= $l ?></label>
            <textarea name="staff_development[<?= $k ?>]" class="form-control" rows="2"><?= e($sd[$k] ?? $_POST['staff_development'][$k] ?? '') ?></textarea>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-hammer me-2"></i>Infrastructure Development</h5>
    <textarea name="infrastructure_development" class="form-control" rows="3"><?= e($s['infrastructure_development'] ?? $_POST['infrastructure_development'] ?? '') ?></textarea>
</div>

<div class="form-section">
    <h5><i class="bi bi-heart me-2"></i>Community Services</h5>
    <div class="row g-3">
        <?php foreach (['outreach_programs'=>'Outreach Programs','csr_activities'=>'CSR Activities','environmental_activities'=>'Environmental Activities'] as $k=>$l): ?>
        <div class="col-md-4">
            <label class="form-label"><?= $l ?></label>
            <textarea name="community_services[<?= $k ?>]" class="form-control" rows="2"><?= e($cs[$k] ?? $_POST['community_services'][$k] ?? '') ?></textarea>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-flag me-2"></i>Future Development Plans</h5>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Next 5-Year Strategic Plan</label>
            <textarea name="future_plans[strategic_plan]" class="form-control" rows="3"><?= e($fp['strategic_plan'] ?? $_POST['future_plans']['strategic_plan'] ?? '') ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Required Resources</label>
            <textarea name="future_plans[required_resources]" class="form-control" rows="3"><?= e($fp['required_resources'] ?? $_POST['future_plans']['required_resources'] ?? '') ?></textarea>
        </div>
    </div>
</div>

<div class="form-section">
    <h5><i class="bi bi-paperclip me-2"></i>Documents</h5>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Upload Document</label>
            <input type="file" name="supporting_documents" class="form-control" accept=".pdf,.docx,.jpg,.jpeg,.png">
            <small class="text-muted d-block mt-1">Accepted: PDF, DOCX, JPG, PNG (Max 10MB)</small>
            <?php if (!empty($s['supporting_documents'])): ?>
            <p class="mt-2 mb-0">
                <a href="<?= url($s['supporting_documents']) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-file-earmark-arrow-down me-1"></i>View uploaded document
                </a>
            </p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label class="form-label">Google Drive Link</label>
            <input type="text" name="google_drive_link" class="form-control" inputmode="url"
                placeholder="drive.google.com/file/d/... or docs.google.com/..."
                value="<?= e($s['google_drive_link'] ?? $_POST['google_drive_link'] ?? '') ?>">
            <small class="text-muted d-block mt-1">Paste a shareable Google Drive, Docs, Sheets, or Slides link.</small>
            <?php if (!empty($s['google_drive_link'])): ?>
            <p class="mt-2 mb-0">
                <a href="<?= e($s['google_drive_link']) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-google me-1"></i>Open current Google Drive link
                </a>
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!empty($showStatus)): ?>
<div class="form-section">
    <h5><i class="bi bi-flag me-2"></i>Submission Status</h5>
    <select name="status" class="form-select" style="max-width:200px;">
        <option value="pending" <?= ($s['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="completed" <?= ($s['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
    </select>
</div>
<?php endif; ?>
