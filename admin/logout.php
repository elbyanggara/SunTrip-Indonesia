<?php
/**
 * SunTrip Indonesia - Admin Logout
 */

require_once __DIR__ . '/../includes/config.php';

unset($_SESSION['admin_id']);
unset($_SESSION['admin_user']);
unset($_SESSION['admin_name']);

header("Location: /admin/login.php");
exit;
