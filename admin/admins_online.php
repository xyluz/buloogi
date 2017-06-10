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
    $setting->HTML5("Administrators");
     $setting->navigation();
}
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            All Administrators
            <small><?php foreach($user->count_admin() as $admins){ echo $admins['count(*)'];} ?> total</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Mailbox</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">
                <a href="register.php" class="btn btn-primary btn-block margin-bottom">Add New Administrator</a>
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Folders</h3>
                  <div class='box-tools'>
                    <button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                  </div>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                      <li><a href="admins.php"><i class="fa fa-inbox"></i> All <span class="label label-primary pull-right"><?php foreach($user->count_admin() as $admins){ echo $admins['count(*)'];} ?></span></a></li>
                      <li class="active"><a href="admins_online.php"><i class="fa fa-envelope-o"></i> Online</a></li>
                      <li><a href="admins_offline.php"><i class="fa fa-file-text-o"></i> Offline</a></li>
                      <li><a href="admins_deleted.php"><i class="fa fa-trash-o"></i> Deleted</a></li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
    
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">

                <div class="box-body no-padding">
                   <div class="mailbox-controls">
                    <!-- Check all button -->                    
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm" href="admins.php" title="see all admin"><i class="fa fa-reply"></i></a>
                      <a class="btn btn-default btn-sm" href="admins_online.php" title="See admin online"><i class="fa fa-share"></i></a>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" onclick="window.location.reload(); alert('refresh done')" title="refresh page"><i class="fa fa-refresh"></i></button>
                    
                  </div>
                  <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                         <thead>
                      <tr>
                        <th>Serial</th>                                    
                        <th>Full Name</th>
                        <th>Login ID</th>
                        <th>Status</th>
                        <th>Level</th>
                        <th>Date</th>                                         
                        <th>Action</th>
                      </tr>
                    </thead>
                      <tbody>
                          <?php 
                          $n=1;
                          foreach($user->advance_search_admin_online() as $single_admin){
                              echo "<tr><td>$n</td>";                              
                              echo "<td class='mailbox-name'><a href='read-mail.html'>$single_admin[fullName]</a></td>";
                              echo "<td class='mailbox-subject'>$single_admin[userId]</td>";
                              if($single_admin[online] == 0){
                              echo "<td class='mailbox-star'><a href='#'><i class='fa fa-star text-danger'></i> offline</a></td>";               }else{
                             echo "<td class='mailbox-star'><a href='#'><i class='fa fa-star text-green'></i> Online</a></td>"     ;
                              }             
                             
                              echo "<td class='mailbox-date'>$single_admin[level]</td>";
                              echo "<td class='mailbox-date'>$single_admin[date]</td>";
                              
                               echo "<td class='mailbox-name'><a id='edit' href='edit_admin.php?id=$single_admin[admin_id]' class='btn .btn-xs btn-info'  title='edit $single_admin[userId]'><i class='fa fa-edit'></i></a> <a  id='more' href='single_admin.php?id=$single_admin[admin_id]' class='btn .btn-xs btn-primary' title='more about $single_admin[userId]'><i class='fa fa-eye'></i></a> <a id='edit' onclick=\"delete_admin('$single_admin[admin_id]')\" class='btn .btn-xs btn-danger' title='delete $single_admin[userId]'><i class='fa fa-trash'></i></a></td>";
                              $n++;
                          }
                          ?>
                      </tbody>
                    </table><!-- /.table -->
                  </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                   <div class="mailbox-controls">
                    <!-- Check all button -->                    
                    <div class="btn-group">
                        <a class="btn btn-default btn-sm" href="admins.php" title="see all admin"><i class="fa fa-reply"></i></a>
                      <a class="btn btn-default btn-sm" href="admins_offline.php" title="See admin online"><i class="fa fa-share"></i></a>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" onclick="window.location.reload(); alert('refresh done')" title="refresh page"><i class="fa fa-refresh"></i></button>
                    
                  </div>
                </div>
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <script>
      function delete_admin(n){ 
   
                     var confirm_del = prompt('Type DELETE to confirm');
                           if(confirm_del ===  'DELETE'){  
                             
                        $.ajax({
                                type: "POST",
                                url: "admin_delete.php?id=" + n,
                                data: $('#ad_id').serialize(),
                                success: function(msg){
                                   
                                      alert(msg);
                                      window.location.reload();

                                },
                                error: function(error){
                                        alert('not done, something went wrong');

                                        }
                                });
                            }
                            else{
                                alert('delete cancelled!');
                            }
                        }
      </script>

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
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>    
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- Page Script -->
    <script>
      $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }          
          $(this).data("clicks", !clicks);
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
          e.preventDefault();
          //detect type
          var $this = $(this).find("a > i");
          var glyph = $this.hasClass("glyphicon");
          var fa = $this.hasClass("fa");

          //Switch states
          if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
          }

          if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
          }
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
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
  </body>
</html>