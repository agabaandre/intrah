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
            <h2>Campaign Details</h2>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php if($this->aauth->is_group_allowed("addcampaigns",$this->mygroup) ){ ?>
                <button class="btn btn-success" onclick="add_activity()"><i class="glyphicon glyphicon-plus"></i> Add Campaign</button>
                <?php } ?>
                <!--<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>-->
                <!--<a href="javascript:void(0);" data-toggle="modal" data-target="#add-employee" class="float-right btn btn-primary btn-sm" style="margin: 4px;" rel="noopener noreferrer"><i class="fa fa-plus"></i> Add provider</a>-->
            </div>
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
                            <input type="text" class="form-control column_filter" id="location_filter" data-custom_column="1" placeholder="Location">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="date_filter" data-custom_column="3" placeholder="Date">
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
                        <th scope="col">Location</th>
                        <th scope="col">Region</th>
                        <th scope="col">SNU's</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Notes</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Location</th>
                        <th scope="col">Region</th>
                        <th scope="col">SNU's</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Notes</th>
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
                "url": "<?php echo site_url('activity/getAllDetails') ?>",
                "type": "POST",
                "data": function ( data ) {
                    data.location = $('#location_filter').val();
                    data.date_range = $('#date_filter').val();
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

    function add_activity(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add New Campaign'); // Set Title to Bootstrap modal title
    }


    function edit_activity(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('activity/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="activity_id"]').val(data.activity_id);
                $('[name="location"]').val(data.location);
                $('[name="notes"]').val(data.notes);
                $('[name="starts"]').val(data.starts);
                $('[name="ends"]').val(data.ends);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Activity'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('An Error occured');
                //alert('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
            }
        });
    }

    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('activity/save') ?>";
        } else {
            url = "<?php echo site_url('activity/update') ?>";
        }
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                $('.text-danger').remove();
                    if (data['error']) {             
                        for (i in data['error']) {
                            var element = $('.input-emp-' + i);
                            if ($(element).parent().hasClass('input-group')) {                       
                                $(element).parent().after('<div class="text-danger" style="font-size: 14px;">' + data['error'][i] + '</div>');
                            } else {
                                $(element).after('<div class="text-danger" style="font-size: 14px;">' + data['error'][i] + '</div>');
                            }
                        }
                    } else {
                        if(save_method == 'add') {
                            jQuery('span#success-msg').html('<div class="alert alert-success">A new Campaign has successfully been added.</div>');
                        } else {
                            jQuery('span#success-msg').html('<div class="alert alert-success">Campaign successfully Updated.</div>');
                        }
                        $('#modal_form').modal('hide');
                        jQuery('#render-datatable').DataTable().ajax.reload(null,false);
                        
                        
                    }

                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //alert('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }

    function reload_table()
    {
        jQuery('#render-datatable').DataTable().ajax.reload(null,false);
        //table.ajax.reload(null,false); //reload datatable ajax
    }

    function delete_activity(id){
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('activity/delete') ?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    jQuery('span#success-msg').html('<div class="alert alert-success">Deleted Campaign successfully.</div>');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        }
    }
    function view_activity(id){
         // ajax view data to database
        $.ajax({
            url : "<?php echo site_url('activity_details/index') ?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                jQuery('span#success-msg').html('<div class="alert alert-success">Activity Opened.</div>');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                alert('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                alert('Error Opening Activity');
            }
        });
    }
    $(function() {
        /*$('#start_datetimepicker').datetimepicker({
         dateFormat: 'yy-mm-dd',
        });

        $('#end_datetimepicker').datetimepicker({
         dateFormat: 'yy-mm-dd',
         changeMonth: true,
         changeYear: true,
         viewMode: 'years',
         clearBtn: true,
         icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                }
        });

        $('#start_datetimepicker').on("dp.change", function (e) {
            $('#end_datetimepicker').data("DateTimePicker").minDate(e.date);
        });
        $('#end_datetimepicker').on("dp.change", function (e) {
            $('#start_datetimepicker').data("DateTimePicker").maxDate(e.date);
        });
        */

        $('input[name="starts"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2018,
            maxYear: parseInt(moment().format('YYYY'),5),
            locale: {
                format: 'YYYY-MM-DD'
            }
        },);
        $('input[name="ends"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2018,
            maxYear: parseInt(moment().format('YYYY'),5),
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

    });

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Campaign</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="activity_id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Location</label>
                            <div class="col-md-9">
                                <input name="location" placeholder="Location" class="form-control input-emp-location" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Region</label>
                            <div class="col-md-9">
                               <select name="region" style="width:300px" class="form-control input-emp-region">
                                </select>
                               <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                               <script type="text/javascript">
                                    $('.input-emp-region').select2({
                                        placeholder: '-- Select Region --',
                                        ajax: {
                                        url: "<?php echo site_url('activity/regions') ?>",
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                            return {
                                            results: data
                                            };
                                        },
                                        cache: true
                                        }
                                    });
                                </script>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">SNU's</label>
                            <div class="col-md-9">
                               <select name="snu[]" style="width:300px" class="form-control input-emp-snu" multiple>
                                </select>
                               <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                               <script type="text/javascript">
                                    $('.input-emp-snu').select2({
                                        placeholder: '-- Select SNUs --',
                                        multiple: true,
                                        ajax: {
                                        url: "<?php echo site_url('activity/snus') ?>",
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                            return {
                                            results: data
                                            };
                                        },
                                        cache: true
                                        }
                                    });
                                </script>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Start Date</label>
                            <div class="col-md-7 input-group date"><!--<span class="glyphicon glyphicon-calendar"></span></div>-->
                              <input  name="starts" id="start_datetimepicker" placeholder="Start Date" class="form-control input-emp-starts datetimepicker" type="text"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">End Date</label>
                            <div class="input-group date col-md-7">
                                <input name="ends" type="text" class="form-control input-emp-ends datetimepicker" id="end_datetimepicker"  placeholder="End Date">
                                <span class="input-group-addon"><i class="fa fa-calendar" ></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Notes</label>
                            <div class="input-group date col-md-7">
                                <textarea name="notes" type="text" class="form-control input-emp-notes " id="notes"  placeholder="Notes"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
<?php

$this->load->view('includes/footermain.php');
$this->load->view('includes/rightsidebar.php');
$this->load->view('includes/footer.php');
?>