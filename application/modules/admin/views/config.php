
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $title; ?></h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active"><?php echo $title; ?></li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>

<section class="content">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-body">
        <form method="post" id="config_form">
          <?php

            $varss = $this->admin_model->get_vars();
            usort($varss, 'rowid');
            foreach ($varss as $var1) {  $label = $var1['variable'];
                     $width = "";
                     $min = "";
          ?>

          <div class="form-group">
            <label>
              <?php echo $label; ?>
            </label>
            <input name="
              <?php echo $var1['rowid']; ?>" class="form-control" type="text" minlength="
              <?php echo $min; ?>" maxlength="
              <?php echo $width; ?>" value="
              <?php echo $var1['content']; ?>">
            </div>
            <?php }?>
            <div class="form-group">
              <button class="btn btn-success" type="submit">
                <i class="ion ion-ios-albums"></i>Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END COL-6-->
  </section>

<script type="text/javascript">

$(document).ready(function() {

  $('#config_form').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = '<?php echo base_url(); ?>admin/configure'

    console.log(data);

    $.ajax({
      url: url,
      method: "post",
      data: data,
      success: function(res) {
        console.log(res);
        var alert = '<div class="alert alert-info alert dismissible"><i class="fa fa-info-circle"></i> <a href="" class="pull-right" data-dismiss="alert">&times;</a> ' + res + '</div>'

        $('.suc').html(alert).fadeIn('slow');


        setTimeout(function() {

          $('.suc').fadeOut('slow');

        }, 4000)
      } //success

    }); // ajax
  }); //form submit

}); //doc

</script>
<script>

function uploadStarted(){


	$('.notif').html("<center><font color='green'><b>Upload in Progress Please Wait...</b></font></center>");


}

</script>

