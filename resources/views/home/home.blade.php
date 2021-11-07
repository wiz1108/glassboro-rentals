@extends('template')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ url('public/css/daterangepicker.min.css')}}" />
@endpush

@section('main')
<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type')}}">
<section class="hero-banner magic-ball">
    <div class="main-banner" style="background-image: url('{{BANNER_URL}}');">
        <div class="container none">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-6 col-lg-5 mb-5 mb-md-0">
                    <div class="main_formbg item animated zoomIn mt-80">
                        <h1 class="pt-4 ">{{trans('messages.home.make_your_reservation')}}</h1>
                        <form id="front-search-form" method="post" action="{{url('search')}}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group pt-4">
                                        <input class="form-control p-3 text-14" id="front-search-field"
                                            placeholder="{{trans('messages.home.where_want_to_go')}}" autocomplete="off"
                                            name="location" type="text" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-5">
                                    <div class="d-flex" id="daterange-btn">
                                        <div class="input-group mr-2 pt-4">
                                            <input class="form-control p-3 border-right-0 border text-14 checkinout"
                                                name="checkin" id="startDate" type="text"
                                                placeholder="{{trans('messages.search.check_in')}}" autocomplete="off"
                                                readonly="readonly" required>
                                            <span class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar success-text text-14"></i>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="input-group ml-2 pt-4">
                                            <input class="form-control p-3 border-right-0 border text-14 checkinout"
                                                name="checkout" id="endDate"
                                                placeholder="{{trans('messages.search.check_out')}}" type="text"
                                                readonly="readonly" required>
                                            <span class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar success-text text-14"></i>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-5 pt-4">
                                    <div class="input-group">
                                        <select id="front-search-guests" class="form-control  text-14">
                                            <option class="p-4 text-14" value="1">1 {{trans('messages.home.guest')}}
                                            </option>
                                            @for($i=2;$i<=16;$i++) <option class="p-4 text-14" value="{{ $i }}">
                                                {{ ($i == '16') ? $i.'+ '.trans('messages.home.guest') : $i.' '.trans('messages.property_single.guest') }}
                                                </option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 front-search mt-5 pb-3 pt-4">
                                    <button type="submit"
                                        class="btn vbtn-default btn-block p-3 text-16">{{trans('messages.home.search')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!$starting_cities->isEmpty())
<section class="bg-gray mt-70 pb-5">
    <div class="container-fluid container-fluid-90">
        <div class="row">
            <div class="section-intro text-center">
                <p class="item animated fadeIn text-24 font-weight-700 m-0 text-capitalize">
                    {{trans('messages.home.top_destination')}}</p>
                <p class="mt-3">{{trans('messages.home.destination_slogan')}} </p>
            </div>
        </div>

        <div class="row mt-2">
            @foreach($starting_cities as $city)
            <div class="col-md-4 mt-5">
                <a href="{{URL::to('/')}}/search?location={{ $city->name }}&checkin=&checkout=&guest=1">
                    <div class="grid item animated zoomIn">
                        <figure class="effect-ming">
                            <img src="{{ $city->image_url }}" alt="city" />
                            <figcaption>
                                <p class="text-18 font-weight-700 position-center">{{$city->name}}</p>
                            </figcaption>
                        </figure>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@stop

@push('scripts')
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ @$map_key }}&libraries=places'></script>
<script type="text/javascript" src="{{ url('public/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/daterangepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ url('public/js/front.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/daterangecustom.js')}}"></script>
<script type="text/javascript">
$(function() {
    dateRangeBtn(moment(), moment());
});
</script>
@endpush