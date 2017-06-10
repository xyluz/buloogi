<?php session_start();

//get required libraries
require_once('_autoload.php');
require_once '../lib/function.php';

//collect all fields

$section = $_GET[section];
$field = $_GET[field];
$firstname = $_POST[firstname];
$lastname = $_POST[lastname];
$middlename = $_POST[middlename];
$phone1 = $_POST[phone1];
$phone2 = $_POST[phone2];
$email = $_POST[email];
$address = $_POST[address];
$occupation = $_POST[occupation];
$dob = $_POST[dob];

$_SESSION[error]= 0;
//swith section

switch($section){
    case "personal":
     //for personal   
        switch ($field){
            case "firstname":               
               
                if(!ctype_alpha($firstname)){
                    $_SESSION[error]++;
                    echo 'no numbers allowed in this field';
                }
                if(strlen ($firstname) < 3){
                    $_SESSION[error]++;
                    echo 'First Name is too short';
                }else{
                    $_SESSION[error];
                }
                
                break;
            case "lastname":               
               
                if(!ctype_alpha($lastname)){
                    echo 'no numbers allowed in this field';
                }else if(strlen ($lastname) < 3){
                    echo 'Last Name is too short';
                }
                
                break;    
            case "middlename":               
               
                if(!ctype_alpha($middlename)){
                    echo 'no numbers allowed in this field';
                }else if(strlen ($middlename) < 3){
                    echo 'Middle Name is too short';
                }
                
                break;    
            case "phone1":               
               
                if(ctype_alpha($phone1)){
                    echo 'only numbers allowed';
                }
                //check if phone number is not already in use
                
                break;    
            case "phone2":               
               
                if(ctype_alpha($phone2)){
                    echo 'only numbers allowed';
                }
                //check if phone number is not already in use
                break;    
            case "email":               
               
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) ) { 
                     echo 'Email is incorrect';
                }
                //check that email is not already in use
                
                break;    
            default : 
                echo $field . ' was not validated, something went wrong';                
        }
    
    case "nok":
    //for next of kin
        switch($field){
        
        }
       
    case "payment":
    //for payment 
        switch($field){
        
        }
}

//switch fileds
//validate each field by connecting to database and checking length
//return true or false