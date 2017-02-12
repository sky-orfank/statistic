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