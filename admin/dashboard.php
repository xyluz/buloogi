<?php session_start();

require_once('_autoload.php');
require_once '../lib/function.php';
require_once '../excels/excel_reader.php';

if($_SESSION[locked]){
redirect_to('lockscreen.php');
}
//used for lockscreen redirect
$_SESSION[my_url] = $_SERVER[REQUEST_URI];

if(isset($_FILES['file'])){
    
    $target_dir = "../excels/";
    
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    
    
    
       if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
         
            
            $excel = new PhpExcelReader;     
            $excel->read($target_file);   // reads and stores the excel file data

         
            
            $title = "NSE" . count($excel->sheets[0][cells]) . rand(000,999) ."RA";
            $user = $_SESSION[admin_id];
            
//            echo "<pre>";
//            print_r($excel->sheets);
//            exit;
   for($n=1; $n <= count($excel->sheets[0][cells]); $n++){
       
            $ticker = $excel->sheets[0][cells][$n][1];     
            $pclose= $excel->sheets[0][cells][$n][2];
            $open= $excel->sheets[0][cells][$n][3];
            $high= $excel->sheets[0][cells][$n][4];
            $low= $excel->sheets[0][cells][$n][5];
            $percentSpread= $excel->sheets[0][cells][$n][6];
            $close= $excel->sheets[0][cells][$n][7];
            $changeA= $excel->sheets[0][cells][$n][8];
            $percentChange= $excel->sheets[0][cells][$n][9];
            $trades= $excel->sheets[0][cells][$n][10]; 
            $volume= $excel->sheets[0][cells][$n][11]; 
            $value= $excel->sheets[0][cells][$n][12];                       
            
            $u = new upload();
            
            $l = new user();
            
            $t = $u->add_data($ticker, $pclose, $open, $high, $low, $percentSpread, $close, $changeA, $trades, $percentChange, $volume, $value, $user,$title);
       
            if($t){
               $l->database_action_log($_SESSION[admin_id], "Date set $title was added");
            }else{
                $l->database_action_log($_SESSION[admin_id], "Date set $title could not be added");
            }
          
   }
   

     }
}


//instantiate instances
$session = new Session();

$user = new User();


$b = new breadcrumb();

if(!$session->is_logged_in()){
    redirect_to("index.php");
}
else{
    $setting = new global_settings();
    $setting->HTML5("Dashboard");
//    $single_admin = $user->search_admin($_SESSION[admin_id]);
    $setting->navigation();
}


?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            NSE
            <small>Version 1.0 (Alpha)</small>
          </h1>
          <ol class="breadcrumb">
              <?php echo $b->breadcrumbs(" > ", "Home"); ?>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-cloud-upload"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Recent Backups</span>
                  <span class="info-box-number"><?php $b = new backup(); echo $b->backup_count(); ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-archive"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Log Files</span>
                  <span class="info-box-number"><?php $r=new User(); echo $r->count_log(); ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Administrators</span>
                  <span class="info-box-number"><?php $user1 = new User(); foreach($user1->count_admin() as $users){echo $users['count(*)'];} ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-filing"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Record Count</span>
                  <span class="info-box-number"><?php $up = new upload(); echo $up->countUploads()["count(*)"]; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">All Share Index</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center">
                        <strong>Market Activity Graph</strong>
                      </p>
                      <div class="chart">
                        <!-- Sales Chart Canvas -->
                       <div id="myfirstchart" style="height: 250px;"></div>
                      </div><!-- /.chart-responsive -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">
                  <div class="row">
<!--                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">

                        <h5 class="description-header">NGN
                            <?php// foreach($account->income() as $income){
                              //  echo $income[0];
                            //} ?></h5>
                        <span class="description-text">TOTAL INCOME</span>
                      </div>
                    </div>-->
<!--                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">NGN
                           </h5>
                        <span class="description-text">EXPECTED INCOME</span>
                      </div>
                    </div>  -->
<!--                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">NGN 24,813.53</h5>
                        <span class="description-text">EXPECTED INCOME</span>
                      </div>
                    </div> -->
<!--                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block">

                        <h5 class="description-header">NGN
                            <?php //foreach($account->expected() as $expected){
                               // echo $expected;
                           // } ?></h5>
                        <span class="description-text">EXPECTED INCOME</span>
                      </div>
                    </div>-->
                  </div><!-- /.row -->
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
              <!-- MAP & BOX PANE -->
              <div class="box box-success">

                <div class="box-body no-padding">
                  <div class="row">


                  </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="row">
                <div class="col-md-6">
                  <!-- DIRECT CHAT -->
                  <div class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Recent Admin Activity</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-toggle="tooltip" title="see more" data-widget="chat-pane-toggle"><i class="fa fa-eye-slash"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <!-- Conversations are loaded here -->
                      <div class="direct-chat-messages">
                        <?php

                        foreach($user->fetch_database_log() as $activity){

                            foreach($user->search_admin($activity[admin_id]) as $admin_person){
                            echo "<div class='direct-chat-msg'>
                                    <div class='direct-chat-info clearfix'>
                                      <span class='direct-chat-name pull-left'>$admin_person[fullName]</span>
                                      <span class='direct-chat-timestamp pull-right'>$activity[Date]</span>
                                    </div><!-- /.direct-chat-info -->
                                    <img class='direct-chat-img' src='$admin_person[photo]' alt='message user image' /><!-- /.direct-chat-img -->
                                    <div class='direct-chat-text'>
                                      $activity[message]
                                    </div><!-- /.direct-chat-text -->
                                  </div><!-- /.direct-chat-msg -->";
                            }
                        }
                        ?>
                          <!-- Message. Default to the left -->

                      </div><!--/.direct-chat-messages-->
                    </div><!-- /.box-body -->

                  </div><!--/.direct-chat -->
                </div><!-- /.col -->

                <div class="col-md-6">
                  <!-- USERS LIST -->
                  <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">Administrators</h3>
                      <div class="box-tools pull-right">
                          <span class="label label-danger"></span>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <ul class="users-list clearfix">

                          <?php foreach($user->advance_search_admin() as $user){
                              echo "
                                  <li>
                                    <a href='single_admin.php?id=$user[admin_id]'><img src='$user[photo]' alt='$user[fullName] Photo'/></a>
                                    <a class='users-list-name' href='single_admin.php?id=$user[admin_id]'>$user[fullName]</a>
                                    <span class='users-list-date'>$user[date]</span>
                                  </li>";

                          } ?>

                      </ul>

                    </div><!-- /.box-body -->
                    <div class="box-footer text-center">
                        <a href="admins.php" class="uppercase">View All Users</a>
                    </div><!-- /.box-footer -->
                  </div><!--/.box -->
                </div><!-- /.col -->
              </div><!-- /.row -->

              <!-- TABLE: LATEST ORDERS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Recent Uploaded</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Data Set</th>
                          <th>Date Uploaded</th>
                          <th>Action</th>                         
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            $n=1;
                            $data = new upload();
                         foreach($data->dataMenu($_SESSION[admin_id]) as $single_data){
                             echo " <tr><td>$n</td>
                          <td><a href='single_data.php?id=$single_data[title]'>$single_data[title]</a></td>
                          <td>$single_data[date_uploaded]  </td>";   
                                          echo "<td><a  id='more' href='single_data.php?id=$single_data[title]' class='btn .btn-xs btn-primary' title='more about $single_data[title]'><i class='fa fa-eye'></i></a>   <a id='delete' onclick=\"delete_customer('$single_data[title]')\" class='btn .btn-xs btn-danger' title='delete $single_data[title]'><i class='fa fa-trash'></i></a>  </td>";                                  
                              
                                  
                     
                        echo "</tr>";
                                  $n++;
                         }
                          ?>

                                <script>
                                function seek(n){
                                    alert(n);
                                }
                               </script>
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  

                    <a href="datamenu.php" class="btn btn-sm btn-primary btn-flat pull-right">View All Or Search Record</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-4">
            
        

              <!-- PRODUCT LIST -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Upload File</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body"><form method="post" enctype="multipart/form-data">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                     Upload your excel format file here.
                    </li><!-- /.item -->
                   
                       
                    <input type="file" name="file" class="form-control"/>
                            
                 
                    <!-- /.item -->
                    <li class="item">
                     
                        <button type="submit" class="btn btn-app pull-left"><i class="fa fa-upload"></i> Upload</button>
                    </li><!-- /.item -->

                  </ul></form>
                     <script>
                 
                   function upload(){
                       
                     n = $('#feedback').html();
                     
                            $.ajax({
    		   	type: "POST",
			url: "save.php",
			data: $('#stage1_form').serialize(),
                        async: false,
                        cache: false,
                        contentType: false,
                        enctype: 'multipart/form-data',
                        processData: false,
        		success: function(msg){
//                             $("#c").removeClass('alert-info ');
//                              $("#c").addClass('alert-success');
//                                  $("#feedback").html(msg);

                        alert(msg);


 		        },
			error: function(error){
//                               alert("no");
                        alert(error);
//				$("#feedback").html(error);

				}
      			});
                        }
                    </script>
                </div><!-- /.box-body -->
             
              </div><!-- /.box -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Application Backup</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class='box-body'>
                    <span id="reply"></span>

                    <form id="backup">

                  <a class="btn btn-app pull-left" onclick="backup()"><i class="fa fa-upload"></i>Run Backup</a>
                  <a class="btn btn-app pull-right" onclick="alert('nothing to restore')"><i class="fa fa-download"></i>Restore Last Backup</a>
                    </form>
                    <!-- /.box-footer -->
              </div>
                <div id="working" class="overlay" style="visibility: hidden">
                     <i class="fa fa-refresh fa-spin"></i>
                </div>
                <script>
                function backup(){
                    var response = confirm('are you sure you want to backup?');
                   if(response === true){

                        $.ajax({
                         type: "POST",
                         url: "backup.php",
                         data: $('#backup').serialize(),
                         success: function(msg){
                                   $("#reply").addClass('text-primary');
                                   $("#reply").html('backup started... please wait');

                                   $("#reply").removeClass('text-primary');
                                   $("#reply").addClass('text-success');
                                   $("#reply").html('backup complete');
                                   $("#working").css('visibility','hidden');

                         },
                         error: function(error){
                                $("#reply").addClass('text-danger');
                                 $("#reply").html('Something went wrong, backup could not be done');
                                 }
                         });
                   }



                        }
                </script>
            </div><!-- /.col -->
            <div class="box-footer text-center">
                  <a href="backup_history.php" class="uppercase">Backup History</a>
                </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <!--<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>-->
          <!--<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>-->
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>

          </div><!-- /.tab-pane -->

          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Other sets of options are available
                </p>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked />
                </label>
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div><!-- /.form-group -->

              <h3 class="control-sidebar-heading">Chat Settings</h3>

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right" />
                </label>
              </div><!-- /.form-group -->

              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
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
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <!--<script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>-->
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="plugins/morris/lib/prettify.min.js" type="text/javascript"></script>
    <script src="plugins/morris/lib/raphael-min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js" type="text/javascript"></script>
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <?php
    //$account1 = new accounts();

//    echo "<script>
//    new Morris.Area({
//    // ID of the element in which to draw the chart.
//    element: 'myfirstchart',
//    // Chart data records -- each entry in this array corresponds to a point on
//    // the chart.
//    data: [";

//    $counter=1;
// foreach($account->get_all_month() as $date){
//     $year = date('Y',time());
//
//     foreach($account->sales_for_month($date[0]) as $a){
//         foreach($account->expected_for_month($date[0]) as $b){
//         echo "{x: '" .$year . " Q".$counter ."', y: " .$a[0] .', z: ' .$b[0] .'},' ;
//         $counter++;
//         }
//     }
//
//    }
//
//   echo "],
//   xkey: 'x',
//  ykeys: ['y', 'z'],
//  labels: ['Real', 'Expected']
//  });
//    </script>" ?>

  </body>

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
</html>
