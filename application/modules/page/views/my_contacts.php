
<!--Contact Section Start-->
<section id="contact" class="contact-section pt-page">
    <div class="section-container">

        <!--Page Heading-->
        <div class="page-heading">
            <span class="icon"><i class="lnr lnr-envelope"></i></span>
            <h2>Contact Me.</h2>
        </div>

        <!--Form Row-->
        <div class="row mb-70">
            <div class="col-lg-8  offset-lg-2">
                <!-- div class="subheading">
                    <h3>Let's Talk</h3>
                </div -->

        <!--Contact Info Row Start-->
        <div class="row contact-info mb-70">
            <strong>I'd be happy to Hear from you!</strong> <span>If you’d like to get in touch with me, whether to hire me, request for additional information, or just to say hi, you can reach out to me using the contact form below or my e-mail address <b><?php echo $contacts->email; ?></b>, or call me on: <b><?php echo $contacts->phone2; ?></b></span> 
             
             <center>
                <b>
                    <span style="color: green;" id="res"></span></b>
            </center>
    
             <center><span class="text-danger" id="response">
                  <?php echo $this->session->flashdata('msg'); ?>
                </span> </center>
        </div>
        <!--Contact Info Row End-->               

                <!--Form Start-->
                <form>
                    <div class="row">

                        <!--Name Field-->
                        <div class="col-md-6 mb-50">
                            <span class="input">
                                <input class="input__field" type="text" id="nam"  name="names" required />
                                <label class="input__label" for="cf-name">Name</label>
                            </span>
                        </div>

                        <!--Email Field-->
                        <div class="col-md-6 mb-50">
                            <span class="input">
                                <input class="input__field" type="text" id="em" name="email" required/>
                                <label class="input__label" for="cf-email">Email</label>
                            </span>
                        </div>

                        <!--Message Box-->
                        <div class="col-md-12 mb-30">
                            <span class="input">
                                <textarea  class="input__field" id="mess" name="message" rows="2" required></textarea>
                                <label class="input__label" for="cf-message">How can we help you?</label>
                            </span>
                        </div>

                        <div class="alert-container col-md-12"></div>

                        <!--Submit Button-->
                        <div class="col-md-12 text-center">
                            <button  id="send" class="btn-main">Send Message</button>
                        </div>


                    </div>
                </form>
                <!--Form End-->

            </div>
        </div>

    </div>

<script type="text/javascript">

 /*   $('#submitMessage').submit(function(e){
    e.preventDefault(); 
         $.ajax({
             url:'<?php echo base_url(); ?>page/send',
             type:"post",
             data:new FormData(this),
             processData:false,
             contentType:false,
             cache:false,
             async:true,
             success:function(data){
               console.log(data)
               //alert(result);
                $('#res').html(data);
           }
         });
    });  */

</script>

</section>
<!--Contact Section End-->  
3
    
<script type="text/javascript"> 

    $( document ).on( 'click', '#send', function ( e ) {
    e.preventDefault();
    //hide response if it's visible
    $( '#response' ).hide();
    //we grab all fields values to create our email
    var names = $( '#nam' ).val();
    var email = $( '#em' ).val();
    var message = $( '#mess' ).val();
    if ( names === '' || email === '' || message === '' )
    {
        //all fields are rquired so if one of them is empty the function returns
        return;
    }
    //if it's all right we proceed
    $.ajax( {
        type: 'post',
        //our baseurl variable in action will call the sendemail() method in our default controller
        url: '<?php echo base_url(); ?>page/sendemail',
        data: { name: name, email: email, message: message },
        success: function ( result )
        {
            console.log(result)
            //Ajax call success and we can show the value returned by our controller function
            $( '#response' ).html( result ).fadeIn( 'slow' ).delay( 1222000 ).fadeOut( 'slow' );
            
            // $( '#nam' ).val( '' );
            // $( '#em' ).val( '' );
            // $( '#mess' ).val( '' );
        },
        error: function ( result )
        {
            //Ajax call failed, so we inform the user something went wrong
            $( '#response' ).html( 'Server unavailable now: please, retry later.' ).fadeIn( 'slow' ).delay( 5663000 ).fadeOut( 'slow' );
           // $( '#nam' ).val( '' );
           //  $( '#em' ).val( '' );
           //  $( '#mess' ).val( '' );
        }
    } );
} );
</script>