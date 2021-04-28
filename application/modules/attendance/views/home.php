

  <style type="text/css">

  .fc-view{

      max-height:300px;
      overflow-y:scroll;

  }
  </style>


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="row" style="padding-left:15px; padding-right:15px;">
            <div class="col-md-4 col-sm-6 col-xs-12">

        <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="ion ion-ios-clock-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Campaigns</span>
              <a href="<?php echo base_url(); ?>activity/index"><span class="info-box-number"><?php echo $widgets['activities']; ?></span></a>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
        <!-- ./col -->

       <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Staff/Providers</span>
             <a href="<?php echo base_url(); ?>person/index"><span class="info-box-number"><?php echo $widgets['staff']; ?></span></a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <?php include "includes/dashcalendar.php";?>


		</div>
		</div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
    <!-- /.content -->





	   <script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

       <!-- <script src="<?php echo base_url(); ?>assets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
		<script src='<?php echo base_url(); ?>assets/js/dashcalendar.js'></script>-->
  <script type="text/javascript">
   
			var events = <?php echo json_encode($data) ?>;
			
			var date = new Date()
			var d    = date.getDate(),
				m    = date.getMonth(),
				y    = date.getFullYear()
					
			$('#calendar').fullCalendar({
				header    : {
				left  : 'prev,next today',
				center: 'title',
				right : 'month,agendaWeek,agendaDay'
				},
				buttonText: {
				today: 'Today',
				month: 'Month',
				week : 'Week',
				day  : 'Day'
				},
				events    : events
			})
			</script>


