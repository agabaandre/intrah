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
                <h3 style="color: SteelBlue;">Name: <?php echo $person ?></h3>
                <h4>Gender: <?php echo $gender ?></h4>
                <h4>Contact: <?php echo $contact ?></h4>
                <h4>Cadre: <?php echo $cadre ?></h4>
                <h4>District: <?php echo $district  ?></h4>
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
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive box-body">
            <table id="render-datatable" class="table table-bordered table-hover small">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col">Location</th>
                        <th scope="col">Region</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th scope="col">Location</th>
                        <th scope="col">Region</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
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

    var table;

    $(document).ready(function () {
        table = $('#render-datatable').DataTable({
            "paging": true,
            "processing": false,
            "serverSide": true,
            "order": [],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('person_details/getActivityDetails/'. $person_id) ?>",
                "type": "POST",
                "data": function ( data ) {
                    data.location = $('#location_filter').val();
                }
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column
                    "orderable": false, //set not orderable
                    
                },

            ],
            "select" :{
                style: 'multi',
            },
            "columns": [
                {
                    "bVisible": false, "aTargets": [0]
                },
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
            $('#render-datatable').DataTable().ajax.reload();
        });
    });

    function reload_table()
    {
        jQuery('#render-datatable').DataTable().ajax.reload(null,false);
    }
</script>

<?php

$this->load->view('includes/footermain.php');
$this->load->view('includes/rightsidebar.php');
$this->load->view('includes/footer.php');
?>