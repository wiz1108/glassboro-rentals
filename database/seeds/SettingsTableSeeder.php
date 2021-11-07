<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('settings')->truncate();

        DB::table('settings')->insert([
        	['name' => 'name', 'value' => 'Vrent', 'type' => 'general'],
            ['name' => 'logo', 'value' => 'logo.png', 'type' => 'general'],
            ['name' => 'favicon', 'value' => 'favicon.png', 'type' => 'general'],
            ['name' => 'head_code', 'value' => '', 'type' => 'general'],
            ['name' => 'default_currency', 'value' => 1, 'type' => 'general'],
            ['name' => 'default_language', 'value' => 1, 'type' => 'general'],
            ['name' => 'email_logo', 'value' => 'email_logo.png', 'type' => 'general'],
        	
            ['name' => 'username', 'value' => 'techvillage_business_api1.gmail.com', 'type' => 'PayPal'],
            ['name' => 'password', 'value' => '9DDYZX2JLA6QL668', 'type' => 'PayPal'],
            ['name' => 'signature', 'value' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31ABayz5pdk84jno7.Udj6-U8ffwbT', 'type' => 'PayPal'],
            ['name' => 'mode', 'value' => 'sandbox', 'type' => 'PayPal'],
            ['name' => 'paypal_status', 'value' => '1', 'type' => 'PayPal'],
            
            ['name' => 'publishable', 'value' => 'pk_test_c2TDWXsjPkimdM8PIltO6d8H', 'type' => 'Stripe'],
            ['name' => 'secret', 'value' => 'sk_test_UWTgGYIdj8igmbVMgTi0ILPm', 'type' => 'Stripe'],
            ['name' => 'stripe_status', 'value' => '1', 'type' => 'Stripe'],


            ['name' => 'driver', 'value' => 'sendmail', 'type' => 'email'],
            ['name' => 'host', 'value' => 'mail.techvill.net', 'type' => 'email'],
            ['name' => 'port', 'value' => '587', 'type' => 'email'],
            ['name' => 'from_address', 'value' => 'stockpile@techvill.net', 'type' => 'email'],
            ['name' => 'from_name', 'value' => 'Vrent', 'type' => 'email'],
            ['name' => 'encryption', 'value' => 'tls', 'type' => 'email'],
            ['name' => 'username', 'value' => 'stockpile@techvill.net', 'type' => 'email'],
            ['name' => 'password', 'value' => 'nT4HD2XEdRUX', 'type' => 'email'],

            ['name' => 'facebook', 'value' => '#', 'type' => 'join_us'],
            ['name' => 'google_plus', 'value' => '#', 'type' => 'join_us'],
            ['name' => 'twitter', 'value' => '#', 'type' => 'join_us'],
            ['name' => 'linkedin', 'value' => '#', 'type' => 'join_us'],
            ['name' => 'pinterest', 'value' => '#', 'type' => 'join_us'],
            ['name' => 'youtube', 'value' => '#', 'type' => 'join_us'],
            ['name' => 'instagram', 'value' => '#', 'type' => 'join_us'],

            ['name' => 'key', 'value' => 'AIzaSyAUevXmCBPElE-UiPcZW77KpuckXZ_iWRc', 'type' => 'googleMap'],
        
            ['name' => 'client_id', 'value' => '155732176097-s2b8liiqj6v8l39r25baq31vm3adg8uv.apps.googleusercontent.com', 'type' => 'google'],
            ['name' => 'client_secret', 'value' => 'ltyqX9vFSqkaRjo4-rxphynm', 'type' => 'google'],

            ['name' => 'client_id', 'value' => '166441230733266', 'type' => 'facebook'],
            ['name' => 'client_secret', 'value' => '0787364d54422d8ff0bbb646c7f3231e', 'type' => 'facebook'],
            ['name' => 'email_status', 'value' => '0', 'type' => 'email'],
            ['name' => 'row_per_page', 'value' => '25', 'type' => 'preferences'],
            ['name' => 'date_separator', 'value' => '-', 'type' => 'preferences'],
            ['name' => 'date_format', 'value' => '2', 'type' => 'preferences'],
            ['name' => 'dflt_timezone', 'value' => 'Asia/Dhaka', 'type' => 'preferences'],
            ['name' => 'money_format', 'value' => 'before', 'type' => 'preferences'],
            ['name' => 'date_format_type', 'value' => 'mm-dd-yyyy', 'type' => 'preferences'],
            ['name' => 'front_date_format_type', 'value' => 'mm-dd-yy', 'type' => 'preferences'],
            ['name' => 'search_date_format_type', 'value' => 'm-d-yy', 'type' => 'preferences'],
            
        ]);
    }
}
