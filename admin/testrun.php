<?php 

require_once '../includes/excel_reader.php';

 


if(isset($_FILES['file'])){
    
        
    $target_dir = "../includes/";
    
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    
  
//    $uploadOk = 1;
//    $errorList = array();
////    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//    
     if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
         
          $excel = new PhpExcelReader;      // creates object instance of the class
    
        
    
     $excel->read($target_file);   // reads and stores the excel file data
//
//    // Test to see the excel data stored in $sheets property
    echo '<pre>';
    print_r($excel->sheets);
//
    echo '</pre>';
         
     }
//
////            $try = $user->admin_photo($target_file, $_POST[id]);
//
//            if($try > 0){
//                $user->database_action_log($_SESSION[admin_id], "admin photo added ");
//            redirect_to('edit_admin.php?photoupload=true');        
//            }
//            else{
//                 $user->database_action_log($_SESSION[admin_id], "tried to add customer photo, Something went wrong");
//                redirect_to("edit_admin.php");
//            }
//        }
    
//    echo "set";
    
   
//
//    or 
//
// echo '<pre>';
//    print_r($excel->sheets);
//
//    echo '</pre>';


    
}else{
    
    echo "not set";
}



