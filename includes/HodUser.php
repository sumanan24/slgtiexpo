<?php

declare(strict_types=1);

class HodUser
{
    public static function find(int $id): ?array
    {
        $stmt = db()->prepare(
            'SELECT h.*, d.department_name
             FROM hod_users h
             JOIN departments d ON d.id = h.department_id
             WHERE h.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = db()->prepare(
            'SELECT h.*, d.department_name
             FROM hod_users h
             JOIN departments d ON d.id = h.department_id
             WHERE h.email = ?'
        );
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function availableDepartments(): array
    {
        return Department::all();
    }

    public static function create(array $data): int
    {
        $now = date('Y-m-d H:i:s');
        $stmt = db()->prepare(
            'INSERT INTO hod_users (department_id, name, email, password, phone, designation, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['department_id'],
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['phone'] ?: null,
            $data['designation'] ?: null,
            $now,
            $now,
        ]);
        return (int)db()->lastInsertId();
    }

    public static function updateProfile(int $id, array $data): void
    {
        $fields = ['name = ?', 'email = ?', 'phone = ?', 'designation = ?', 'updated_at = ?'];
        $params = [
            $data['name'],
            $data['email'],
            $data['phone'] ?: null,
            $data['designation'] ?: null,
            date('Y-m-d H:i:s'),
        ];

        if (!empty($data['password'])) {
            $fields[] = 'password = ?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $params[] = $id;
        $sql = 'UPDATE hod_users SET ' . implode(', ', $fields) . ' WHERE id = ?';
        db()->prepare($sql)->execute($params);
    }
}
