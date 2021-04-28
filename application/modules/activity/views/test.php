    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Activity Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Activity</li>
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
            </div>
        </div>


        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title float-left">
                    <?php if($this->aauth->is_group_allowed("addcampaigns",$this->mygroup) ){ ?>
                        <button class="btn btn-success btn-sm float-left" onclick="add_activity()">Add Activity</button>
                     <?php } ?>
                </h3>
              <!--   <form  method="post" >  -->

                <div class="card-tools float-right">
                  <div class="input-group input-group-sm" style="width: 30em;">

                    <input type="text" class="form-control float-right" id="search" name="search" value="<?php echo $search; ?>" placeholder="Enter your search (e.g: location, region)"  >

                    <div class="input-group-append">
                      <button type="#" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
             <!--    </form> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 390px;">
                <table  class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col">Location</th>
                            <th scope="col">Region</th>
                            <th scope="col">Sart Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Nate</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead> 
                    <tbody> 

                        <?php echo $rows; ?>

                    </tbody>

                    
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div>


<script type="text/javascript">

    var save_method; //for save method string
    var table;

    function add_activity(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add New Activity'); // Set Title to Bootstrap modal title
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

</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Activity</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div>
            <div class="modal-body form">
                <form  id="form" method="post" enctype="multipart/form-data"> 

                   <input type="hidden" value="" name="pid"/>
                        <div class="form-group">
                            <label class="control-label">Location</label>
                                <input name="location" placeholder="Location" class="form-control input-emp-location" type="text">
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
                                <label class="control-label">Region</label>
                                <br>
                               <select name="regions" class="form-control select2bs4" style="width: 100%">
                                <option value="">--Select region--</option>
                                <?php 
                                    $query = $this->db->select('id, region as text')->get("regions");
                                    $regions = $query->result();

                                    foreach ($regions as $data) { ?>
                                        <option value="<?php echo $data->id; ?>">
                                            <?php echo $data->text; ?>
                                        </option>
                                <?php } ?>
                                
                                </select>
                                <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                          <label>Start Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="starts" placeholder="Start Date" data-target="#reservationdate"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                          <label>Start Date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="ends" placeholder="End Date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Notes</label>
                                <textarea name="notes" type="text" class="form-control input-emp-notes " id="notes"  placeholder="Notes"></textarea>
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

<script type="text/javascript">
        //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
</script>


