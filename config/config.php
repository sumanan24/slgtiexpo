<?php

return [
    'app_name' => 'SLGTI Impact Report',
    'db_host' => '127.0.0.1',
    'db_port' => '3307', // WAMP MariaDB default port (use 3306 for MySQL)
    'db_name' => 'slgti_impact',
    'db_user' => 'root',
    'db_pass' => '',
    'upload_max_size' => 10485760, // 10MB
    'allowed_extensions' => ['pdf', 'docx', 'jpg', 'jpeg', 'png'],
];
