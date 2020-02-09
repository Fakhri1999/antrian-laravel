<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
  public function showHome()
  {
    $result = DB::table('layanan')->where('id', '>', '0')->get();
    // echo json_encode(['API_KEY' => env("API_KEY"), 'layanan' => $result]);
    // return;
    // print_r(range('A', 'Z')[0]);
    // return;
    return view('home', ['API_KEY' => env("API_KEY"), 'layanan' => $result]);
  }
}
