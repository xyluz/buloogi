<?php session_start();
require_once('_autoload.php');
require_once '../lib/function.php';

if($_SESSION[locked]){
redirect_to('lockscreen.php');
}

//used for lockscreen redirect
$_SESSION[my_url] = $_SERVER[REQUEST_URI];

//instantiate instances
$session = new Session();

$user = new User();
if(!$session->is_logged_in()){
    redirect_to("index.php");
}
else{
    $setting = new global_settings();
    
    foreach($user->search_admin($_GET[id]) as $person){
        
    }
    
    $setting->HTML5($person[fullName]);
     $setting->navigation();
}
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Administrator
            <small><?php echo  $person[fullName] ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo  $person[fullName]  ?></h3>
              
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="box box-solid">
                    
                    <div class="box-body">
                        <img src="<?php echo $person[photo]  ?>" class="img-rounded" width="200px" height="250px"/>
                    </div><!-- /.box-body -->
                    <div class="col-md-12"> 
                     
                     <a href="edit_admin.php" class="btn btn-info"  title="edit $single_admin[userId]"><i class="fa fa-edit"></i></a> <a  id="more" href="single_admin.php?id=$single_admin[admin_id]" class="btn btn-primary" title="more about $single_admin[userId]"><i class="fa fa-eye"></i></a> <a onclick="" class="btn btn-danger" title="delete $single_admin[userId]"><i class="fa fa-trash"></i></a>
                  </div>
                  </div><!-- /.box -->
                </div><!-- ./col -->
                <div class="col-md-5">
                  <div class="box box-solid">
                    
                    <div class="box-body">
                        <p class="lead"><strong>Full Name:</strong> <?php echo  $person[fullName] ?></p>
                        <p class="lead"><strong>Admin Level:</strong> <?php echo  $person[level] ?></p>
                        <p class="lead"><strong>User ID:</strong> <?php echo  $person[userId] ?></p>
                        <p class="lead"><strong>Password:</strong> <?php echo  $person[password] ?> <small>(encrypted)</small></p>
                        <p class="lead"><strong>Email:</strong> <?php echo  $person[email] ?> </p>
                        <p class="lead"><strong>Office:</strong> <?php echo  $person[office] ?> </p>
                        <p class="lead"><strong>Last Login:</strong> <?php echo  $person[last_login] ?> </p>
                      
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                </div><!-- ./col -->
                <div class="col-md-3">
                  <div class="box box-solid">
                    
                    <div class="box-body">
                       Instructions
                    </div><!-- /.box-body -->
                    <div class="col-md-12"> 
                     
                    
                  </div>
                  </div><!-- /.box -->
                </div><!-- ./col -->
              </div><!-- /.row -->
              <div class="row">
                 
                  
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Control Sidebar -->      
      <aside class="control-sidebar control-sidebar-dark">                
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class='control-sidebar-menu'>
                 <?php                      
                        foreach($user->fetch_database_log() as $activity){
                          
                            foreach($user->search_admin($activity[admin_id]) as $admin_person){
                                                       
                            echo " 
                              <li>
                                <a href='javascript::;'>
                                   <img class='direct-chat-img' src='$admin_person[photo]' alt='message user image' />
                                  <div class='menu-info'>
                                    <h4 class='control-sidebar-subheading'>$admin_person[fullName] | $activity[Date]</h4>
                                    <p>$activity[message]</p>
                                  </div>
                                </a>
                              </li>";
                            }
                        }
                        ?>
            </ul><!-- /.control-sidebar-menu -->
          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">            
              <form method="post" id="tr">
              <h3 class="control-sidebar-heading">Global Settings</h3>
              <div class="form-group">
                  <p>
                  Some information about this general settings option
                </p>
                <label class="control-sidebar-subheading">
                  Create Tracker                  
                </label>
                <input name="tracker_name" type="text" id="tr_name" placeholder="name" />
                <input name="tracker_price" type="text" id="tr_price" placeholder="price"/>                     <button type="button" onclick="create_tracker()" class="btn btn-primary">Create Tracker</button>
                
              </div><!-- /.form-group -->

              <div class="form-group">
                <p>
                  List of Trackers, you can delete trackers from here
                </p>
                <label class="control-sidebar-subheading">
                  Trackers               
                </label>
               
                <?php 
                    foreach($setting->get_all_trackers() as $track){
                        echo "<p>$track[name] <a href='#' title='$track[id]' onclick='delete_tracker($track[id])' class='text-red pull-right'><i class='fa fa-trash-o' ></i></a></p>";
                    }
                ?>
               
              </div><!-- /.form-group -->
              
              <div class="form-group">
                  <p>
                 Select the service you wish to update, and enter the price below. Click on the change button to effect the change
                </p>
                <label class="control-sidebar-subheading">
                  Change Service                  
                </label>
                <select id="sr_id">
                    <?php foreach($setting->get_all_services() as $service){
                        echo "<option value='$service[id]'>$service[name]</option>";
                    }
                    ?>
                </select>
                <input name="service_price" type="text" id="sr_price" placeholder="price"/>                     <button type="button" onclick="change_service()" class="btn btn-warning">Change</button>
                
              </div><!-- /.form-group -->
              
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    
    <!-- Demo -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
    <script type="text/javascript">
        function delete_tracker(t){ 
                    var response = confirm('are you sure you want to delete this item?');
                   if(response === true){
                       
                        $.ajax({
                         type: "POST",
                         url: "delete_tracker.php?id=" + t,
                         data: $('#tr').serialize(),
                         success: function(msg){                             
                                   alert(msg);
                                   window.location.reload();
                         },
                         error: function(error){
                              alert(error);
                                 }
                         });
                   }  else{
                       alert("Action cancelled");
                   }
                        }
                        
      function create_tracker(){
                    var price = $("#tr_price").val();
                    var name = $("#tr_name").val();
                    
                    var response = confirm('This item will affect your whole application, do you want to proceed?');
                   if(response === true){                       
                        $.ajax({
                         type: "POST",
                         url: "create_tracker.php?name=" + name + "&&price=" + price,
                         data: $('#tr').serialize(),
                         success: function(msg){                             
                                   alert(msg);
                                   window.location.reload();
                         },
                         error: function(error){
                              alert(error);
                                 }
                         });
                   }else{
                       alert("Action cancelled");
                   }  
                        }
                        
      function change_service(){
                    var price = $("#sr_price").val();
                    var id = $("#sr_id").val();
                    
                    var response = confirm('This item will affect your whole application, do you want to proceed?');
                   if(response === true){                       
                        $.ajax({
                         type: "POST",
                         url: "change_service.php?id=" + id + "&&price=" + price,
                         data: $('#tr').serialize(),
                         success: function(msg){                             
                                   alert(msg);
                                   window.location.reload();
                         },
                         error: function(error){
                              alert(error);
                                 }
                         });
                   }else{
                       alert("Action cancelled");
                   }  
                        }
      
    </script>
  </body>
</html>