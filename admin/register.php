<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';
require_once '../lib/constants.php';

if($_SESSION[locked]){
redirect_to('lockscreen.php');
}

//used for lockscreen redirect
$_SESSION[my_url] = $_SERVER[REQUEST_URI];

$session = new Session();

$user = new user();

if(isset($_POST['create'])){
	
//echo en_al($_POST['password']);
	//TODO: Form validation, log action, authenticate user in database, redirect to dashboard
	//form validation
//	$validate = new FormValidator();
//	$validate->addValidation('fullName','req',"The FUll Name is required");
//	$validate->addValidation('userid','req',"The user ID is required");
//	$validate->addValidation('password','req',"The Password is required");
//	$validate->addValidation('level','req',"The Level is required");
	
//	if(!$validate->ValidateForm())
//	{
//		$error_hash = $validate->GetErrors();
//		foreach($error_hash as $inpname => $inp_err)
//		{
//                    $error .= "<p>$inp_err</p>\n";
//                    
//		}
////                store in error session 
//              
//                $session->error($error);
//                $error = $session->error;
//		//log error 
////		log_action($_POST['userid'],"Tried to log in","The following errors occurred " . $error);
//	}
//	else{
     $fullName = $_POST[fullName]; 
     $userid= $_POST[userid]; 
     $password = en_al($_POST[password]); 
     $level = "Level 1";
     
                $create = $user->create_admin($fullName, $userid, $password, $level);
		
		if($create != 1){                   
			 $session->error("Admin not created");                         
//			log_action("Tried to log in","User was not found in the database username : " . $_POST['userid'] . "password : " . $_POST['password']);
                         $user->database_action_log($_SESSION[admin_id], "Tried to add new admin ~ failed");
                        redirect_to('register.php');
                   
			}
			else{
                           
//				log_action($_POST['userid'],"Tried to log in","Log in successful");                              
//                                echo $check . $_POST[userid];
//                               $session->login();  
//                               $user->online();                                     
//                              $session->message("Login successful... Welcome " . $_SESSION[user]); 
                             $user->database_action_log($_SESSION[admin_id], "Tried to add new admin ~ successful");
                              redirect_to('admins.php');
                              
				
				}
		
		}
    
//}
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo CLIENT; ?> | REGISTER</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <b>NSE</b> E-MANAGER 
      </div>
 <?php // require_once('../includes/alert.php'); ?>
      <div class="register-box-body">
        <p class="login-box-msg">Register a New Administrator 1</p>
        <form  method="post">
          <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Full name" name="fullName"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="userid" name="userid"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
<!--          <div class="form-group has-feedback">
              <select class="form-control" name="level">
                  <option value="level1">Level 1 (Partial Access)</option>
                  <option value="level2">Level 2 (Full Access)</option>
              </select>
            <span class="glyphicon glyphicon-list form-control-feedback"></span>
          </div>-->
          <div class="row">
            
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat" name="create">Register</button>
            </div><!-- /.col -->
          </div>
        </form> 
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>