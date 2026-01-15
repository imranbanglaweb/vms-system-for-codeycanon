@extends('frontend.master')
@section('contact')
                 
            
<br>
<br>
<br>
                    <div class="contact-us row" style="padding: 30px">
                            <h3 style="text-align: center;">Booking Details</h3>
                            <br>
                            <hr>
                        <div class="col-md-4">
                            @if(!empty($search))
                            <form method="get" route="{{ route('bookonline')}}">
                                  <label>Arrival Date</label>
                                <input type="date" name="arrival_date" value="{{ $data['arrival_date'] }}" class="form-control">
                                <br>
                                  <label>Departure Date</label>
                                <input type="date" value="{{ $data['departure_date'] }}" name="departure_date" class="form-control">
                                <br>
                                  <label>Adult</label>
                                <input type="number" name="adult" value="{{ $data['adult'] }}" placeholder="Adult" class="form-control">
                                <br>
                                <br>
                                  <label>Children</label>
                                <input type="number" name="children" value="{{ $data['children'] }}" placeholder="Children" class="form-control">
                                <br>
                                <br>
                                  <label>Guests</label>
                                <input type="number" name="guest" value="{{ $data['guest'] }}" placeholder="Guests" class="form-control">
                                <br>
                                  <label>Price</label>
                                <input type="number" name="amount" value="{{ $data['amount'] }}" placeholder="Price" class="form-control">
                                <br>
                                <h4>Included Services</h4>
                                <hr>
                                <ul>

                                  @foreach($room_services as $room_service)
                                    <li>
                                      <label><input type="checkbox" name="service_id">&nbsp;&nbsp;
                                      {{ $room_service->service_name}}</label>
                                    </li>
                                    @endforeach
                                
                                </ul>
                                
                               {{--    <h4>Additional Services</h4>
                                  <hr>

                                  <ul>
                                    @foreach($room_services as $room_service)
                                    <li><i class="fa fa-check"></i>&nbsp;&nbsp;{{ $room_service->service_name}}</li>
                                    @endforeach
                                  </ul> --}}

                                  <input class="btn btn-primary" type="submit" name="search" value="Search"> 
                                  &nbsp;
                            </form>
                            @else
                               <form method="get" route="{{ route('bookonline')}}">
                                  <label>Arrival Date</label>
                                <input type="date" name="arrival_date" class="form-control">
                                <br>
                                  <label>Departure Date</label>
                                <input type="date" name="departure_date" class="form-control">
                                <br>
                                  <label>Adult</label>
                                <input type="number" name="adult" placeholder="Adult" class="form-control">
                                <br>
                                <br>
                                  <label>Children</label>
                                <input type="number" name="children" placeholder="Children" class="form-control">
                                <br>
                                <br>
                                  <label>Guests</label>
                                <input type="number" name="guest" placeholder="Guests" class="form-control">
                                <br>
                                  <label>Price</label>
                                <input type="number" name="amount" placeholder="Price" class="form-control">
                                <br>
                                <h4>Included Services</h4>
                                <hr>
                                <ul>

                                  @foreach($room_services as $room_service)
                                    <li>
                                      <label><input type="checkbox" name="service_id">&nbsp;&nbsp;
                                      {{ $room_service->service_name}}</label>
                                    </li>
                                    @endforeach
                                
                                </ul>
                                
                               {{--    <h4>Additional Services</h4>
                                  <hr>

                                  <ul>
                                    @foreach($room_services as $room_service)
                                    <li><i class="fa fa-check"></i>&nbsp;&nbsp;{{ $room_service->service_name}}</li>
                                    @endforeach
                                  </ul> --}}

                                  <input class="btn btn-primary" type="submit" name="search" value="Search"> 
                                  &nbsp;
                            </form>

                            @endif

                        </div>
                        <div class="col-md-8">
                            @foreach($room_lists as $room_list)

                            <a href="{{ url('room-details',$room_list->id)}}" style="color: #000">
                              <div class="row">
                                    <div class="col-md-3">
                                         <img  src="{{ asset('public/frontend_resource/')}}/images/{{$room_list->room_main_image}}" style="width:150px; height: 100px;" alt="HANSA &#8211; A Premium Residence &#8211; 4 Star Premium Hotels in Dhaka" />
                                         {{-- <img src="https://via.placeholder.com/350x150"> --}}
                                    </div>
                                    <div class="col-md-5">
                                        <h3>{{$room_list->room_name }}</h3>
                                        {{-- <p>{{$room_list->room_discription }}</p> --}}
                                    </div>
                                    <div class="col-md-2">
                                        <h3>$ {{$room_list->amount }} </h3>
                                        <span><strong>PER NIGHT</strong></span>
                                    </div>
                             </div>
                             </a>
                             <hr>
                             @endforeach

                             <hr>
                    
                        </div>

                    </div>
@endsection
 