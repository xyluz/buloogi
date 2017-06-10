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
$backup = new backup();
if(!$session->is_logged_in()){
    redirect_to("index.php");
}
else{
    $setting = new global_settings();
    $setting->HTML5("Backup History");
    $setting->navigation();
}
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            PIVSS 
            <small>Version 1.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Backup History</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
              
            </div>
            <div class="box-body">
                <?php include '../includes/alert.php'; ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Serial</th>
                        <th>File</th>
                        <th>Date</th>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Size</th>                       
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                         if(isset($_GET[delete]) && $_GET[delete]==TRUE){
                             $user->database_action_log($_SESSION[admin_id], "Backup restore point was deleted");
                           $backup->delete_restore_point($_GET[id]);
//                           redirect_to('backup_history.php');
                        }
//                         if(isset($_GET[restore]) && $_GET[restore]==TRUE){
//                           $backup->delete_restore_point($_GET[id]); 
//                        }
                        
                          $n=1;
                         foreach($backup->backup_history() as $history){
                             echo " <tr><td>$n</td>
                          <td>$history[filename]</td>
                         <td><div class='sparkbar' data-color='#00a65a' data-height='20'>$history[date]</div></td>
                              <td><a href='single_admin.php?id=$history[admin]'>";
                                  echo $customer->admin_add_customer($history[admin]);
                                  echo "</a></td><td><a class='btn btn-primary' href='backup_history.php?restore=true&&id=$history[backup_id]'><i class='fa fa-download' title='restore to this point'></i></a><a href='backup_history.php?delete=true&&id=$history[backup_id]' class='btn btn-danger'><i class='fa fa-trash-o'></i></a></td><td>$history[size]</td>
                                      
                        </tr>";
                                  $n++;
                         }
                          
                          ?>
                     
                    </tbody>                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
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
    
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
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