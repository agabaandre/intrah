
    <!-- Main content -->
        <section class="content">

       <div class="nav-tabs-custom">
                 <br>
		  </div>
             <div class="row">
                 
               <?php echo $_SESSION['msg']; ?>  

<div class="col-md-4">

  <div class="panel">
  <div class="panel-heading"><h4>Add User</h4> <span class="suc"></span></div>
<br>
   <div class="panel-body">

<form id="user_form">
  
<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-text-size"></i></span>
<input type="text" name="name" class="form-control" placeholder="Full Name" required>
  

</div>

</div>


<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input type="text" name="username" class="form-control" placeholder="Username" required>
  

</div>

</div>

<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input type="password" name="password" pattern=".{6,13}" required title="6 to 13 characters" value="<?php echo $_SESSION['defaultpass']; ?>"  class="form-control" placeholder="Password" required>
  

</div>

</div>



<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>

<select  name="role" class="form-control role" required>

  <option>Select Role</option>
  <?php 
  
//user groups
$groups=$this->aauth->list_groups();  

foreach($groups as $group){  ?>

  <option value="<?php echo $group->name; ?>"><?php echo ucwords($group->name); ?></option>
  
  
  <?php } ?>
  

</select>
  

</div>

</div>

<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
<input type="email" name="email" class="form-control" value="" placeholder="Email">
  

</div>

</div>


<div class="form-group">

  <div class="input-group">

<input type="submit" class="btn btn-success" value="Save User">
  

</div>

</div>



</form>

</div>
</div>


</div>

<div class="col-md-8">
   <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $title; ?></h3>
              
              
 
        
              
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
              <div class="box-body">
              
              <div class="pagination" style="padding: 0.5rem;"> <?php echo $links; ?> </div> 
              <form class='form-horizontal' method="post" action="<?php echo base_url(); ?>admin/user_list">
              <div class="form-group col-md-11">
                  <input name="search_key" class="form-control" />
              </div>
              <div class="form-group col-md-1">
              <input type="submit" class="btn btn-default" value="Search" />
              </div>
              </form>
              

                <table class="table table-striped ">
                  <thead>
                    <th  width="10px;">#</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th width="300px">Email</th>
                  <th>Action</th>
                  </thead>

                  <tbody>

                    <?php 

                    $no=0;

                    foreach($users as $user) {
                            $no++;

                     ?>

                   

                    <tr id="user<?php echo $user['user_id']; ?>" >
                      <td><?php echo $no; ?></td>
                      <td><?php echo $user['name']; ?></td>
                      <td><?php echo $user['username']; ?></td>
                      <td><?php echo $user['role']; ?></td>
                      <td><?php echo $user['email']; ?></td>

                      <td>


<?php if($user['status']=="1"){ ?>


<a href="#"  data-toggle="modal" data-target="#edit<?php echo $no; ?>"><i class="glyphicon glyphicon-edit" title="Edit"></i></a> |
<a href="#"  id="<?php echo $user['username'].'/'.$user['user_id']; ?>"><i class="glyphicon glyphicon-ok-circle" title="Activate"></i></a>

                        <?php } else { ?>


<a href="#" data-toggle="modal" data-target="#edit<?php echo $no; ?>"><i class="glyphicon glyphicon-edit" title="Edit"></i></a> |
<a href="#"  id="<?php echo $user['username'].'/'.$user['user_id']; ?>">Blocked</a>


                        <?php } ?>
                        

                      </td>
                    </tr>





<!-- edit Modal -->
<div id="edit<?php echo $no; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit User-<b><?php echo $user['name']; ?></b></h4>
      </div>
      <div class="modal-body">

        <span class="upd" style="padding: 0.5em;"></span>

       <form class="user_edit">
  
<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-text-size"></i></span>
<input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
  

</div>

</div>


<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input type="text" name="username" value="<?php echo $user['username']; ?>"  class="form-control" placeholder="Username" required>
  

</div>

</div>


<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>

<select  name="role" class="form-control role" required >

  <option><?php echo $user['role']; ?> </option>
  <option value="sadmin">System Admin</option>
  <option value="admin">Finance Admin</option>
  <option value="Field-Officer">Field Officer</option>
  

</select>
  

</div>

</div>






<div class="form-group">

  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
<input type="email" name="email" value="<?php echo $user['email']; ?>"  class="form-control" placeholder="Email" required>


<input type="hidden" name="id" value="<?php echo $user['user_id']; ?>"  class="form-control" placeholder="Email" required>  

</div>

</div>

<a href="" data-toggle="modal" data-target="#reset<?php echo $user['user_id']; ?>" class="btn btn-info" >Reset Password</a> 
<a href="" data-toggle="modal" data-target="#block<?php echo $user['user_id']; ?>" class="btn btn-danger" >Deactivate</a> 




<!-- Reset password Modal -->
<div id="reset<?php echo $user['user_id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reset Password?</h4>
      </div>
      <div class="modal-body">
        <p>Password for <?php echo $user['name']; ?> will be reset</p>
      </div>
      <div class="modal-footer">
          
          <a href="<?php echo base_url().'/admin/resetpass/'.$user['user_id']; ?>" class="btn btn-danger" >Reset Password</a> 
          
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>

<!---end reset pass modal-->

<!-- block password Modal -->
<div id="block<?php echo $user['user_id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Block Account?</h4>
      </div>
      <div class="modal-body">
        <p>Account for <?php echo $user['name']; ?> will be Blocked</p>
      </div>
      <div class="modal-footer">
          
          <a href="<?php echo base_url().'/admin/block/'.$user['user_id'].'/'.$user['username']; ?>" class="btn btn-danger" >Block Account</a> 
          
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>

<!---end block pass modal-->

      </div>
      <div class="modal-footer"> 
        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Save Changes</button>
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
              <div class="pagination" style="padding: 0.5rem;"> <?php echo $links; ?> </div> 
              </div>
         





          </div>
          <!-- /.box -->

        </div><!--col-md-12-->







            </div>
  <!-- /.content-row -->
   </section>


<script type="text/javascript">

  $(document).ready(function(){

$('#scheduletbl').slimscroll({
  height: '400px',
  size: '5px'
});


$('.timepicker').timepicker({showInputs:false});




$('#user_form').submit(function(e){

  e.preventDefault();

  var data=$(this).serialize();
  var url='<?php echo base_url(); ?>admin/add_user'

  $.ajax({url:url,
method:"post",
data:data,
dataType:'json',
success:function(res){
    
    console.log(res);

  if(res.status=="success")
  {

  $('.suc').html("<center><font color='green'>User Added</font></center>");

  $('#reset').click();

}
else  if(res.status=="exist"){

$('.suc').html("<center><font color='red'> This User already exists</font></center>");

}

}//success

}); // ajax



});//form submit





$('.user_edit').submit(function(e){

  e.preventDefault();

 var fac=$('#facility').val();

 if(fac==''){

$('.suc').html("<center><font color='red'> Select New Facility</font></center>");

 }

 else

 {

  var data=$(this).serialize();
  var url='<?php echo base_url(); ?>admin/edit_user'

  $.ajax({url:url,
method:"post",
data:data,
dataType:'json',
success:function(res){

  console.log(res.status);

  if(res.status==="success")
  {

  $('.upd').html("<center><font color='green'>User Details Updated</font></center>");

  $('#reset2').click();

}
else  if(res.status==="fail"){

$('.upd').html("<center><font color='red'> Update Failed</font></center>");

}

}//success

}); // ajax


}//check


});//form submit


$('.block').click(function(e){

  e.preventDefault();

  var id=$(this).attr('id');
  var url='<?php echo base_url(); ?>admin/deactivate_user/'+id;

  console.log(id);
console.log(url);
  alert(id+" "+url);
  $.ajax({url:url,
success:function(res){

  console.log(res);

  $(".suc").html("<font color='green'>"+res+"</font>");


 setTimeout(function(){

    window.location.reload();


  },3000);


}//success

}); // ajax



});//btn click




//activate

$('.activate').click(function(e){

  e.preventDefault();

  var id=$(this).attr('id');
  var url='<?php echo base_url(); ?>admin/activate_user/'+id;

  console.log(id);
console.log(url);

  $.ajax({url:url,
success:function(res){

  console.log(res);

  $(".suc").html("<font color='green'>"+res+"</font>");

  setTimeout(function(){

    window.location.reload();


  },3000);



}//success

}); // ajax



});//btn click

  });//doc
  



</script>
