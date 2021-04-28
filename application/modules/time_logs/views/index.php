<?php
$this->load->view('includes/head.php');
$this->load->view('includes/topbar.php');
$this->load->view('includes/sidenav.php');
$this->load->view('includes/responsive_table.php');
//$this->load->view('includes/header');
?>
<style>
    .dataTables_filter { display: none; }
    .dataTables_wrapper .dt-buttons {
        float:right;
        text-align:center;
        font-size:12px;
    }
    .dataTables_paginate{
        font-size:10px;
        margin-bottom:5px;
    }
    .dataTables_length{
        font-size:12px;
        margin-bottom:5px;
    }
    .dataTables_info{
        font-size:14px;
    }
</style>
<div class="content-wrapper">
<section class="content">
      <div class="row">
          <div class="col-lg-12"><span id="success-msg"></div>
      </div>
      <div id="error">
    </div>
        
            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h2>Campaigns Attendance Time Logs</h2>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <!--<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>-->
            </div>
        </div>
        <div class="row">
            <div class="row">
                <form id="form-filter" class="form-horizontal">
                    <div class="form-group">
                        <label for="activity" class="col-sm-2 control-label">Campaign</label>
                        <div class="col-sm-4">
                            <?php echo $form_activity; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <label for="activity" class="col-sm-2 control-label"></label>
                            <label for="activity" class="col-sm-2 control-label"></label>
                            <label for="activity" class="col-sm-2 control-label"></label>
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group">
                            <input type="text" class="small form-control global_filter" id="global_filter" placeholder="Keyword..">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="name_filter" data-custom_column="1" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="site_filter" data-custom_column="1" placeholder="Site Name">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="date_filter" data-custom_column="1" placeholder="Date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive box-body">
            <table id="render-datatable" class="table table-bordered table-hover small">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time In</th>
                        <th scope="col">Time Out</th>
                        <th scope="col">Hours</th>
                        <th scope="col">GPS</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time In</th>
                        <th scope="col">Time Out</th>
                        <th scope="col">Hours</th>
                        <th scope="col">GPS</th>
                    </tr>
                </tfoot>
            </table>
        </div>
</section>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>
<!--<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>-->
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    jQuery(document).ready(function () {
        jQuery('#render-datatable').dataTable({
            "paging": true,
            "processing": false,
            "serverSide": true,
            "order": [],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('time_logs/getAllDetails') ?>",
                "type": "POST",
                "data": function ( data ) {
                    data.activity = $('#activity').val();
                    data.fullname = $('#name_filter').val();
                    data.siteName = $('#site_filter').val();
                    data.date = $('#date_filter').val();
                }
            },
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="far fa-file-excel" aria-hidden="true"></i> Excel Export',
                    filename: 'Campaign_Time_Logs',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'current'
                        },
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="far fa-csv"></i> Export CSV',
                    filename: 'Campaign_Time_Logs',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'current'
                        },
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="far fa-file-pdf" aria-hidden="true"></i> PDF',
                    filename: 'Campaign_Time_Logs',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'current'
                        },
                        columns: [1, 2, 3, 4, 5]
                    }
                },
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column
                    "orderable": false, //set not orderable
                },

            ],
            "columns": [
                {
                    "bVisible": false, "aTargets": [0]
                },
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id', aData[0]);
            }
        });

        // define method global search
        function filterGlobal(v) {
            jQuery('#render-datatable').DataTable().search(
                    v,
                    false,
                    false
                    ).draw();
        }

        // filter keyword
        jQuery('input.global_filter').on('keyup click', function () {
            var v = jQuery(this).val();
            filterGlobal(v);
        });
        jQuery('input.column_filter').on('keyup click', function () {
            jQuery('#render-datatable').DataTable().ajax.reload();
        });

        $('#btn-filter').click(function(){ //button filter event click
            jQuery('#render-datatable').DataTable().ajax.reload();   //just reload table
        });
        $('#btn-reset').click(function(){ //button reset event click
            $('#form-filter')[0].reset();
            jQuery('#render-datatable').DataTable().ajax.reload(); //just reload table
         });
    });

    function reload_table()
    {
        jQuery('#render-datatable').DataTable().ajax.reload(null,false);
        //table.ajax.reload(null,false); //reload datatable ajax
    }


</script>
<?php

$this->load->view('includes/footermain.php');
$this->load->view('includes/rightsidebar.php');
$this->load->view('includes/footer.php');
?>