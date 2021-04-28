
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
                <div class="col-lg-12">
                    <span id="error-msg">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <a id="downloadLink" class="btn-default btn pull-right" onclick="exportF(this)">Export to excel (or Excel Template)</a>
                    </div>
                </div>
            </div>

          <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title float-left">
                    <?php echo $form_activity; ?>
                </h3>
                <form id="Searchform" method="post" > 

                <div class="card-tools float-right">
                  <div class="input-group input-group-sm" style="width: 20em;">

                  </div>
                </div>
                </form>
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
                    <tbody class="actv"> 

                        <?php echo $row_data; ?>

                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div> 


            </form>

    </div>
    </section>

<script type="text/javascript">

    function load_activty()
    {
        var $activity_id = $('#activity').val();
        var url ='<?php echo base_url(); ?>payments/payment_details/'+$activity_id;
       
        $.ajax({
            url : url,
            type: "GET",
            success: function(data)
            {
                $('.actv').html(data);
            }
        });
    }

    function exportF(elem) {
      var table = document.getElementById("payments_table");
      var html = table.outerHTML;
      var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
      elem.setAttribute("href", url);
      elem.setAttribute("download", "payments-report.xls"); // Choose the file name
      return false;
    }

</script>



    