<?php
require_once dirname(__DIR__) . '/includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $errors = [];
    $departmentId = (int)($_POST['department_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirmation'] ?? '';

    if ($departmentId <= 0) $errors[] = 'Please select your department.';
    if ($name === '') $errors[] = 'Staff name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Password confirmation does not match.';
    if ($email && HodUser::findByEmail($email)) {
        $errors[] = 'Email is already registered.';
    }

    if (!$errors) {
        HodUser::create([
            'department_id' => $departmentId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'designation' => $designation,
            'password' => $password,
        ]);
        flash('success', 'Account created successfully. Please login.');
        redirect('hod/login.php');
    }
    $_SESSION['form_errors'] = $errors;
}

if (hod_user()) redirect('hod/dashboard.php');

$departments = Department::all();
$pageTitle = 'Create Staff Account';
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);
require ROOT_PATH . '/includes/partials/header_hod.php';
?>
<div class="container hod-auth-page">
    <div class="row justify-content-center w-100 mx-0">
        <div class="col-md-8 col-lg-6 hod-auth-card">
            <div class="admin-page-card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus text-slgti-primary" style="font-size:2.5rem;"></i>
                        <h2 class="text-slgti-primary mt-2 h4">Create Staff Account</h2>
                        <p class="text-muted small">Multiple staff from the same department can register. All staff in a department share one submission.</p>
                    </div>
                    <form method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Department <span class="text-danger">*</span></label>
                            <select name="department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $d): ?>
                                <option value="<?= $d['id'] ?>" <?= (int)($_POST['department_id'] ?? 0) === (int)$d['id'] ? 'selected' : '' ?>>
                                    <?= e($d['department_name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Staff Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required value="<?= e($_POST['name'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control" value="<?= e($_POST['designation'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= e($_POST['phone'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                        </div>
                        <button type="submit" class="btn btn-slgti-primary w-100">Create Account</button>
                    </form>
                    <p class="text-center mt-3 mb-0 small">Already have an account? <a href="<?= url('hod/login.php') ?>">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ROOT_PATH . '/includes/partials/footer_hod.php'; ?>
