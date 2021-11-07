	@extends('admin.template')

	@section('main')
	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-8 col-sm-offset-2">
					<div class="box box-info box_info">
						<div class="box-header with-border">
							<h3 class="box-title">Booking Details</h3>
						</div>

						<form action="{{ url('admin/bookings/detail/'.$result->id) }}" method="post" class='form-horizontal'>
							{{ csrf_field() }}
							<div class="box-body">
								<div class="form-group">
									<label class="col-sm-3 control-label">
										Property name
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ $result->properties->name }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Host name
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ ucfirst($result->properties->users->first_name) }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Guest name
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ ucfirst($result->users->first_name) }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Checkin
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ onlyFormat($result->start_date) }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Checkout
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ onlyFormat($result->end_date) }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Number of guests
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ $result->guest }}
									</div>
								</div>

								
								<div class="form-group">
									<label class="col-sm-3 control-label">
									Total nights
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{{ $result->total_night }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
									Per nights fee
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{!! moneyFormat($result->currency->org_symbol, $result->original_per_night) !!}
									</div>
								</div>

								@if($date_price)
	            					@foreach($date_price as $datePrice )   
										<div class="form-group">
											<label class="col-sm-3 control-label">
											{{ $datePrice->date }}
											</label>
											<div class="col-sm-6 col-sm-offset-1">
											{!! moneyFormat($result->currency->org_symbol, $datePrice->price) !!}											
											</div>
										</div>
									@endforeach
          						@endif


								<div class="form-group">
									<label class="col-sm-3 control-label">
										Sub Total amount
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{!! moneyFormat($result->currency->org_symbol, $result->original_base_price) !!}
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">
										Cleaning fee
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{!! moneyFormat($result->currency->org_symbol, $result->original_cleaning_charge) !!}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										I.V.A Tax
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{!! moneyFormat($result->currency->org_symbol, $result->iva_tax) !!}
										
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Accomodation Tax
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{!! moneyFormat($result->currency->org_symbol, $result->accomodation_tax) !!}
										
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Additional guest fee
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{!! moneyFormat($result->currency->org_symbol, $result->original_guest_charge) !!}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Security fee
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{!! moneyFormat($result->currency->org_symbol, $result->original_security_money) !!}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
									Service fee
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{!! moneyFormat($result->currency->org_symbol, $result->original_service_charge) !!}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Host fee
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{!! moneyFormat($result->currency->org_symbol, $result->original_host_fee) !!}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Total amount
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{!! moneyFormat($result->currency->org_symbol, $result->original_total) !!}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Currency
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{!! $result->currency_code !!}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Paymode
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ @$result->payment_methods->name }}
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">
										Status
									</label>
									<div class="col-sm-6 col-sm-offset-1">
										{{ $result->status }}
									</div>
								</div>

								@if($result->status == "Cancelled")
									<div class="form-group">
										<label class="col-sm-3 control-label">
										Cancelled By
										</label>
										<div class="col-sm-6 col-sm-offset-1">
										{{ $result->cancelled_by }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">
										Cancelled Date
										</label>
										<div class="col-sm-6 col-sm-offset-1">
										{{ dateFormat($result->cancelled_at) }}
										</div>
									</div>
								@endif

								<div class="form-group">
									<label class="col-sm-3 control-label">
									Transaction ID
									</label>
									<div class="col-sm-6 col-sm-offset-1">
									{{ $result->transaction_id }}
									</div>
								</div>

								@if($result->paymode == 'Credit Card')
									<div class="form-group">
										<label class="col-sm-3 control-label">
										First name
										</label>
										<div class="col-sm-6 col-sm-offset-1">
										{{ $result->first_name }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">
										Last name
										</label>
										<div class="col-sm-6 col-sm-offset-1">
										{{ $result->last_name }}
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">
										Postal code
										</label>
										<div class="col-sm-6 col-sm-offset-1">
										{{ $result->postal_code }}
										</div>
									</div>
								@endif
							
								@if($result->host_account != '')
									<div class="form-group">
										<label class="col-sm-3 control-label">
										Host Paypal account
										</label>
										<div class="col-sm-6 col-sm-offset-1">
										{{ $result->host_account }}
										</div>
									</div>
								@endif

								@if(@$bank->account_number != '')
									<div class="form-group">
										<label class="col-sm-3 control-label">
										Host Bank account
										</label>
										<div class="col-sm-6 col-sm-offset-1">
										{{$bank->account_number  }}
										</div>
									</div>
								@endif

								@if($result->guest_account != '')
									<div class="form-group">
										<label class="col-sm-3 control-label">
											Guest Paypal account
										</label>
										<div class="col-sm-6 col-sm-offset-1">
											{{ $result->guest_account }}
										</div>
									</div>
								@endif

								@if($result->host_penalty_amount != 0)
									<div class="form-group">
										<label class="col-sm-3 control-label">
											Applied Penalty Amount
										</label>
										<div class="col-sm-6 col-sm-offset-1">
											{!! $result->currency->org_symbol !!}{{ $result->host_penalty_amount }}
										</div>
									</div>
								@endif

								@if(@$penalty_amount != 0)
									<div class="form-group">
										<label class="col-sm-3 control-label">
											Subtracted Penalty Amount
										</label>
										<div class="col-sm-6 col-sm-offset-1">
											{!! $result->currency->org_symbol !!}{{ @$penalty_amount }}
										</div>
									</div>
								@endif
							</div>
						</form> 

						@if((($result->status == 'Accepted' &&  $result->checkin_cross == 0 && $result->check_host_payout != 'yes' ) || ($result->status == 'Cancelled') && ($result->check_host_payout != 'yes') && ($result->original_admin_host_payment != 0)))
							@if($result->host_account)
								<form action="{{ url('admin/bookings/pay') }}" method="post">
									{{ csrf_field() }}
									<input type="hidden" name="booking_id" value="{{ $result->id }}">
									<input type="hidden" name="host_payout_id" value="{{ $result->host_payout_id }}">
									<input type="hidden" name="user_type" value="host">
									<div class="text-center"> 
										<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to mark it as paid?')">Paid to Host({!! $result->currency->org_symbol !!}{{ $result->original_admin_host_payment }})</button>
									</div>
								</form>
							@else
								<div class="text-bold text-danger text-center">Yet, host doesn't enter his/her Account preferences. <a href="{{ url('admin/booking/need_pay_account/'.$result->id.'/host') }}">Send Email to Host</a></div>
							@endif
						@endif

						@if(($result->status == 'Declined' || $result->status == 'Cancelled' || $result->status == 'Expired') && ($result->check_guest_payout != 'yes') && ($result->original_admin_guest_payment != 0))
							@if($result->guest_account)
								<br>
								<form action="{{ url('admin/bookings/pay') }}" method="post">
									{{ csrf_field() }}
									<input type="hidden" name="booking_id" value="{{ $result->id }}">
									<input type="hidden" name="guest_payout_id" value="{{ $result->guest_payout_id }}">
									<input type="hidden" name="user_type" value="guest">
									<div class="text-center">
										<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to mark it as paid?')">Paid to Guest({!! $result->currency->org_symbol !!}{{ $result->original_admin_guest_payment }})</button>
									</div>
								</form>
							@else
								<div class="text-bold text-danger text-center">Yet, guest doesn't enter his/her Account preferences. <a href="{{ url('admin/booking/need_pay_account/'.$result->id.'/guest') }}">Send Email to Guest</a></div>
							@endif
						@endif
						
						@if($result->check_host_payout == 'yes')
							<div class="text-bold text-success text-center">Host payout amount ({!! $result->currency->org_symbol.$result->original_host_payout !!}) transferred.</div>
						@endif
							@if($result->check_guest_payout == 'yes')
						<div class="text-bold text-success text-center">Guest payout amount ({!! $result->currency->org_symbol.$result->original_guest_payout !!}) transferred.</div>
						@endif

						<div class="box-footer text-center">
							<a class="btn btn-default" href="{{ url('admin/bookings') }}">Back</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	@push('scripts')
	<script  type="text/javascript">
	$('#input_dob').datepicker({ 'format': 'dd-mm-yyyy'});
	</script>
	@endpush
	@stop