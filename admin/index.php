<?php session_start();

require_once('_autoload.php');
require_once '../lib/function.php';
	
    $session = new Session();
    
    if($session->is_logged_in()){
//        log_action("NULL","Tried to login", "Already logged in, redirected to dashboard");
        redirect_to("dashboard.php");
    }
    else{
//        log_action("NULL","Tried to login", "redirected to login");
        redirect_to("login.php");
    }
	
