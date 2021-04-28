
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
        <form  enctype="multipart/form-data" id="save_payements">

          <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title float-left">
                    <?php echo $form_activity; ?>
                </h3> 

                <div class="card-tools float-right">
                  <div class="input-group input-group-sm" style="width: 20em;">
                    <div class="form-group"> 
                        <a id="downloadLink" class="btn-default btn pull-right" onclick="exportF(this)">Export to excel (or Excel Template)</a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 370px;">
                <table class="table table-head-fixed text-nowrap" id="payments_table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">District</th>
                            <th scope="col">Email</th>
                            <th scope="col">Transport</th>
                            <th scope="col">Accommodation</th>
                        </tr>
                    </thead> 
                    <tbody class="acTbl"> 

                        <?php //echo $row_data; ?>

                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div> 

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group save_d">
                        <button type="button" onclick="save_pymt()" class="btn btn-primary pull-right" style="width: 10em;">Save</button>
                    </div>
                </div>
            </div>

            </form>

    </div>
    </section>

<script type="text/javascript">
    $('.save_d').hide();
    

    function save_pymt()
    {
        var url ="<?php echo site_url('payments/save_payements');?>";
        $.ajax({
            url : url,
            type: "POST",
            data: $('#save_payements').serialize(),
            success: function(data)
            {
                console.log(data);
                $('.acTbl').html(data);

            }
        });
    }

    function load_row()
    {
        var $activity_id = $('#activity').val();
        var url ='<?php echo base_url(); ?>payments/view_activities/'+$activity_id;
        console.log(url);
        $.ajax({
            url : url,
            type: "GET",
            success: function(data)
            {
                $('.save_d').show();
                $('.acTbl').append(data);
            }
        });
    }

    function getActivities(){
        var $activity_id = $('#activity').val();

            if($activity_id){
                $.ajax({
                    url:'<?=base_url()?>payments/view_activities/'+$activity_id,
                    type: "GET",
                    success:function(response){
                            if(response.length  == 0) {
                                $('span#error-msg').html('<div class="alert alert-warning">This Activity has no records. Select another activity...</div>');
                                $("#acTbl tr").remove();
                            }else {
                                $('.save_d').hide();
                                $('.acTbl').html(data);
                            }
                            
                       
                    }
                });   
            } else {
                $('span#error-msg').html('<div class="alert alert-warning">Select an activity below to view records...</div>');
                $(".acTbl tr").remove();
            }
  }

    function exportF(elem) {
      var table = document.getElementById("payments_table");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "add-payments.xls"); // Choose the file name
      return false;
    }

</script>



    