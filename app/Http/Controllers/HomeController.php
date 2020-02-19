<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class HomeController extends Controller
{
  public function showHome()
  {
    $result = DB::table('layanan')->where('id', '>', '0')->get();
    $display = DB::table('display')->where('id', 1)->first();
    return view('home', ['API_KEY' => env("API_KEY"), 'layanan' => $result, 'data' => $display]);
  }

  public function tes(){
    echo public_path();
  }

  public function showDisplay()
  {
    $result = DB::table('display')->where('id', 1)->first();
    return view('display', ['data' => $result]);
  }

  public function printAntrian()
  {
    $data = DB::table('display')->where('id', '1')->first();
    $connector = new WindowsPrintConnector("\\wind7\usb\epson");
    $printer = new Escpos($connector);
    // $logo = EscposImage::load(public_path("uploads/display/logo.png"));
    // $printer->graphics($logo);
    $printer->initialize();
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setTextSize(3, 3);
    $printer->text($data->nama_perusahaan . "\n");
    $printer->setTextSize(2, 2);
    $printer->text($data->alamat_perusahaan . "\n");
    $printer->setTextSize(5, 5);
    $printer->text($data->alamat_perusahaan . "\n");
    $printer->cut();
  }
}
