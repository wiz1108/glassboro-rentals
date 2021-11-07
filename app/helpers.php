<?php

use App\Models\Settings;
use App\Models\Change;
use App\Models\Currency;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\Common;
use Twilio\Http\CurlClient;



/**
 * [dateFormat description for database date]
 * @param  [type] $value    [any number]
 * @return [type] [formates date according to preferences setting in Admin Panel]
 */
function setDateForDb($value = null)
{
    if (empty($value)) {
        return null;
    }
    $separator   = Session::get('date_separator');
    $date_format = Session::get('date_format_type');
    if (str_replace($separator, '', $date_format) == "mmddyyyy") {
        $value = str_replace($separator, '/', $value);
        $date  = date('Y-m-d', strtotime($value));
    } else {
        $date = date('Y-m-d', strtotime(strtr($value, $separator, '-')));
    }
    return $date;
}


/**
 * [Default timezones]
 * @return [timezonesArray]
 */
function phpDefaultTimeZones()
{
    $zonesArray  = array();
    $timestamp   = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zonesArray[$key]['zone']          = $zone;
        $zonesArray[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zonesArray;
    return $timezones;
}


/**
 * [dateFormat description]
 * @param  [type] $value    [any number]
 * @return [type] [formates date according to preferences setting in Admin Panel]
 */
function dateFormat($value, $type = null)
{
    $timezone       = '';
    $timezone       = Settings::where(['type' => 'preferences', 'name' => 'dflt_timezone'])->first(['value'])->value;
    $today          = new DateTime($value, new DateTimeZone(config('app.timezone')));
    $today->setTimezone(new DateTimeZone($timezone));
    $value          = $today->format('Y-m-d H:i:s');


    $preferenceData = Settings::where(['type' => 'preferences'])->whereIn('name', ['date_format_type', 'date_separator'])->get(['name', 'value'])->toArray();
    $preferenceData = Common::key_value('name', 'value', $preferenceData);
    $preference     = $preferenceData['date_format_type'];
    $separator      = $preferenceData['date_separator'];

    $data           = str_replace(['/', '.', ' ', '-'], $separator, $preference);
    $data           = explode($separator, $data);
    $first          = $data[0];
    $second         = $data[1];
    $third          = $data[2];

    $dateInfo       = str_replace(['/', '.', ' ', '-'], $separator, $value);
    $datas          = explode($separator, $dateInfo);
    $year           = $datas[0];
    $month          = $datas[1];
    $day            = $datas[2];

    $dateObj        = DateTime::createFromFormat('!m', $month);
    $monthName      = $dateObj->format('F');

    $toHoursMin     = \Carbon\Carbon::createFromTimeStamp(strtotime($value))->format(' g:i A');

    if ($first == 'yyyy' && $second == 'mm' && $third == 'dd') {
        $value = $year . $separator . $month . $separator . $day. $toHoursMin;
    } else if ($first == 'dd' && $second == 'mm' && $third == 'yyyy') {
        $value = $day . $separator . $month . $separator . $year. $toHoursMin;
    } else if ($first == 'mm' && $second == 'dd' && $third == 'yyyy') {
        $value = $month . $separator . $day . $separator . $year. $toHoursMin;
    } else if ($first == 'dd' && $second == 'M' && $third == 'yyyy') {
        $value = $day . $separator . $monthName . $separator . $year. $toHoursMin;
    } else if ($first == 'yyyy' && $second == 'M' && $third == 'dd') {
        $value = $year . $separator . $monthName . $separator . $day. $toHoursMin;
    }        
    return $value;

}


/**
* Process of sending twilio message 
*
* @param string $request
*
* @return mixed
*/
function twilioSendSms($toNumber,$messages)
{
        
    try {

        $client          = new CurlClient();
        $response        = $client->request('GET', 'https://api.twilio.com:8443');
        $phoneSms        = Settings::where('type','twilio')->whereIn('name', ['twilio_sid', 'twilio_token','formatted_phone'])->pluck('value', 'name')->toArray();    
        $sid             = !empty($phoneSms['twilio_sid']) ? $phoneSms['twilio_sid'] : 'ACf4fd1e';
        $token           = !empty($phoneSms['twilio_token']) ? $phoneSms['twilio_token'] : 'da9580307';

        $url             = "https://api.twilio.com/2010-04-01/Accounts/$sid/SMS/Messages";
        $trimmedMsg      = trim(preg_replace('/\s\s+/', ' ', $messages));

        if (!empty($phoneSms['formatted_phone'])) {
            $data = array (
                'From' => $phoneSms['formatted_phone'],
                'To' => $toNumber,
                'Body' => strip_tags($trimmedMsg),
            );
            $post = http_build_query($data);
            $x    = curl_init($url );
            curl_setopt($x, CURLOPT_POST, true);
            curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
            if ($response->getStatusCode() <= 200 || $response->getStatusCode() >= 300) {
                curl_setopt($x, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
            }
            curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($x, CURLOPT_USERPWD, "$sid:$token");
            curl_setopt($x, CURLOPT_POSTFIELDS, $post);
            $y = curl_exec($x);
            curl_close($x);
        }
        return redirect()->back();   
           
    } catch (Exception $e) {

        return redirect()->back();        
    }   
                 
}

/**
 * [onlyFormat description]
 * @param  [type] $value    [any number]
 * @return [type] [formates date according to preferences setting in Admin Panel]
 */
function onlyFormat($value)
{
    $preferenceData = Settings::where(['type' => 'preferences'])->whereIn('name', ['date_format_type', 'date_separator'])->get(['name', 'value'])->toArray();
    $preferenceData = Common::key_value('name', 'value', $preferenceData);
    $separator      = $preferenceData['date_separator'];
    $preference     = str_replace(['/', '.', ' ', '-'], '', $preferenceData['date_format_type']);
    switch ($preference) {
        case 'yyyymmdd':
            $value = date('Y'. $separator . 'm' . $separator . 'd', strtotime($value));
            break;
        case 'ddmmyyyy':
            $value = date('d' . $separator .'m' . $separator . 'Y', strtotime($value));
            break;
        case 'mmddyyyy':
            $value = date('m' . $separator . 'd' . $separator . 'Y', strtotime($value));
            break;
        case 'ddMyyyy':
            $value = date('d' . $separator .'M' . $separator . 'Y', strtotime($value));
            break;
        case 'yyyyMdd':
            $value = date('Y' . $separator . 'M' . $separator . 'd', strtotime($value));
            break;
        default:
            $value = date('Y-m-d', strtotime($value));
            break;
    }
    return $value;

}




/**
 * [roundFormat description]
 * @param  [type] $value     [any number]
 * @return [type] [placement of money symbol according to preferences setting in Admin Panel]
 */
function moneyFormat($symbol, $value)
{
    $symbolPosition = currencySymbolPosition();
    if ($symbolPosition == "before") {
         $value = $symbol . ' ' . $value;
    } else {
        $value = $value . ' ' . $symbol;
    }
    return $value;
}

/**
 * [currencySymbolPosition description]
 * @return [position type of symbol after or before]
 */
function currencySymbolPosition() 
{
    $position = Settings::where(['type' => 'preferences', 'name' => 'money_format'])->first(['value'])->value;
    return !empty($position) ? $position : 'after';
}


 function codeToSymbol($code)
{
    $symbol = DB::table('currency')->where('code', $code)->first()->symbol;
    return $symbol;
}


function SymbolToCode($symbol)
{
    $code = DB::table('currency')->where('symbol', $symbol)->first()->code;
    return $code;
}


function changeEnvironmentVariable($key, $value)
{
    $path = base_path('.env');

    if (is_bool(env($key)))
    {
        $old = env($key) ? 'true' : 'false';
    }
    elseif (env($key) === null)
    {
        $old = 'null';
    }
    else
    {
        $old = env($key);
    }

    if (file_exists($path))
    {
        if ($old == 'null')
        {

            file_put_contents($path, "$key=" . $value, FILE_APPEND);
        }
        else
        {
            file_put_contents($path, str_replace(
                "$key=" . $old, "$key=" . $value, file_get_contents($path)
            ));
        }
    }
}


function currency_fix($field, $code)
{   
    $default_currency = Currency::where('default', 1)->first()->code;
    $rate = Currency::whereCode($code)->first()->rate;


    $base_amount = $field / $rate;


    $session_rate = Currency::whereCode((Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->rate;

    return round($base_amount * $session_rate);
}




