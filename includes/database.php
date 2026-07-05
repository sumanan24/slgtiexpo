<?php

declare(strict_types=1);

function db_options(): array
{
    return [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
}

function db_dsn(?string $database = null): string
{
    global $config;
    $host = $config['db_host'];
    $port = trim((string)($config['db_port'] ?? '3306'));

    if ($port === '') {
        $dsn = sprintf('mysql:host=%s;charset=utf8mb4', $host);
    } else {
        $dsn = sprintf('mysql:host=%s;port=%s;charset=utf8mb4', $host, $port);
    }

    if ($database !== null) {
        $dsn .= ';dbname=' . $database;
    }

    return $dsn;
}

function db_credentials(): array
{
    global $config;
    return [$config['db_user'], $config['db_pass']];
}

function db_connect(?string $database = null): PDO
{
    [$user, $pass] = db_credentials();
    return new PDO(db_dsn($database), $user, $pass, db_options());
}

function db_server(): PDO
{
    return db_connect();
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        global $config;
        $pdo = db_connect($config['db_name']);
    }

    return $pdo;
}

function db_connection_hint(Throwable $e): string
{
    global $config;

    $message = $e->getMessage();
    if (!str_contains($message, '2002') && !str_contains($message, 'Connection refused')) {
        return '';
    }

    $host = $config['db_host'] ?? '';
    $port = $config['db_port'] ?? '';

    if ($host === '127.0.0.1' && (string)$port === '3307') {
        return 'This looks like a local WAMP setting (127.0.0.1:3307). On shared hosting, use localhost, port 3306, and the MySQL details from cPanel.';
    }

    return 'MySQL is not reachable at the configured host/port. Confirm db_host, db_port, db_user, and db_pass in config/config.php match your hosting control panel.';
}

function install_database(): void
{
    global $config;

    $dbName = $config['db_name'];
    $allowCreate = $config['db_allow_create'] ?? true;

    $sql = file_get_contents(ROOT_PATH . '/database/slgti_impact.sql');
    if ($sql === false) {
        throw new RuntimeException('Could not read database/slgti_impact.sql');
    }

    $sql = preg_replace('/^CREATE DATABASE.*?;\s*/is', '', $sql) ?? $sql;
    $sql = preg_replace('/^USE\s+.*?;\s*/im', '', $sql) ?? $sql;

    if ($allowCreate) {
        $pdo = db_server();
        $pdo->exec(sprintf(
            'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
            str_replace('`', '``', $dbName)
        ));
        $pdo->exec('USE `' . str_replace('`', '``', $dbName) . '`');
    } else {
        $pdo = db();
    }

    $pdo->exec($sql);
}
