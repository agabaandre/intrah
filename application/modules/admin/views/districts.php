
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Districts</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Districts</li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>

<section class="content">
    <div class="nav-tabs-custom">
      <br>
    </div>

    <div class="row">
      <?php echo $_SESSION['msg']; ?>
      <div class="col-md-4">
        <div class="panel">
          <div class="panel-body">
            <form id="districts_form">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-text-size"></i>
                  </span>
                  <input type="text" name="district" class="form-control" placeholder="Add a new district" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="submit" class="btn btn-success" value="Save District">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>


          <div class="col-md-8">

            <div class="box">
              <div class="box-body">

                <form class='form-horizontal' method="post" action="
                  <?php echo base_url(); ?>admin/districts_list">
                  <div class="form-group col-md-11">
                    <input name="search_key" class="form-control" placeholder="Search district"/>
                  </div>
                  <div class="form-group col-md-1">
                    <input type="submit" class="btn btn-default" value="Search" />
                  </div>
                </form>
                <table class="table table-striped ">
                  <thead>
                    <th width="20px;">#</th>
                    <th>District</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php $no=0; foreach($districts as $district) { $no++; ?>
                    <tr id="<?php echo $district['id']; ?>" >
                      <td>
                        <?php echo $district['id']; ?>
                      </td>
                      <td>
                        <?php echo $district['district_name']; ?>
                      </td>
                      <td>
                        <a href="#"  data-toggle="modal" data-target="#edit
                          <?php echo $no; ?>">
                          <i class="glyphicon glyphicon-edit" title="Edit"></i>Edit
                        </a>
                      </td>
                    </tr>
                    <!-- edit Modal -->
                    <div id="edit<?php echo $no; ?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit District - 
                              <b>
                                <?php echo $district['district_name']; ?>
                              </b>
                            </h4>
                          </div>
                          <div class="modal-body">
                            <span class="upd" style="padding: 0.5em;"></span>
                            <form class="district_edit">
                              <div class="form-group">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-text-size"></i>
                                  </span>
                                  <input type="text" name="district" class="form-control" value="
                                    <?php echo $district['district_name']; ?>" required>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="input-group">
                                    <input type="hidden" name="id" value="
                                      <?php echo $district['id']; ?>"  class="form-control" required>
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
              </div>
            </div>

            <!-- /.content-row -->
          </section>

<script type="text/javascript">

$(document).ready(function(){

$('#scheduletbl').slimscroll({
  height: '400px',
  size: '5px'
});

$('#district_form').submit(function(e){

  e.preventDefault();

  var data=$(this).serialize();
  var url='<?php echo base_url(); ?>admin/add_district';

$.ajax({url:url,
method:"post",
data:data,
dataType:'json',
success:function(res){
    
    console.log(res);

  if(res.status=="success")
  {

  $('.suc').html("<center><font color='green'>District Added</font></center>");

  $('#reset').click();

}
else  if(res.status=="exist"){

$('.suc').html("<center><font color='red'> This District already exists</font></center>");

}

}//success

}); // ajax 
});//form submit

$('.district_edit').submit(function(e){

  e.preventDefault();
  var data=$(this).serialize();
  var url='<?php echo base_url(); ?>admin/edit_district';

  $.ajax({url:url,
method:"post",
data:data,
dataType:'json',
success:function(res){

  console.log(res.status);

  if(res.status==="success")
  {

  $('.upd').html("<center><font color='green'>District Details Updated</font></center>");

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
