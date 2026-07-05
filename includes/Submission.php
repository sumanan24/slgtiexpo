<?php

declare(strict_types=1);

class Submission
{
    public static function findByDepartment(int $departmentId): ?array
    {
        $stmt = db()->prepare(
            'SELECT s.*, d.department_name
             FROM submissions s
             JOIN departments d ON d.id = s.department_id
             WHERE s.department_id = ?
             ORDER BY s.updated_at DESC
             LIMIT 1'
        );
        $stmt->execute([$departmentId]);
        $row = $stmt->fetch();
        return $row ? decode_json_fields($row) : null;
    }

    public static function findByHodUser(int $hodUserId): ?array
    {
        $stmt = db()->prepare(
            'SELECT s.*, d.department_name
             FROM submissions s
             JOIN departments d ON d.id = s.department_id
             WHERE s.hod_user_id = ?
             ORDER BY s.updated_at DESC
             LIMIT 1'
        );
        $stmt->execute([$hodUserId]);
        $row = $stmt->fetch();
        return $row ? decode_json_fields($row) : null;
    }

    public static function find(int $id): ?array
    {
        $stmt = db()->prepare(
            'SELECT s.*, d.department_name
             FROM submissions s
             JOIN departments d ON d.id = s.department_id
             WHERE s.id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? decode_json_fields($row) : null;
    }

    public static function findByReference(string $ref): ?array
    {
        $stmt = db()->prepare(
            'SELECT s.*, d.department_name
             FROM submissions s
             JOIN departments d ON d.id = s.department_id
             WHERE s.reference_number = ?'
        );
        $stmt->execute([$ref]);
        $row = $stmt->fetch();
        return $row ? decode_json_fields($row) : null;
    }

    public static function allWithDepartment(): array
    {
        $rows = db()->query(
            'SELECT s.*, d.department_name
             FROM submissions s
             JOIN departments d ON d.id = s.department_id
             ORDER BY s.submission_date DESC'
        )->fetchAll();

        return array_map('decode_json_fields', $rows);
    }

    public static function byDepartment(int $departmentId): array
    {
        $stmt = db()->prepare(
            'SELECT s.*, d.department_name
             FROM submissions s
             JOIN departments d ON d.id = s.department_id
             WHERE s.department_id = ?
             ORDER BY s.submission_date DESC'
        );
        $stmt->execute([$departmentId]);
        return array_map('decode_json_fields', $stmt->fetchAll());
    }

    public static function search(array $filters, int $page = 1, int $perPage = 10): array
    {
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = '(s.reference_number LIKE ? OR s.submitted_by LIKE ? OR s.staff_name LIKE ? OR s.email LIKE ? OR d.department_name LIKE ?)';
            $q = '%' . $filters['search'] . '%';
            array_push($params, $q, $q, $q, $q, $q);
        }
        if (!empty($filters['department_id'])) {
            $where[] = 's.department_id = ?';
            $params[] = $filters['department_id'];
        }
        if (!empty($filters['status'])) {
            $where[] = 's.status = ?';
            $params[] = $filters['status'];
        }

        $whereSql = implode(' AND ', $where);
        $offset = ($page - 1) * $perPage;

        $countStmt = db()->prepare("SELECT COUNT(*) FROM submissions s JOIN departments d ON d.id = s.department_id WHERE $whereSql");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $sql = "SELECT s.*, d.department_name
                FROM submissions s
                JOIN departments d ON d.id = s.department_id
                WHERE $whereSql
                ORDER BY s.submission_date DESC
                LIMIT $perPage OFFSET $offset";
        $stmt = db()->prepare($sql);
        $stmt->execute($params);
        $items = array_map('decode_json_fields', $stmt->fetchAll());

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => (int)ceil($total / $perPage),
        ];
    }

    public static function stats(): array
    {
        $pdo = db();
        return [
            'total_departments' => (int)$pdo->query('SELECT COUNT(*) FROM departments')->fetchColumn(),
            'total_submissions' => (int)$pdo->query('SELECT COUNT(*) FROM submissions')->fetchColumn(),
            'pending_reports' => (int)$pdo->query("SELECT COUNT(*) FROM submissions WHERE status = 'pending'")->fetchColumn(),
            'completed_reports' => (int)$pdo->query("SELECT COUNT(*) FROM submissions WHERE status = 'completed'")->fetchColumn(),
        ];
    }

    public static function create(array $data, ?string $documentPath): int
    {
        $sql = 'INSERT INTO submissions (
            reference_number, department_id, hod_user_id, staff_name, submitted_by, designation, email, phone,
            student_growth, department_growth, special_achievements, events_conducted,
            income_generation, industry_partnerships, research_innovations, staff_development,
            infrastructure_development, community_services, future_plans, supporting_documents, google_drive_link,
            submission_date, status, created_at, updated_at
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

        $now = date('Y-m-d H:i:s');
        $stmt = db()->prepare($sql);
        $stmt->execute([
            $data['reference_number'],
            $data['department_id'],
            $data['hod_user_id'] ?? null,
            $data['staff_name'],
            $data['submitted_by'],
            $data['designation'] ?: null,
            $data['email'],
            $data['phone'],
            json_encode($data['student_growth']),
            json_encode($data['department_growth']),
            json_encode($data['special_achievements']),
            json_encode($data['events_conducted']),
            json_encode($data['income_generation']),
            json_encode($data['industry_partnerships']),
            json_encode($data['research_innovations']),
            json_encode($data['staff_development']),
            $data['infrastructure_development'] ?: null,
            json_encode($data['community_services']),
            json_encode($data['future_plans']),
            $documentPath,
            ($data['google_drive_link'] ?? '') ?: null,
            $now,
            $data['status'] ?? 'pending',
            $now,
            $now,
        ]);

        return (int)db()->lastInsertId();
    }

    public static function update(int $id, array $data, ?string $documentPath, ?int $hodUserId = null): void
    {
        $existing = self::find($id);
        if ($hodUserId) {
            $hod = HodUser::find($hodUserId);
            if (!$hod || (int)($existing['department_id'] ?? 0) !== (int)$hod['department_id']) {
                throw new RuntimeException('You can only update your department submission.');
            }
        }
        $doc = $documentPath ?? ($existing['supporting_documents'] ?? null);
        $driveLink = array_key_exists('google_drive_link', $data)
            ? (($data['google_drive_link'] ?? '') ?: null)
            : ($existing['google_drive_link'] ?? null);

        $sql = 'UPDATE submissions SET
            department_id=?, hod_user_id=?, staff_name=?, submitted_by=?, designation=?, email=?, phone=?,
            student_growth=?, department_growth=?, special_achievements=?, events_conducted=?,
            income_generation=?, industry_partnerships=?, research_innovations=?, staff_development=?,
            infrastructure_development=?, community_services=?, future_plans=?, supporting_documents=?, google_drive_link=?,
            status=?, updated_at=?
            WHERE id=?';

        $stmt = db()->prepare($sql);
        $stmt->execute([
            $data['department_id'],
            $hodUserId ?? ($existing['hod_user_id'] ?? null),
            $data['staff_name'],
            $data['submitted_by'],
            $data['designation'] ?: null,
            $data['email'],
            $data['phone'],
            json_encode($data['student_growth']),
            json_encode($data['department_growth']),
            json_encode($data['special_achievements']),
            json_encode($data['events_conducted']),
            json_encode($data['income_generation']),
            json_encode($data['industry_partnerships']),
            json_encode($data['research_innovations']),
            json_encode($data['staff_development']),
            $data['infrastructure_development'] ?: null,
            json_encode($data['community_services']),
            json_encode($data['future_plans']),
            $doc,
            $driveLink,
            $data['status'] ?? 'pending',
            date('Y-m-d H:i:s'),
            $id,
        ]);
    }

    public static function updateStatus(int $id, string $status): void
    {
        $stmt = db()->prepare('UPDATE submissions SET status=?, updated_at=? WHERE id=?');
        $stmt->execute([$status, date('Y-m-d H:i:s'), $id]);
    }

    public static function delete(int $id): void
    {
        $sub = self::find($id);
        if ($sub && !empty($sub['supporting_documents']) && file_exists(ROOT_PATH . '/' . $sub['supporting_documents'])) {
            unlink(ROOT_PATH . '/' . $sub['supporting_documents']);
        }
        $stmt = db()->prepare('DELETE FROM submissions WHERE id = ?');
        $stmt->execute([$id]);
    }
}
