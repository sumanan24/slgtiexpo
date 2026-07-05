<?php

/**
 * Copy this file to config.php and update values for your server.
 *
 * Local WAMP example:
 *   db_host => 127.0.0.1, db_port => 3307, db_allow_create => true
 *
 * cPanel / shared hosting example:
 *   db_host => localhost, db_port => 3306, db_allow_create => false
 *   Use the database name, username, and password from cPanel > MySQL Databases.
 */
return [
    'app_name' => 'SLGTI Impact Report',
    'db_host' => 'localhost',
    'db_port' => '3306',
    'db_name' => 'your_cpanel_db_name',
    'db_user' => 'your_cpanel_db_user',
    'db_pass' => 'your_db_password',
    'db_allow_create' => false,
    'upload_max_size' => 10485760,
    'allowed_extensions' => ['pdf', 'docx', 'jpg', 'jpeg', 'png'],
];
