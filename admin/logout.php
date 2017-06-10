<?php session_start();

require_once('_autoload.php');
require_once '../lib/function.php';

$session = new Session();
$user = new user();
   $user->database_action_log($_SESSION[admin_id], "Logout Successful");
   $session->logout();
   $user->offline($_SESSION[admin_id]);
//   log_action('Logout', "logout successful"); 
 
    redirect_to('index.php');
   
   