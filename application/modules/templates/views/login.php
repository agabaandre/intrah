
<?php include('includes/head.php'); ?>


<?php  	$this->load->view($module."/".$view);	?>




<?php  include('includes/footer.php'); ?>

 <script>
      window.onload = hideLoginErrors();
      function hideLoginErrors(){
        $("#login-empty-input").hide();
      }

    function checkEmptyInput(){
    
      hideLoginErrors();
      
      $("#login-invalid-input").hide();
      if( $("#email").val() == '' || $("#password").val() == '' ){
        $("#login-empty-input").show();
        return false;
      }
    }
 </script>
