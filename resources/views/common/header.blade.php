<!--================ Header Menu Area start =================-->
<?php 
    $lang = Session::get('language');
?>
<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type')}}">
<header class="header_area  animated fadeIn">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid container-fluid-90">
                <a class="navbar-brand logo_h" aria-label="logo" href="{{ url('/') }}"><img src="{{ $logo ?? '' }}"
                        alt="logo" class="img-170x70"></a>
            </div>
        </nav>
    </div>
</header>

<!-- Modal Window -->
<div class="modal left fade" id="left_modal" tabindex="-1" role="dialog" aria-labelledby="left_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 secondary-bg">
                @if(Auth::check())
                <div class="row justify-content-center">
                    <div>
                        <img src="{{Auth::user()->profile_src}}" class="head_avatar" alt="{{Auth::user()->first_name}}">
                    </div>

                    <div>
                        <p class="text-white mt-4"> {{Auth::user()->first_name}}</p>
                    </div>
                </div>
                @endif

                <button type="button" class="close text-28" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="mobile-side">
                    @if(Auth::check())
                    <li><a href="{{ url('dashboard') }}"><i
                                class="fa fa-tachometer-alt mr-3"></i>{{trans('messages.header.dashboard')}}</a></li>
                    <li><a href="{{ url('inbox') }}"><i
                                class="fas fa-inbox mr-3"></i>{{trans('messages.header.inbox')}}</a></li>
                    <li><a href="{{ url('properties') }}"><i
                                class="far fa-list-alt mr-3"></i>{{trans('messages.header.your_listing')}}</a></li>
                    <li><a href="{{ url('my-bookings') }}"><i
                                class="fa fa-bookmark mr-3"></i>{{trans('messages.booking_my.booking')}}</a></li>
                    <li><a href="{{ url('trips/active') }}"><i class="fa fa-suitcase mr-3"></i>
                            {{trans('messages.header.your_trip')}}</a></li>
                    <li><a href="{{ url('users/payout-list') }}"><i class="far fa-credit-card mr-3"></i>
                            {{trans('messages.sidenav.payouts')}}</a></li>
                    <li><a href="{{ url('users/transaction-history') }}"><i
                                class="fas fa-money-check-alt mr-3 text-14"></i>
                            {{trans('messages.account_transaction.transaction')}}</a></li>
                    <li><a href="{{ url('users/profile') }}"><i
                                class="far fa-user-circle mr-3"></i>{{trans('messages.utility.profile')}}</a></li>
                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                        aria-controls="collapseExample">
                        <li><i class="fas fa-user-edit mr-3"></i>{{trans('messages.sidenav.reviews')}}</li>
                    </a>

                    <div class="collapse" id="collapseExample">
                        <ul class="ml-4">
                            <li><a href="{{ url('users/reviews') }}"
                                    class="text-14">{{trans('messages.reviews.reviews_about_you')}}</a></li>
                            <li><a href="{{ url('users/reviews_by_you') }}"
                                    class="text-14">{{trans('messages.reviews.reviews_by_you')}}</a></li>
                        </ul>
                    </div>
                    <li><a href="{{ url('logout') }}"><i
                                class="fas fa-sign-out-alt mr-3"></i>{{trans('messages.header.logout')}}</a></li>
                    @else
                    <li><a href="{{ url('signup') }}"><i
                                class="fas fa-stream mr-3"></i>{{trans('messages.sign_up.sign_up')}}</a></li>
                    <li><a href="{{ url('login') }}"><i
                                class="far fa-list-alt mr-3"></i>{{trans('messages.header.login')}}</a></li>
                    @endif

                    @if(Request::segment(1) != 'help')
                    <a href="{{ url('property/create') }}">
                        <button class="btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                            {{trans('messages.header.list_space')}}
                        </button>
                    </a>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!--================Header Menu Area =================-->