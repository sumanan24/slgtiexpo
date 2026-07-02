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
$pageTitle = 'Dashboard';
$active = 'dashboard';
require ROOT_PATH . '/includes/partials/header_admin.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-slgti-primary mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    <span class="text-muted">Welcome, <?= e(admin_user()['name']) ?></span>
</div>
<div class="row g-4 mb-4">
    <?php foreach ([['Total Departments',$stats['total_departments'],'bi-building'],['Total Submissions',$stats['total_submissions'],'bi-file-earmark-text'],['Pending Reports',$stats['pending_reports'],'bi-hourglass-split'],['Completed Reports',$stats['completed_reports'],'bi-check-circle']] as [$label,$val,$icon]): ?>
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat"><div class="card-body d-flex align-items-center">
            <div class="stat-icon me-3"><i class="bi <?= $icon ?> fs-4"></i></div>
            <div><h6 class="text-muted mb-0"><?= $label ?></h6><h3 class="mb-0 text-slgti-primary"><?= $val ?></h3></div>
        </div></div>
    </div>
    <?php endforeach; ?>
</div>
<div class="row g-4">
    <?php foreach ([['studentChart','bar',$students,'Student Growth'],['graduateChart','bar',$graduates,'Graduates'],['incomeChart','line',$income,'Income'],['researchChart','bar',$research,'Research'],['achievementChart','bar',$achievements,'Achievements']] as [$id,$type,$data,$title]): ?>
    <div class="col-lg-<?= $id === 'achievementChart' ? '12' : '6' ?>">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0 text-slgti-primary"><?= $title ?></h6></div>
            <div class="card-body"><div class="chart-container"><canvas id="<?= $id ?>"></canvas></div></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php
$extraScripts = '<script>
const labels = ' . json_encode($labels) . ';
const primary = "#005BAC";
function chart(id,type,data,label){const el=document.getElementById(id);if(!el||!labels.length)return;new Chart(el,{type,data:{labels,datasets:[{label,data,backgroundColor:type==="line"?"rgba(0,91,172,0.2)":primary,borderColor:primary,borderWidth:2,fill:type==="line",tension:0.3}]},options:{responsive:true,maintainAspectRatio:false,scales:{y:{beginAtZero:true}}}});}
chart("studentChart","bar",' . json_encode($students) . ',"Students");
chart("graduateChart","bar",' . json_encode($graduates) . ',"Graduates");
chart("incomeChart","line",' . json_encode($income) . ',"Income");
chart("researchChart","bar",' . json_encode($research) . ',"Research");
chart("achievementChart","bar",' . json_encode($achievements) . ',"Achievements");
</script>';
require ROOT_PATH . '/includes/partials/footer_admin.php';
