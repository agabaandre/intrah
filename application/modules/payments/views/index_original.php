
<?php  foreach ($list as $e) { ?>

   $row .= "<tr><td><?php echo $e['activity_id']; ?></td><td><?php echo $e['location']; ?></td><td><?php echo $e['region']; ?></td><td><?php echo date('jS F Y', strtotime($e['starts'])); ?></td><td><?php echo date('jS F Y', strtotime($e['ends'])) ?></td><td><?php echo $e['notes']; ?></td><td><a class='btn btn-sm btn-primary'><i class='glyphicon glyphicon-folder-open'></i>View</a>&nbsp;&nbsp;<a class='btn btn-sm btn-primary' href='javascript:void(0)'><i class='glyphicon glyphicon-pencil'></i>Edit</a>&nbsp;&nbsp;<a class='btn btn-sm btn-danger' href='javavscript:void(0)'><i class='glyphicon glyphicon-trash'></i></td></tr>";

<?php } ?>


$row .= "<tr><td>#ID</td><td>LOCATION</td><td>REGION</td><td>START DATE</td><td>END DATE</td><td>NOTES</td><td>ACTION</td></tr>";


        foreach ($list as $element) {
            $row = array();
            $row[] = $element['activity_id'];
            $row[] = $element['location'];
            $row[] = $element['region'];
            $row[] = $element['snu'];
            $row[] = date("jS F Y", strtotime($element['starts']));
            $row[] = date("jS F Y", strtotime($element['ends']));
            $row[] = $element['notes'];
            if($this->aauth->is_group_allowed("managecampaigns",$this->mygroup) ){


                $row[] = '<a class='btn btn-sm btn-primary'><i class='glyphicon glyphicon-folder-open'></i>View</a>&nbsp;&nbsp;<a class='btn btn-sm btn-primary' href='javascript:void(0)'><i class='glyphicon glyphicon-pencil'></i>Edit</a>&nbsp;&nbsp;<a class='btn btn-sm btn-danger' href='javavscript:void(0)'><i class='glyphicon glyphicon-trash'></i>Delete</a>';

            } else {
                $row[] = '<a class="btn btn-sm btn-primary" href="../activity_details/index/' . $element['activity_id'] .'" title="View" ><i class="glyphicon glyphicon-folder-open"></i>View</a>';
                  
            }

            $data[] = $row;
        }

        href='../activity_details/index/' . $e['activity_id'] .'

        onclick="edit_activity(' . "'" . $element['activity_id'] . "'" . ')"

        onclick="delete_activity(' . "'" . $element['activity_id'] . "'" . ')"












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
    table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>

  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Payment Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <span id="error-msg">
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="activity" class="control-label">
                            Select Activity
                        </label>
                        <div class="col-md-12">
                            <?php echo $form_activity; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                    <label for="reportrange" class="control-label">Date Range</label>
                        <div id="reportrange" class="selectbox pull-left" style="background:inherit; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">  
                        <label for="reportrange" class="control-label">Excel Template</label>
                        <a id="downloadLink" class="btn-default btn pull-right" onclick="exportF(this)">Export to excel</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive box-body">
                        <table class="table table-bordered" id="payments_table">
                        <tbody id="activitiesTbl"></tbody>
                        </table>
                    </div>
                </div>
            </div>

    </div>
    </section>


<script type="text/javascript">
    var number_of_days; 
    var providerRate = 0;
    var supportRate = 0;
    var debitAccount = "";
    var cityCode = "DAR";
    var countryCode = "TZ";
    var activityStartDate;
    var activityEndDate;
    var number_of_publicHolidays = 0;

function getRates(){
        $.ajax({
        url:'<?=base_url()?>payments/get_rates',
        success:function(response){
            var res=JSON.parse(response);
            console.log(res);
            window.localStorage.setItem("rates",JSON.stringify(res));
        }
    });   
}
function getPublicHolidays(start,end){
        $.ajax({
        url:'<?=base_url()?>payments/get_public_holidays/'+start+'/'+end,
        success:function(response){
            number_of_publicHolidays = response;
        },
        async: false
    });
}
  function getWeekendDays(start, end){
        var date1 = new Date(start);
        var date2 = new Date(end);
        var weekendDays = 0;
        dayMilliseconds = 1000 * 60 * 60 * 24;

        while (date1 <= date2) {
            var day = date1.getDay();
            if (day == 0) {
                weekendDays++;
            }
            date1 = new Date(+date1 + dayMilliseconds);
        }
        number_of_days = weekendDays ;
  }
  function getDebitAccountDetails(){
        $.ajax({
        url:'<?=base_url()?>payments/get_debit_account',
        success:function(response){
            var res=JSON.parse(response);
            console.log(res);
            window.localStorage.setItem("debit_account",JSON.stringify(res));
        }
    });   
  }
function getActivities(){
        var $activity_id = $('#activity').val();
        if(window.localStorage.getItem("activityData")!=='null'){ 
            if($activity_id){
                $.ajax({
                    url:'<?=base_url()?>payments/view_activities/'+$activity_id,
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
                                    url:'<?=base_url()?>payments/get_activity_days/'+$activity_id,
                                    success:function(response){
                                        var data = jQuery.parseJSON(response);
                                        activityStartDate = data.startdate;
                                        activityEndDate = data.enddate;
                                        getWeekendDays(activityStartDate,activityEndDate);
                                        getPublicHolidays(activityStartDate,activityEndDate);
                                        loadActivities(activityStartDate,activityEndDate);
                                    }
                                });
                                
                            }
                            
                       
                    }
                });   
            } else {
                jQuery('span#error-msg').html('<div class="alert alert-warning">Select an activity below to view records...</div>');
                $("#activitiesTbl tr").remove();
            }
            return;
        }
  }
function loadloadActivitiesWithDates(number_of_days, startdate, enddate){
    getRates();
    getDebitAccountDetails();
    $('#activitiesTbl').html('');
    var $activity_id = $('#activity').val();
    if (!$activity_id) {
        var weekenddays = 0; 
    } else {
        if(!number_of_days){
            var weekenddays = 0; 
        }else{
            var weekenddays = number_of_days;
        }
    }
        //********create table header**********
        var bckcolor = "#A9A9A9";
        var header="<tr style='font-size:10px;background-color:"+bckcolor+"'><th>Payment Types</th><th>Payment/ Value Date</th><th width='10%'>Debit Account</th><th>Beneficiary Names</th><th>Amount</th><th>Payment Details</th><th width='10%'>AccNo</th><th>Bank Name</th><th>Beneficiary Bank Code</th><th>Beneficiary Bank Local Clearing Branch Code</th><th>Debit account City code</th><th>Debit Account country code</th><th>Payment Currency</th>";  
        $('#activitiesTbl').prepend(header);
       
        var rates=JSON.parse(window.localStorage.getItem("rates"));
        rates.forEach(function(rate){
            if (rate.short_name == "provider"){
                    providerRate = rate.content;
                } else if (rate.short_name == "support"){
                    supportRate = rate.content;
            }
        });

        var debit_accounts=JSON.parse(window.localStorage.getItem("debit_account"));
        debit_accounts.forEach(function(debit_account_detail){
            if (debit_account_detail.short_name == "debit_account"){
                debitAccount = debit_account_detail.content;
            } else if (debit_account_detail.short_name == "city_code"){
                cityCode = debit_account_detail.content;
            } else if (debit_account_detail.short_name == "county_code"){
                countryCode = debit_account_detail.content;
            }
        });
       var data=JSON.parse(window.localStorage.getItem("activityData"));

            //******create a row and add it to table for each person

           for (var person in data) {

                        var person=data[person];
                        var personDetails=person.data;
                        var personActivities=person.activity;
                        var personBankDetails=person.bank_details;

                        console.log(personDetails);
                        console.log(personActivities);
                        console.log(personBankDetails);

                            var count=0;
                            var account_no = "" ;
                            var bank_name = "" ;
                            var bank_code = "" ;
                            var branch_code = "" ;
                            var row="<tr><td>PAY</td><td></td><td>"+debitAccount+"</td>";
                            //row+="<td>"+personDetails.surname+" "+personDetails.firstname+"</td><td>"+personDetails.cadre+"</td><td>"+personDetails.district+"</td>";
                            row+="<td>"+personDetails.surname+" "+personDetails.firstname+"</td>";
                            //get rate per day
                            if(personDetails.cadre == 'Provider' ) {
                                var rate = providerRate;
                            } else if (personDetails.cadre == 'Support'){
                                var rate = supportRate;
                            }else{
                                var rate = 0;
                            } 
                            // bank Details
                            personBankDetails.forEach(function(bank_details){
                                account_no = bank_details.account_no;
                                bank_name = bank_details.bank_name;
                                bank_code = bank_details.bank_code;
                                branch_code = bank_details.branch_code;
                            });
                            //count days worked
                            personActivities.forEach(function(activity){
                                
                                var activityDate = Date.parse(activity.date);
                                var fDate = Date.parse(startdate);
                                var lDate = Date.parse(enddate);
                                if((activityDate <= lDate && activityDate >= fDate)) {
                                    var timeIn=new Date(activity.date+"T"+activity.time_in);
                                    var timeOut=new Date(activity.date+"T"+activity.time_out);
                            
                                    var hours= diff_hours(timeOut,timeIn);
                                        if(!hours || hours < 1){
                                                
                                            }else{
                                                count++;
                                            }
                                }
                            });
                            //Add Number of days
                            //row+="<td>"+count+"</td>";
                            //Add Weekends
                            alert("Before Weekends" + count);
                            count = +count + +weekenddays + +number_of_publicHolidays;
                            // get Total Amount
                            alert("After Weekends" + count + ":" +weekenddays);
                            var total = rate * count;
                            row+="<td>"+total+"</td><td></td><td>"+account_no+"</td><td>"+bank_name+"</td><td>"+bank_code+"</td><td>"+branch_code+"</td><td>"+cityCode+"</td><td>"+countryCode+"</td><td>TZS</td>";
                            row+="</tr>";
                        $('#activitiesTbl').append(row); //add row to table
    }
}


function loadActivities(startdate,enddate){
        getPublicHolidays(startdate, enddate);
        var minDate = moment(activityStartDate).format('MM/DD/YYYY');;
        var maxDate = moment(activityEndDate).format('MM/DD/YYYY');
        if (!startdate){
            var start = moment().subtract(number_of_days, 'days');
            var end = moment();
        } else {
            var start = moment(startdate);
            var end = moment(enddate);
        }
        function cb(start, end) {
                $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                startdate = start.format('YYYY-MM-DD');
                enddate = end.format('YYYY-MM-DD');
                getWeekendDays(startdate, enddate);
                getPublicHolidays(startdate, enddate);
                loadloadActivitiesWithDates(number_of_days, startdate, enddate );
            }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            minDate: minDate,
            maxDate: maxDate,
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

        cb(start, end);

    }

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            startdate = picker.startDate.format('YYYY-MM-DD');
            enddate = endDate.end.format('YYYY-MM-DD');
            getWeekendDays(startdate, enddate);
            getPublicHolidays(startdate, enddate);
            loadloadActivitiesWithDates(number_of_days, startdate, enddate );
    });

//calculates time worked
function diff_hours(dt2, dt1) 
 {

  var diff =(dt2.getTime() - dt1.getTime()) / 1000;
  diff /= (60 * 60);
  return Math.abs(Math.round(diff));
  
 }

//on load run this
getActivities();

function exportF(elem) {
  var table = document.getElementById("payments_table");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "campaign_payments.xls"); // Choose the file name
  return false;
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

    