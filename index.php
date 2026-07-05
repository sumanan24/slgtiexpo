<?php
require_once __DIR__ . '/includes/init.php';
$pageTitle = 'SLGTI 10-Year Impact';
require ROOT_PATH . '/includes/partials/header_public.php';
?>
<section class="home-hero">
    <div class="home-hero-pattern" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center g-4 g-lg-5">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="home-badge"><i class="bi bi-award me-2"></i>2016 &ndash; 2026 Institutional Milestone</span>
                <h1 class="home-hero-title">SLGTI 10-Year Impact</h1>
                <p class="home-hero-subtitle">Department Head Data Collection Portal</p>
                <p class="home-hero-lead">A secure platform for documenting institutional growth, departmental achievements, and a decade of excellence at the Sri Lanka-German Training Institute.</p>
                <div class="home-hero-actions">
                    <?php if (hod_user()): ?>
                    <a href="<?= url('hod/dashboard.php') ?>" class="btn btn-slgti-secondary btn-lg"><i class="bi bi-grid me-2"></i>My Dashboard</a>
                    <a href="<?= url('hod/submission.php') ?>" class="btn btn-outline-light btn-lg"><i class="bi bi-file-earmark-text me-2"></i>My Submission</a>
                    <?php else: ?>
                    <a href="<?= url('hod/login.php') ?>" class="btn btn-slgti-secondary btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Staff Login</a>
                    <a href="<?= url('hod/register.php') ?>" class="btn btn-outline-light btn-lg"><i class="bi bi-person-plus me-2"></i>Create Staff Account</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="home-hero-stats">
                    <div class="home-stat-card">
                        <span class="home-stat-value">6</span>
                        <span class="home-stat-label">Academic Departments</span>
                    </div>
                    <div class="home-stat-card">
                        <span class="home-stat-value">10</span>
                        <span class="home-stat-label">Years of Impact</span>
                    </div>
                    <div class="home-stat-card">
                        <span class="home-stat-value"><i class="bi bi-shield-check"></i></span>
                        <span class="home-stat-label">Secure Submissions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section home-welcome">
    <div class="container">
        <div class="home-section-header text-center">
            <span class="home-eyebrow">Welcome</span>
            <h2 class="home-section-title">Official Data Collection Portal</h2>
        </div>
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6">
                <div class="home-content-card h-100">
                    <p>Welcome to the official <strong>SLGTI 10-Year Impact Department Head Data Collection Portal</strong>. This platform has been developed to facilitate the systematic collection of information from all academic departments, supporting the documentation of institutional growth, achievements, and contributions over the past decade.</p>
                    <p class="mb-0">Department Heads are requested to provide accurate, complete, and up-to-date information relating to their respective departments. The information collected through this portal will contribute to evaluating institutional progress, identifying key achievements, and supporting future strategic planning and quality enhancement initiatives.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="home-highlight-card h-100">
                    <div class="home-highlight-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <h3>Why Your Contribution Matters</h3>
                    <p class="mb-0">Every department has played a vital role in the growth and success of SLGTI. Your contribution helps build a comprehensive record of institutional excellence, highlights departmental accomplishments, and provides valuable insights for future planning, accreditation, quality assurance, and stakeholder engagement.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section home-purpose bg-white">
    <div class="container">
        <div class="home-section-header text-center">
            <span class="home-eyebrow">Purpose</span>
            <h2 class="home-section-title">What This Portal Enables</h2>
            <p class="home-section-desc">Departments can submit, document, and review comprehensive impact data through a structured workflow.</p>
        </div>
        <div class="row g-3 g-md-4">
            <?php
            $purposes = [
                ['bi-building', 'Department Profiles', 'Submit department profiles and historical information.'],
                ['bi-mortarboard', 'Academic Achievements', 'Record academic and training achievements.'],
                ['bi-people', 'Student Statistics', 'Provide student enrolment, completion, and employment statistics.'],
                ['bi-handshake', 'Industry Collaborations', 'Document industry collaborations, partnerships, and outreach activities.'],
                ['bi-lightbulb', 'Innovation & Projects', 'Report staff development, research, innovation, and special projects.'],
                ['bi-folder2-open', 'Supporting Evidence', 'Upload supporting documents, photographs, publications, and other evidence.'],
                ['bi-pencil-square', 'Review & Update', 'Review and update submitted information before final submission.'],
            ];
            foreach ($purposes as [$icon, $title, $desc]): ?>
            <div class="col-md-6 col-xl-4">
                <div class="home-feature-card h-100">
                    <div class="home-feature-icon"><i class="bi <?= $icon ?>"></i></div>
                    <h3><?= e($title) ?></h3>
                    <p class="mb-0"><?= e($desc) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="home-section home-guidelines">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="home-content-card h-100">
                    <div class="home-section-header mb-4">
                        <span class="home-eyebrow">Guidelines</span>
                        <h2 class="home-section-title h4 mb-0">Submission Best Practices</h2>
                    </div>
                    <ul class="home-checklist">
                        <li><i class="bi bi-check-circle-fill"></i>Provide accurate and verified information.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Ensure all mandatory sections are completed.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Upload supporting evidence where applicable.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Save your progress regularly.</li>
                        <li><i class="bi bi-check-circle-fill"></i>Review all information carefully before final submission.</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="home-secure-card h-100">
                    <div class="home-secure-icon"><i class="bi bi-shield-lock"></i></div>
                    <h3>Secure Access</h3>
                    <p>This portal is exclusively intended for authorized Department Heads and designated representatives. All submitted information will be securely stored and managed in accordance with institutional data management practices.</p>
                    <div class="home-closing-quote">
                        <strong>Together, we are documenting a decade of excellence, innovation, and impact at the Sri Lanka German Training Institute (SLGTI).</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section home-departments bg-white">
    <div class="container">
        <div class="home-section-header text-center">
            <span class="home-eyebrow">Departments</span>
            <h2 class="home-section-title">Participating Departments</h2>
            <p class="home-section-desc">Six academic departments contributing to the SLGTI 10-Year Impact Report.</p>
        </div>
        <div class="row g-4 justify-content-center home-dept-grid">
            <?php
            $depts = [
                ['bi-car-front', 'Automotive Technology'],
                ['bi-building', 'Construction Technology'],
                ['bi-lightning-charge', 'Electrical & Electronic Technology'],
                ['bi-cup-hot', 'Food Technology'],
                ['bi-laptop', 'Information & Communication Technology (ICT)'],
                ['bi-gear-wide-connected', 'Mechanical Technology'],
            ];
            foreach ($depts as [$icon, $name]): ?>
            <div class="col-sm-6 col-lg-4">
                <div class="home-dept-card h-100">
                    <div class="home-dept-icon"><i class="bi <?= $icon ?>"></i></div>
                    <h3><?= e($name) ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="home-cta">
    <div class="container">
        <div class="home-cta-inner text-center">
            <h2>Ready to Submit Your Department Data?</h2>
            <p class="mb-4">Access the portal to complete or update your department&rsquo;s 10-year impact submission.</p>
            <div class="home-hero-actions justify-content-center">
                <?php if (hod_user()): ?>
                <a href="<?= url('hod/submission.php') ?>" class="btn btn-slgti-secondary btn-lg"><i class="bi bi-file-earmark-text me-2"></i>Go to My Submission</a>
                <?php else: ?>
                <a href="<?= url('hod/login.php') ?>" class="btn btn-slgti-secondary btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Staff Login</a>
                <a href="<?= url('hod/register.php') ?>" class="btn btn-outline-light btn-lg"><i class="bi bi-person-plus me-2"></i>Create Staff Account</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php require ROOT_PATH . '/includes/partials/footer_public.php'; ?>
