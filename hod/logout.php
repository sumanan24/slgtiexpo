<?php
require_once dirname(__DIR__) . '/includes/init.php';
hod_logout();
flash('success', 'You have been logged out.');
redirect('hod/login.php');
