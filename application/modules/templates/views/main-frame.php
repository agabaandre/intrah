<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Intra | Health</title>

  <?php  include('inc/top-css-files.php');  ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?php echo base_url(); ?>assets/files/logo.svg" alt="IntraHealth" height="150" width="150">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">

    <?php  include('inc/top-nav-bar.php');  ?>

  </nav>
  <!-- /.navbar -->

  <!-- MAIN SIDE-DAR -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php  include('inc/side-bar.php');  ?>
  </aside>
   <!-- MAIN SIDE-DAR -->


  <!-- CONTENT WRAPPER. Contains page content -->
  <div class="content-wrapper page_data dash_page_data">

    <?php //$this->load->view($module."/".$view); ?>
    
  </div>
  <!-- CONTENT WRAPPER. Contains page content -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->

  </aside >
  <!-- /.control-sidebar -->


<!-- FOOTER SECTION ------------------->
  <footer class="main-footer">
    <?php  include('inc/footer.php');  ?>
  </footer>
<!-- FOOTER SECTION ------------------->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
  <?php  include('inc/btm-js-files.php');  ?>
<!-- REQUIRED SCRIPTS -->

<script type="text/javascript">
    $(document).ready(
       function(){

           var html = '<div class="loader_text_text"><br><br><br><br><center ><img  src="<?php echo base_url(); ?>assets/files/logo.svg" height="200" width="200"><p>Loading ....</p></center></div>';
           
          window.setTimeout(function(){
                $.get({
                    url: "<?php echo base_url('attendance'); ?>",
                    success:function(response){
                      $('.loader_text_text').hide();
                      $('.page_data').html(response);
                      //console.log(response);
                    }
                    });
         },3000); 
       
         $('.link').on('click',function(e){
          e.preventDefault(); $('.page_data').html(html); 
         
          var url=$(this).attr('href');
          $.ajax({
          type:"GET",
          url:url,
          success:function(response){
            $('.page_data').html(response);
              $('.loader_text_text').hide(); 
          }});});
  }); 
</script>

</body>
</html>
