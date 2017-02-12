<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Page;
use DB;

class HomeController extends Controller
{
    public function getTestPage($id = 1)
    {
        $pages = DB::table('pages')->select('title', 'id')->get();
        $page = Page::find($id);
        return view('page', ['page' => $page, 'pages' => $pages, 'current_page' => $id]);
    }  
}
