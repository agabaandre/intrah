<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List of Participants</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Participants</li>
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
        <span id="success-msg"></span>
        
         <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title float-left">
                    <a  onclick="add_person()" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Participant</a>
                </h3>
                <form id="Searchform" method="post" > 

                <div class="card-tools float-right">
                  <div class="input-group input-group-sm" style="width: 40em;">

                    <input type="text" class="form-control column_filter" id="search" name="search" value="<?php echo $search; ?>" data-custom_column="1" placeholder="Enter your search (e.g: first name, other name, sur name, gender, contact, district, email)">

                    <div class="input-group-append">
                      <button type="button" onclick="search_person()" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 370px;">
                <table id="render-datatable" class="table table-head-fixed text-nowrap">
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
                    <tbody class="page_data"> 

                        <?php echo $row_data; ?>

                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div> 
        
    </section>
        <!-- /.row -->

<script type="text/javascript">

    function add_person(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#registration_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Participant'); // Set Title to Bootstrap modal title
    }



    function person_details(id)
    {
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
                $('[name="pid"]').val(data.pid);
                $('[name="firstname"]').val(data.firstname);
                $('[name="surname"]').val(data.surname);
                $('[name="othername"]').val(data.othername);
                $('[name="gender"]').val(data.gender);
                $('[name="cadre"]').val(data.cadre);
                $('[name="district"]').val(data.district);
                $('[name="place"]').val(data.place);
                $('[name="mobile"]').val(data.mobile);
                $('[name="email"]').val(data.email);
                $('[name="occupation"]').val(data.occupation);
                $('[name="organisation"]').val(data.organisation);
                $('#view_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Participant'); // Set title to Bootstrap modal title


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('An Error occured');
            }
        });
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

                $('[name="pid"]').val(data.pid);
                $('[name="firstname"]').val(data.firstname);
                $('[name="surname"]').val(data.surname);
                $('[name="othername"]').val(data.othername);
                $('[name="gender"]').val(data.gender);
                $('[name="cadre"]').val(data.cadre);
                $('[name="district"]').val(data.district);
                $('[name="place"]').val(data.place);
                $('[name="mobile"]').val(data.mobile);
                $('[name="email"]').val(data.email);
                $('[name="occupation"]').val(data.occupation);
                $('[name="organisation"]').val(data.organisation);
                $('#registration_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Participant'); // Set title to Bootstrap modal title


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('An Error occured');
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
            //dataType: "JSON",
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
                            jQuery('span#success-msg').html('<div class="alert alert-success">Provider data has been successfully Added.</div>');
                        } else {
                            jQuery('span#success-msg').html('<div class="alert alert-success">Provider data has been successfully Updated.</div>');
                        }
                        $('#registration_form').modal('hide');
                        //jQuery('#render-datatable').DataTable().ajax.reload(null,false);
                        
                    }
                
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

                $.get({
                    url: "<?php echo base_url('persons-info'); ?>",
                            success:function(response){
                            //$('.loader_text_text').hide();
                            $('.page_data').html(response);
                      //console.log(response);
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);

                //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }


    function search_person()
    {
        var url ="<?php echo site_url('person/index') ?>";
        $.ajax({
            url : url,
            type: "POST",
            data: $('#Searchform').serialize(),
            success: function(data)
            {
                $('.page_data').html(data);
               /* $.get({
                    url: "<?php //echo base_url('persons-info'); ?>",
                            success:function(response){
                            $('.page_data').html(response);
                    }
                }); */
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
                    $('#registration_form').modal('hide');
                    jQuery('span#success-msg').html('<div class="alert alert-success">Deleted Provider details successfully..</div>');

                    $('#render-datatable').DataTable().ajax.reload(null,false);
                    //reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                    alert('Error deleting data');
                }
            });

        }

        $.get({
            url: "<?php echo base_url('persons-info'); ?>",
                    success:function(response){
                $('.page_data').html(response);
            }
        });
    }
</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="registration_form" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div>
            <div class="modal-body form">
                <form  id="form" method="post" enctype="multipart/form-data"> 

                   <input type="hidden" value="" name="pid"/>
                        <div class="form-group">
                            <label class="control-label">Surname Name</label>
                                <input name="surname" class="form-control input-emp-surname" type="text">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Other Name</label>
                                <input name="othername" class="form-control input-emp-othername" type="text">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                                <input name="firstname" class="form-control input-emp-firstname" type="text">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Gender</label>
                                <select name="gender" class="form-control select2bs4" style="width: 100% ">
                                    <option value="">--Select Gender--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Telephone</label>
                                <input name="mobile"  class="form-control input-emp-telephone" type="text">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                                <input name="email"  class="form-control input-emp-email" type="email">
                                <span class="help-block"></span>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Occupation</label>
                                <input name="occupation"  class="form-control input-emp-occupation" type="text">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Title</label>
                                <select name="cadre" class="form-control select2bs4" style="width: 100% ">
                                    <option value="">--Select Designation--</option>
                                    <option value="Participant">Participant</option>
                                    <option value="Support">Support</option>
                                </select>
                                <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                                <label class="control-label">District</label>
                                <br>
                               <select name="district" class="form-control select2bs4" style="width: 100% ">
                                <option value="">--Select District--</option>
                                <?php 
                                    $query = $this->db->select('id, district_name as text')->get("districts");
                                    $districts = $query->result();

                                    foreach ($districts as $data) { ?>
                                        <option value="<?php echo $data->id; ?>">
                                            <?php echo $data->text; ?>
                                        </option>
                                <?php } ?>
                                
                                </select>
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Place/Residence</label>
                                <input name="place" class="form-control input-emp-place" type="text">
                                <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Organisation</label>
                                <input name="organisation" class="form-control input-emp-organisation" type="text">
                                <span class="help-block"></span>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->




<!-- Bootstrap modal -->
<div class="modal fade" id="view_form" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="PID"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div>
            <div class="modal-body form">
                        
                        <div class="form-group">
                            <label class="control-label">Surname Name</label>
                                <input name="surname" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Other Name</label>
                                <input name="othername" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">First Name</label>
                                <input name="firstname" class="form-control input-emp-firstname" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Gender</label>
                                <input name="firstname" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Telephone</label>
                                <input name="mobile"  class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                                <input name="email"  class="form-control" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Occupation</label>
                                <input name="occupation"  class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Title</label>
                               <input name="occupation"  class="form-control" readonly>
                        </div>

                        <div class="form-group">
                                <label class="control-label">District</label>
                                <input name="district"  class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Place/Residence</label>
                                <input name="place" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Organisation</label>
                                <input name="organisation" class="form-control" readonly>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">
        //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
</script>