<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';
$session = new Session();
if(!$session->is_logged_in()){
    redirect_to("index.php");
}
else{

$user = new user();
$target_dir = "admin/";

if(isset($_POST[avatarPick])&& ($_POST[avatarPick] != NULL) && ($_POST[avatarPick]!="")){
   $user->admin_photo($_POST[avatarPick], $_POST[id]);
   $user->database_action_log($_SESSION[admin_id], "Admin avatar added");
   redirect_to('admins.php');
}


    $target_file = $target_dir . basename($_FILES["passport"]["name"]);
    $uploadOk = 1;
    $errorList = array();
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


        $check = getimagesize($_FILES["passport"]["tmp_name"]);

        if($check !== false) {       

            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $user->database_action_log($_SESSION[admin_id], "tried to add admin photo, the file is not an image");

            exit;
        }

    // Check if file already exists
    if (file_exists($target_file)) {
        $user->database_action_log($_SESSION[admin_id], "tried to add admin photo, The photo is already in use");


        $uploadOk = 0;
        exit;
    }
    // Check file size
    if ($_FILES["passport"]["size"] > 500000) {
    // $errorList += "Sorry, your file is too large.";
         $user->database_action_log($_SESSION[admin_id], "tried to add admin photo, The photo is too large");

        $uploadOk = 0;
        exit;
    }
    // Allow certain file formats
    if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" ) {
        $uploadOk = 1;
    }
    else{
        $user->database_action_log($_SESSION[admin_id], "tried to add admin photo, Photo not in accepted format");

        $uploadOk = 0;
        exit;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $user->database_action_log($_SESSION[admin_id], "tried to add admin photo, Something went wrong");

        exit;          

    // if everything is ok, try to upload file
    } 
        if (move_uploaded_file($_FILES["passport"]["tmp_name"], $target_file)) {

            $try = $user->admin_photo($target_file, $_POST[id]);

            if($try > 0){
                $user->database_action_log($_SESSION[admin_id], "admin photo added ");
            redirect_to('edit_admin.php?photoupload=true');        
            }
            else{
                 $user->database_action_log($_SESSION[admin_id], "tried to add customer photo, Something went wrong");
                redirect_to("edit_admin.php");
            }
        }
        else{
            redirect_to('edit_admin.php?photoupload=false');

        }
}

