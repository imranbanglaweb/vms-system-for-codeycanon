@extends('frontend.master')

@section('roomsandsuites')

                    <div class="welcome-container-holder">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="welcome-text-div pattern">
                                        <h2><span>Discover Rooms &amp; Suites</span></h2>
                                        <!-- <p class="page-header"><span>Discover Rooms &amp; Suites</span></p> -->
                                        <img src="{{ asset('public/frontend_resource/')}}/images/icons/line.png" alt="grand sultan">
                                       
                                    </div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div><!-- END .container -->
                    </div><!-- END .welcome-container-holder -->

                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div id="calls" class="rooms-info-container">

                                    @foreach($room_lists as $room_list)

                                     @if($loop->iteration % 2 == 0)

                                    <div class="calls-content left visible">
                                        <div class="pic has_transition_1000_cubic big"><img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/Studio-Deluxe.jpg" alt="king deluxe room"></div>
                                        <div class="pic has_transition_1000_cubic small"><img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/rooms-and-suites/king-deluxe.jpg" alt="king deluxe room"></div>
                                        <div class="room_summary">
                                            <div class="content right">
                                                <h3 class="room_titlename">{{ $room_list->room_name}}</h3>
                                                <img src="{{ asset('public/frontend_resource/')}}/images/icons/classy_spacer.png" alt="grand sultan" class="line">
                                                <ul class="info-ul">
                                                    <li><div class="number"><h3>36</h3></div><div class="text"><p><span>Max</span>   Guests</p></div></li>
                                                    <li><div class="number"><h3>382</h3></div><div class="text"><p><span>Min</span> Booking </p></div></li>
                                                    <li><div class="number"><h3>1</h3></div><div class="text"><p><span> Size</span> Bed</p></div></li>
                                                </ul>

                                                <div class="rack-rate"><span class="rate-title">Amount</span><span class="rate">BDT <i> {{$room_list->amount}}</i></span></div>
                                               

                                                <style type="text/css">.discount-offer p{text-align: center;}.discount-offer p a {color: #000;font-weight: 500;}.discount-offer p a:hover {color: #2b4726;}.discount-offer p>span.normtxt {font-size:13px;font-style: normal;}</style>
<div class="discount-offer">
    <p><a href="winter-offer-2021.html" target="_blank">
            {{ $room_list->room_offer}}
        <br/><!-- <span class="normtxt">Above rate is exclusive of 10% Service Charge & 15% VAT.</span> --></p>    <!-- <p class="mobile">Enjoy <span></span> discount on room rack rate.</p> -->
</div>
<!--<div class="discount-offer mobile">
    <p>Enjoy <span></span> discount on room rack rate.</p>
</div> -->
                                                <ul class="link-ul">
                                                    <li><a href="king-deluxe.html">Find More</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- END .calls-content -->
                                    @else
                                     <div class="calls-content right visible">

                                        <div class="pic has_transition_1000_cubic small"><img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/executive-Deluxe.jpg" alt="queen deluxe"></div>

                                        <div class="room_summary">
                                          <div class="content right">
                                                <h3 class="room_titlename">{{ $room_list->room_name}}</h3>
                                                <img src="{{ asset('public/frontend_resource/')}}/images/icons/classy_spacer.png" alt="grand sultan" class="line">
                                                <ul class="info-ul">
                                                    <li><div class="number"><h3>36</h3></div><div class="text"><p><span>Max</span>   Guests</p></div></li>
                                                    <li><div class="number"><h3>382</h3></div><div class="text"><p><span>Min</span> Booking </p></div></li>
                                                    <li><div class="number"><h3>1</h3></div><div class="text"><p><span> Size</span> Bed</p></div></li>
                                                </ul>

                                                <div class="rack-rate"><span class="rate-title">Amount</span><span class="rate">BDT <i> {{$room_list->amount}}</i></span></div>
                                               

                                                <style type="text/css">.discount-offer p{text-align: center;}.discount-offer p a {color: #000;font-weight: 500;}.discount-offer p a:hover {color: #2b4726;}.discount-offer p>span.normtxt {font-size:13px;font-style: normal;}</style>
<div class="discount-offer">
    <p><a href="winter-offer-2021.html" target="_blank">
            {{ $room_list->room_offer}}
        <br/><!-- <span class="normtxt">Above rate is exclusive of 10% Service Charge & 15% VAT.</span> --></p>    <!-- <p class="mobile">Enjoy <span></span> discount on room rack rate.</p> -->
</div>
<!--<div class="discount-offer mobile">
    <p>Enjoy <span></span> discount on room rack rate.</p>
</div> -->
                                                <ul class="link-ul">
                                                    <li><a href="king-deluxe.html">Find More</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="pic has_transition_1000_cubic big">
                                            <img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/executive-Deluxe.jpg" alt="triple deluxe">
                                        </div>
                                    </div><!-- END .calls-content -->
                                    @endif
                                        @endforeach
                                  
                                </div><!-- END #calls -->
                            </div>
                        </div>
                    </div>

                    <!-- Offers -->
                    ra<div class="offer-carousel-container">
   <div class="container">
      <div class="row">
         <div class="special-offers">
            <div class="welcome-text-div inner-header-div offerSectTitle">
               <h4 class="header-one">Special Offers</h4>
               <img src="{{ asset('public/frontend_resource/')}}/images/icons/line-small.png" alt="special offers of grand sultan">
            </div>
         </div>
         <div id="offer-carousel" class="facilities-carousel fadeOut owl-carousel owl-theme">

            
           
                       

            


            
                        <div class="item">
               <div class="dot-line-right">
                  <a href="eid-ul-adha-package-2022.html"><img src="{{ asset('public/frontend_resource/')}}/images/Valentines-Day.jpg" alt="Eid-Ul-Adha Package 2022"></a>
               </div>
               <div class="package-text-container offer-text-container">
                  <h3> VALENTINE’S DAY FOREVER!</h3>
                  <h4 class="offer-date">Valid for the VALENTINE’S DAY Package 2022</h4>
                  <p> Starting from <b>BDT 18,000 NET</b> for 2 persons per night including buffet <b> Lunch, Dinner, Breakfast &amp; many more. </b><span style="color:#2b4726;"><b>KIDS STAY & MEAL FREE!</b></span></p>
                  <a href="eid-ul-adha-package-2022.html" class="has_transition_400 left">Find More</a>
               </div>
            </div>
            
                        <div class="item">
               <div class="dot-line-right">
                  <a href="eid-ul-fitre-offer-2022.html"><img src="{{ asset('public/frontend_resource/')}}/images/buffet_dinner.png" alt="Eid-Ul-Fitre Offer"></a>
               </div>
               <div class="package-text-container offer-text-container">
                  <h3>SEAFOOD BUFFET DINNER</h3>
                  <h4 class="offer-date">Valid for the SEAFOOD BUFFET DINNER 2022</h4>
                   <p>Starting from <b>BDT 13,219 NET</b> for 2 persons per night including buffet <b>Breakfast &amp; many more.</b></p>
                  <a href="eid-ul-adha-offer-2022.html" class="has_transition_400 left">Find More</a>
               </div>
            </div>
                                    <div class="item">
               <div class="dot-line-right">
                  <a href="summer-package-2022.html"><img src="{{ asset('public/frontend_resource/')}}/images/offers/summer-package-2022.jpg" alt="Summer package"></a>
               </div>
               <div class="package-text-container offer-text-container">
                  <h3>Summer Package</h3>
                  <h4 class="offer-date">Valid up to 8<sup>th</sup>July 2022</h4>
                  <p>Starting from <b>BDT 7,500 Net</b> Per person per night including buffet <b>lunch, dinner, breakfast &amp; many more. </b><span style="color:#2b4726; font-weight:bold;"><strong> KIDS STAY & MEAL FREE!</strong></span></p>
                  <a href="summer-package-2022.html" class="has_transition_400 left">Find More</a>
               </div>
            </div>
            
                        <div class="item">
               <div class="dot-line-right">
                  <a href="summer-offer-2022.html"><img src="{{ asset('public/frontend_resource/')}}/images/offers/summer_offer_new_2022.jpg" alt="Summer offer"></a>
               </div>
               <div class="package-text-container offer-text-container">
                  <h3>Summer Offer</h3>
                  <h4 class="offer-date">Valid from 1<sup>st</sup> June 2022 to 8<sup>th</sup> July 2022</h4>
                  <p>Starting from <b>BDT 12,018 Net</b> for 2 persons per night including buffet <b>breakfast &amp; many more.</b></p>
                  <a href="summer-offer-2022.html" class="has_transition_400 left">Find More</a>
               </div>
            </div>
            
            


            
            
            
            
            
            <div class="item">
               <div class="dot-line-right">
                  <a href="srimongal-package.html" class="has_transition_400 left"><img src="images/offers/sreimongal-package-new.jpg" alt="Srimongal Package"></a>
               </div>
               <div class="package-text-container offer-text-container">
                  <p class="package-header">Srimongal Package</p>
                  <p style="color:#000;">Starting from BDT 999++ per person. Enjoy Srimongal- the tea capital of Bangladesh, is famous for its nature, forests and wildlife.</p>
                  <a href="srimongal-package.html" class="has_transition_400 left">Read More</a>
               </div>
            </div>


            <!-- END .item -->
         </div>
         <!-- END #services-carousel -->
         <div class="changer-div">
            <div class="customNavigation">
               <a class="btn offer-prev"></a>
               <a class="btn offer-next"></a>
            </div>
         </div>
         <!-- Carousel -->
         <script>
            $(document).ready(function() {

              var owl_offer = $("#offer-carousel");
              owl_offer.owlCarousel({
                nav:true,
                items: 2,
                responsive:{
                    0:{
                        items:1
                    },
                    769:{
                        items:2
                    },
                    1000:{
                        items:2
                    }
                },
                dots: false,
                navContainer: '.offer-carousel-container .customNavigation',
                navText: [$('.offer-prev'),$('.offer-next')],
                animateOut: 'fadeOut',
                loop: true,
                autoplay:false,
                margin: 10

              });
            });
         </script>
         <!-- End Carousel -->
      </div>
   </div>
</div>

@endsection