   

<?php 
include_once("includes/head.php");
include_once("includes/topbar.php");
include_once("includes/sidenav.php");
include_once("includes/responsive_table.php");


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />

<style>
    .datepicker,.userin {
        max-width:250px;
        background-color:#fff;
    }
</style>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
 

    <!-- Main content -->
        <section class="content">
 
             <div class="row">
<div class="col-md-12">
   <!-- general form elements -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Enrolled Staff</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>attendance/fingerprints">
 
                  <div class="form-group col-md-3" style="margin-left:0.5em; margin-top:0.3em;">
                      <div class="form-group">
                    <div class='input-group userin'>
                     <input type="text" name="name" class="name form-control" placeholder="Search By Name" value="<?php echo $name; ?>">
                       <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                     </span>
                    </div>
                    </div>
                
                <label>Name</label>
                </div>
                
                 <div class="form-group col-md-2" style="margin-left:0.5em; margin-top:0.3em;">
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>Apply</button>
                </div>
                
            </form>
           
              <div class="box-body" id='scheduletb'>
                <table class="table table-striped table-bordered mytbl ">
                  <thead>
                         <th style="width:50px;">#</th>
                        <th>Name</th>
                        <th>Fingerprint</th>
                        <?php
                        if($this->aauth->is_group_allowed("manageusers",$mygroup) )
                        { ?>
                        <th>Action</th>
                        <?php }
                        ?>
                    
                    <!--<th width="13%"></th>-->
                  </thead>

                  <tbody>
                     

        <?php 
                     $i=1;
                     foreach($fingerprints as $fingerprint):  ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td data-label="Name"><?php echo $fingerprint->surname." ".$fingerprint->firstname; ?></td>
            <td data-label="Finger  ID"><?php echo $fingerprint->fingerprint; ?></td>
            <td data-label="Action">
            <?php
            if($this->aauth->is_group_allowed("manageusers",$mygroup) )
            { ?>
            <a href="<?php echo base_url(); ?>attendance/deleteFinger/<?php echo $fingerprint->pid; ?>" class="btn btn-danger">Disable Fingerprint</a></td>
           <?php }
            ?>
        </tr>
        
        <?php endforeach; ?>
                   
                  </tbody>


                </table>
               
<p class="pull-right"><?php echo $links; ?></p>
            
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
              </div>
  
          </div>
          <!-- /.box -->

        </div><!--col-md-12-->
            </div>
  <!-- /.content-row -->
   </section>
    <!-- /.section-->
  </div>
  
  <!-- /.content-wrapper -->
 <?php 
include_once("includes/footermain.php");
include_once("includes/rightsidebar.php");
include_once("includes/footer.php");



?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $('.datepicker').datepicker({
        format:"yyyy-mm-dd"
    });
</script>