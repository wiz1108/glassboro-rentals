@extends('template')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ url('public/css/daterangepicker.min.css')}}" />
<link  rel="stylesheet" type="text/css" href="{{ url('public/css/glyphicon.css') }}"/>
<link  rel="stylesheet" type="text/css"  href="{{ url('public/js/ninja/ninja-slider.min.css') }}" />
@endpush
@section('main')

<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type')}}">

<div class="carousel-inner" role="listbox">
	<div class="item active">
		<div class="ex-image-container" onclick="lightbox(0)" style="background-image:url({{$result->cover_photo}});">
		</div>
	</div>
</div>

<div class="container-fluid container-fluid-90">
	<div class="row" id="mainDiv">
		<div class="col-lg-8 col-xl-9">
			<div  id="sideDiv">
				<div class="d-flex border rounded-4 p-4 mt-4">
					<div class="text-center">
						<a href="{{ url('users/show/'.$result->host_id) }}" >
							<img alt="User Profile Image" class="img-fluid rounded-circle mr-4 img-90x90" src="{{ $result->users->profile_src }}" title="{{$result->users->first_name}}">
						</a>
					</div>
					
					<div class="ml-2">
						<h3 class="text-20 mt-4"><strong>{{ $result->name }}</strong></h3>
						<span class="text-14 gray-text"><i class="fas fa-map-marker-alt"></i> {{ $result->property_address->city }} @if($result->property_address->city !=''),@endif {{ $result->property_address->state}} @if($result->property_address->state !=''),@endif {{ $result->property_address->countries->name }}</span>
						@if($result->avg_rating)
								<p>	<i class="fa fa-star secondary-text-color"></i> {{sprintf("%.1f",$result->avg_rating )}} ({{ $result->guest_review }})</p>
						@endif
					</div>
				</div>
	
			</div>
		</div>

		<div class="col-lg-4 col-xl-3 mb-4 mt-4">
			<div id="sticky-anchor" class="d-none d-md-block"></div>
			<div class="card p-4">
				<div id="booking-price" class="panel panel-default">
					<div  class="" id="booking-banner" class="">
						<div class="secondary-bg rounded">
							<div class="col-lg-12">
								<div class="row justify-content-between p-3">
									<div class="text-white">
										{!! moneyFormat($result->property_price->currency->symbol, $result->property_price->price) !!}
									</div>

									<div class="text-white text-14">
										<div id="per_night" class="per-night">
										{{trans('messages.property_single.per_month')}}
										</div>
										<div id="per_month" class="per-month display-off">
										{{trans('messages.property_single.per_month')}}
										<i id="price-info-tooltip" class="fa fa-question hide" data-behavior="tooltip"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="mt-5">
						<div class="col-md-12">
							<div class="clearfix"></div>
							<h2><strong>{{trans('messages.property_single.about_host')}}</strong></h2> 
							<div class="d-flex mt-4">
								<div class="">
									<div class="media-photo-badge text-center">
										<img alt="{{ $result->users->first_name }}" class="" src="{{ $result->users->profile_src }}" title="{{ $result->users->first_name }}">
									</div>
								</div>

								<div class="ml-3 align-self-center">
									<h2 class="text-16 font-weight-700">{{ $result->users->full_name }}</h2>
								</div>
							</div> 
							<div class="ml-2 pt-3">
								<p>{{trans('messages.users_show.member_since')}}: {{ date('F Y', strtotime($result->users->created_at))  }}</p>
								<p>Email: {{$result->users->email}}</p>
								<p>Phone: {{$result->users->phone}}</p>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	{{-- erorr check here --}}
	<div class="row mt-4 mt-sm-0">
		<div class="col-lg-8 col-xl-9 col-sm-12">
			<div class="row  justify-content-center border rounded pb-5"  id="listMargin">
				<div class="col-md-12 mt-3 pl-4 pr-4">
					<div class="mt-3">
						<div class="row">
							<div class="col-md-12">
								<h2><strong>{{trans('messages.property_single.about_list')}}</strong> </h2>
								<p class="mt-4 text-justify" >{{ $result->property_description->summary }}</p>
							</div>
						</div>
					</div>

					<div class="mt-3">
						<div class="row">
							<div class="col-md-3 col-sm-3">
								<div class="d-flex h-100">
									<div class="align-self-center">
										<h2 class="font-weight-700 text-18"> {{trans('messages.property_single.the_space')}}</h2>
									</div>
								</div>
							</div>

							<div class="col-md-9 col-sm-9">
								<div class="row">
								<div class="col-md-6 col-sm-6">
									<div><strong>{{trans('messages.property_single.property_type')}}:</strong> {{ $result->property_type_name }}</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div><strong>{{trans('messages.property_single.bedroom')}}:</strong> {{ @$result->bedrooms }}</div>

									<div><strong>{{trans('messages.property_single.bathroom')}}:</strong> {{ @$result->bathrooms }}</div>
								</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-md-3 col-sm-3">
								<div class="d-flex h-100">
									<div class="align-self-center">
										<h2 class="font-weight-700 text-18">  {{trans('messages.property_single.amenity')}}</h2>
									</div>
								</div>
							</div>
						
							<div class="col-md-9 col-sm-9">
								<div class="row">
									@php $i = 1 @endphp
									@php $count = round(count($amenities)/2) @endphp
									@foreach($amenities as $all_amenities)
										@if($all_amenities->status != null)
										<div class="col-md-6 col-sm-6">
											<i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i> 
											{{ $all_amenities->title }}
										</div>
										@php $i++ @endphp
										@endif
									@endforeach

									<div class="row">
										<!-- Modal -->
										<div class="modal fade mt-5 z-index-high" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<div class="w-100 pt-3">
															<h5 class="modal-title text-20 text-center font-weight-700" id="exampleModalLongTitle">{{trans('messages.property_single.amenity')}}</h5>
														</div>
							
														<div>
															<button type="button" class="close text-28 mr-2 filter-cancel" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div> 
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>  
						@if(count($safety_amenities) !=0)
							<hr>
							<div class="row">
								<div class="col-md-3 col-sm-3">
									<div class="d-flex h-100">
										<div class="align-self-center">
											<h2 class="font-weight-700 text-18">{{trans('messages.property_single.safety_feature')}}</h2>
										</div>
									</div>
								</div>

								<div class="col-md-9 col-sm-9">
									<div class="row">
										@foreach($safety_amenities as $row_safety)
											@if($row_safety->status != null)
											<div class="col-md-6 col-sm-6">
												<i class="fa h3 fa-{{ $all_amenities->symbol }}" aria-hidden="true"></i> 
													{{ $row_safety->title }}
											</div>
											@endif
										@endforeach
									</div>
								</div>
							</div>
						@endif

						@if(@$result->property_description->about_place !='' || $result->property_description->place_is_great_for !='' || $result->property_description->guest_can_access !='' || $result->property_description->interaction_guests !='' || $result->property_description->other || $result->property_description->about_neighborhood || $result->property_description->get_around) 
							<hr>
							<div class="row">
								<div class="col-md-3 col-sm-3">
									<div class="d-flex h-100">
										<div class="align-self-center">
											<h2 class="font-weight-700 text-18">{{trans('messages.property_single.description')}}</h2>
										</div>
									</div>
								</div>

								<div class="col-md-9 col-sm-9">
									@if($result->property_description->about_place)
										<strong class="font-weight-700">{{trans('messages.property_single.about_place')}}</strong>
										<p class="text-justify">{{ $result->property_description->about_place}}</p>
									@endif

									@if($result->property_description->place_is_great_for)
										<strong class="font-weight-700">{{trans('messages.property_single.place_great_for')}}</strong>
										<p  class="text-justify">{{ $result->property_description->place_is_great_for}} </p>
									@endif

									<a href="javascript:void(0)" id="description_trigger" data-rel="description" class="more-btn"><strong>+ {{trans('messages.property_single.more')}}</strong></a>
									<div class="d-none" id='description_after'>
										@if($result->property_description->interaction_guests)
											<strong class="font-weight-700">{{trans('messages.property_single.interaction_guest')}}</strong>
											<p  class="text-justify"> {{ $result->property_description->interaction_guests}}</p>
										@endif

										@if($result->property_description->about_neighborhood)
											<strong class="font-weight-700">{{trans('messages.property_single.about_neighborhood')}}</strong>
											<p  class="text-justify"> {{ $result->property_description->about_neighborhood}}</p>
										@endif

										@if($result->property_description->guest_can_access)
											<strong class="font-weight-700">{{trans('messages.property_single.guest_access')}}</strong>
											<p  class="text-justify">{{ $result->property_description->guest_can_access}}</p>
										@endif

										@if($result->property_description->get_around)
											<strong class="font-weight-700">{{trans('messages.property_single.get_around')}}</strong>
											<p  class="text-justify">{{ $result->property_description->get_around}}</p>
										@endif

										@if($result->property_description->other)
											<strong class="font-weight-700">{{trans('messages.property_single.other')}}</strong>
											<p  class="text-justify">{{ $result->property_description->other}}</p>
										@endif
										<a href="javascript:void(0)" id="description_less" data-rel="description" class="less-btn"><strong>- less</strong></a>

									</div>
								</div>
							</div>
						@endif
						<hr>

						<!--popup slider-->
						<div class="d-none" id="showSlider">
							<div id="ninja-slider">
								<div class="slider-inner">
									<ul>
										@foreach($property_photos as $row_photos)
											<li>
												<a class="ns-img" href="{{url('public/images/property/'.$property_id.'/'.$row_photos->photo)}}" aria-label="photo"></a>
											</li>
										@endforeach
									</ul>
									<div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
								</div>
							</div>
						</div>

						<!--popup slider end-->
						@if(count($property_photos) > 0)
							<div class="row mt-4">
								<div class="col-md-12 col-sm-12 pl-3 pr-3">
									<div class="row">
										@php $i=0 @endphp
										
										@foreach($property_photos as $row_photos)
											@if($i == 0)
												<div class="col-md-12 col-sm-12 mb-2 mt-2 p-2">
													<div class="slider-image-container" onclick="lightbox({{$i}})" style="background-image:url({{url('public/images/property/'.$property_id.'/'.$row_photos->photo)}});">
													</div>
												</div>
											@elseif($i <= 4)
											
												
													@if($i==4) 
														<div class="p-2 position-relative">
															<div class="view-all gal-img h-110px">
																<img src="{{url('public/images/property/'.$property_id.'/'.$row_photos->photo)}}" alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{$i}})" />
																<span class="position-center cursor-pointer" onclick="lightbox({{$i}})">{{trans('messages.property_single.view_all')}}</span>
															</div>
														</div> 
														
													@else 
														<div class="p-2">
															<div class="h-110px gal-img">
																<img src="{{url('public/images/property/'.$property_id.'/'.$row_photos->photo)}}" alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{$i}})" />
															</div>
														</div>
													@endif
											@else
												@php break; @endphp
											@endif
											@php $i++ @endphp
										@endforeach
									</div>
								</div>
							</div>
							<hr>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid container-fluid-90 mt-70">
	<div class="row mt-5">
		<div class="col-md-12">
			<div id="room-detail-map" class="single-map-w"></div>
		</div>
	</div>
</div>

	<div class="container-fluid container-fluid-90 mt-70 mb-5">
		@if(count($similar)!= 0)
			<div class="row">
				<div class="col-md-12">
					<h2 class="text-center-sm text-20 font-weight-700">{{trans('messages.property_single.similar_list')}}</h2>
				</div>
			</div>

			<div class="row m-0 mt-5 mb-5">
				@foreach($similar->slice(0, 8) as $row_similar)
					<div class="col-md-6 col-lg-4 col-xl-3 p-2 mt-4 pl-4 pr-4">
						<div class="card h-100 border card-1">
							<div class="grid">
								<a href="{{ $row_similar->slug }}">
									<figure class="effect-milo">
										<img src="{{ $row_similar->cover_photo }}" class="room-image-container200" alt="img11"/>
										<figcaption>
										</figcaption>     
									</figure>        
								</a>
							</div>

							<div class="card-body p-0 pl-1 pr-1">
								<div class="d-flex">
									<div>
										<div class="profile-img pl-2 pr-1">
											<a href="{{ url('users/show/'.$row_similar->host_id) }}"><img src="{{ $row_similar->users->profile_src }}" alt="profile-photo"></a>
										</div>
									</div>
			
									<div class="p-2 text">
										<a class="text-color text-color-hover" href="{{ url('properties/'.$row_similar->slug) }}">
											<h4 class="text-16 font-weight-700 text"> {{ $row_similar->name}}</h4>
										</a>
										<p class="text-14 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i> {{$row_similar->property_address->city}}</p>
									</div>
								</div> 
			
								<div class="review-0 p-3">
									<div class="d-flex justify-content-end">
										<div>
											<span class="font-weight-700">{!! moneyFormat( $row_similar->property_price->currency->symbol, $row_similar->property_price->price) !!}</span> / Month
										</div>
									</div>
								</div>
			
								<div class="card-footer text-muted p-0 border-0">
									<div class="d-flex flex-column bg-white pl-2 pr-2 pt-2 mb-3">
										<div>
											<ul class="d-flex list-inline justify-content-around">
												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
												<div class="vtooltip"> <i class="fas fa-bed"></i> {{ $row_similar->bedrooms }}
													<span class="vtooltiptext  text-14">{{ $row_similar->bedrooms }} {{trans('messages.property_single.bedroom')}}</span>
												</div>
												</li>
				
												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
												<div class="vtooltip"> <i class="fas fa-bath"></i> {{ $row_similar->bathrooms }}
													<span class="vtooltiptext  text-14 p-2">{{ $row_similar->bathrooms }} {{trans('messages.property_single.bathroom')}}</span>
												</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@endif
	</div>
@push('scripts')
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ @$map_key }}&libraries=places'></script>



<script type="text/javascript" src="{{ url('public/js/locationpicker.jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/ninja/ninja-slider.js') }}"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="{{ url('public/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/daterangepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ url('public/js/daterangecustom.js')}}"></script>

<script type="text/javascript">
	$(function() {
		var checkin = $('#startDate').val();
		var checkout = $('#endDate').val();
		var page = 'single'
		dateRangeBtn(checkin,checkout,page);
		
	});
</script>

<script type="text/javascript">
$("#view-calendar").on("click", function() {
	return $("#startDate").trigger("select");
})

$( window ).resize(function() {
	if ($(window).width() < 760) {
		$("#listMargin").css({"margin-top": "0px"});
	} else {
		sticky_relocate();
	}
});



function sticky_relocate() {
	var window_top = $(window).scrollTop();
	var list_div = $("#listMargin").height();

	var div_top = $('#sticky-anchor').offset().top;
	if (window_top > div_top && $(window).width() > 2000) {
		$('#booking-price').addClass('stick');
		$('#sticky-anchor').height($('#sticky').outerHeight());
		$("#listMargin").addClass('mt-25');
		$("#listMargin").css({"margin-top": "25px"});
		divAdjust();
	} else {
		$('#booking-price').removeClass('stick');
		$('#sticky-anchor').height(0);
		divAdjust();
	}
	if(window_top > list_div){
		$('#booking-price').addClass('d-none');
	}else{
		$('#booking-price').removeClass('d-none');
	}
}

function divAdjust() {
	if ($(window).width() > 992) {
		var mainDiv = $("#mainDiv").height();
		var sideDiv = $("#sideDiv").height();
		var listMargin = (mainDiv - sideDiv)-40;
		$("#listMargin").css({"margin-top": "-"+listMargin +"px"});
	}
	else {
			// More than 960
	}
}

$(function(){
	var checkin     = $('#url_checkin').val();
	var checkout    = $('#url_checkout').val();
	var guest       = $('#url_guests').val();
	// price_calculation(checkin, checkout, guest);
});

$('#number_of_guests').on('change', function(){
	price_calculation('', '', '');
});

function price_calculation(checkin, checkout, guest){
	var checkin = checkin != ''? checkin:$('#startDate').val();
	var checkout = checkout != ''? checkout:$('#endDate').val();
	var guest = guest != ''? guest:$('#number_of_guests').val();
	if(checkin != '' && checkout != '' &&  guest != ''){
	var property_id     = $('#property_id').val();
	var dataURL = '{{url("property/get-price")}}';
		$.ajax({
			url: dataURL,
			data: {
				"_token": "{{ csrf_token() }}",
				'checkin': checkin,
				'checkout': checkout,
				'guest_count': guest, 
				'property_id': property_id,
			},
			type: 'post',
			dataType: 'json',
			beforeSend: function (){
				// $('.price_table').addClass('d-none');
				show_loader();
			},
			success: function (result) {
				$('.append_date').remove();
				if(result.status == 'Not available'){
					$('.book_btn').addClass('d-none');
					$('.booking-subtotal').addClass('d-none');
					$('#book_it_disabled').removeClass('d-none');
				}
				else if(result.status == 'minimum stay')
				{
					$('.book_btn').addClass('d-none');
					$('.booking-subtotal').addClass('d-none');
					$('#book_it_disabled').addClass('d-none');
					$('#minimum_disabled').removeClass('d-none');
					$('#minimum_disabled_message').text(result.minimum);


				}
				else
				{

					//showing custom price in info icon
					if(!jQuery.isEmptyObject(result.different_price_dates)){
						var output = "{{trans('messages.listing_price.custom_price')}} <br/>";
						for (var ical_date in result.different_price_dates) {
							output += "{{__('messages.account_transaction.date')}}: "+ical_date+" | {{__('messages.utility.price')}}: "+"{{$result->property_price->currency->symbol}}"+ result.different_price_dates[ical_date]+" <br>";
						}
						
						$("#custom_price").attr("data-original-title", output);
						$('#custom_price').tooltip({ 'placement': 'top' });   
						$('#custom_price').show();

					}else{
						$('#custom_price').addClass('d-none');
					}


					var append_date = ""

					for(var i=0; i<result.date_with_price.length; i++){

					append_date +=		'<tr class="append_date">'
											+ '<td class="pl-4">'
												+ result.date_with_price[i]['date']+
											'</td>'
											+ '<td class="pl-4 text-right"> <span  id="" value="">'+ result.date_with_price[i]['price'] +'</span></td>'
										+ '</tr>';
					
					}

					var tableBody = $("table tbody");
	                tableBody.first().prepend(append_date);


					$('.additional_price').removeClass('d-none');
					$('.security_price').removeClass('d-none');
					$('.cleaning_price').removeClass('d-none');
					$('.iva_tax').removeClass('d-none');
					$('.accomodation_tax').removeClass('d-none');
					$("#total_night_count").html(result.total_nights);
					$('#total_night_price').html(result.total_night_price_with_symbol);
					$('#service_fee').html(result.service_fee_with_symbol);
					$('#discount').html(result.discount);

					if(result.iva_tax != 0) $('#iva_tax').html(result.iva_tax_with_symbol);
					else $('.iva_tax').addClass('d-none');
					if(result.accomodation_tax != 0) $('#accomodation_tax').html(result.accomodation_tax_with_symbol);
					else $('.accomodation_tax').addClass('d-none');

					if(result.additional_guest != 0) $('#additional_guest').html(result.additional_guest);
					else $('.additional_price').addClass('d-none');
					if(result.security_fee != 0) $('#security_fee').html(result.security_fee);
					else $('.security_price').removeClass('d-none');
					if(result.cleaning_fee != 0) $('#cleaning_fee').html(result.cleaning_fee);
					else $('.cleaning_price').addClass('d-none');
					$('#total').html(result.total_with_symbol);
					//$('#total_night_price').html(result.total_night_price);

					$('.booking-subtotal').removeClass('d-none');
					$('#book_it_disabled').addClass('d-none');
					$('#minimum_disabled').addClass('d-none');
					$('.book_btn').removeClass('d-none');
				}

				var host = "{{ ($result->host_id == @Auth::guard('users')->user()->id) ? '1' : '' }}";
				if(host == '1') $('.book_btn').addClass('d-none');
			},
			error: function (request, error) {
				// This callback function will trigger on unsuccessful action
				console.log(error);
			},
			complete: function(){
				$('.price_table').removeClass('d-none');
				hide_loader();
			}
		});
	}
}

$(function() {
	$(window).scroll(sticky_relocate);
	sticky_relocate();
});

document.addEventListener('readystatechange', event => { 
	if (event.target.readyState === "complete") {
			setTimeout(function() { 
				sticky_relocate();
			}, 1000);
	}
});



$(document).ready(function() {
    $('#booking_form').validate({        
        submitHandler: function(form)
        {
     		$("#save_btn").on("click", function (e)
            {	
            	$("#save_btn").attr("disabled", true);
                e.preventDefault();
            });
            
            $(".spinner").removeClass('d-none');
            $("#save_btn-text").text("{{trans('messages.users_profile.save')}} ..");
            return true;
        }
    });
});

$('.more-btn').on('click', function(){
	var name = $(this).attr('data-rel');
	$('#'+name+'_trigger').addClass('d-none');
	$('#'+name+'_after').removeClass('d-none');
});

$('.less-btn').on('click', function(){
	var name = $(this).attr('data-rel');
	$('#'+name+'_trigger').removeClass('d-none');
	$('#'+name+'_after').addClass('d-none');
});



setTimeout(function(){

	$('#room-detail-map').locationpicker({
		location: {
			latitude: "{{$result->property_address->latitude}}",
			longitude: "{{ $result->property_address->longitude }}"
		},
		radius: 0,
		addressFormat: "",
		markerVisible: false,
		markerInCenter: false,
		enableAutocomplete: true,
		scrollwheel: false,
		oninitialized: function (component) {
			setCircle($(component).locationpicker('map').map);
		}

	});

}, 5000);






function setCircle(map){
	var citymap = {
	loccenter: {
		center: {lat: 41.878, lng: -87.629},
		population: 240
	},
	};

	var cityCircle = new google.maps.Circle({
		strokeColor: '#329793',
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: '#329793',
		fillOpacity: 0.35,
		map: map,
		center: {lat: {{$result->property_address->latitude}}, lng: {{ $result->property_address->longitude }} },
		radius: citymap['loccenter'].population
	});
}

function lightbox(idx) {
	//show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
	$('#showSlider').removeClass("d-none");
	nslider.init(idx);
	$("#ninja-slider").addClass("fullscreen");
}

function fsIconClick(isFullscreen) { //fsIconClick is the default event handler of the fullscreen button
	if (isFullscreen) {
		$('#showSlider').addClass("d-none");
	}
}

function show_loader(){
	$('#loader').removeClass('d-none');
	$('#pagination').addClass('d-none');
}

function hide_loader(){
	$('#loader').addClass('d-none');
	$('#pagination').removeClass('d-none');
}

</script>
@endpush 
@stop
