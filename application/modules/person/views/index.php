
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
        font-size:12px;
    }
</style>

<section class="content">
        <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>List of Persons</h2>
      </div>
      <div class="row">
          <div class="col-lg-12"><span id="success-msg"></div>
      </div>
      <?php if ($msg) { ?>
        <div class="col-lg-12"><div class="alert alert-success"> <?php echo $msg  ?></div></div>
      <?php   
        }
      ?>
        <div class="row">
            <div class="col-lg-12">
                <?php if($this->aauth->is_group_allowed("manageusers",$this->mygroup) ){ ?>
                <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add provider</button>             
                <?php } ?>

                <a href="javascript:void(0);" data-toggle="modal" data-target="#registration_form" class="float-right btn btn-primary btn-sm" style="margin: 4px;" rel="noopener noreferrer"><i class="fa fa-plus"></i> Add Participant</a> 
            </div>
        </div>
        <?php if($this->aauth->is_group_allowed("manageusers",$this->mygroup) ){ ?>
            <form action="<?php echo site_url('person/uploadData');?>" method="post" enctype="multipart/form-data" name="uploadform" id="uploadform"> 
                <table>
                    <tr>
                        <td> Choose your file For Upload: </td>
                        <td>
                            <input type="file" class="form-control" name="providerimport" id="providerimport"  align="center"/>
                        </td>
                        <td>
                            <div class="col-lg-offset-3 col-lg-9">
                                <button type="submit" name="submit" class="btn btn-info">Upload</button>
                            </div>
                        </td>
                    </tr>
                </table> 
            </form>
        <?php } ?>
        <div class="row col-lg-12"></div>

        <!--div class="row">
            
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
                            <input type="text" class="form-control column_filter" id="contact_filter" data-custom_column="2" placeholder="Email">
                        </div>

                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">                        
                            <input type="text" class="form-control column_filter" id="cadre_filter" data-custom_column="3" placeholder="Contact">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <div class="form-group">
                            <input type="text" class="form-control column_filter" id="district_filter" data-custom_column="3" placeholder="District">
                        </div>
                    </div>
                </div>                
            </div>
        </div --> 


        <div class="table-responsive">
            <table id="render-datatable" class="table table-bordered table-hover small"> 
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Cadre</th>
                        <th scope="col">District</th>
                        <th scope="col">Contact No</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead> 
                <tbody> 
                </tbody> 
                <tfoot> 
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Cadre</th>
                        <th scope="col">District</th>
                        <th scope="col">Contact No</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>

</section>
</div>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<!--<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>-->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#render-datatable').dataTable({
            "paging": true,
            "processing": false,
            "serverSide": true,
            "order": [],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('person/getAllPersons') ?>",
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
                    filename: 'Provider_Details',
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
                    filename: 'Provider_Details',
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
                    filename: 'Provider_Details',
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
            jQuery('#render-datatable').DataTable().ajax.reload();
        });
    });

    function add_person(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Provider'); // Set Title to Bootstrap modal title
    }


    function edit_person(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('person/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="id"]').val(data.pid);
                $('[name="firstName"]').val(data.firstname);
                $('[name="lastName"]').val(data.surname);
                $('[name="otherName"]').val(data.othername);
                $('[name="gender"]').val(data.gender);
                $('[name="cadre"]').val(data.cadre);
                $('[name="district"]').val(data.district);
                $('[name="region"]').val(data.region);
                $('[name="mobile"]').val(data.mobile);
                $('[name="email"]').val(data.email);
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

        if(save_method == 'add') {
            url = "<?php echo site_url('person/save') ?>";
        } else {
            url = "<?php echo site_url('person/update') ?>";
        }
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                //if(data.status) //if success close modal and reload ajax table
                //{
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
                            jQuery('span#success-msg').html('<div class="alert alert-success">Provider data has been successfully Added.</div>');
                        } else {
                            jQuery('span#success-msg').html('<div class="alert alert-success">Provider data has been successfully Updated.</div>');
                        }
                        $('#modal_form').modal('hide');
                        jQuery('#render-datatable').DataTable().ajax.reload(null,false);
                        
                        
                    }
                
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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
    }

    function delete_person(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('person/delete') ?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    jQuery('span#success-msg').html('<div class="alert alert-success">Deleted Provider details successfully..</div>');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    alert('Error deleting data');
                }
            });

        }
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Provider</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input name="firstName" placeholder="First Name" class="form-control input-emp-firstname" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input name="lastName" placeholder="Last Name" class="form-control input-emp-lastname" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Other Name</label>
                            <div class="col-md-9">
                                <input name="otherName" placeholder="Other Name" class="form-control input-emp-othername" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <select name="gender" class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Contact</label>
                            <div class="col-md-9">
                                <input name="mobile" placeholder="Mobile" class="form-control input-emp-mobile" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="email" placeholder="Email" class="form-control input-emp-email" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Designation</label>
                            <div class="col-md-9">
                                <select name="cadre" class="form-control input-emp-cadre">
                                    <option value="">--Select Designation--</option>
                                    <option value="Provider">Provider</option>
                                    <option value="Support">Support</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">District</label>
                            <div class="col-md-9">
                               <select name="district" style="width:300px" class="form-control input-emp-district">
                                </select>
                               <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                               <script type="text/javascript">
                                    $('.input-emp-district').select2({
                                        placeholder: '-- Select District --',
                                        ajax: {
                                        url: "<?php echo site_url('person/districts') ?>",
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
                            <label class="control-label col-md-3">Account Number</label>
                            <div class="col-md-9">
                                <input name="account_no" placeholder="Account Number" class="form-control input-emp-account_no" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Bank Name</label>
                            <div class="col-md-9">
                                <input name="bank_name" placeholder="Bank Name" class="form-control input-emp-bank_name" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Bank Code</label>
                            <div class="col-md-9">
                                <input name="bank_code" placeholder="Bank Code" class="form-control input-emp-bank_code" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Branch</label>
                            <div class="col-md-9">
                                <input name="branch_name" placeholder="Branch" class="form-control input-emp-branch_name" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Branch Code</label>
                            <div class="col-md-9">
                                <input name="branch_code" placeholder="Branch Code" class="form-control input-emp-branch_code" type="text">
                                <span class="help-block"></span>
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


<!-- Bootstrap modal -->
<div class="modal fade" id="registration_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Participant</h3>
            </div>
            <div class="modal-body form">
                <form action="<?php echo site_url('person/saveParticipantData');?>" method="post" enctype="multipart/form-data"> 

                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Participant</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Name of Participant" class="form-control input-emp-firstname" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-9">
                                <select name="title" class="form-control">
                                    <option value="">--Select Title--</option>
                                    <option value="Mrs">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Prof.">Prof.</option>
                                    <option value="Dr.">Dr.</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Organisation</label>
                            <div class="col-md-9">
                                <input name="organisation" placeholder="Organisation" class="form-control input-emp-organisation" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Telephone</label>
                            <div class="col-md-9">
                                <input name="telephone" placeholder="Telephone" class="form-control input-emp-telephone" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Time in</label>
                            <div class="col-md-9">
                                <input name="time_in" placeholder="Time in" class="form-control input-emp-account_no" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Signature</label>
                            <div class="col-md-9">
                                <input name="signature1" placeholder="Signature" class="form-control input-emp-signature" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Time out</label>
                            <div class="col-md-9">
                                <input name="time_out " placeholder="Time out" class="form-control input-emp-time_out" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Signature</label>
                            <div class="col-md-9">
                                <input name="signature2" placeholder="Signature" class="form-control input-emp-signature" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
