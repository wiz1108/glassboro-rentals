@php 
$form_data = [
		'page_title'=> 'Fees Setting Form',
		'page_subtitle'=> 'Fees Setting Page', 
		'form_name' => 'Fees Setting Form',
		'form_id' => 'fees_setting',
		'action' => URL::to('/').'/admin/settings/fees',
		'fields' => [
			
      		['type' => 'text', 'class' => '', 'label' => 'Guest service charge (%)', 'name' => "guest_service_charge", 'value' => $result['guest_service_charge'], 'hint' => 'service charge of guest for booking'],

            ['type' => 'text', 'class' => '', 'label' => 'I.V.A Tax (%)', 'name' => "iva_tax", 'value' => $result['iva_tax'], 'hint' => 'I.V.A Tax of guest for booking'],

            ['type' => 'text', 'class' => '', 'label' => 'Accomadation Tax (%)', 'name' => "accomodation_tax", 'value' => $result['accomodation_tax'], 'hint' => 'accomadation Tax of guest for booking'],
		]
	];
@endphp
@include("admin.common.form.setting", $form_data)
<script type="text/javascript">
   $(document).ready(function () {

            $('#fees_setting').validate({
                rules: {
                    guest_service_charge: {
                        required: true
                    }
                }
            });

        });
</script>