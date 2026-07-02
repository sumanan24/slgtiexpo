<?php
require_once dirname(__DIR__) . '/includes/init.php';
admin_logout();
redirect('admin/login.php');
