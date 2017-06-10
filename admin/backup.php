<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';

$backup = new backup();
$user = new User();
$do = $backup->run_backup('*');
$user = new User();
        $user->database_action_log($_SESSION[admin_id], "Back up successfully done");
echo 'Backup done... filename: ' . $do;

