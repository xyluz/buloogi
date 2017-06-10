<?php   session_start();
        require_once '../lib/constants.php';
        require_once '../lib/function.php';
        require_once('_autoload.php');        
       
 
class global_settings {
    
    public $database;
   
    public function __construct() {
       $this->database = new Database();
       $this->database->getLink();
    }
    
    public function HTML5($page){
        echo "<!DOCTYPE html>
<html>
  <head>
    <meta charset='UTF-8'>
    <title>" . CLIENT . " ~ " . $page . "</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>    
    <link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />   
    <link href='offlineCSS/font-awesome.css' rel='stylesheet' type='text/css' />    
    <link href='offlineCSS/ionicons.css' rel='stylesheet' type='text/css' />      
    <link href='plugins/jvectormap/jquery-jvectormap-1.2.2.css' rel='stylesheet' type='text/css' />    
    <link href='dist/css/AdminLTE.min.css' rel='stylesheet' type='text/css' />  
    <link href='dist/css/skins/_all-skins.min.css' rel='stylesheet' type='text/css' />   
    <!--[if lt IE 9]>
        <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
        <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->
  </head>";
    }
   
    public function navigation(){
        $user = new user();
        foreach($user->search_admin($_SESSION[admin_id]) as $single_admin){
            
        echo "<body class='skin-blue sidebar-mini'>
    <div class='wrapper'>

      <header class='main-header'>

        <!-- Logo -->
        <a href='index.php' class='logo'>
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class='logo-mini'><b>NSE</b>EM</span>
          <!-- logo for regular state and mobile devices -->
          <span class='logo-lg'><b>NSE </b> E-Manager </span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class='navbar navbar-static-top' role='navigation'>
          <!-- Sidebar toggle button-->
          <a href='#' class='sidebar-toggle' data-toggle='offcanvas' role='button'>
            <span class='sr-only'>Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class='navbar-custom-menu'>
            <ul class='nav navbar-nav'> 
            
              <!-- User Account: style can be found in dropdown.less -->
              <li class='dropdown user user-menu'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                  <img src='" . $single_admin[photo] . "' class='user-image' alt='User Image'/>
                  <span class='hidden-xs'>$single_admin[fullName]</span>
                </a>
                <ul class='dropdown-menu'>
                  <!-- User image -->
                  <li class='user-header'>
                    <img src='" . $single_admin['photo'] . "' class='img-circle' alt='User Image' />
                    <p>"
                                        . $single_admin[fullName] ." - " . $single_admin[office]. " <small>Admin since " . $single_admin[date] . "</small>
                    </p>
                  </li>                 
                  <!-- Menu Footer-->
                  <li class='user-footer'>
                    <div class='pull-left'>
                      <a href='single_admin.php?id=$single_admin[admin_id]' class='btn btn-default btn-flat'>Profile</a>
                    </div>
                    <div class='pull-left'>
                      <a href='lockscreen.php' class='btn btn-default btn-flat'>Lockscreen</a>
                    </div>
                    <div class='pull-right'>
                        <a href='logout.php' class='btn btn-default btn-flat'>Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href='#' data-toggle='control-sidebar'><i class='fa fa-gears'></i></a>
              </li>
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class='main-sidebar'>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class='sidebar'>
          <!-- Sidebar user panel -->
          <div class='user-panel'>
            <div class='pull-left image'>
              <img src='". $single_admin[photo] ."' class='img-circle' alt='User Image' />
            </div>
            <div class='pull-left info'>
              <p><a href='myprofile.php'>". $single_admin[fullName]."</a></p>

              <a href='admins.php'><i class='fa fa-circle text-success'></i> Online</a>
            </div>
          </div>
         
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class='sidebar-menu'>
            <li class='header'>MAIN NAVIGATION</li>
            <li class='active treeview'>
              <a href='index.php'>
                <i class='fa fa-dashboard'></i><span>Dashboard</span> <i class='fa fa-angle-left pull-right'></i>
              </a>             
            </li>            
             
            <li class='treeview'>
              <a href='datamenu.php'>
                <i class='fa fa-area-chart'></i>
                <span>Market Data</span>              
              </a>             
            </li>
            <li class='treeview'>
              <a href='#'>
                <i class='fa fa-user'></i>
                <span>Administrators</span>
                <span class='label label-primary pull-right'>3</span>
              </a>
              <ul class='treeview-menu'>
                <li><a href='admins_online.php'><i class='fa fa-circle-o'></i>Online</a></li>
                <li><a href='admins_offline.php'><i class='fa fa-circle-o'></i> Offline</a></li>
                <li><a href='admins_deleted.php'><i class='fa fa-circle-o'></i> Deleted</a></li>
                <li><a href='admins.php'><i class='fa fa-circle-o'></i> View all</a></li>
                <li><a href='register.php'><i class='fa fa-circle-o'></i> Add new</a></li>
                
              </ul>
            </li>
            <li class='treeview'>
              <a href='log.php'>
                <i class='fa fa-file'></i>
                <span>Log</span>
                <span class='label label-primary pull-right'>3</span>
              </a>              
            </li>
             
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>";
        }
    }

    public function count_trackers(){
        //count all trackers
        $this->database->query("SELECT count(*) FROM trackers");
        $this->database->execute();
        return $this->database->single();
    }
    
    public function create_tracker($name,$price,$admin){        
       try{ 
        $this->database->query("INSERT INTO trackers (name,price,admin,date) VALUES(:name,:price,:admin,NOW())");
        $this->database->bind("name", $name);
        $this->database->bind("price", $price);
        $this->database->bind("admin", $admin);        
        $this->database->execute();
        return $this->database->rowCount();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
           echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function get_all_trackers(){
        try{
        $this->database->query("SELECT * FROM trackers");
        $this->database->execute();
        return $this->database->resultset();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
           echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function delete_tracker($id){
        try{
        //delete a tracker to change        
        $this->database->query("DELETE FROM trackers WHERE id=:id");
        $this->database->bind("id", $id);
        $this->database->execute();
        return $this->database->rowCount();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
           echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function add_service_price($id,$price,$admin){
        try{
        $this->database->query("UPDATE services SET price=:price, admin=:admin, date=NOW() WHERE id='$id'");
        $this->database->bind("price", $price);
        $this->database->bind("admin", $admin);
        
        $this->database->execute();
        return $this->database->rowCount();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
           echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function get_all_services(){
        try{
        $this->database->query("SELECT * FROM services");
        $this->database->execute();
        return $this->database->resultset();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
           echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
}
