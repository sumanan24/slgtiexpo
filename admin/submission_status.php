<?php
require_once dirname(__DIR__) . '/includes/init.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/submissions.php');
verify_csrf();
$id = (int)($_POST['id'] ?? 0);
$status = $_POST['status'] ?? 'pending';
if (!in_array($status, ['pending', 'completed'], true)) redirect('admin/submission_view.php?id=' . $id);
Submission::updateStatus($id, $status);
flash('success', 'Status updated successfully.');
redirect('admin/submission_view.php?id=' . $id);
