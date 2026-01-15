@extends('frontend.master')
@section('gallery')
 <div class="home-landing-about-us"></div>
           <div class="container offer-container">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="welcome-text-div">
                                        <h2>Photo Gallery</h2>
                                        <img class="dot-square mtp0" src="{{ asset('public/frontend_resource/')}}/images/icons/line-small.png" alt="Photo Gallery">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12"> 
                                    <!-- data-scrollreveal="enter left over 1s after 0.5s" -->
                                    <fieldset class="filter flat">
                                        <div>
                                            <select id="select_element">
                                                <option value="Facility" >Facility</option> 
                                                <option value="restaurants">Restaurants</option> 
                                                <option value="rooms">Room</option> 
                                                <option value="swimming_pool">Swimming Pool</option> 
                                                <option value="all" selected>All</option>
                                            </select> 
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12"> <!-- data-scrollreveal="enter left over 1s after 0.5s" -->
                                
                                <div class="photo-gallery-container">
                                <ul class="magnet photo-gallery" style="">
                                    @foreach ($gallery_lists as $key => $gallery_list)

                                    @if($gallery_list->category_id == 2)
                                <li class="magnet-item Facility odd first-child Facility">
                                    <div>
                                        <a href="images/rooms-and-suites/king-deluxe/gallery/1.jpg" title="King Deluxe" class="vt-item" rel="restaurant_vtours[king-deluxe]">
                                        <div>
                                           <img src="{{ asset('public/admin_resource/assets/images/')}}/{{$gallery_list->gallery_image}}" alt="rooms-and-suites">

                                        </div>
                                        <h2>{{$gallery_list->gallery_name}}</h2></a>
                                        <ul>
                                            <li class="odd first-child">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/2.jpg" title="King Deluxe"></a>
                                            </li>
                                            <li class="even">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/3.jpg" title="King Deluxe"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                @elseif($gallery_list->category_id == 1)
                                
                                <li class="magnet-item restaurants odd first-child restaurants">
                                    <div>
                                        <a href="images/rooms-and-suites/king-deluxe/gallery/1.jpg" title="King Deluxe" class="vt-item" rel="restaurant_vtours[king-deluxe]">
                                        <div>
                                           <img src="{{ asset('public/admin_resource/assets/images/')}}/{{$gallery_list->gallery_image}}" alt="rooms-and-suites">

                                        </div>
                                        <h2>{{$gallery_list->gallery_name}}</h2></a>
                                        <ul>
                                            <li class="odd first-child">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/2.jpg" title="King Deluxe"></a>
                                            </li>
                                            <li class="even">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/3.jpg" title="King Deluxe"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li> 
                                @elseif($gallery_list->category_id == 3)
                                
                                <li class="magnet-item rooms odd first-child rooms">
                                    <div>
                                        <a href="images/rooms-and-suites/king-deluxe/gallery/1.jpg" title="King Deluxe" class="vt-item" rel="restaurant_vtours[king-deluxe]">
                                        <div>
                                           <img src="{{ asset('public/admin_resource/assets/images/')}}/{{$gallery_list->gallery_image}}" alt="rooms-and-suites">

                                        </div>
                                        <h2>{{$gallery_list->gallery_name}}</h2></a>
                                        <ul>
                                            <li class="odd first-child">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/2.jpg" title="King Deluxe"></a>
                                            </li>
                                            <li class="even">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/3.jpg" title="King Deluxe"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>  

                             {{--       @elseif($gallery_list->category_id == 4)
                                
                                <li class="magnet-item restaurants odd first-child restaurants">
                                    <div>
                                        <a href="images/rooms-and-suites/king-deluxe/gallery/1.jpg" title="King Deluxe" class="vt-item" rel="restaurant_vtours[king-deluxe]">
                                        <div>
                                           <img src="{{ asset('public/admin_resource/assets/images/')}}/{{$gallery_list->gallery_image}}" alt="rooms-and-suites">

                                        </div>
                                        <h2>{{$gallery_list->gallery_name}}</h2></a>
                                        <ul>
                                            <li class="odd first-child">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/2.jpg" title="King Deluxe"></a>
                                            </li>
                                            <li class="even">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/3.jpg" title="King Deluxe"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>  --}}   

                                 @elseif($gallery_list->category_id == 4)
                                
                                <li class="magnet-item swimming_pool odd first-child swimming_pool">
                                    <div>
                                        <a href="images/rooms-and-suites/king-deluxe/gallery/1.jpg" title="King Deluxe" class="vt-item" rel="restaurant_vtours[king-deluxe]">
                                        <div>
                                           <img src="{{ asset('public/admin_resource/assets/images/')}}/{{$gallery_list->gallery_image}}" alt="rooms-and-suites">

                                        </div>
                                        <h2>{{$gallery_list->gallery_name}}</h2></a>
                                        <ul>
                                            <li class="odd first-child">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/2.jpg" title="King Deluxe"></a>
                                            </li>
                                            <li class="even">
                                                <a class="vt-item" rel="restaurant_vtours[king-deluxe]" href="images/rooms-and-suites/king-deluxe/gallery/3.jpg" title="King Deluxe"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                @endif
                                @endforeach
                           
                            </ul>
                                    
                            </div>
                               
                        </div>
                    </div>
                </div>
                     

              <script type="text/javascript">
                    $('#select_element').change(function(){
                        if($(this).val() == 'all'){
                            $('.photo-gallery-container ul.photo-gallery li').fadeIn(2000);
                            $('.photo-gallery-container ul.photo-gallery li').css('display', 'inline-block');
                        }else{
                            $('.photo-gallery-container ul.photo-gallery li').fadeOut();
                            $('.photo-gallery-container ul.photo-gallery li.'+$(this).val()).css('display', 'inline-block');
                            $('.photo-gallery-container ul.photo-gallery li.'+$(this).val()).fadeIn(2000);
                        }
                        
                    });
                </script>
         

@endsection