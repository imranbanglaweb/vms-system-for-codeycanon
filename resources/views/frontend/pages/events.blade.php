@extends('frontend.master')
@section('events')
 <div class="welcome-container-holder">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="welcome-text-div pattern">
                                        <h2><span>Events</span></h2>
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

                                    @foreach($event_lists as $event_list)
                                
                                @if($loop->iteration % 2 == 0)
                                    <div class="calls-content left visible">
                                        <div class="pic has_transition_1000_cubic big"><img class="full_width" src="{{ asset('public/admin_resource/assets/')}}/images/{{ $event_list->event_main_image}}" alt="rashni mahal"></div>
                                        <div class="pic has_transition_1000_cubic small"><img class="full_width" src="{{ asset('public/admin_resource/assets/')}}/images/{{ $event_list->event_main_image}}" alt="rashni mahal"></div>
                                        <div class="room_summary">
                                            <div class="content right">
                                                <h3 class="ConcernSub">
                                                 {{ $event_list->event_name }}  
                                                </h3>
                                               {{--  <img src="{{ asset('public/admin_resource/assets/')}}/images/{{ $event_list->event_main_image}}" alt="grand sultan" class="line"> --}}
                                                <p class="short_description">
                                                {{ $event_list->event_name }}                       
                                                     </p>
                                              
                                            </div>
                                        </div>
                                    </div><!-- END .calls-content -->

                                    @else
                                         <div class="calls-content right visible">
                                        <div class="pic has_transition_1000_cubic small">
                                            <img class="full_width" src="{{ asset('public/admin_resource/assets/')}}/images/{{ $event_list->event_main_image}}" alt="nowmi manzil"></div>
                                        <div class="room_summary">
                                            <div class="content left">
                                                <h3 class="ConcernSub"> {{ $event_list->event_name }}</h3>
                                                <img src="{{ asset('public/frontend_resource/')}}/images/icons/classy_spacer.png" alt="nowmi manzil" class="line">
                                                <p class="short_description">
                                                 {{ $event_list->event_name }}
                                        </p>
                                               
                                            </div>
                                        </div>
                                        <div class="pic has_transition_1000_cubic big">
                                        <img class="full_width" src="{{ asset('public/admin_resource/assets/')}}/images/{{ $event_list->event_main_image}}" alt="nowmi manzil">
                                    </div>
                                    </div><!-- END .calls-content -->

                                    @endif
                                    @endforeach
                               
                                 
                                </div><!-- END #calls -->
                            </div>
                        </div>
                    </div>

                    <div class="offer-carousel-container events-carousel-container">
                        <div class="welcome-text-div inner-header-div">
                            <h4>Recent Events</h4>
                            <img src="{{ asset('public/frontend_resource/')}}/images/icons/line-small.png" alt="Recent Events">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div id="offer-carousel" class="facilities-carousel fadeOut owl-carousel owl-theme">
                                    <div class="item">
                                        <div class="dot-line-left">
                                            <img src="{{ asset('public/frontend_resource/')}}/images/recent_events_01.jpeg" alt="Nat San Kirtan">
                                        </div>
                                        <div class="package-text-container">
                                            <h5>Hansa Swimming Pool</h5>
                                           
                                        </div>
                                    </div><!-- END .item -->
                                    <div class="item">
                                        <div class="dot-line-right">
                                            <img src="{{ asset('public/frontend_resource/')}}/images/recent_events_02.jpeg" alt="Stick Dance">
                                        </div>
                                        <div class="package-text-container offer-text-container">
                                            <h5>Buffet Dinner</h5>
                                            <!-- <p>24 December 2016</p>
                                            <a href="#" class="has_transition_400 left">Find More</a> -->
                                        </div>
                                    </div><!-- END .item -->
                                </div><!-- END #services-carousel -->

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
                   
