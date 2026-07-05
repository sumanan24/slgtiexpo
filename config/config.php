<?php

return [
    'app_name' => 'SLGTI Impact Report',
    'db_host' => '127.0.0.1',
    'db_port' => '3307', // WAMP MariaDB. Use 3306 on cPanel/shared hosting.
    'db_name' => 'slgti_impact',
    'db_user' => 'root',
    'db_pass' => '',
    // Set to false on shared hosting when the database is already created in cPanel.
    'db_allow_create' => true,
    'upload_max_size' => 10485760, // 10MB
    'allowed_extensions' => ['pdf', 'docx', 'jpg', 'jpeg', 'png'],
];
