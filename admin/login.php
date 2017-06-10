<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';
require_once '../lib/constants.php';

$session = new Session();
$user = new user();

if($_SESSION[locked]){
redirect_to('lockscreen.php');
}


//used for lockscreen redirect
$_SESSION[my_url] = $_SERVER[REQUEST_URI];

if(isset($_POST['login'])){

//echo en_al($_POST['password']);
	//TODO: Form validation, log action, authenticate user in database, redirect to dashboard
	//form validation
	// $validate = new FormValidator();
	// $validate->addValidation('userid','req',"The user ID is required");
	// $validate->addValidation('password','req',"The Password is required");
	//
	// if(!$validate->ValidateForm())
	// {
	// 	$error_hash = $validate->GetErrors();
	// 	foreach($error_hash as $inpname => $inp_err)
	// 	{
  //                   $error .= "<p>$inp_err</p>\n";
  //
	// 	}
//                store in error session
                // $session->error($error);
                // $error = $session->error;
		//log error
		// log_action($_POST['userid'],"Tried to log in","The following errors occurred " . $error);
	// }
	// else{
		//check  database, log action
		$check = $user->authenticate($_POST['userid'], en_al($_POST['password']));

		if(empty($check)){
                    $session->error("Login failed.");
//                    $error = "Login Failed";
                        redirect_to('index.php');
			}
			else{
                           $session->message('Login Successful');
                           $_SESSION[admin_id] = $check['admin_id'];
                           $session->login($_SESSION[admin_id]);
                           $user->online($_SESSION[admin_id]);
                           $user->database_action_log($_SESSION[admin_id], "Login Successful");
                           redirect_to('dashboard.php');

				}

		// }
}

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo CLIENT; ?> | LOGIN</title>
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
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <b>NSE</b> E-MANAGER
      </div><!-- /.login-logo -->
     <div class="box box-default">
                <div class="box-body">

          <?php
//     require_once('../includes/alert.php');

//                     if(isset($error) && $error != ""){
//                         echo "<div class='alert alert-danger alert-dismissable'>
//                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
//                    <h4><i class='icon fa fa-ban'></i> Error!</h4>
//                    $error
//                  </div>";
//                     }
//           $session->check_error();
           echo $session->error();
//          $error = $session->error();
//          echo $error;
     ?>
                </di>
                </div>
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form method="post">
          <div class="form-group has-feedback">
              <input type="userid" class="form-control" placeholder="User ID" name="userid" required/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Password" name="password" required/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat" name="login">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

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
