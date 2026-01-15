@extends('frontend.master')
@section('about_us')
 <div class="home-landing-about-us">
 
</div>
                        <div class="container offer-container">
                      <div class="row">
         <div class="col-md-12">
            <div id="services-carousel" class="facilities-carousel fadeOut owl-carousel owl-theme">
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/facilities/Executive-Deluxe.jpg" alt="rooms suites at Hansa Hotel">
                  <div class="services-carousel-container">
                 
                     <h3 class="glance-item-name">About Us</h3>
                        <p class="detail" style="text-align: justify;">
HANSA – A Premium Residence is owned by Unique Hotel & Resorts Limited, the leading Hospitality Management Company and the owner of “The Westin, Dhaka” with more than 20 years of experience in the hospitality industry. HANSA is the first premium residence in Bangladesh providing all services at par with any other international hotels of the country. The residence has 76 contemporary Rooms including 12 Suites, 2 World Class Restaurants, Gymnasium, Spa, Rooftop Swimming Pool and many other best-in-class amenities.

  {{-- {!!$about_us_page->page_description!!} --}}
</p>
                  
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
     
     
       
              
            </div>
 
         </div>
         <!-- END .col -->
      </div>
   </div>
       <script>
               $(document).ready(function() {
                 var owlk = $("#services-carousel");
                 owlk.owlCarousel({
                   nav:true,
                   items: 1,
                   dots: false,
                   navContainer: '.services-carousel-container .customNavigation',
                   navText: [$('.prev'),$('.next')],
                   animateOut: 'fadeOut',
                   loop: true,
                   autoplay:false,
                   margin: 10

                 });
               });
            </script>
@endsection
                                  