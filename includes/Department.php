<?php

declare(strict_types=1);

class Department
{
    public static function all(): array
    {
        return db()->query('SELECT * FROM departments ORDER BY department_name')->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = db()->prepare('SELECT * FROM departments WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function withSubmissionCounts(): array
    {
        $sql = 'SELECT d.*, COUNT(s.id) AS submissions_count
                FROM departments d
                LEFT JOIN submissions s ON s.department_id = d.id
                GROUP BY d.id
                ORDER BY d.department_name';
        return db()->query($sql)->fetchAll();
    }
}
