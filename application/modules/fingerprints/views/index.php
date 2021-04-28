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
    .datetimepicker {
      z-index: 1151 !important; /* has to be larger than 1050 */
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
            <h2>View Enrollements</h2>
        </div>
        
        <div class="row">
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
                            <input type="text" class="form-control column_filter" id="pid_filter" data-custom_column="1" placeholder="Person ID">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="siteId_filter" data-custom_column="3" placeholder="Site ID">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive box-body">
            <table id="render-datatable" class="table table-bordered table-hover small">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Fingerprint Number</th>
                        <th scope="col">Person ID</th>
                        <th scope="col">Site ID</th>
                        <th scope="col">Enrollment Date</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Fingerprint Number</th>
                        <th scope="col">Person ID</th>
                        <th scope="col">Site ID</th>
                        <th scope="col">Enrollment Date</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
</section>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    jQuery(document).ready(function () {
        table = jQuery('#render-datatable').dataTable({
            "paging": true,
            "processing": false,
            "serverSide": true,
            "order": [],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('fingerprints/getAllDetails') ?>",
                "type": "POST",
                "data": function ( data ) {
                    data.pid = $('#pid_filter').val();
                    data.siteId = $('#siteId_filter').val();
                }
            },
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="far fa-file-excel" aria-hidden="true"></i> Excel Export',
                    filename: 'Campaigns',
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
                    filename: 'Campaigns',
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
                    filename: 'Campaigns',
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
            "columns": [
                {
                    "bVisible": true, "aTargets": [0]
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
    });

    function reload_table()
    {
        jQuery('#render-datatable').DataTable().ajax.reload(null,false);
        //table.ajax.reload(null,false); //reload datatable ajax
    }

    function delete_fpt(id){
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('fingerprints/delete') ?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    jQuery('span#success-msg').html('<div class="alert alert-success">Deleted Data successfully.</div>');
                    jQuery('#render-datatable').DataTable().ajax.reload(null,false);
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        }
    }

</script>
<?php

$this->load->view('includes/footermain.php');
$this->load->view('includes/rightsidebar.php');
$this->load->view('includes/footer.php');
?>