// view Emp details
jQuery(document).on('click', 'a.display-emp', function(){
    var emp_id = jQuery(this).data('geteid');
    jQuery.ajax({
        type:'POST',
        url: '<?php echo site_url('person/display') ?>',
        data:{emp_id: emp_id},
        dataType:'html',    
        beforeSend: function () {
            jQuery('#render-dispaly-data').html('<div class="text-center"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>');
        },                      
        success: function (html) {
            jQuery('#render-dispaly-data').html(html);
                                 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});
// Edit Emp Details
jQuery(document).on('click', 'a.update-emp-details', function(){
    var emp_id = jQuery(this).data('getueid');
    jQuery.ajax({
        type:'POST',
        url: '<?php echo site_url('person/edit') ?>',
        data:{emp_id: emp_id},
        dataType:'html',    
        beforeSend: function () {
            jQuery('#render-update-data').html('<div class="text-center"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>');
        },                      
        success: function (html) {
            jQuery('#render-update-data').html(html);
                                 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});
// set emp id for delete 
jQuery(document).on('click', 'a.delete-em-details', function(){
    var emp_id = jQuery(this).data('getdeid');
    jQuery('button#delete-emp').data('deleteempid', emp_id);

});
// Edit Delete Details
jQuery(document).on('click', 'button#delete-emp', function(){
    var emp_id = jQuery(this).data('deleteempid');
    jQuery.ajax({
        type:'POST',
        url: '<?php echo site_url('person/delete') ?>',
        data:{emp_id: emp_id},
        dataType:'html',         
        complete: function () {           
            setTimeout(function () {
                jQuery('tr#'+emp_id).html(''),
                jQuery('#render-datatable').DataTable().ajax.reload();
            }, 3000);
            jQuery('#delete-employee').modal('hide');
        }, 
        success: function (html) {
            jQuery('tr#'+emp_id).html('<td colspan="5"><span style="color:red;">Deleted Provider details successfully.</span></td>');
                                 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});

// Emp Details Add
jQuery(document).on('click', 'button#add-emp', function(){
    jQuery.ajax({
        type:'POST',
        url: '<?php echo site_url(''person/save') ?>',
        data:jQuery("form#add-employee-form").serialize(),
        dataType:'json',    
        beforeSend: function () {
            jQuery('button#add-emp').button('loading');
        },
        complete: function () {
            jQuery('button#add-emp').button('reset');
            setTimeout(function () {
                jQuery('span#success-msg').html('');
            }, 5000);
            
        },                
        success: function (json) {
            //console.log(json);
           $('.text-danger').remove();
            if (json['error']) {             
                for (i in json['error']) {
                    var element = $('.input-emp-' + i.replace('_', '-'));
                    if ($(element).parent().hasClass('input-group')) {                       
                        $(element).parent().after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                    }
                }
            } else {
                jQuery('span#success-msg').html('<div class="alert alert-success">Provider data has been successfully added.</div>');
                jQuery('#render-datatable').DataTable().ajax.reload();
                jQuery('form#add-employee-form').find('textarea, input').each(function () {
                    jQuery(this).val('');
                });
                jQuery('#add-employee').modal('hide');
                
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});

// Emp details update
jQuery(document).on('click', 'button#update-emp', function(){
    jQuery.ajax({
        type:'POST',
        url:'<?php echo site_url('person/update') ?>',
        data:jQuery("form#update-employee-form").serialize(),
        dataType:'json',    
        beforeSend: function () {
            jQuery('button#update-emp').button('loading');
        },
        complete: function () {
            jQuery('button#update-emp').button('reset');
            setTimeout(function () {
                jQuery('span#success-msg').html('');
            }, 5000);
            
        },                
        success: function (json) {
            //console.log(json);
           $('.text-danger').remove();
            if (json['error']) {             
                for (i in json['error']) {
                  var element = $('.input-emp-' + i.replace('_', '-'));
                  if ($(element).parent().hasClass('input-group')) {                       
                    $(element).parent().after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                  } else {
                    $(element).after('<div class="text-danger" style="font-size: 14px;">' + json['error'][i] + '</div>');
                  }
                }
            } else {
                jQuery('span#success-msg').html('<div class="alert alert-success">Provider data has been successfully updated.</div>');
                jQuery('#render-datatable').DataTable().ajax.reload();
                jQuery('form#update-employee-form').find('textarea, input').each(function () {
                    jQuery(this).val('');
                });
                jQuery('#update-employee').modal('hide');
            }                       
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }        
    });
});