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
    $dsn = sprintf(
        'mysql:host=%s;port=%s;charset=utf8mb4',
        $config['db_host'],
        $config['db_port']
    );

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

function db_server(): PDO
{
    [$user, $pass] = db_credentials();
    return new PDO(db_dsn(), $user, $pass, db_options());
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        global $config;
        [$user, $pass] = db_credentials();
        $pdo = new PDO(db_dsn($config['db_name']), $user, $pass, db_options());
    }

    return $pdo;
}

function install_database(): void
{
    global $config;

    $dbName = $config['db_name'];
    $pdo = db_server();
    $pdo->exec(sprintf(
        'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
        str_replace('`', '``', $dbName)
    ));

    $sql = file_get_contents(ROOT_PATH . '/database/slgti_impact.sql');
    if ($sql === false) {
        throw new RuntimeException('Could not read database/slgti_impact.sql');
    }

    $sql = preg_replace('/^CREATE DATABASE.*?;\s*/is', '', $sql) ?? $sql;
    $sql = preg_replace('/^USE\s+.*?;\s*/im', '', $sql) ?? $sql;

    $pdo->exec('USE `' . str_replace('`', '``', $dbName) . '`');
    $pdo->exec($sql);
}
