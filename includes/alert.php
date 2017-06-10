
<div class="box box-default">               
                <div class="box-body">
                    <?php 
                     if(isset($error) && $error != ""){
                         echo "<div class='alert alert-danger alert-dismissable'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-ban'></i> Error!</h4>
                    $error
                  </div>";
                     }
                     if(isset($message) && $message != ""){
                         echo "<div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4>	<i class='icon fa fa-check'></i> Success!</h4>
                   $message
                  </div>";
                     }                    
                     if(isset($info) && $info != ""){
                         echo "<div class='alert alert-info alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-info'></i> Info!</h4>
                   $info
                  </div>";
                     }
                     if(isset($warning) && $warning != ""){
                         echo "<div class='alert alert-warning alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4><i class='icon fa fa-warning'></i> Warning!</h4>
                    $warning
                  </div>";  
                     }
                     ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->