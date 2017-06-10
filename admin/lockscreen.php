<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';

$_SESSION[locked] = true;

$user = new User();
$session = new Session();
//if(!$session->is_logged_in()){
//    redirect_to("index.php");
//}
//else{
    foreach($user->lockscreen_info($_SESSION[admin_id]) as $admin){
        $photo = $admin[photo];
        $name = $admin[fullName];
        $password = en_al($admin[password]);
//    }
    $user->database_action_log($_SESSION[admin_id], "Screen locked by admin $name");
    if(isset($_POST[unlock])){
        
        if($password == en_al($_POST[password])){
            $_SESSION[locked] = false;
            $user->database_action_log($_SESSION[admin_id], "Screen unlocked by admin $name");
            //get the address that opened a page
            redirect_to($_SESSION[my_url]);
            
         
        }else{           
         $message = 'Incorrect Login Details';   
        }
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>PIVSS | Screen Locked</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a href="index2.html"><b>PIVSS E-</b>Manager</a>
        
      </div> <?php if(isset($message)){ echo $message; } ?>
      <!-- User name -->
      <div class="lockscreen-name"><?php echo $name ?></div>
        
      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="<?php echo $photo ?>" alt="user image"/>
        </div>
        <!-- /.lockscreen-image -->
       
        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" method="post">
          <div class="input-group">
              <input type="password" class="form-control" placeholder="password" name="password" />
            <div class="input-group-btn">
                <button class="btn" type="submit" name="unlock"><i class="fa fa-arrow-right text-muted"></i></button>
            </div>
          </div>
        </form><!-- /.lockscreen credentials -->

      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Enter your password to retrieve your session
      </div>
      
      <div class='text-center'>
          <a href="logout.php">Or sign in as a different user</a>
      </div>
      
    </div><!-- /.center -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>