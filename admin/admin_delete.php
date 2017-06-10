<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';

$user = new user();
$id = $_GET[id];


foreach($user->search_admin($id) as $admin){
    $status = $admin[status];
    $online = $admin[online];
//    $id = $admin[admin_id];
}
 if($online){
        echo "the admin is presently online and cannot be deleted";
         $user->database_action_log($_SESSION[admin_id], "admin delete not successful, the admin is online");
        exit();
 }else{
                if($status == 0){

                $delete = $user->remove_admin($id);


                }else{

                $delete = $user->delete_admin($id);

                }
 }
    if($delete){
        $user->database_action_log($_SESSION[admin_id], "admin delete successful");
        echo "Admin Delete Succesful";    
    }
    else{     
        $user->database_action_log($_SESSION[admin_id], "admin delete not successful");
        echo "Admin Delete Not Succesful";  
    }
               
            