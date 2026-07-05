<?php
require_once dirname(__DIR__) . '/includes/init.php';
redirect(hod_user() ? 'hod/submission.php' : 'hod/login.php');
