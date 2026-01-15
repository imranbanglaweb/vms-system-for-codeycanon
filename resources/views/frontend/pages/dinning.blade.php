@extends('frontend.master')
@section('dinning')

 <!-- <div class="background-radius"></div>
                    <a id="style-logo" href="./">Grand Sultan Tea Resort &amp; Golf</a> -->

                    <div class="welcome-container-holder">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="welcome-text-div pattern">
                                        <h2><span>Discover Dining Experience</span></h2>
                                        <img src="{{ asset('public/frontend_resource/')}}/images/icons/line.png" alt="grand sultan">
                                        <p>
                                          A tempting assortment of delicacies is served at the restaurants of HANSA. The H Café, located in the lobby, serves the guests with freshly brewed coffee, sandwiches, pastries and many more all day throughout the week. You can grab a quick bite before you head out for work in the morning or recharge yourself with a rejuvenating cup of coffee during midday at this venue. Situated on the first floor, Goldberg offers a selection of Pan Asian delectable delights. Tantalize your taste buds with the rich buffet spread or delicacies from the a-la-carte menu.
                                        </p>
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

                                    @foreach($dinning_lists as $dinning_list)
                                    @if($loop->iteration % 2 == 0)
                                    <div class="calls-content left visible">
                                        <div class="pic has_transition_1000_cubic big">

                                        <img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/hotel-near-airport-dhaka.jpg" alt="Hotel Near Airport">

                                    </div>
                                        <div class="pic has_transition_1000_cubic small">
                                            <img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/restaurants/fowara-dine.jpg" alt="fowara dine"></div>
                                        <div class="room_summary">
                                            <div class="content right">
                                                <h2>{{ $dinning_list->dinning_name }}</h2>
                                                <img src="{{ asset('public/frontend_resource/')}}/images/icons/classy_spacer.png" alt="Fowara Dine" class="line">

                                                <p class="short_description">
                                                    {!!$dinning_list->dinning_content!!}
                                                 </p>

                                                <ul class="link-ul">
                                                    <li><a href="fowara-dine.html">Find More</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- END .calls-content -->

                                    @else
                                         <div class="calls-content right visible">
                                        <div class="pic has_transition_1000_cubic small">

                                            <img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/hansa-h-caffe.jpg" alt="Hansa H-CAFE">

                                        </div>
                                        <div class="room_summary">
                                            <div class="content left">
                                                   <h2>{{ $dinning_list->dinning_name }}</h2>
                                                <img src="{{ asset('public/frontend_resource/')}}/images/icons/classy_spacer.png" alt="Fowara Dine" class="line">
                                                <p class="short_description">
                                                   {!!$dinning_list->dinning_content!!}                                               </p>
                                                <ul class="link-ul">
                                                    <li><a href="oronno-bilash.html">Find More</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="pic has_transition_1000_cubic big">
                                            <img class="full_width" src="{{ asset('public/frontend_resource/')}}/images/hansa-h-caffe.jpg" alt="Oronno Bilash"></div>
                                    </div><!-- END .calls-content -->
                                    @endif
                                    @endforeach
                                 
                                </div><!-- END #calls -->
                            </div>
                        </div>
                    </div>
 <!-- END Offers -->


@endsection

                   