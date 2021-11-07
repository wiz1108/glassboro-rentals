		<!-- New Js start-->
		<script src="{{asset('public/js/jquery-2.2.4.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('public/js/main.js')}}"></script>

		  {!! @$head_code !!}

		<!-- New Js End -->
		<!-- Needed Js from Old Version Start-->
		<script type="text/javascript">
			var APP_URL = "{{ url('/') }}";
			var USER_ID = "{{ isset(Auth::user()->id)  ? Auth::user()->id : ''  }}";
			var sessionDate      = '{!! Session::get('date_format_type') !!}';

		$(".currency_footer").on('click', function() {
			var currency = $(this).data('curr');
				$.ajax({
					type: "POST",
					url: APP_URL + "/set_session",
					data: {
						"_token": "{{ csrf_token() }}",
						'currency': currency
						},
					success: function(msg) {
						location.reload()
					},
			});
		});

		$(".language_footer").on('click', function() {
			var language = $(this).data('lang');
			$.ajax({
				type: "POST",
				url: APP_URL + "/set_session",
				data: {
						"_token": "{{ csrf_token() }}",
						'language': language
					},
				success: function(msg) {
					location.reload()
				},
			});
		});
		</script>
		<!-- Needed Js from Old Version End -->
		@stack('scripts')
	</body>
</html>