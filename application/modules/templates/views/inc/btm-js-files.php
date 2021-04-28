<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/files/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/files/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets/files/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/files/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url(); ?>assets/files/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url(); ?>assets/files/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/files/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/files/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/files/plugins/chart.js/Chart.min.js"></script>

<!-- date-range-picker -->
<script src="<?php echo base_url(); ?>assets/files/plugins/daterangepicker/daterangepicker.js"></script>

<!-- InputMask -->
<script src="<?php echo base_url(); ?>assets/files/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/files/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url(); ?>assets/files/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?php echo base_url(); ?>assets/files/plugins/bs-stepper/js/bs-stepper.min.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/files/dist/js/pages/dashboard2.js"></script>

 <script src="<?php echo base_url(); ?>assets/files/plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/files/dist/js/demo.js"></script>


<script type="text/javascript">
	    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
</script>
 <!--script src="<?php //echo base_url(); ?>assets/files/plugins/jquery/jquery.dataTables.min.js"></script -->
