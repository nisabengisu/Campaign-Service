<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $data['products']= DB::table('mdns_product')->get();
        $data['brands']= DB::table('mdns_brand')->get();
        $data['categories']= DB::table('mdns_category')->get();
        $data['count']= Basket::count();

        return view('Home', $data);
    }
}
