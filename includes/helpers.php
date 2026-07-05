<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    return BASE_URL . ($path !== '' ? '/' . $path : '');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        die('Invalid security token. Please go back and try again.');
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['old'][$key] ?? $default;
}

function store_old(array $data): void
{
    $_SESSION['old'] = $data;
}

function clear_old(): void
{
    unset($_SESSION['old']);
}

function val(array $data, string $section, string $key, mixed $default = ''): mixed
{
    return $data[$section][$key] ?? $default;
}

function generate_reference(): string
{
    do {
        $ref = 'SLGTI-' . strtoupper(bin2hex(random_bytes(4)));
        $stmt = db()->prepare('SELECT id FROM submissions WHERE reference_number = ?');
        $stmt->execute([$ref]);
    } while ($stmt->fetch());

    return $ref;
}

function decode_json_fields(array $row): array
{
    $jsonFields = [
        'student_growth', 'department_growth', 'special_achievements',
        'events_conducted', 'income_generation', 'industry_partnerships',
        'research_innovations', 'staff_development', 'community_services', 'future_plans',
    ];
    foreach ($jsonFields as $field) {
        if (isset($row[$field]) && is_string($row[$field])) {
            $row[$field] = json_decode($row[$field], true) ?? [];
        }
    }
    return $row;
}

function submission_metrics(array $s): array
{
    $sg = $s['student_growth'] ?? [];
    $ig = $s['income_generation'] ?? [];
    $ri = $s['research_innovations'] ?? [];
    $sa = $s['special_achievements'] ?? [];
    $ev = $s['events_conducted'] ?? [];

    $totalIncome = (float)($ig['consultancy_income'] ?? 0)
        + (float)($ig['training_programs'] ?? 0)
        + (float)($ig['industry_projects'] ?? 0)
        + (float)($ig['other_revenue'] ?? 0);

    $research = (int)($ri['research_projects'] ?? 0)
        + (int)($ri['publications'] ?? 0)
        + (int)($ri['innovations'] ?? 0)
        + (int)($ri['patents'] ?? 0);

    $achievements = (int)($sa['awards'] ?? 0)
        + (int)($sa['accreditations'] ?? 0)
        + (int)($sa['national_recognition'] ?? 0)
        + (int)($sa['international_recognition'] ?? 0)
        + (int)($ev['workshops'] ?? 0)
        + (int)($ev['seminars'] ?? 0)
        + (int)($ev['competitions'] ?? 0);

    return [
        'total_students' => (int)($sg['total_students'] ?? 0),
        'total_graduates' => (int)($sg['total_graduates'] ?? 0),
        'employment_rate' => (float)($sg['employment_rate'] ?? 0),
        'total_income' => $totalIncome,
        'research_output' => $research,
        'achievement_score' => $achievements,
    ];
}

function short_dept_name(string $name): string
{
    return match (true) {
        str_contains($name, 'ICT') => 'ICT',
        str_contains($name, 'Automotive') => 'Automotive',
        str_contains($name, 'Electrical') => 'Electrical',
        str_contains($name, 'Mechanical') => 'Mechanical',
        str_contains($name, 'Construction') => 'Construction',
        str_contains($name, 'Food') => 'Food Tech',
        default => $name,
    };
}

function handle_upload(?array $file, ?string $existing = null): ?string
{
    global $config;

    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $existing;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('File upload failed.');
    }

    if ($file['size'] > $config['upload_max_size']) {
        throw new RuntimeException('File exceeds maximum size of 10MB.');
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $config['allowed_extensions'], true)) {
        throw new RuntimeException('Invalid file type. Allowed: PDF, DOCX, JPG, PNG.');
    }

    $dir = ROOT_PATH . '/uploads/documents';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    if ($existing && file_exists(ROOT_PATH . '/' . $existing)) {
        unlink(ROOT_PATH . '/' . $existing);
    }

    $filename = 'documents/' . uniqid('doc_', true) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], ROOT_PATH . '/uploads/' . basename($filename))) {
        throw new RuntimeException('Could not save uploaded file.');
    }

    return 'uploads/' . basename($filename);
}

function normalize_google_drive_link(string $link): string
{
    $link = trim($link);
    if ($link === '') {
        return '';
    }

    if (!preg_match('#^https?://#i', $link)) {
        $link = 'https://' . ltrim($link, '/');
    }

    return $link;
}

function is_valid_google_drive_link(string $link): bool
{
    $link = normalize_google_drive_link($link);
    if ($link === '' || !filter_var($link, FILTER_VALIDATE_URL)) {
        return false;
    }

    $host = strtolower((string)parse_url($link, PHP_URL_HOST));
    $path = strtolower((string)(parse_url($link, PHP_URL_PATH) ?? ''));

    if (in_array($host, [
        'drive.google.com',
        'www.drive.google.com',
        'docs.google.com',
        'www.docs.google.com',
        'links.google.com',
    ], true)) {
        return true;
    }

    if (preg_match('/^(drive|docs)\.google\.[a-z.]+$/', $host)) {
        return true;
    }

    if (in_array($host, ['google.com', 'www.google.com'], true)) {
        return str_starts_with($path, '/drive')
            || str_starts_with($path, '/document')
            || str_starts_with($path, '/spreadsheets')
            || str_starts_with($path, '/presentation');
    }

    return false;
}

function store_submission_form_input(array $data, int $submissionId = 0): void
{
    if ($submissionId > 0) {
        $data['_submission_id'] = $submissionId;
    }
    $_SESSION['submission_form_input'] = $data;
}

function pull_submission_form_input(): ?array
{
    $data = $_SESSION['submission_form_input'] ?? null;
    unset($_SESSION['submission_form_input']);
    return is_array($data) ? $data : null;
}

function merge_submission_with_form_input(?array $submission, ?array $input): array
{
    if (!$input) {
        return $submission ?? [];
    }

    $result = $submission ?? [];
    $submissionId = (int)($input['_submission_id'] ?? 0);
    unset($input['_submission_id']);

    foreach ($input as $key => $value) {
        if (is_array($value) && isset($result[$key]) && is_array($result[$key])) {
            $result[$key] = array_merge($result[$key], $value);
        } else {
            $result[$key] = $value;
        }
    }

    if ($submissionId > 0) {
        $result['id'] = $submissionId;
    }

    return $result;
}

function load_composer(): void
{
    static $loaded = false;
    if ($loaded) {
        return;
    }
    $autoload = ROOT_PATH . '/vendor/autoload.php';
    if (!file_exists($autoload)) {
        throw new RuntimeException('Export libraries not installed. Run: composer install');
    }
    require_once $autoload;
    $loaded = true;
}
function collect_submission_data(): array
{
    return [
        'department_id' => (int)($_POST['department_id'] ?? 0),
        'staff_name' => trim($_POST['staff_name'] ?? ''),
        'submitted_by' => trim($_POST['submitted_by'] ?? ''),
        'designation' => trim($_POST['designation'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'student_growth' => $_POST['student_growth'] ?? [],
        'department_growth' => $_POST['department_growth'] ?? [],
        'special_achievements' => $_POST['special_achievements'] ?? [],
        'events_conducted' => $_POST['events_conducted'] ?? [],
        'income_generation' => $_POST['income_generation'] ?? [],
        'industry_partnerships' => $_POST['industry_partnerships'] ?? [],
        'research_innovations' => $_POST['research_innovations'] ?? [],
        'staff_development' => $_POST['staff_development'] ?? [],
        'infrastructure_development' => trim($_POST['infrastructure_development'] ?? ''),
        'community_services' => $_POST['community_services'] ?? [],
        'future_plans' => $_POST['future_plans'] ?? [],
        'google_drive_link' => normalize_google_drive_link($_POST['google_drive_link'] ?? ''),
        'status' => $_POST['status'] ?? 'pending',
    ];
}

function validate_submission(array $data, bool $isAdmin = false): array
{
    $errors = [];

    if ($data['department_id'] <= 0) $errors[] = 'Please select a department.';
    if ($data['staff_name'] === '') $errors[] = 'Staff name is required.';
    if ($data['submitted_by'] === '') $errors[] = 'Submitted by is required.';
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($data['phone'] === '') $errors[] = 'Phone number is required.';
    if ((int)($data['student_growth']['total_students'] ?? -1) < 0) $errors[] = 'Total students is required.';
    if ((int)($data['student_growth']['total_graduates'] ?? -1) < 0) $errors[] = 'Total graduates is required.';
    $rate = (float)($data['student_growth']['employment_rate'] ?? -1);
    if ($rate < 0 || $rate > 100) $errors[] = 'Employment rate must be between 0 and 100.';
    if ($isAdmin && !in_array($data['status'], ['pending', 'completed'], true)) {
        $errors[] = 'Invalid status.';
    }

    $driveLink = $data['google_drive_link'] ?? '';
    if ($driveLink !== '' && !is_valid_google_drive_link($driveLink)) {
        $errors[] = 'Please enter a valid Google Drive or Google Docs share link.';
    }

    return $errors;
}
