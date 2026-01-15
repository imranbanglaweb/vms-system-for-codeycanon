@extends('frontend.master')
@section('menu')
<body>
  <!--       <div class="item i1">
          <div id="notification-bar">
            <div class="container">
              <img class="closeimg" src="images/close.png"/>
              <p><img class="blinkz" src="images/logo.png" alt="HANSA &#8211; A Premium Residence &#8211; 4 Star Premium Hotels in Dhaka" height="100" /><a href="index.html" target="_blank"></a></p>
            </div>
          </div>
        </div> -->

        
        <!-- <style type="text/css"> #cookie-bar {position: absolute; display: inline-block; z-index: 999999; bottom: 0; width: 100%;} .cookie-bar__inner { padding: 5px 10px 5px; box-sizing: border-box; width: 100%; background-color: #000000e3; text-align: center; color: #ddd; font-size: 15px; line-height: 25px;letter-spacing: 0.2px;} .cookie-bar__btn {background: #ffffff; color: #000000; border: 0; padding: 0px 15px; margin: 4px 15px; border-radius: 3px; font-size: 14px;} a.cookie-bar__link {color: #e8c037;} a:hover.cookie-bar__link {color: #fff; text-decoration: underline;} </style> -->

        <style type="text/css"> 
            #cookie-bar {position: absolute; display: inline-block; z-index: 99999999999; bottom: 0; width: 100%;} 
            .cookie-bar__inner { padding: 15px 50px 15px; box-sizing: border-box; width: 100%; background-color: #000000f0; text-align: left; color: #ddd; font-size: 16px; line-height: 23px; letter-spacing: 0.2px; }
            .cookie-bar__buttons { position: absolute; top: 21%; left: 45%; }
            .cookie-bar__btn { background: #ffffff; color: #000000; border: 0; padding: 5px 15px; margin: 4px 15px; border-radius: 3px; font-size: 14px; }
            a.cookie-bar__link {color: #e8c037;} 
            a:hover.cookie-bar__link {color: #fff; text-decoration: underline;} 
            @media  screen and (max-width: 1366px) {
                .cookie-bar__inner {font-size: 14px;padding: 18px 50px 18px;line-height: 21px;}
                .cookie-bar__buttons {top: 25%; left: 55%;}
            }
            @media  screen and (max-width: 1366px) and (orientation: portrait){
                .cookie-bar__inner {font-size: 12px;padding: 14px 15px 14px;line-height: 22px;}
                .cookie-bar__buttons {top: 25%; left: unset; right: 10%;}              
            }
            @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
                .cookie-bar__buttons {top: 25%; left: unset; right: 10%;}              
            }
            @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) {
                .cookie-bar__inner {font-size: 13px; padding: 18px 25px 18px; line-height: 20px;}
                .cookie-bar__buttons {top: 25%; left: unset; right: 1%;}              
            }
            @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
                .cookie-bar__inner {font-size: 12px; padding: 15px 15px 45px; line-height: 20px;}
                .cookie-bar__buttons {top: 68%;left: 0;right: unset;}
                .cookie-bar__btn {padding: 2px 13px;}
            }
        </style>

        <div id="perspective">
            <div id="container">
        
                <div id="top">
                    <ul>
                        <li class="add first-child">
                            <a id="showMenu">
                                <div id="menu_controller" class="has_transition_300">
                                    <hr class="_1">
                                    <hr class="_2">
                                    <hr class="_3">
                                </div>
                               <!-- <i class="fa fa-bars" style="color: #fff"></i> -->
                                Menu
                            </a>

                        </li>
                      <!--   <li>
                            <a id="showBook">Reservation</a>
                        </li> -->
                    </ul>
                    <a href="index.html"></a>
                    <ul class="contact-ul">

                            <li>
                          <a href="https://www.google.com/maps/dir/23.6869357,90.4268467/HANSA+-+A+Premium+Residence+HANSA+-+A+Premium+Residence,+PLOT%23+3+%26+5,+ROAD%23+10%2FA+SECTOR%23+9,+%E0%A6%A2%E0%A6%BE%E0%A6%95%E0%A6%BE+1230/@23.783649,90.2770226,11z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3755c438fb7814bb:0x4badb30ca9c36544!2m2!1d90.4002931!2d23.8791894" target="blank" style="cursor: pointer;"><i class="fa fa-map-marker" ></i>
                          Getting There</a>
                        </li>

                        <li>
                          <a href="tel:+8809678785959"> 
                              <i class="fa fa-phone"></i>  +880255080501-12
                            </a>
                        </li>
                        </ul>
                </div>
                <!-- END #top -->

                <div id="wrapper">
                    <div id="menu_upper">

                        <ul class="contact-ul">
                         
            <li> 
             <!--  <img class="" src="images/close.png"/> -->
              <img class="hansa_logo" src="{{ asset('public/frontend_resource/')}}/images/hansa_logo_updated.jpeg" style="width:auto; height: 100px;" alt="HANSA &#8211; A Premium Residence &#8211; 4 Star Premium Hotels in Dhaka" /><a href="index.html"></a>
            </li>
            <li></li>
            <li></li>
            <li></li>
          <!--   <li></li>
            <li></li>
            <li></li> -->
                        <li>
                          <a href="https://www.google.com/maps/dir/23.6869357,90.4268467/HANSA+-+A+Premium+Residence+HANSA+-+A+Premium+Residence,+PLOT%23+3+%26+5,+ROAD%23+10%2FA+SECTOR%23+9,+%E0%A6%A2%E0%A6%BE%E0%A6%95%E0%A6%BE+1230/@23.783649,90.2770226,11z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3755c438fb7814bb:0x4badb30ca9c36544!2m2!1d90.4002931!2d23.8791894" target="blank" style="cursor: pointer;"><i class="fa fa-map-marker" ></i>
                          Getting There</a>
                        </li>

                        <li>
                          <a href="tel:+8809678785959"> 
                              <i class="fa fa-phone"></i>  +880255080501-12
                            </a>
                        </li>

                        </ul>
                    </div>
                    <div class="quick_socials mobile_hidden">
                        <ul>
                            <li class="has_transition_600"><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="has_transition_600"><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                   
                            <li class="has_transition_600"><a href="#" target="_blank"><i class="fab fa-youtube"></i></a></li>
                          
                            <li class="has_transition_600"><a href="#" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
@endsection
@section('slider')
<div class="home-landing scrollable">
   <div class="content-holder">
      <!-- ========== REVOLUTION SLIDER ========== -->
      <div class="fullwidthbanner">
         <ul>
            <!-- FADE -->

            @foreach($sliders as $slider)

            <li data-transition="fade" data-slotamount="10" data-thumb="images/home-slides/hansa_gallery_01.jpeg">
               <img src="{{ asset('public/admin_resource/assets/images/'.$slider->slider_image)}}" alt="resorts in sylhet"/>
            </li>
        
            </li>
            @endforeach

         </ul>
         <div class="slider-preload-cover">
         </div>

      </div>

   </div>
</div>
@endsection

@section('home_intro_content')

<!-- 
<button id="Mybtn" class="btn btn-primary">Resarvation</button>

<div class="resarvation">
  <form id="MyForm" action="" method="post">



    <input type="text" class="form-control" id="check_in_date" name="" placeholder="Arrival Date">
    <br>
<input type="text" class="form-control" id="check_out_date" name="" placeholder="Departure Date"> 
<br>
       <select class="form-control">
      <option>Adult</option>
      <option value="1">1</option>
      <option value="1">2</option>
      <option value="1">3</option>
      <option value="1">4</option>
      <option value="1">5</option>
      <option value="1">6</option>
      <option value="1">7</option>
      <option value="1">8</option>
    </select>
    <br>
 <select class="form-control">
      <option>Children</option>
      <option value="1">1</option>
      <option value="1">2</option>
      <option value="1">3</option>
    </select>
    <br>
     <button class="btn btn-success">Check Availability</button>
</form>
</div> -->
<!-- END .home-landing -->
<div class=""></div>
<!-- <a id="" href="#">Hansa A Premium Residance &amp; 4 Star Premium Hotels in Dhaka </a> -->
<div class="welcome-container-holder">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="welcome-text-div pattern">
              <div class="check_in_div">
  <div class="row">
  <div class="room_checking">
    <div class="col-md-2 col-md-offset-1">
        <label> 
    <!-- <img src="images/check-in.png" width="30" height="30">&nbsp; -->
    <input type="text"  id="check_in_date_two" name="" placeholder="Arrival Date">
  </label>
    </div>
    <!-- <div class="col-md-offset-1"></div> -->
    <div class="col-md-2">
        <label> <input  type="text" class="form-control" id="check_out_date_two" name="" placeholder="Departure Date"> 
        </label>
    </div>
    <div class="col-md-2">
        <select class="form-control">
      <option>Adult</option>
      <option value="1">1</option>
      <option value="1">2</option>
      <option value="1">3</option>
      <option value="1">4</option>
      <option value="1">5</option>
      <option value="1">6</option>
      <option value="1">7</option>
      <option value="1">8</option>
    </select>
    </div>
    <div class="col-md-2">
        <select class="form-control">
      <option>Children</option>
      <option value="1">1</option>
      <option value="1">2</option>
      <option value="1">3</option>
    </select>
    </div>




<div class="col-md-2">
    <button class="btn btn-default" style="color: #000!important"><a href="{{route('bookonline')}}">Check Availability</a></button>
</div>

<div class="chat_icon">
 <!--  <i class="fa fa-phone"></i> -->
 <img src="{{ asset('public/frontend_resource/')}}/images/chat_icon.png">
</div>
</div>
</div>

</div> 
               <h1><span>Welcome to</span> Hansa A Premium Residance
               </h1>
               <img src="{{ asset('public/frontend_resource/')}}/images/icons/small_line.png" alt="Hansa Hotel">
               <p>
                 HANSA – A Premium Residence is Owned by Unique Hotel & Resorts Limited, the leading Hospitality Management Company and the owner of “The Westin, Dhaka” with more than 20 years of experience in the hospitality industry. HANSA is the first premium residence in Bangladesh providing all services at par with any other international hotels of the country. The residence has 76 contemporary Rooms including 12 Suites, 2 World Class Restaurants, Gymnasium, Spa, Rooftop Swimming Pool and many other best-in-class amenities.
               </p>

            </div>
         </div>
      </div>
      <div>
      </div>
   </div>
   <!-- END .container -->
</div>
@endsection

@section('room_facilities')
<!-- END .welcome-container-holder -->
<div class="facilities-container-holder">
   <div class="container offer-container">
      <div class="row">
         <div class="col-md-12">
            <div class="welcome-text-div inner-header-div">
               <h2 class="header-one">At A Glance</h2>
               <img style="text-align: center;margin: 0 auto;margin-bottom: 3%;" src="{{ asset('public/frontend_resource/')}}/images/icons/small_line.png" alt="at a glance at Hansa Hotel">
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div id="services-carousel" class="facilities-carousel fadeOut owl-carousel owl-theme">
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/facilities/Executive-Deluxe.jpg" alt="rooms suites at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Rooms &amp; Suites</h3>
                     <p class="detail">
                        A combination of design, space and a peaceful faraway outlook of tea garden, lake or swimming pool, There are 135 rooms of 08 categories consisting of both rooms and suites, ranging from King, Queen, Triple, Executive Suites, Family Suites and the exclusive Presidential Suite (Raj Prashad). The high speed Wi-Fi facilities in each of our guest rooms and in the Lobby area and the Business Center allow you to keep in touch with home and your office.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-restaurant%26cafe.jpg" alt="restaurants at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name"> Restaurant &amp; Cafe</h3>
                     <p class="detail">
                        The Hansa Hotel is fitted with the most up to date hygienic kitchen maintained and operated by our highly trained team of Food and Beverage specialists. Our service staff are professionally trained and knowledgeable in the local area and aim to assist in making your stay pleasurable and an unforgettable experience.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-swimming-pool.jpg" alt="swimming pool at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Swimming Pool</h3>
                     <p class="detail">
                        Perhaps the amoeba shaped, temperature controlled swimming pool, the largest in Bangladesh, can soothe your tired mind and body after a long day's adventure whilst your children enjoy the 2 smaller children's pools.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-roopnogori-spa.jpg" alt="spa at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Roopnogori Spa</h3>
                     <p class="detail">
                        Perhaps the amoeba shaped, temperature controlled swimming pool, the largest in Bangladesh, can soothe your tired mind and body after a long day's adventure whilst your children enjoy the 2 smaller children's pools.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-children-play-zone.jpg" alt="children play zone">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Children Play Zone</h3>
                     <p class="detail">
                        Our children play zone is equiped with various types of children activity games which will keep your children busy & joyfull.
                     </p>
                     <a href="recreations.html" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-outdoor-sports.jpg" alt="outdoor sports at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Outdoor Sports</h3>
                     <p class="detail">
                        The Grand Resort Sultan and Golf venue can boast to having a 9 hole recreational golf course, a basketball court, tennis court and a badminton court all providing outdoor leisure and sport activities for your whole family to enjoy. If you prefer to be indoors then enjoy the competitiveness of the pool tables or play table tennis whilst your children enjoy the Children's play zone with its array of rides for our younger guests.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-indoor-sports.jpg" alt="indoor sports at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Indoor Sports</h3>
                     <p class="detail">
                        Pool, Game Centre, and Children Play Zone can present you the moment of eventful joy.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-library.jpg" alt="library at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Library</h3>
                     <p class="detail">
                        The Library affords the luxury of taking time out to relax with a book in solitude. Pick up a novel, a historical tome, a business magazine or reference book, a religious work or just bring your own and enjoy the quiet atmosphere.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/4.movie-room.jpg" alt="movie theatre at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Movie Theatre</h3>
                     <p class="detail">
                        The 44 seated 3D/HD Movie Theater allows you to enjoy a private movie experience with your friends with a choice of quality international movies.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
               <div class="item">
                  <img src="{{ asset('public/frontend_resource/')}}/images/home/facilities/home-gym.jpg" alt="gym at Hansa Hotel">
                  <div class="services-carousel-container">
                     <div class="customNavigation">
                        <a class="btn prev"></a>
                        <a class="btn next"></a>
                     </div>
                     <h3 class="glance-item-name">Gym</h3>
                     <p class="detail">
                        Apart from spending the leisure time it is necessary to take a good care of health. Hansa Hotel Tea Resort &amp; Golf presents you a world class gym can offer you the relax with lavishness.
                     </p>
                     <a href="#" class="find has_transition_400">Find More</a>
                  </div>
                  <!-- END .services-carousel-container -->
               </div>
               <!-- END .item -->
            </div>
            <!-- END #services-carousel -->
            <!-- Carousel -->
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
            <!-- End Carousel -->
         </div>
         <!-- END .col -->
      </div>
      <!-- END .row -->
   </div>
   <!-- END .container -->
</div>
<!-- END .facilities-container-holder -->
@endsection
@section('meeting_and_events')
<div id="calls">
   <div class="calls-content left visible home">
      <div class="matt_block _1 has_transition_1000_cubic">
         <!-- <a href="#"> -->
         <div class="content meeting_icon">
        <!--     <img class="cls_logo centered has_transition_800" src="images/icons/meeting.png" alt="meeting venues at Hansa Hotel"> -->

            <i class="fab fa-meetup"></i>
            <h3 class="cls_title has_transition_800">Meetings &amp; Events</h3>
            <img class="centered cls_spacer has_transition_800" src="images/icons/small_spacer_white.png" alt="gs meetings">
            <div class="ref_title has_transition_800">Organize annual conference, product launch, board meeting, or any type of business activities and celebrate a GRAND event. Call us today to book your next event.</div>
            <a href="#" class="more has_transition_400">Find More</a>
         </div>
         <!-- </a> -->
      </div>
      <div class="pic has_transition_1000_cubic"><img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/facilities/OUR-AWESOME-SERVICES-Conference-room.jpg" alt="meetings"></div>
   </div>
</div>
<!-- END #calls -->
@endsection

@section('special_offer')
<div class="container offer-container">
   <div class="row">
      <div class="col-md-12">
         <div class="welcome-text-div inner-header-div">
            <h3 class="header-one">Special Offers</h3>
            <img style="text-align: center;margin: 0 auto;margin-bottom: 3%;" src="{{ asset('public/frontend_resource/')}}/images/icons/small_line.png" alt="offers at Hansa Hotel">
         </div>
      </div>
   </div>
      <!-- Eid-Ul-Fitre Package  start -->
      <!--Eid-Ul-Fitre Package end -->

   <!-- Eid-Ul-Fitre Offer start -->
      <!-- Eid-Ul-Fitre Offer end -->    


      @foreach ($offers as $offer)

    @if($loop->iteration % 2 == 0)

         <div class="row">
            <div class="col-md-6">
               <div class="dot-line-left offers-dot-line-left">
                  <img src="{{ asset('public/admin_resource/assets/images/'.$offer->offer_image)}}" alt="Eid-Ul-Adha Package 2022">
               </div>
            </div>
            <div class="col-md-6">
               <div class="package-text-container offer-text-container buffet_dinner right offers-right">
                  <h3>{{ $offer->offer_title}}</h3>
                  <h4 class="offer-date">{{$offer->offer_caption }}</h4>
                  <p> Weekend Buffet Dinner <b>BDT 1150 ++</b> per person </p>
                  <a href="#" class="has_transition_400 left">Find More</a>
               </div>
            </div>
         </div>

    @else
        
      <div class="row">

          <div class="col-md-6 dot-line-right-small">
             <div class="dot-line-right offers-dot-line-right">
              <img src="{{ asset('public/frontend_resource/')}}/images/offer_02.jpeg" alt="Buffet Dinner 2022" style="width: 100%!important">
             </div>
          </div>
          <div class="col-md-6">
             <div class="package-text-container offer-text-container buffet_dinner">
                 <h3>{{ $offer->offer_title}}</h3>
                <h4 class="offer-date">{{$offer->offer_caption }}</h4>
                 <p><i class="fa fa-calendar"></i> 11 <b>To</b> 10 <b>PM</b></p>
                <a href="#" class="has_transition_400 left">Find More</a>
             </div>
          </div>
          <div class="col-md-6 dot-line-right-big">
             <div class="dot-line-right">
                <!-- <img src="images/offers/eid-ul-adha-offer.jpg" alt="Eid-Ul-Adha Offer 2022"> -->
              <img src="{{ asset('public/admin_resource/assets/images/'.$offer->offer_image)}}" alt="Eid-Ul-Adha Package 2022">
             </div>
          </div>

       </div>

    @endif
@endforeach
   <!-- Eid-Ul-Adha Package  start -->
 

</div>
@endsection