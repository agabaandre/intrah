
<body class=" login-page">
<div class="login-box">
  <div class="login-logo">
      <!-- VMMC Campaigns -->
      <img src="<?php echo base_url(); ?>assets/files/logo.svg" alt="IntraHealth" height="150" width="150">
     <br>Attendance Tracking
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <small id="login-empty-input" class="error">email or password cannot be empty <br>&nbsp;</small>
                    <?php if($alert): ?>
                      <small id="login-invalid-input" class="error">invalid email or password<br>&nbsp;</small>
                    <?php endif; ?>

    <form method="post" onsubmit="return checkEmptyInput();" action="<?=base_url()?>authentication/login/">
      <div class="form-group has-feedback">
        <input id="email"  class="form-control" placeholder="Username" name="username" type="text" autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password"  placeholder="Password" id="password" value="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
      
        <!-- /.col -->
        <div class="col-xs-4">
         <button id="login-submit" type="submit" value="Login" class="btn btn-success btn-rounded">Sign in</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- /.social-auth-links -->

    <a href="#" onclick="alert('Please contact the administrator to reset your password!')">I forgot my password</a><br>
  

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


