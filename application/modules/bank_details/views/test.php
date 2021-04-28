    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Providers' Bank Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bank Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9 col-sm-9">
                        <div class="form-group">
                            <input type="text" class="small form-control global_filter" id="global_filter" placeholder="Keyword..">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="district_filter" data-custom_column="3" placeholder="District">
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
                            <input type="text" class="form-control column_filter" id="account_filter" data-custom_column="3" placeholder="Account">
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="bank_filter" data-custom_column="2" placeholder="Bank Name">
                        </div>

                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="facility_filter" data-custom_column="3" placeholder="Facility">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive box-body">
                    <table id="render-datatable" class="table table-bordered table-hover small">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Acount Number</th>
                                <th scope="col">Bank Name</th>
                                <th scope="col">Bank Code</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Branch Code</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Acount Number</th>
                                <th scope="col">Bank Name</th>
                                <th scope="col">Bank Code</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Branch Code</th>
                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </div>

      </div>

      </div>

    </section>
        <!-- /.row -->
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
                "url": "<?php echo site_url('bank_details/getAllDetails') ?>",
                "type": "POST",
                "data": function ( data ) {
                    data.fullname = $('#name_filter').val();
                    data.account_no = $('#account_filter').val();
                    data.bank_name = $('#bank_filter').val();
                    data.facility = $('#facility_filter').val();
                    data.district = $('#district_filter').val();
                }
            },
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="far fa-file-excel" aria-hidden="true"></i> Excel Export',
                    filename: 'Bank_Details',
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
                    filename: 'Bank_Details',
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
                    filename: 'Bank_Details',
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

    function add_person(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Provider Bank Details'); // Set Title to Bootstrap modal title
    }


    function edit_record(id,pid)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        if (!id) {
           id = 0 ; 
        }
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('bank_details/edit') ?>/" + id + "/" + pid,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="pid"]').val(data.pid);
                $('[name="id"]').val(data.bid);
                $('[name="firstName"]').val(data.firstname);
                $('[name="lastName"]').val(data.surname);
                $('[name="otherName"]').val(data.othername);
                $('[name="account_no"]').val(data.account_no);
                $('[name="bank_name"]').val(data.bank_name);
                $('[name="branch_name"]').val(data.branch_name);
                $('[name="bank_code"]').val(data.bank_code);
                $('[name="branch_code"]').val(data.branch_code);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

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
        var bid;
        bid = $('[name="id"]').val();
        if(bid == 0) {
            url = "<?php echo site_url('bank_details/save') ?>";
        } else {
            url = "<?php echo site_url('bank_details/update') ?>";
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
                            jQuery('span#success-msg').html('<div class="alert alert-success">Provider Bank data has been successfully Added.</div>');
                        } else {
                            jQuery('span#success-msg').html('<div class="alert alert-success">Provider Bank data has been successfully Updated.</div>');
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

    function delete_record(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('bank_details/delete') ?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    jQuery('span#success-msg').html('<div class="alert alert-success">Deleted Provider bank details successfully..</div>');
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

