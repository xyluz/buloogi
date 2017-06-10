<?php session_start();

require_once('_autoload.php');
require_once '../lib/function.php';

$user = new User();

$id = $_POST[id];
$fullname = $_POST[fullname];
$level = $_POST[level];
$userid = $_POST[userid];
$password = $_POST[password];
$office = $_POST[office];
$email = $_POST[email];

$go = $user->update_admin($id, $fullname, $userid, $password, $level, $email, $office);

if($go > 0){
    
    $user->database_action_log($_SESSION[admin_id], "admin $fullname was updated");
    redirect_to('single_admin.php?id='.$id);
    
}else{
    $user->database_action_log($_SESSION[admin_id], "tried to update admin $fullname ~ failed");
    echo "update not done" . $id;
}
