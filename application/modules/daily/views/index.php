	
<?php
$this->load->view('includes/head.php');
$this->load->view('includes/topbar.php');
$this->load->view('includes/sidenav.php');
$this->load->view('includes/responsive_table.php');
?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style type="text/css">
    .overlay{
        width: 100%;
        height: 800px;
        background-color:navy;
        z-index: 2000;
    }
</style>
<div class="content-wrapper">
    <section class="content">
    <div class="row">
        <div class="col-md-12">
   <!-- general form elements 
          <div class="box">-->
    <div class="row">
        <!--<div class="overlay"><center style="padding-top: 20%; color:#fff;"><h4>Loading Data...</h4></center></div>-->
            <div class="col-md-9 border-bottom">
                <h2>Daily Attendance Details</h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <span id="error-msg">
                </div>
            </div>
            <div class="form-group">
                <label for="activity" class="col-sm-2 control-label">Select Campaign</label>
                <div class="col-sm-4">
                    <?php echo $form_activity; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="activity" class="col-sm-2 control-label"></label>
                <label for="activity" class="col-sm-2 control-label"></label>
                <label for="activity" class="col-sm-2 control-label"></label>
            </div>
            <br/> 
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="reportrange" class="col-sm-2 control-label">Date Range</label>
                        <div id="reportrange" class="selectbox pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
            </div> 
        <div class="col-md-9">
            <div class="col-md-9 mt-4 mb-2 border-bottom">
            <h4>Hours Worked Per Day</h4>
            </div>
        </div>
        <div class="col-md-3"> 
            <a id="downloadLink" onclick="exportF(this)">Export to excel</a>
        </div>
    </div>
    <div class="table-responsive box-body">

        <table class="table table-striped table-bordered" id="provider_table">
            <tbody id="activitiesTbl"></tbody>
        </table>

    </div>
   <!-- </div>
           /.box -->

    </div><!--col-md-12-->
    </div>
   </section>
</div>
<!--<script type="text/javascript"
  src="https://code.jquery.com/jquery-1.11.3.min.js"
  integrity="sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g="
  crossorigin="anonymous"></script>-->
<script type="text/javascript">
    var activityStartDate;
    var activityEndDate;
    function getActivities(){
        var $activity_id = $('#activity').val();
		if(window.localStorage.getItem("activityData") !== 'null') { 
            if($activity_id){
                $.ajax({
				url:'<?=base_url()?>daily/view_activities/'+$activity_id,
				success:function(response){
					
					var res=JSON.parse(response);
					if(res.length  == 0) {
                        jQuery('span#error-msg').html('<div class="alert alert-warning">This Activity has no records. Select another activity...</div>');
                        $("#activitiesTbl tr").remove();
                    }else {
                        $( "div" ).remove( ".alert" );
                        console.log(res);
                        window.localStorage.setItem("activityData",JSON.stringify(res));
                                $.ajax({
                                url:'<?=base_url()?>daily/get_activity_days/'+$activity_id,
                                success:function(response){
                                    var data = jQuery.parseJSON(response);
                                    var number_of_days = data.number_of_days;
                                    activityStartDate = data.startdate;
                                    activityEndDate = data.enddate;
                                    loadActivities(number_of_days,activityStartDate,activityEndDate);
                                }
                            });     
                    }
				}
			});   
            } else {
                    //loadActivities();
                    jQuery('span#error-msg').html('<div class="alert alert-warning">Select another activity below to view records...</div>');
                    $("#activitiesTbl tr").remove();
                     
            }
			return;
        }
  }

  function loadloadActivitiesWithEnd(number_of_days, startdate, enddate){
    $('#activitiesTbl').html('');  
        var $activity_id = $('#activity').val();
        if (!$activity_id) {
            var days = 0;
        } else {
            if(!number_of_days){
                // var days = 7; 
            }else{
                var starts = startdate;
                var ends = enddate;
                var days = number_of_days;
            }
        }
        //********create table header**********
        var bckcolor = "#A9A9A9";
          //var header="<tr bgcolor="+bckcolor+"><th width='15%'> Name</th><th>Gender</th><th>Cadre</th>";
        var header="<tr style='font-size:10px;background-color:"+bckcolor+"'><th width='15%'> Name</th><th>Gender</th><th>Cadre</th>";
        var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var d = new Date(starts);
        var w = new Date(ends);

        // To calculate the no. of days between two dates
        var Difference_In_Time = w.getTime() - d.getTime();  
        days = Difference_In_Time / (1000 * 3600 * 24);
        var day;
        

        for(var i=0;i<=days;i++){
            day = months[d.getMonth()]+"-"+d.getDate();
            header+="<th>"+day+"</th>";
            d.setDate(d.getDate() + 1);
        }
        header+="</tr>";

        $('#activitiesTbl').prepend(header);

  		var data=JSON.parse(window.localStorage.getItem("activityData"));

//******create a row and add it to table for each person

for (var person in data) {

          var person=data[person];
          var personDetails=person.data;
          var personActivities=person.activity;

          console.log(personDetails);
          console.log(personActivities);

              var count=0;
              var row="<tr>";
              row+="<td>"+personDetails.surname+" "+personDetails.firstname+"</td><td>"+personDetails.gender+"</td><td>"+personDetails.cadre+"</td>";

              //if employee has data
              var row_value = [];
              personActivities.forEach(function(activity){
                var activityDate = Date.parse(activity.date);
                var compareDate = new Date(activity.date);
                var fDate = Date.parse(startdate);
                var lDate = Date.parse(enddate);
                if((activityDate <= lDate && activityDate >= fDate)) {
                    var timeIn=new Date(activity.date+"T"+activity.time_in);
                    var timeOut=new Date(activity.date+"T"+activity.time_out);
                    //var timeIn = mysqlDateTimeToDate(activity.time_in);
                    //var timeOut = mysqlDateTimeToDate(activity.time_out);
                    var hours= diff_hours(timeOut,timeIn);

                    var Difference = compareDate.getTime() - fDate.getTime();  
                    var days_a_part = Difference / (1000 * 3600 * 24);

                    if (hours>0){
                    /*var comparestart = new Date(startdate);
                        for(var i=0;i<=days;i++){
                            if(comparestart.getDate() === compareDate.getDate()) {
                            row+="<td>X</td>";
                            }else{
                            row+="<td></td>";  
                            } 
                            comparestart.setDate(comparestart.getDate() + 1);
                        } 
                     */
                        for(var i=0;i<=days;i++){
                            if(days_a_part === i) {
                            row_value[i]="<td>X</td>";
                            break;
                            }
                        } 
                        //count++;
                    } else {
                        //row+="<td></td>";
                        //count++;
                    }
                }
              });
              //build full row to make a rows full length, starting at the last counted <td> with data
              //count--;
              for(var i=count;i<days;i++){ 
                      //row+="<td>"+0+"</td>";	
                      row+="<td></td>";	
                  }
             for(var i=0;i<=days;i++){
                 if(row_value[i]){
                    row+=row_value[i]; 
                 }else{
                    row+="<td></td>"; 
                 }
             }

              row+="</tr>";


          $('#activitiesTbl').append(row); //add row to table

          //$('.overlay').fadeOut(2000);
      }
  }

  function loadActivities(number_of_days, startdate, enddate){

        var minDate = moment(activityStartDate).format('MM/DD/YYYY');
        var maxDate = moment(activityEndDate).format('MM/DD/YYYY');
    
        if (!startdate){
            var start = moment().subtract(14, 'days');
            var end = moment();
        } else {
            var start = moment(startdate);
            var end = moment(enddate);
        }
        function cb(number_of_days, start, end) {
                $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                startdate = start.format('YYYY-MM-DD');
                enddate = end.format('YYYY-MM-DD');
                loadloadActivitiesWithEnd(number_of_days, startdate, enddate );
            }
        $('#reportrange').daterangepicker({
            minDate: minDate,
            maxDate: maxDate,
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Last 14 Days': [moment().subtract(14, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            alwaysShowCalendars : true,
            opens : "center"
        }, cb);

        cb(number_of_days, start, end);

    }

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            startdate = picker.startDate.format('YYYY-MM-DD');
            enddate = endDate.end.format('YYYY-MM-DD');
            loadloadActivitiesWithEnd(number_of_days, startdate, enddate );
    });
//calculates time worked
function diff_hours(dt2, dt1) 
 {

  var diff =(dt2.getTime() - dt1.getTime()) / 1000;
  diff /= (60 * 60);
  return Math.abs(Math.round(diff));
  
 }

getActivities(); 

function exportF(elem) {
  var table = document.getElementById("provider_table");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "daily_attendance.xls"); // Choose the file name
  return false;
}
function mysqlDateTimeToDate(datetime) {
    var regex=/^([0-9]{2,4})-([0-1][0-9])-([0-3][0-9]) (?:([0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?$/;
    var parts=datetime.replace(regex,"$1 $2 $3 $4 $5 $6").split(' ');
    return new Date(parts[0],parts[1]-1,parts[2],parts[3],parts[4],parts[5]);
}
function toMysqlDate(date) {
    var year, month, day;
        year = String(date.getFullYear());
        month = String(date.getMonth() + 1);
        if (month.length == 1) {
            month = "0" + month;
        }
        day = String(date.getDate());
        if (day.length == 1) {
            day = "0" + day;
        }
        return year + "-" + month + "-" + day;
}
</script>
<?php
$this->load->view('includes/footermain.php');
$this->load->view('includes/rightsidebar.php');
$this->load->view('includes/footer.php');

?>

	