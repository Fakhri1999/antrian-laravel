<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\Printer;

class HomeController extends Controller
{
  public function showHome()
  {
    if(session('admin_username') == null){
      return redirect('admin/login?r=antriantersayang/antrian');
    }
    $result = DB::table('layanan')->where('id', '>', '0')->get();
    $display = DB::table('display')->where('id', 1)->first();
    return view('home', ['API_KEY' => env("API_KEY"), 'layanan' => $result, 'data' => $display]);
  }

  public function showDisplay()
  {
    $result = DB::table('display')->where('id', 1)->first();
    return view('display', ['data' => $result]);
  }
}
