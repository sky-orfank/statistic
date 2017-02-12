<?php

namespace App\Http\Controllers\Admin;

use Redis;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Page;
use DB;

class DashboardController extends BaseController
{
 
    public function index()
    { 
        $data = [
            'platform' => self::scan("p:*:platform:*:*"),
            'browser' => self::scan("p:*:browser:*:*"),        
            'geo_loc' => self::scan("p:*:geo_loc:*:*"),
            'referrer' => self::scan("p:*:referrer:*:*"),        
        ];

        $view_data = [];
        //dd($data);
        foreach ($data as $k=>$v) {

            foreach ($data[$k] as $item) {

                    $data_arr = explode(":", $item);

                    if(!isset($view_data[$k][$data_arr[3]])) {
                        $view_data[$k][$data_arr[3]] = [];
                    }
                    if(!isset($view_data[$k][$data_arr[3]][$data_arr[4]])) {
                        $view_data[$k][$data_arr[3]][$data_arr[4]] = 0; 
                        
                    }
                    if($data_arr[4]=='hit') {
                        $view_data[$k][$data_arr[3]][$data_arr[4]] += Redis::SCARD("p:".$data_arr[1].":".$k.":".$data_arr[3].":".$data_arr[4]);    
                    } elseif($data_arr[4]=='ip') {
                        $tmp = Redis::SMEMBERS("p:".$data_arr[1].":".$k.":".$data_arr[3].":".$data_arr[4]);

                        foreach($tmp as $item) {
                            $valid = filter_var($item, FILTER_VALIDATE_IP);
                            if($valid) {
                                $data_tmp_ip[$k][$data_arr[3]][$data_arr[4]][] = $item;
                            }
                        }
                    } elseif($data_arr[4]=='laravel_session') {
                        $tmp = Redis::SMEMBERS("p:".$data_arr[1].":".$k.":".$data_arr[3].":".$data_arr[4]);

                        foreach($tmp as $item) {
                            $data_tmp_session[$k][$data_arr[3]][$data_arr[4]][] = $item;
                        }
                    }                    
            }
        }

        if(isset($data_tmp_ip)) {
            foreach($data_tmp_ip as $k=>$v) {
                foreach($data_tmp_ip[$k] as $k1=>$v1) {
                    foreach($data_tmp_ip[$k][$k1] as $k2=>$v2) {
                        $view_data[$k][$k1][$k2] = count(array_unique($data_tmp_ip[$k][$k1][$k2]));
                        $view_data[$k][$k1]['laravel_session'] = count(array_unique($data_tmp_session[$k][$k1]['laravel_session']));
                    }
                }
            }
        }
        
        return view('statistic', ['statistic' => $view_data]); 
    }

    public function getPageStatistic($id)
    {
        $pages = DB::table('pages')->select('title', 'id')->get();

        $data = [
            'platform' => self::scan("p:".$id.":platform:*:*"),
            'browser' => self::scan("p:".$id.":browser:*:*"),
            'geo_loc' => self::scan("p:".$id.":geo_loc:*:*"),
            'referrer' => self::scan("p:".$id.":referrer:*:*"),            
        ];
        $view_data = [];

        foreach ($data as $k=>$v) {
            
            foreach ($data[$k] as $item) {

                    $data_arr = explode(":", $item);

                    if(!isset($view_data[$k][$data_arr[3]])) {
                        $view_data[$k][$data_arr[3]] = [];
                    }
                    if(!isset($view_data[$k][$data_arr[3]][$data_arr[4]])) {
                        $view_data[$k][$data_arr[3]][$data_arr[4]] = 0; 
                        
                    }

                    $view_data[$k][$data_arr[3]][$data_arr[4]] += Redis::SCARD("p:".$data_arr[1].":".$k.":".$data_arr[3].":".$data_arr[4]);                      
              
            }

        }

        return view('page_statistic', ['statistic' => $view_data, 'pages' => $pages, 'current_page' => $id]);


    }

    private static function scan($pattern, $results=array(), $cursor=null)
    {
        if ($cursor==="0") return $results;
        if ($cursor===null) $cursor = "0";

        $tmp = Redis::SCAN($cursor, 'match', $pattern);

        $results = array_merge($results, $tmp[1]);
        
        return self::scan($pattern, $results, $tmp[0]);
    }

}
