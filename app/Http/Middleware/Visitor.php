<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redis;
use Closure;
use Request;

class Visitor
{
    public function handle ($request, Closure $next)
    { 
        $response = $next($request);

        $geoLocation = $this->getGeoLocation(Request::ip());
        $data = 'p'.':'.$request->route('id').':'.'geo_loc'.':'.$geoLocation['countryName'].' '.$geoLocation['city'];
        Redis::SADD($data.':'.'hit', $this->getRandomString($data.':'.'hit'));
        if($this->getSession()) Redis::SADD($data.':'.'laravel_session', $this->getSession());        
        Redis::SADD($data.':'.'ip', Request::ip());

        $referrer = $this->getReferer();
        $data = 'p'.':'.$request->route('id').':'.'referrer'.':'.$referrer;
        Redis::SADD($data.':'.'hit', $this->getRandomString($data.':'.'hit'));
        if($this->getSession()) Redis::SADD($data.':'.'laravel_session', $this->getSession());
        Redis::SADD($data.':'.'ip', Request::ip());

        $user_agent = $this->parseUserAgent($request->header('User-Agent'));
        $data = 'p'.':'.$request->route('id').':'.'platform'.':'.$user_agent['platform'];
        Redis::SADD($data.':'.'hit', $this->getRandomString($data.':'.'hit'));
        if($this->getSession()) Redis::SADD($data.':'.'laravel_session', $this->getSession());        
        Redis::SADD($data.':'.'ip', Request::ip());

        $data = 'p'.':'.$request->route('id').':'.'browser'.':'.$user_agent['browser_name'];
        Redis::SADD($data.':'.'hit', $this->getRandomString($data.':'.'hit'));
        if($this->getSession()) Redis::SADD($data.':'.'laravel_session', $this->getSession());
        Redis::SADD($data.':'.'ip', Request::ip());

        return $response; 
    }


    private function getSession() {

        if(!empty(Request::cookie()['laravel_session'])) {
            return Request::cookie()['laravel_session'];
        } else {
            return false;
        }

    }

    private function getGeoLocation($ip) {
        $apiKey = '09d88f4853964570dc8acce97ee80170a1f2e2b0';
        $geoServiceResponse = file_get_contents('http://api.db-ip.com/v2/'.$apiKey.'/'.$ip);
        $geoServiceData = json_decode($geoServiceResponse, true);

        if(empty($geoServiceData['countryName'])) {
            $data['countryName'] = '';
        }

        $data['countryName'] = !empty($geoServiceData['countryName']) ? $geoServiceData['countryName'] : "no_country";
        $data['city'] = !empty($geoServiceData['city']) ? $geoServiceData['city'] : "no_city";
        return $data;
    }

    private function getReferer()
    {
        if(isset($_SERVER['HTTP_REFERER'])) {
            return parse_url($_SERVER['HTTP_REFERER'])['host'];
        } else {
            return "no_referrer";
        } 
    }

    private function getRandomString($key)
    {
        $rand_str = md5(rand(1,1000000).time());

        if(Redis::SISMEMBER($key, $rand_str)) 
            $this->getAssuredUniqHash($key);
        else 
            return $rand_str;
    }

    private function parseUserAgent($user_agent){

        $bname = 'Unknown';
        $platform = 'Unknown';

        if (preg_match('/linux/i', $user_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $user_agent)) {
            $platform = 'windows';
        }
        $data['platform'] = $platform;

        if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$user_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$user_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$user_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$user_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$user_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        $data['browser_name'] = $bname;
        return $data;
    }
}
