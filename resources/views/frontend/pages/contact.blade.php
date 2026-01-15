@extends('frontend.master')
@section('contact')

<style type="text/css">
    
    .saved{
        color: green;
        font-family: georgia;
        font-size: 16px
    }
</style>
                    <div class="contact-us">
<br>
<br>
<br>
                    <div class="rooms-detail-summary-container room-facilities-container">
                        <div class="container offer-container">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="welcome-text-div subpageHdr">
                                        <h2>Contact Us</h2>
                                        <img class="dot-square" src="{{ asset('public/frontend_resource/')}}/images/icons/line-small.png" alt="Contact Us">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              
                                <div class="col-md-6">
                                    <div id="mauticform_wrapper_contactus" class="mauticform_wrapper">

                                        <form autocomplete="false" role="form" method="post"   data-mautic-form="contactus" enctype="multipart/form-data" id="contact_add">
                                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                                            <div class="mauticform-error" id="mauticform_contactus_error"></div>
                                            <div class="mauticform-message" id="mauticform_contactus_message"></div>
                                            <div class="mauticform-innerform">                                                
                                              <div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">

                                                <div id="mauticform_contactus_mobile"  class="mauticform-row mauticform-tel mauticform-field-3">
                                                    <label id="mauticform_label_contactus_mobile" for="mauticform_input_contactus_mobile" class="mauticform-label">Name</label>
                                                    <input id="mauticform_input_contactus_mobile" name="contact_name" value="" class="mauticform-input contact_name" type="tel" />
                                                    <span class="mauticform-errormsg" style="display: none;"></span>
                                                </div>

                                                <div id="mauticform_contactus_mobile"  class="mauticform-row mauticform-tel mauticform-field-3">
                                                    <label id="mauticform_label_contactus_mobile" for="mauticform_input_contactus_mobile" class="mauticform-label">Mobile</label>
                                                    <input id="mauticform_input_contactus_mobile" name="contact_mobile" value="" class="mauticform-input contact_mobile" type="number" />
                                                    <span class="mauticform-errormsg" style="display: none;"></span>
                                                </div> 
                                                <div id="mauticform_contactus_email"  class="mauticform-row mauticform-email mauticform-field-4">
                                                    <label id="mauticform_label_contactus_email" for="mauticform_input_contactus_email" class="mauticform-label">Email</label>
                                                    <input id="mauticform_input_contactus_email" name="contact_email" value="" class="mauticform-input contact_email" type="email" />
                                                    <span class="mauticform-errormsg" style="display: none;"></span>
                                                </div>

                                                <div id="mauticform_contactus_message"  class="mauticform-row mauticform-text mauticform-field-5">
                                                    <label id="mauticform_label_contactus_message" for="mauticform_input_contactus_message" class="mauticform-label">Message</label>
                                                    <textarea id="mauticform_input_contactus_message" name="contact_content" class="mauticform-textarea contact_content"></textarea>
                                                    <span class="mauticform-errormsg" style="display: none;"></span>
                                                </div>


                                                <div id="mauticform_contactus_submit"  class="mauticform-row mauticform-button-wrapper mauticform-field-7">
                                                    <button type="submit" name="mauticform[submit]" id="mauticform_input_contactus_submit" name="mauticform[submit]" value="" class="mauticform-button contact_now" value="1">Contact Now</button>

                                                </div>
                                                </div>
                                                    <span class="saved"></span>
                                            </div>

                                            <input type="hidden" name="mauticform[formId]" id="mauticform_contactus_id" value="6"/>
                                            <input type="hidden" name="mauticform[return]" id="mauticform_contactus_return" value=""/>
                                            <input type="hidden" name="mauticform[formName]" id="mauticform_contactus_name" value="contactus"/>

                                            </form>
                                    </div>


                                </div>
                                  <div class="col-md-6"> <!-- data-scrollreveal="enter left over 1s after 0.5s" -->
                                    <div class="address_div">
                                       <img src="{{ asset('public/frontend_resource/')}}/images/contact_us_icon.jpg">
                                      
                                    </div>
                                 
                                </div>

                            </div>
                        </div>
                    </div>

                    </div><!-- End .contact-us -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">


    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

   $('#contact_add').submit(function(e) {

       e.preventDefault();

       var contact_name = $('.contact_name').val();
       var contact_mobile = $('.contact_mobile').val();
       var contact_email = $('.contact_email').val();
       // alert(contact_name);

       if (contact_name == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter Name',
              icon: 'warning',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
              allowEscapeKey: false,

            })
       }

       else if (contact_mobile == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter number',
              icon: 'warning',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
              allowEscapeKey: false,

            })
       }
       else if (contact_email == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter Email',
              icon: 'warning',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
              allowEscapeKey: false,

            })
       }


       let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
            url:"{{ route('contactstore') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

             Swal.fire({
            html: '<span style="color:green">Information Added</span>',
            icon: 'success',
             type: 'success',
              title: 'Your Information Added',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
                allowEscapeKey: false,
             
            }).then((data) => {
                   if(data){
                     // Do Stuff here for success
                     $('#contact_add').trigger("reset");
               $('.contact_now').html('Saved');
                     location.reload();
                   }else{
                    // something other stuff
                   }

                })


         
               
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });

</script>
@endsection
 