
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Regions</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Regions</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">

  <div class="row">
    <?php echo $_SESSION['msg']; ?>
    <div class="col-md-4">
      <div class="panel">
        <div class="panel-body">
          <form id="regions_form">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-text-size"></i>
                </span>
                <input type="text" name="region" class="form-control" placeholder="Add a new region" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <input type="submit" class="btn btn-success" value="Save Region">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <form class='form-horizontal' method="post" action="
                <?php echo base_url(); ?>admin/regions_list">
                <div class="form-group col-md-11">
                  <input name="search_key" class="form-control" placeholder="Search a region"/>
                </div>
                <div class="form-group col-md-1">
                  <input type="submit" class="btn btn-default" value="Search" />
                </div>
              </form>
              <table class="table table-striped ">
                <thead>
                  <th  width="20px;">#</th>
                  <th>Region</th>
                  <th>Action</th>
                </thead>
                <tbody>

                  <?php $no=0; foreach($regions as $region) {  $no++;  ?>
                  <tr id="<?php echo $region['id']; ?>" >
                    <td><?php echo $region['id']; ?></td>
                    <td><?php echo $region['region']; ?></td>
                    <td>
                      <a href="#"  data-toggle="modal" data-target="#edit<?php echo $no; ?>">
                        <i class="glyphicon glyphicon-edit" title="Edit"></i>Edit
                      </a>
                    </td>
                  </tr>
                  <!-- edit Modal -->
                  <div id="edit
                    <?php echo $no; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Edit Region - 
                            <b>
                              <?php echo $region['region']; ?>
                            </b>
                          </h4>
                        </div>
                        <div class="modal-body">
                          <span class="upd" style="padding: 0.5em;"></span>
                          <form class="region_edit">
                            <div class="form-group">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="glyphicon glyphicon-text-size"></i>
                                </span>
                                <input type="text" name="region" class="form-control" value="
                                  <?php echo $region['region']; ?>" required>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="input-group">
                                  <input type="hidden" name="id" value="
                                    <?php echo $region['id']; ?>"  class="form-control" required>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                  <i class="glyphicon glyphicon-refresh"></i> Save Changes
                                </button>
                                <button type="button" id="reset2" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="pagination" style="padding: 0.5rem;">
                    <?php echo $links; ?>
                  </div>
                </div>
              </div>
              <!-- /.box -->
            </div>
            <!--col-md-12-->
          </div>
          <!-- /.content-row -->
        </section>


<script type="text/javascript">

  $(document).ready(function(){

$('#scheduletbl').slimscroll({
  height: '400px',
  size: '5px'
});

$('#region_form').submit(function(e){

  e.preventDefault();

  var data=$(this).serialize();
  var url='<?php echo base_url(); ?>admin/add_region'

  $.ajax({url:url,
method:"post",
data:data,
dataType:'json',
success:function(res){
    
    console.log(res);

  if(res.status=="success")
  {

  $('.suc').html("<center><font color='green'>Region Added</font></center>");

  $('#reset').click();

}
else  if(res.status=="exist"){

$('.suc').html("<center><font color='red'> This Region already exists</font></center>");

}

}//success

}); // ajax



});//form submit





$('.region_edit').submit(function(e){

  e.preventDefault();
  var data=$(this).serialize();
  var url='<?php echo base_url(); ?>admin/edit_region'

  $.ajax({url:url,
method:"post",
data:data,
dataType:'json',
success:function(res){

  console.log(res.status);

  if(res.status==="success")
  {

  $('.upd').html("<center><font color='green'>Region Details Updated</font></center>");

  $('#reset2').click();

}
else  if(res.status==="fail"){

$('.upd').html("<center><font color='red'> Update Failed</font></center>");

}

}//success

}); // ajax


});//form submit

});//doc
  



</script>
