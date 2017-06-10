<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';

$data = new upload();
$user = new user();

$id = $_GET[id];


$delete = $data->deleteData($id);
   

    
    if($delete){
         $user->database_action_log($_SESSION[admin_id], "All $id Data was deleted");
        echo "Delete of Data $id was successful";    
    }
    else{    
         $user->database_action_log($_SESSION[admin_id], "tried to delete Data $id, Failed!");
        echo "Delete of Data $id was not successful";  
    }
               
            