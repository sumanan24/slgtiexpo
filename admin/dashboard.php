<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();

$stats = Submission::stats();
$submissions = Submission::allWithDepartment();
$labels = $students = $graduates = $income = $research = $achievements = [];

foreach ($submissions as $s) {
    $m = submission_metrics($s);
    $labels[] = short_dept_name($s['department_name']);
    $students[] = $m['total_students'];
    $graduates[] = $m['total_graduates'];
    $income[] = $m['total_income'];
    $research[] = $m['research_output'];
    $achievements[] = $m['achievement_score'];
}

$hasChartData = count($labels) > 0;
$pageTitle = 'Dashboard';
$active = 'dashboard';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>

<div class="dashboard-page">
    <div class="dashboard-header">
        <div>
            <h2 class="dashboard-title text-slgti-primary">
                <i class="bi bi-speedometer2"></i> Dashboard Overview
            </h2>
            <p class="dashboard-subtitle">SLGTI 10-Year Impact Report — summary analytics</p>
        </div>
        <div class="dashboard-welcome">
            <i class="bi bi-person-circle me-1"></i>
            Welcome, <strong><?= e(admin_user()['name']) ?></strong>
        </div>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-card-icon primary"><i class="bi bi-building"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Departments</div>
                <p class="stat-card-value"><?= $stats['total_departments'] ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon info"><i class="bi bi-file-earmark-text"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Total Submissions</div>
                <p class="stat-card-value"><?= $stats['total_submissions'] ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon warning"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Pending Reports</div>
                <p class="stat-card-value warning"><?= $stats['pending_reports'] ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon success"><i class="bi bi-check-circle"></i></div>
            <div class="stat-card-body">
                <div class="stat-card-label">Completed Reports</div>
                <p class="stat-card-value success"><?= $stats['completed_reports'] ?></p>
            </div>
        </div>
    </div>

    <div class="dashboard-section-title">
        <h5><i class="bi bi-graph-up me-2"></i>Analytics Charts</h5>
    </div>

    <div class="dashboard-charts">
        <?php
        $charts = [
            ['studentChart', 'bar', $students, 'Student Growth Comparison', false],
            ['graduateChart', 'bar', $graduates, 'Graduate Statistics', false],
            ['incomeChart', 'line', $income, 'Income Generation Comparison', false],
            ['researchChart', 'bar', $research, 'Research Output Comparison', false],
            ['achievementChart', 'bar', $achievements, 'Department Achievement Summary', true],
        ];
        foreach ($charts as [$id, $type, $data, $title, $full]):
        ?>
        <div class="chart-card<?= $full ? ' full-width' : '' ?>">
            <div class="chart-card-header">
                <h6><i class="bi bi-bar-chart-line me-2"></i><?= e($title) ?></h6>
            </div>
            <div class="chart-card-body">
                <?php if ($hasChartData): ?>
                    <div class="chart-container">
                        <canvas id="<?= e($id) ?>"></canvas>
                    </div>
                <?php else: ?>
                    <div class="chart-empty">
                        <div>
                            <i class="bi bi-inbox"></i>
                            <p>No submission data yet.</p>
                            <small>Charts appear after departments submit data.</small>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if ($hasChartData): ?>
<?php
$extraScripts = '<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const labels = ' . json_encode($labels) . ';
const primary = "#005BAC";
const secondary = "#FFC107";

function buildChart(id, type, data, label) {
    const el = document.getElementById(id);
    if (!el) return;
    new Chart(el, {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: type === "line"
                    ? "rgba(0, 91, 172, 0.15)"
                    : [primary, secondary, "#003d73", "#4a90c2", "#7ab3d9", "#a8cce6"],
                borderColor: primary,
                borderWidth: 2,
                fill: type === "line",
                tension: 0.35,
                borderRadius: type === "bar" ? 6 : 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: type === "line", position: "top" }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: "#eef2f7" } },
                x: { grid: { display: false } }
            }
        }
    });
}

buildChart("studentChart", "bar", ' . json_encode($students) . ', "Total Students");
buildChart("graduateChart", "bar", ' . json_encode($graduates) . ', "Total Graduates");
buildChart("incomeChart", "line", ' . json_encode($income) . ', "Income (LKR)");
buildChart("researchChart", "bar", ' . json_encode($research) . ', "Research Output");
buildChart("achievementChart", "bar", ' . json_encode($achievements) . ', "Achievement Score");
</script>';
?>
<?php endif; ?>

<?php require ROOT_PATH . '/includes/partials/footer_admin.php'; ?>
