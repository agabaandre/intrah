<?php
$this->load->view('includes/head2.php');
$this->load->view('includes/topbar.php');
$this->load->view('includes/sidenav.php');
//$this->load->view('includes/responsive_table.php');
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
    .datepicker {
      z-index: 1151 !important; /* has to be larger than 1050 */
    }
</style>
<div class="content-wrapper">
<section class="content">
      <div class="row">
          <div class="col-lg-12"><span id="success-msg"></div>
      </div>
      <div id="error">
            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h3><?php echo "" . $activity_id . " " . $location . " : " . date("jS F Y", strtotime($starts)) . " - " . date("jS F Y", strtotime($ends))   ?> </h3>
                <h3><?php echo "" . $sid . " : " . $siteName  ?> </h3>
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
                            <input type="text" class="form-control column_filter" id="name_filter" data-custom_column="1" placeholder="Name">
                        </div>

                    </div>

                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="contact_filter" data-custom_column="3" placeholder="Contact">
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="cadre_filter" data-custom_column="2" placeholder="Cadre">
                        </div>

                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="district_filter" data-custom_column="3" placeholder="District">
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-12">
                <button class="btn btn-danger" onclick="bulk_delete()"><i class="glyphicon glyphicon-minus"></i> Delete Selected</button>
            </div>
        <div class="table-responsive box-body">
            <table id="render-datatable2" class="table table-bordered table-hover small">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Cadre</th>
                        <th scope="col">District</th>
                        <th scope="col">Contact No</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Cadre</th>
                        <th scope="col">District</th>
                        <th scope="col">Contact No</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-lg-12">
                <button class="btn btn-danger" onclick="bulk_add()"><i class="glyphicon glyphicon-plus"></i> Add Selected</button>
            </div>
        <div class="table-responsive box-body">
            <table id="render-datatable" class="table table-bordered table-hover small">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Cadre</th>
                        <th scope="col">District</th>
                        <th scope="col">Contact No</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Cadre</th>
                        <th scope="col">District</th>
                        <th scope="col">Contact No</th>
                    </tr>
                </tfoot>
            </table>
        </div>
</section>
</div>

<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
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
    var table_two;

    $(document).ready(function () {
        table = $('#render-datatable').DataTable({
            "paging": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('activity_details/getActivityDetails') ?>",
                "type": "POST",
                "data": function ( data ) {
                    data.fullname = $('#name_filter').val();
                    data.contact = $('#contact_filter').val();
                    data.cadre = $('#cadre_filter').val();
                    data.district = $('#district_filter').val();
                }
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column
                    "orderable": false, //set not orderable
                    "checkboxes":{
                        selectRow:true
                    }
                },

            ],
            "select" :{
                style: 'multi',
            },
            "columns": [
                {
                    "bVisible": true, "aTargets": [0]
                },
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

        table_two = $('#render-datatable2').DataTable({
            "paging": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('activity_details/getAttendActivityDetails/'. $sid) ?>",
                "type": "POST",
                "data": function ( data ) {
                    data.fullname = $('#name_filter').val();
                    data.contact = $('#contact_filter').val();
                    data.cadre = $('#cadre_filter').val();
                    data.district = $('#district_filter').val();
                }
            },
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="far fa-file-excel" aria-hidden="true"></i> Excel Export',
                    filename: 'Campaign_Provider_Details',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'current'
                        },
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="far fa-csv"></i> Export CSV',
                    filename: 'Campaign_Provider_Details',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'current'
                        },
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="far fa-file-pdf" aria-hidden="true"></i> PDF',
                    filename: 'Campaign_Provider_Details',
                    title: '',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'current'
                        },
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                },
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "select" :{
                style: 'multi',
            },
            "columns": [
                {
                    "bVisible": true, "aTargets": [0]
                },
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
            $('#render-datatable2').DataTable().search(
                    v,
                    false,
                    false
                    ).draw();
            $('#render-datatable').DataTable().search(
            v,
            false,
            false
            ).draw();
        }

        // filter keyword
        $('input.global_filter').on('keyup click', function () {
            var v = jQuery(this).val();
            filterGlobal(v);
        });
        $('input.column_filter').on('keyup click', function () {
            $('#render-datatable2').DataTable().ajax.reload();
            $('#render-datatable').DataTable().ajax.reload();
        });

        $('#render-datatable tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );
        
        $('#render-datatable2 tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );
    });

    function bulk_add()
    {
        var list_id = [];
        $(".selected").each(function() {
                id = $(this).closest('tr').attr('id');
                list_id.push(id);
        });
        if(list_id.length > 0)
        {
            if(confirm('Are you sure add these '+list_id.length+' Records?'))
            {
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo site_url('activity_details/bulk_add/'.$activity_id.'/'.$sid) ?>",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status)
                        {
                            jQuery('span#success-msg').html('<div class="alert alert-success">The records have successfully been added to Campaign Site.</div>');
                            reload_table();
                        }
                        else
                        {
                            alert('Failed.');
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error Adding data');
                    }
                });
            }
        }
        else
        {
            alert('no data selected');
        }
    }

    function bulk_delete()
    {
        var list_id = [];
        $(".selected").each(function() {
                id = $(this).closest('tr').attr('id');
                list_id.push(id);
        });
        if(list_id.length > 0)
        {
            if(confirm('Are you sure delete these '+list_id.length+' Records?'))
            {
                $.ajax({
                    type: "POST",
                    data: {id:list_id},
                    url: "<?php echo site_url('activity_details/delete_selected/'.$activity_id) ?>",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status)
                        {
                            jQuery('span#success-msg').html('<div class="alert alert-success">The records have successfully been removed from this Campaign and Site.</div>');
                            reload_table();
                        }
                        else
                        {
                            alert('Failed.');
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error Adding data');
                    }
                });
            }
        }
        else
        {
            alert('no data selected');
        }
    }

    function reload_table()
    {
        jQuery('#render-datatable').DataTable().ajax.reload(null,false);
        jQuery('#render-datatable2').DataTable().ajax.reload(null,false);
    }
    function delete_from_activity(id){
        if(confirm('Are you sure delete this provider from this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('activity/delete_provider') ?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    jQuery('span#success-msg').html('<div class="alert alert-success">Deleted Provider from Activity successfully.</div>');
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